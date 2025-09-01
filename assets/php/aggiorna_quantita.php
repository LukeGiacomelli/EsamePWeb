<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$azione = $_POST['azione'];
$prodotto_id = $_POST['prodotto_id'];
$utente = $_POST['utente_id'];

if (!$azione || !$prodotto_id || !$utente) exit;

if ($azione === 'incrementa') {
  $sql = "UPDATE carrello SET C_quantità = C_quantità + 1 WHERE Prodotto_id = ? AND U_cf = ?";
} elseif ($azione === 'decrementa') {
  $sql = "UPDATE carrello SET C_quantità = C_quantità - 1 WHERE Prodotto_id = ? AND U_cf = ? AND C_quantità > 1";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $prodotto_id, $utente);
$stmt->execute();

// Ritorna nuova quantità
$sql2 = "SELECT C_quantità FROM carrello WHERE Prodotto_id = ? AND U_cf = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ss", $prodotto_id, $utente);
$stmt2->execute();
$res = $stmt2->get_result()->fetch_assoc();

echo $res['C_quantità'] ?? 0;
?>