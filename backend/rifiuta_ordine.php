<?php
include(__DIR__ ."/../common/config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$ordine_id = $_POST['ordine_id'] ?? null;

if (!$ordine_id) {
    echo "Ordine non specificato.";
    exit;
}

// Verifica che lo stato sia ancora "in elaborazione"
$check = $conn->prepare("SELECT stato FROM ordine WHERE Ordine_id = ?");
$check->bind_param("s", $ordine_id);
$check->execute();
$res = $check->get_result()->fetch_assoc();

if (!$res || $res['stato'] !== 'In elaborazione') {
    echo "Ordine già elaborato o non valido.";
    exit;
}

// Annulla l'ordine
$update = $conn->prepare("UPDATE ordine SET stato = 'Rifiutato' WHERE Ordine_id = ?");
$update->bind_param("s", $ordine_id);
$update->execute();

echo "Ordine rifiutato.";
?>