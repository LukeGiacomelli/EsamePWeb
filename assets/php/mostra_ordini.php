<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$cf_utente = $_SESSION['cf'] ?? '';

// --- ORDINAMENTO (whitelist) ---
$allowedSort = [
    'data' => 'Data_ordine',
    'stato' => 'stato',
    'id'    => 'Ordine_id'
];
$sort = $_GET['sort'] ?? 'data';
$dir  = strtoupper($_GET['dir'] ?? 'DESC');

$orderCol = $allowedSort[$sort] ?? $allowedSort['data'];
$dir = ($dir === 'ASC') ? 'ASC' : 'DESC';

// Query con ORDER BY dinamico ma sicuro
$sql = "SELECT * FROM ordine WHERE cf_cliente = ? ORDER BY $orderCol $dir";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cf_utente);
$stmt->execute();
$ordini = $stmt->get_result();
?>

<!-- Controlli ordinamento -->
<form method="get"
      class="d-inline-flex align-items-center gap-2 flex-nowrap mb-3"
      style="white-space:nowrap;">
  <select name="sort" class="form-select form-select-sm w-auto">
    <option value="data"  <?= $sort==='data'  ? 'selected' : '' ?>>Data</option>
    <option value="stato" <?= $sort==='stato' ? 'selected' : '' ?>>Stato</option>
    <option value="id"    <?= $sort==='id'    ? 'selected' : '' ?>>ID Ordine</option>
  </select>

  <select name="dir" class="form-select form-select-sm w-auto mb">
    <option value="ASC"  <?= $dir==='ASC'  ? 'selected' : '' ?>>Crescente</option>
    <option value="DESC" <?= $dir==='DESC' ? 'selected' : '' ?>>Decrescente</option>
  </select>

  <button class="btn btn-sm btn-primary">Applica</button>
</form>
<?php
if ($ordini->num_rows === 0) {
    echo "<p>Non hai ancora effettuato ordini.</p>";
} else {
    while ($ordine = $ordini->fetch_assoc()) {
        $ora = date('d/m/y (H:i)', strtotime($ordine['Data_ordine']));
        echo "<div class='d-flex align-items-center mb-1'>";
        echo "<h5 class='mt-auto ms-1'>Data ordine: {$ora} <span class='badge bg-secondary ms-2'>".htmlspecialchars($ordine['stato'])."</span></h5>";
        echo "</div>";
        echo "<table class='table table-bordered table-sm' >";
        echo "<thead><tr><th>Prodotto</th><th>Quantità</th><th>Prezzo unitario</th><th>Totale</th></tr></thead>";
        echo "<tbody>";

        $id_ordine = $ordine['Ordine_id'];

        $sql2 = "SELECT 
            op.*, 
            co.Corso_Nome, 
            co.Corso_Data,
            s.Sala_Nome, 
            se.Servizio_Tipo
         FROM ordine_prodotto op
         LEFT JOIN corso co ON co.Prodotto_id = op.prodotto_id
         LEFT JOIN sala s ON s.Prodotto_id = op.prodotto_id
         LEFT JOIN servizio se ON se.Prodotto_id = op.prodotto_id
         WHERE op.ordine_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $id_ordine);
        $stmt2->execute();
        $prodotti = $stmt2->get_result();

        $totale = 0;

        while ($prodotto = $prodotti->fetch_assoc()) {
            $tot = $prodotto['quantita'] * $prodotto['prezzo_unitario'];
            $nome = $prodotto['Corso_Nome'] ?? $prodotto['Sala_Nome'] ?? $prodotto['Servizio_Tipo'] ?? 'Generico';

            $extra = '';
            if (!empty($prodotto['Sala_Nome']) && !empty($prodotto['data_prenotazione'])) {
                $dataPrenotazione = date('(d/m/Y H:i)', strtotime($prodotto['data_prenotazione']));
                $extra = " <span class='badge bg-info text-dark ms-2'>Prenotato per: $dataPrenotazione</span>";
            }else if (!empty($prodotto['Corso_Nome']) && !empty($prodotto['Corso_Data'])){
                $dataPrenotazione = date('(d/m/Y H:i)', strtotime($prodotto['Corso_Data']));
                $extra = " <span class='badge bg-warning text-dark ms-2'>Data: $dataPrenotazione</span>";
            }

            $totale += $tot;

            echo "<tr>";
            echo "<td>" . htmlspecialchars($nome) . $extra . "</td>";
            echo "<td>".(int)$prodotto['quantita']."</td>";
            echo "<td>€ " . number_format($prodotto['prezzo_unitario'], 2, ',', '.') . "</td>";
            echo "<td>€ " . number_format($tot, 2, ',', '.') . "</td>";
            echo "</tr>";
        }

        echo "<tr class='table-light'><td colspan='3' class='text-end'><strong>Totale ordine</strong></td><td><strong>€ " . number_format($totale, 2, ',', '.') . "</strong></td></tr>";
        echo "</tbody></table><br>";
        if ($ordine['stato'] === 'In elaborazione') {
            echo "<button class='btn btn-danger btn-sm mt-auto' onclick=\"annullaOrdine('".htmlspecialchars($ordine['Ordine_id'])."')\">Annulla ordine</button>";
        }
        echo "<hr>";
    }
}
?>