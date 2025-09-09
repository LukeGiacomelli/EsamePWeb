<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$prodotto_id = $_POST['prodotto_id'];
$data = $_POST['data_prenotazione'];
$durata = $_POST['durata_prenotazione'];
$cf = $_SESSION['cf'];

// Trova l'ordine attivo del cliente
$sql = "SELECT Ordine_id FROM ordine WHERE cf_cliente = ? AND stato = 'in elaborazione' ORDER BY Data_ordine DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cf);
$stmt->execute();
$result = $stmt->get_result();
$ordine = $result->fetch_assoc();

if (!$ordine) {
  http_response_code(400);
  echo "Nessun ordine in elaborazione trovato.";
  exit;
}

// Aggiorna la riga specifica
$ordine_id = $ordine['Ordine_id'];
$sql = "UPDATE ordine_prodotto SET data_prenotazione = ?, durata_prenotazione = ? WHERE ordine_id = ? AND prodotto_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siss", $data, $durata, $ordine_id, $prodotto_id);
$stmt->execute();

echo "OK";
