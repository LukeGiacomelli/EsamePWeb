<?php
$prodotto_id = $_GET['prodotto_id'];
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$query = "
  SELECT u.U_nome, u.U_cognome, c.messaggio, c.punteggio, c.data_commento
  FROM commenti c
  JOIN utente u ON c.utente_id = u.U_cf
  WHERE c.prodotto_id = ?
  ORDER BY c.data_commento DESC
";

$stmt = $conn->prepare( $query );
$stmt->bind_param("s", $prodotto_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
  $stelle = str_repeat('★', $row['punteggio']) . str_repeat('☆', 5 - $row['punteggio']);

  echo "<div class='mb-3 border-bottom pb-2'>";
  echo "<strong>👤 {$row['U_nome']} {$row['U_cognome']}</strong><br>";
  echo "<span class='text-warning'>$stelle</span><br>";
  echo htmlspecialchars($row['messaggio']) . "<br>";
  echo "<small class='text-muted'>{$row['data_commento']}</small>";
  echo "</div>";
}
?>