<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$utente_cf = $_POST['utente_id']; 

if (!$utente_cf) {
    echo json_encode(['totale' => 0]);
    exit;
}

$sql = "SELECT SUM(C_quantità) AS totale FROM carrello WHERE U_cf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $utente_cf);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['totale' => $row['totale'] ?? 0]);
?>
