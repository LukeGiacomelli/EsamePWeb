<?php

/*function modificaTel($db, $nuovoTel, $cf) {
    $sql = "UPDATE utente SET U_telefono = '$nuovoTel' WHERE U_cf = '$cf'";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        echo "Errore nell'inserimento nel database";
    } else {
        $_SESSION['tel'] = $nuovoTel;
        $_SESSION['success_message'] = 'Numero di telefono modificato con successo!';
    }

    header("location: pg_personale_ut.php");
    exit();
} */

function modificaTel($db, $nuovoTel, $cf) {
    // check for non-digits
    if (!ctype_digit($nuovoTel)) {
        $_SESSION['error_message'] = 'Il numero di telefono deve contenere solo cifre.';
    } 
    // check for length > 10
    else if (strlen($nuovoTel) > 10) {
        $_SESSION['error_message'] = 'Il numero di telefono non può superare le 10 cifre.';
    } 
    else {
        $sql = "UPDATE utente SET U_telefono = '$nuovoTel' WHERE U_cf = '$cf'";
        $result = mysqli_query($db, $sql);

        if (!$result) {
            $_SESSION['error_message'] = 'Errore nell\'inserimento nel database';
        } else {
            $_SESSION['tel'] = $nuovoTel;
            $_SESSION['success_message'] = 'Numero di telefono modificato con successo!';
        }
    }

    header("location: pg_personale_ut.php");
    exit();
}

    function modificaEmail($db,$nuovaEmail,$cf){
        
        $sql = "UPDATE utente SET U_mail = '$nuovaEmail'  WHERE U_cf = '$cf' " ;
        $result = mysqli_query($db,$sql);

        if(!$result){
            echo "Errore nell'inserimento nel database";
        } else {
            
            $_SESSION['email'] = $nuovaEmail;
            $_SESSION['success_message'] = 'Email modificata con successo!';
        }

        header("location: pg_personale_ut.php");
        exit();

    }


    function modificaPassword($db, $vecchiaPassword, $nuovaPassword, $cf) {
        $sql = "UPDATE utente SET U_Password = '$nuovaPassword' WHERE U_cf = '$cf' AND U_password = '$vecchiaPassword'";
        $result = mysqli_query($db, $sql);
    
        //controllo se sono state modificate righe (se ha modificato la password --> successo)
        if (mysqli_affected_rows($db) > 0) {
            $_SESSION['success_message'] = 'Password modificata con successo!';
        } else {
            $_SESSION['error_message'] = 'Modifica non riuscita. Controllare vecchia password.';
        }
    
        header("location: pg_personale_ut.php");
        exit();
    }

?>