<?php
session_start();


function auth_log($db, $post_email, $post_pw){
    $email = mysqli_real_escape_string($db, $post_email);
    $pw = mysqli_real_escape_string($db, $post_pw);

    // Query di check
    $sql = "SELECT * FROM utente WHERE U_mail = '$email' and U_password = '$pw'";
    $result = mysqli_query($db, $sql); 
    $row = mysqli_fetch_assoc($result); 
    $count = mysqli_num_rows($result);

    if($count == 1 && ($row['U_stato'] == 'attivo')) { // Fa il login solo se l'utente è approvato e non bloccato
        // Logg
        $_SESSION['login_error'] = null;
        $_SESSION['name'] = $row['U_nome'];
        $_SESSION['surname'] = $row['U_cognome'];
        $_SESSION['cf'] = $row['U_cf'];
        $_SESSION['tel'] = $row['U_telefono'];
        $_SESSION['email'] = $email; // Non c'è bisogno di cercare nel database
        $_SESSION['birth'] = $row['U_data_di_nascita'];
        $_SESSION['type'] = $row['U_tipo'];
        
        header("location: index.php");

    } else if ($count == 1 && $row['U_stato'] == 'attesa') {

        $_SESSION['login_error'] = 'not_approved';

    } else if ($count == 1 && $row['U_stato'] == 'bloccato') {

        $_SESSION['login_error'] = 'blocked';

    } else {

        $_SESSION['login_error'] = 'no_account';
        
    }
    
}

function check_existing_credentials($db, $cf, $email, $tel) {
    $messages = [];

    // cf
    $sql = "SELECT * FROM utente WHERE U_cf = '$cf'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $messages[] = 'il codice fiscale';
    }

    // mail
    $sql = "SELECT * FROM utente WHERE U_mail = '$email'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $messages[] = 'l\'email';
    }

    //tel
    $sql = "SELECT * FROM utente WHERE U_telefono = '$tel'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $messages[] = 'il telefono';
    }

    // Se ci sono errori, costruisci il messaggio
    if (!empty($messages)) {
        $message = 'I seguenti campi sono già associati a un account esistente: ' . implode(', ', $messages) . '. Accedi.';
        $_SESSION['reg_message'] = $message;
        var_dump($message);  // Aggiungi per debug
        return true;
    }

    return false;
}


function auth_reg($db, $post_array){
    // Dal form...
    $cf = mysqli_real_escape_string($db, $post_array['cf']);
    $email = mysqli_real_escape_string($db, $post_array['email']);
    $pw = mysqli_real_escape_string($db, $post_array['password']);
    $nome = mysqli_real_escape_string($db, $post_array['nome']);
    $cognome = mysqli_real_escape_string($db, $post_array['cognome']);
    $birthdate = mysqli_real_escape_string($db, $post_array['birthdate']);
    $tel = mysqli_real_escape_string($db, $post_array['telefono']);

    // Query di inserimento
    if (check_existing_credentials($db, $cf, $email, $tel)==false){
        $sql = "INSERT INTO `utente` (`U_cf`, `U_mail`, `U_password`, `U_nome`, `U_cognome`, `U_tipo`, `U_data_di_nascita`,`U_telefono`, `U_stato`) 
                VALUES ('$cf', '$email', '$pw', '$nome', '$cognome', 'cliente', '$birthdate', '$tel', 'attesa');";
        $result = mysqli_query($db, $sql);
    }else{
        header("Location: registra.php");
        exit();
    }

    if ($result) {
        $sql_check = "SELECT * FROM utente WHERE U_mail = '$email' AND U_password = '$pw'";
        $result_check = mysqli_query($db, $sql_check);   
        $count_check = mysqli_num_rows($result_check);

        if ($count_check > 0) {
            // Messaggio di successo
            $_SESSION['reg_message'] = 'success';
            header("Location: login.php");
            exit();
        }
    }
}

?>