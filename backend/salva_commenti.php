<?php
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


$utente_id = $_POST['utente_id']; 
$prodotto_id = $_POST['prodotto_id'];
$messaggio = $_POST['messaggio'];
$punteggio = $_POST['punteggio'];

$stmt = $conn->prepare("INSERT INTO commenti (utente_id, prodotto_id, messaggio, punteggio) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $utente_id, $prodotto_id, $messaggio, $punteggio);
$stmt->execute();
?>