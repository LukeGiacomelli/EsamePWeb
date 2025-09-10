<?php
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$conn) {
    http_response_code(500);
    echo "Errore di connessione al database.";
    exit;
}

$prodotto_id = $_POST['prodotto_id'] ?? null;
$utente_cf = $_POST['utente_cf'] ?? null;
$data_prenotazione = $_POST['data_prenotazione'] ?? null;
$durata_prenotazione = $_POST['durata_prenotazione'] ?? null;

if (!$prodotto_id || !$utente_cf || !$data_prenotazione || !$durata_prenotazione) {
    http_response_code(400);
    echo "Dati mancanti.";
    exit;
}

// Esegui update sulla riga del carrello
$sql = "UPDATE carrello 
        SET data_prenotazione = ?, durata_prenotazione = ? 
        WHERE Prodotto_id = ? AND U_cf = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo "Errore nella preparazione della query.";
    exit;
}

$stmt->bind_param("siss", $data_prenotazione, $durata_prenotazione, $prodotto_id, $utente_cf);
$success = $stmt->execute();

if ($success) {
    echo "Prenotazione salvata con successo.";
} else {
    http_response_code(500);
    echo "Errore durante il salvataggio.";
}
?>
