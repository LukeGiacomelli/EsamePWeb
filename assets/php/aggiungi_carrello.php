<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$utente_cf = $_POST['utente_id']; 
$prodotto_id = $_POST['prodotto_id'];

if (!$prodotto_id || !$utente_cf) {
    die("Errore: dati mancanti.");
}

//E una sala?
$isSala = preg_match('/^S\d+$/', $prodotto_id) === 1;

// Verifica se il prodotto è già nel carrello
$sql_check = "SELECT C_quantità FROM carrello WHERE Prodotto_id = ? AND U_cf = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ss", $prodotto_id, $utente_cf);
$stmt->execute();
$result = $stmt->get_result();

if(!$isSala){
    // Verifica se il corso è pieno
    $sql_check = "SELECT N_Iscritti,
                    Max_Iscritti
                    FROM Corso
                    WHERE Prodotto_id = ?
                ";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $prodotto_id);
    $stmt->execute();
    $resultCorso = $stmt->get_result()->fetch_assoc();;

    if($resultCorso && $resultCorso['N_Iscritti'] >= $resultCorso['Max_Iscritti']){
        echo("Iscritti massimi raggiunti");
        exit;
    }
}

if ($result->num_rows > 0 && !$isSala) {
        // Se esiste e non è una sala, aggiorna la quantità
        $sql_update = "UPDATE carrello SET C_quantità = C_quantità + 1 WHERE Prodotto_id = ? AND U_cf = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ss", $prodotto_id, $utente_cf);
        $stmt->execute();
} else {
    // Altrimenti, inserisci una nuova riga
    $sql_insert = "INSERT INTO carrello (Prodotto_id, U_cf, C_quantità) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ss", $prodotto_id, $utente_cf);
    $stmt->execute();
}

echo ("Aggiunto al carrello");
exit;
?>