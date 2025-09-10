<?php
    include(__DIR__ ."/../common/config.php");
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $utente_cf = $_POST['utente_id'] ?? null;

    if (!$utente_cf) {
        echo "Utente non specificato";
        exit;
    }

    echo("ciao");

    // Svuota il carrello
    $delete = $conn->prepare("DELETE FROM carrello WHERE U_cf = ?");
    $delete->bind_param("s", $utente_cf);
    $delete->execute();
?>