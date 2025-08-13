<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$prodotto_id = $_POST['prodotto_id'];
$utente = $_POST['utente_id'];

if (!$prodotto_id || !$utente) exit;

$sql = "DELETE FROM carrello WHERE Prodotto_id = ? AND U_cf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $prodotto_id, $utente);
$stmt->execute();
?>