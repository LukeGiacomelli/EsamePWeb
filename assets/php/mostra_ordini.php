<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$cf_utente = $_SESSION['cf'];

$sql = "SELECT * FROM ordine WHERE cf_cliente = ? ORDER BY Data_ordine DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cf_utente);
$stmt->execute();
$ordini = $stmt->get_result();

if ($ordini->num_rows === 0) {
    echo "<p>Non hai ancora effettuato ordini.</p>";
} else {
    while ($ordine = $ordini->fetch_assoc()) {
        $ora = date('g/m/y (H:i)', strtotime($ordine['Data_ordine']));
        echo "<div class='d-flex align-items-center mb-1'>";
        echo "<h5 class='mt-auto ms-1'>Data ordine: {$ora} <span class='badge bg-secondary ms-2'>{$ordine['stato']}</span></h5>";
        echo "</div>";
        echo "<table class='table table-bordered table-sm' >";
        echo "<thead><tr><th>Prodotto</th><th>Quantità</th><th>Prezzo unitario</th><th>Totale</th></tr></thead>";
        echo "<tbody>";

        $id_ordine = $ordine['Ordine_id'];

        $sql2 = "SELECT 
            op.*, 
            co.Corso_Nome, 
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
            }

            $totale += $tot;

            echo "<tr>";
            echo "<td>" . htmlspecialchars($nome) . $extra . "</td>";
            echo "<td>{$prodotto['quantita']}</td>";
            echo "<td>€ " . number_format($prodotto['prezzo_unitario'], 2) . "</td>";
            echo "<td>€ " . number_format($tot, 2) . "</td>";
            echo "</tr>";
        }

        echo "<tr class='table-light'><td colspan='3' class='text-end'><strong>Totale ordine</strong></td><td><strong>€ " . number_format($totale, 2) . "</strong></td></tr>";
        echo "</tbody></table><br>";
        if ($ordine['stato'] === 'In elaborazione') {
            echo "<button class='btn btn-danger btn-sm mt-auto' onclick=\"annullaOrdine('{$ordine['Ordine_id']}')\">Annulla ordine</button>";
        }
        echo "<hr>";
    }
}
?>
