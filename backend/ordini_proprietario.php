<?php
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$statoFiltro = $_GET['stato'] ?? '';
$where = '';
if ($statoFiltro !== '') {
    $where = "WHERE o.stato = '".$conn->real_escape_string($statoFiltro)."'";
}

$sql = "SELECT o.*, u.U_mail, u.U_nome, u.U_cognome
        FROM ordine o
        JOIN utente u ON u.U_cf = o.cf_cliente
        $where
        ORDER BY o.Data_ordine DESC";
$res = $conn->query($sql);

?>
<div class="mb-3 text-start">
  <form method="get" class="d-inline-flex gap-2">
      <select name="stato" class="form-select form-select-sm">
          <option value="">Stato dell'ordine</option>
          <?php foreach(["In elaborazione","Confermato","Rifiutato","Spedito","Completato","Annullato"] as $st): ?>
              <option value="<?= $st ?>" <?= ($statoFiltro===$st?'selected':'') ?>><?= $st ?></option>
          <?php endforeach; ?>
      </select>
      <button class="btn btn-sm btn-primary">Filtra</button>
  </form>
</div>
<?php

if ($res->num_rows === 0) {
    echo "<p>Nessun ordine presente.</p>";
} else {
    while ($o = $res->fetch_assoc()) {
        $ordine_id = $o['Ordine_id'];
        $ora = date('d/m/Y H:i', strtotime($o['Data_ordine']));
        $cliente = $o['U_nome'] . ' ' . $o['U_cognome'];
        $email = $o['U_mail'];

        // prodotti di questo ordine
        $sql2 = "SELECT op.*, co.Corso_Nome, co.Corso_Data, s.Sala_Nome, se.Servizio_Tipo
                 FROM ordine_prodotto op
                 LEFT JOIN corso co ON co.Prodotto_id = op.prodotto_id
                 LEFT JOIN sala s ON s.Prodotto_id = op.prodotto_id
                 LEFT JOIN servizio se ON se.Prodotto_id = op.prodotto_id
                 WHERE op.ordine_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $ordine_id);
        $stmt2->execute();
        $prodotti = $stmt2->get_result();

        $totale = 0;
        ?>
        <div class="card mb-3 w-100">
            <div class="card-body">
                <h5 class="card-title">Ordine #<?= $ordine_id ?> — <?= htmlspecialchars($cliente) ?> (<a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a>)</h5>
                <p class="card-subtitle text-muted">Data: <?= $ora ?> — Stato: <strong><?= htmlspecialchars($o['stato']) ?></strong></p>

                <div class="table-responsive mt-2">
                    <table class="table table-sm table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Prodotto</th>
                                <th>Quantità</th>
                                <th>Prezzo unitario</th>
                                <th>Totale</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($p = $prodotti->fetch_assoc()):
                            $extra = '';
                            //Badge
                            if (!empty($p['Sala_Nome']) && !empty($p['data_prenotazione'])) {
                                $dataPrenotazione = date('(d/m/Y H:i)', strtotime($p['data_prenotazione']));
                                $durataPrenotazione = $p['durata_prenotazione'];
                                $extra = " <span class='badge bg-info text-dark ms-2'>Prenotato per: $dataPrenotazione ($durataPrenotazione h)</span>";
                            }else if (!empty($p['Corso_Nome']) && !empty($p['Corso_Data'])){
                                $dataPrenotazione = date('(d/m/Y H:i)', strtotime($p['Corso_Data']));
                                $extra = "<span class='badge bg-warning text-dark ms-2'>Data: $dataPrenotazione/span>";
                            }
                            
                            $nome = $p['Corso_Nome'] ?? $p['Sala_Nome'] ?? $p['Servizio_Tipo'] ?? 'Generico';
                            $rigaTot = $p['quantita'] * $p['prezzo_unitario'];
                            $totale += $rigaTot;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($nome) . $extra ?></td>
                                <td><?= (int)$p['quantita'] ?></td>
                                <td>€ <?= number_format($p['prezzo_unitario'], 2, ',', '.') ?></td>
                                <td>€ <?= number_format($rigaTot, 2, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr class="table-light">
                            <td colspan="3" class="text-end"><strong>Totale</strong></td>
                            <td><strong>€ <?= number_format($totale, 2, ',', '.') ?></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pulsanti -->
                <?php if ($o['stato'] === 'In elaborazione'): ?>
                    <button class="btn btn-success btn-sm" onclick="aggiornaOrdine('<?= $ordine_id ?>','Confermato')">Conferma</button>
                    <button class="btn btn-danger btn-sm" onclick="aggiornaOrdine('<?= $ordine_id ?>','Rifiutato')">Rifiuta</button>
                    <a class="btn btn-primary btn-sm" href="mailto:<?= htmlspecialchars($email) ?>?subject=Ordine%20<?= $ordine_id ?>">Scrivi e-mail</a>
                <?php else: ?>
                    <button class="btn btn-success btn-sm" disabled>Conferma</button>
                    <button class="btn btn-danger btn-sm" disabled>Rifiuta</button>
                    <a class="btn btn-primary btn-sm" href="mailto:<?= htmlspecialchars($email) ?>?subject=Ordine%20<?= $ordine_id ?>">Scrivi e-mail</a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
?>
