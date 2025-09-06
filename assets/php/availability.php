<?php
// /api/availability.php?prodotto_id=STUDIO_A&from=2025-09-01&to=2025-09-30
header('Content-Type: application/json; charset=utf-8');

$dsn  = 'mysql:host=localhost;dbname=TUO_DB;charset=utf8mb4';
$user = 'TUO_USER';
$pass = 'TUO_PASS';
$pdo  = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$prodottoId = $_GET['prodotto_id'] ?? '';
$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to']   ?? date('Y-m-t');

// valida formato (semplice)
if (!$prodottoId) { echo json_encode([]); exit; }

// includi anche le prenotazioni che iniziano PRIMA di :to ma finiscono DOPO :from (sovrapposizioni)
$sql = "
SELECT
  DATE(op.data_prenotazione) AS day,
  DATE_FORMAT(op.data_prenotazione, '%H:%i') AS start_time,
  DATE_FORMAT(DATE_ADD(op.data_prenotazione, INTERVAL COALESCE(op.durata_prenotazione,1) HOUR), '%H:%i') AS end_time
FROM ordine_prodotto op
JOIN ordine o ON o.Ordine_id = op.ordine_id
WHERE op.prodotto_id = :prodotto
  AND o.stato = 'Confermato'
  AND op.data_prenotazione < DATE_ADD(:to, INTERVAL 1 DAY)
  AND DATE_ADD(op.data_prenotazione, INTERVAL COALESCE(op.durata_prenotazione,1) HOUR) >= :from
ORDER BY op.data_prenotazione
";
$st = $pdo->prepare($sql);
$st->execute([':prodotto' => $prodottoId, ':from' => $from, ':to' => $to]);

$busy = [];
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $busy[$r['day']][] = ['start' => $r['start_time'], 'end' => $r['end_time']];
}
echo json_encode($busy);
?>