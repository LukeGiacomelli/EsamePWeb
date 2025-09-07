<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$utente_cf = $_POST['utente_id']; 

$sql = "
  SELECT 
    SUM(
        p.Prodotto_prezzo 
        * c.C_quantità 
        * COALESCE(c.durata_prenotazione, 1)
    ) AS totale_carrello
FROM carrello c
JOIN prodotto p ON c.Prodotto_id = p.Prodotto_id
WHERE c.U_cf = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $utente_cf);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  echo $row['totale_carrello'];
  exit;
}

?>