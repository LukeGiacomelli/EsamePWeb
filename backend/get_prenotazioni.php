<?php
session_start();
header('Content-Type: text/plain; charset=utf-8');
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$conn) {
    http_response_code(500);
    echo "Errore";
    exit;
}

$cf_utente = $_SESSION['cf'] ?? '';

//raccolta parametri
$pid  = $_POST['prodotto_id'] ?? $_POST['sala'] ?? null;   

if (!$pid) {
    http_response_code(400);
    echo "Errore";
    exit;
}

$sql = "SELECT DATE(start_date) AS data, DATE_FORMAT(start_date, '%H:%i') AS inizio, durata
        FROM prenotazioni
        WHERE prodotto_id = ?
";

$params = [$pid];
$types  = "s";


$sql .= " ORDER BY start_date";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500);
    echo "Errore";
    exit;
}

mysqli_stmt_bind_param($stmt, $types, ...$params);

if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo "Errore";
    exit;
}

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    http_response_code(500);
    echo "Errore";
    exit;
}

$parts = [];
while ($row = mysqli_fetch_assoc($result)) {
    // data,ora,durata
    $parts[] = $row['data'] . "," . $row['inizio'] . "," . (int)$row['durata'];
}

mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($conn);
echo implode("|", $parts);

?>