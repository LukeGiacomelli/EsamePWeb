<?php
// assets/php/get_prenotazioni.php
session_start();
header('Content-Type: text/plain; charset=utf-8');

include("config.php");

// Connessione (tua logica)
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$conn) {
    http_response_code(500);
    echo "Errore";
    exit;
}

$cf_utente = $_SESSION['cf'] ?? '';

// --- Parametri POST ---
$pid  = $_POST['prodotto_id'] ?? $_POST['sala'] ?? null;   // obbligatorio
$from = $_POST['from'] ?? null;                            // YYYY-MM-DD (opzionale)
$to   = $_POST['to']   ?? null;                            // YYYY-MM-DD (opzionale)

if (!$pid) {
    http_response_code(400);
    echo "Errore";
    exit;
}

// --- Costruzione query con prepared statement ---
$sql = "SELECT
            DATE(start_date)                  AS data,
            DATE_FORMAT(start_date, '%H:%i') AS inizio,
            durata
        FROM prenotazioni
        WHERE prodotto_id = ?
";

$params = [$pid];
$types  = "s"; // prodotto_id è varchar(255) nella tua tabella

if (!empty($from)) {
    $sql .= " AND start_date >= ? ";
    $params[] = $from . " 00:00:00";
    $types   .= "s";
}
if (!empty($to)) {
    // limite superiore esclusivo: giorno successivo alle 00:00
    $sql .= " AND start_date < ? ";
    $params[] = date('Y-m-d', strtotime($to . ' +1 day')) . " 00:00:00";
    $types   .= "s";
}

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

// Output (stringa vuota se nessun record)
echo implode("|", $parts);

?>