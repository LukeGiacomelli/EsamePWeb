<?php
function check_existing_product($db, $id) {

    $sql = "SELECT * FROM prodotto WHERE Prodotto_id = '$id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function creaProdotto($db, $post_gen_array, $post_spec_array) {
    $id = mysqli_real_escape_string($db, $post_gen_array['id']);
    $prezzo = mysqli_real_escape_string($db, $post_gen_array['prezzo']);
    $img = mysqli_real_escape_string($db, $post_gen_array['img']);
    $desc = mysqli_real_escape_string($db, $post_gen_array['desc']);
    $tipo_prod = mysqli_real_escape_string($db, $post_gen_array['tipo']);

    // Controlla se il prodotto esiste già
    if (check_existing_product($db, $id) == false) {
        // Inserisci il prodotto nella tabella `prodotto`
        $sql = "INSERT INTO `prodotto` (`Prodotto_id`, `Prodotto_prezzo`, `Prodotto_immagine`, `Prodotto_descrizione`) 
                VALUES ('$id', '$prezzo', '$img', '$desc');";
        $result = mysqli_query($db, $sql);

        if (!$result) {
            die("Errore nell'inserimento del prodotto: " . mysqli_error($db));
        }
    }

    // Inserisci nelle tabelle specifiche in base al tipo di prodotto
    if ($tipo_prod === "sale") {
        $tipo_sala = mysqli_real_escape_string($db, $post_spec_array['tipo_sala']);
        $nome_sala = mysqli_real_escape_string($db, $post_spec_array['nome_sala']);
        $capienza = mysqli_real_escape_string($db, $post_spec_array['capienza']);

        $sql_sale = "INSERT INTO `sala` (`Sala_Tipo`, `Sala_Nome`, `Sala_Capienza`, `Prodotto_id`) 
                     VALUES ('$tipo_sala', '$nome_sala', '$capienza', '$id');";
        $result = mysqli_query($db, $sql_sale);

        if (!$result) {
            die("Errore nell'inserimento della sala: " . mysqli_error($db));
        }

    } elseif ($tipo_prod === "servizi") {
        $tipo_servizio = mysqli_real_escape_string($db, $post_spec_array['tipo_servizio']);
        $nome_operatore = mysqli_real_escape_string($db, $post_spec_array['nome_operatore']);
        $cognome_operatore = mysqli_real_escape_string($db, $post_spec_array['cognome_operatore']);

        $sql_servizi = "INSERT INTO `servizio` (`Servizio_tipo`, `Servizio_Operatore_Nome`, `Servizio_Operatore_Cognome`, `Prodotto_id`) 
                        VALUES ('$tipo_servizio', '$nome_operatore', '$cognome_operatore', '$id');";
        $result = mysqli_query($db, $sql_servizi);

        if (!$result) {
            die("Errore nell'inserimento del servizio: " . mysqli_error($db));
        }else{
            // Controllo per verificare l'inserimento
            $sql_check = "SELECT * FROM prodotto WHERE Prodotto_id = '$id'";
            $result_check = mysqli_query($db, $sql_check);   
            $count_check = mysqli_num_rows($result_check);

        if ($count_check > 0) {
            // Messaggio di successo
            $_SESSION['prod_message'] = 'success';
            header("Location: prenota.php");
            exit();
        }
        }

    } elseif (($tipo_prod === "corsi")) {

        $nome_corso = mysqli_real_escape_string($db, $post_spec_array['nome_corso']);
        $lezioni = mysqli_real_escape_string($db, $post_spec_array['lezioni']);
        $nome_insegnante_corso = mysqli_real_escape_string($db, $post_spec_array['nome_insegnante_corso']);
        $cognome_insegnante_corso = mysqli_real_escape_string($db, $post_spec_array['cognome_insegnante_corso']);

        if ($tipo_prod === "corso"){
            $data = mysqli_real_escape_string($db, $post_spec_array['data_corso']);
        }else{
            $data = null; 
        }

        $sql_corsi = "INSERT INTO `corso` (`Corso_nome`, `Corso_Operatore_Nome`, `Corso_Operatore_Cognome`, `Corso_Data`, `N_iscritti`, `Prodotto_id`) 
                      VALUES ('$nome_corso', '$nome_insegnante_corso', '$cognome_insegnante_corso', '$data', '$lezioni', '$id');";
        $result = mysqli_query($db, $sql_corsi);

        if (!$result) {
            die("Errore nell'inserimento del corso: " . mysqli_error($db));
        }

    }
}
function aggiornaProdotto($db, $post_gen_array, $post_spec_array) {
    $id = mysqli_real_escape_string($db, $post_gen_array['id']);
    $prezzo = mysqli_real_escape_string($db, $post_gen_array['prezzo']);
    $img = mysqli_real_escape_string($db, $post_gen_array['img']);
    $desc = mysqli_real_escape_string($db, $post_gen_array['desc']);
    $tipo_prod = mysqli_real_escape_string($db, $post_gen_array['tipo']);
    
    // Inserisci il prodotto nella tabella `prodotto`
    $sql = "UPDATE prodotto SET Prodotto_prezzo='$prezzo', Prodotto_immagine='$img', Prodotto_descrizione='$desc'
    WHERE prodotto.Prodotto_id='$id';";

    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Errore nell'inserimento del prodotto: " . mysqli_error($db));
    }

    // Inserisci nelle tabelle specifiche in base al tipo di prodotto
    if ($tipo_prod === "Sala") {
        $tipo_sala = mysqli_real_escape_string($db, $post_spec_array['tipo_sala']);
        $nome_sala = mysqli_real_escape_string($db, $post_spec_array['nome_sala']);
        $capienza = mysqli_real_escape_string($db, $post_spec_array['capienza']);

        $sql_sale = "UPDATE sala SET Sala_Tipo='$tipo_sala', Sala_Nome='$nome_sala', Sala_Capienza='$capienza'
        WHERE sala.Prodotto_id = '$id';";
        $result = mysqli_query($db, $sql_sale);

        if (!$result) {
            die("Errore nell'inserimento della sala: " . mysqli_error($db));
        }
        //continuare da qui (cambiare le prossime query da insert a update)
    } elseif ($tipo_prod === "Servizio") {
        $tipo_servizio = mysqli_real_escape_string($db, $post_spec_array['tipo_servizio']);
        $nome_operatore = mysqli_real_escape_string($db, $post_spec_array['nome_operatore']);
        $cognome_operatore = mysqli_real_escape_string($db, $post_spec_array['cognome_operatore']);

        $sql_servizi = "UPDATE `servizio` SET `Servizio_tipo`='$tipo_servizio', `Servizio_Operatore_Nome`='$nome_operatore', `Servizio_Operatore_Cognome` = '$cognome_operatore'
                        WHERE servizio.Prodotto_id = '$id';";
        $result = mysqli_query($db, $sql_servizi);

        if (!$result) {
            die("Errore nell'inserimento del servizio: " . mysqli_error($db));
        }

    } elseif (($tipo_prod === "Corso")) {

        $nome_corso = mysqli_real_escape_string($db, $post_spec_array['nome_corso']);
        $lezioni = mysqli_real_escape_string($db, $post_spec_array['lezioni']);
        $nome_insegnante_corso = mysqli_real_escape_string($db, $post_spec_array['nome_insegnante_corso']);
        $cognome_insegnante_corso = mysqli_real_escape_string($db, $post_spec_array['cognome_insegnante_corso']);

        if ($tipo_prod === "Corso"){
            $data = mysqli_real_escape_string($db, $post_spec_array['data_corso']);
        }else{
            $data = null; 
        }

        $sql_corsi = "UPDATE `corso` SET `Corso_nome` = '$nome_corso', `Corso_Operatore_Nome`='$nome_insegnante_corso', `Corso_Operatore_Cognome`='$cognome_insegnante_corso', `Corso_Data`='$data', `N_iscritti`='$lezioni'
                      WHERE corso.Prodotto_id = '$id';";
        $result = mysqli_query($db, $sql_corsi);

        if (!$result) {
            die("Errore nell'inserimento del corso: " . mysqli_error($db));
        }

    }    
}
?>