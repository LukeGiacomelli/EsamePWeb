<?php
// /api/occupied-slots.php
$pdo = new PDO('mysql:host=localhost;dbname=TUO_DB;charset=utf8mb4','USER','PASS', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$salaId = isset($_GET['sala_id']) && $_GET['sala_id'] !== '' ? (int)$_GET['sala_id'] : null;

$sql = "
  SELECT 
    op.sala_id,
    op.data_prenotazione AS start_dt,
    DATE_ADD(op.data_prenotazione, INTERVAL op.durata_prenotazione MINUTE) AS end_dt
  FROM ordine AS o
  INNER JOIN ordine_prodotto AS op ON op.ordine_id = o.Ordine_id
  WHERE o.stato = 'Confermato'
";
$params = [];
if ($salaId !== null) { $sql .= " AND op.sala_id = :sala_id"; $params[':sala_id'] = $salaId; }
$sql .= " ORDER BY start_dt ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$byDate = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $start = new DateTime($row['start_dt']);
  $end   = new DateTime($row['end_dt']);
  $dateKey = $start->format('Y-m-d');
  $byDate[$dateKey][] = [$start->format('H:i'), $end->format('H:i')];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($byDate, JSON_UNESCAPED_UNICODE);
?>