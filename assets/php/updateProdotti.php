<?php
    $data = json_decode(file_get_contents('php://input'), true);

    //Se ricevo la variabile da js (con ajax)
    if (isset($data['id_caller'])) {
        $id_prod = $data['id_caller'];

        update($id_prod,$db);

        //echo "Ricevuto: " . htmlspecialchars($id_prod);
    }

    function update($id_prod, $db){
        $sql = "SELECT 
        p.Prodotto_id, 
        p.Prodotto_prezzo, 
        p.Prodotto_immagine, 
        p.Prodotto_descrizione,
        c.Corso_Nome, 
        c.N_Lez,  
        c.Corso_Data,
        s.Sala_Nome,
        s.Sala_Tipo,  
        servizio.Servizio_Tipo,
        c.Corso_Operatore_Nome,
        c.Corso_Operatore_Cognome,   
        servizio.Servizio_Operatore_Nome,
        servizio.Servizio_Operatore_Cognome,
        s.Sala_capienza
        FROM 
        PRODOTTO p
        LEFT JOIN CORSO c ON p.Prodotto_id = c.Prodotto_id
        LEFT JOIN SALA s ON p.Prodotto_id = s.Prodotto_id
        LEFT JOIN SERVIZIO servizio ON p.Prodotto_id = servizio.Prodotto_id
        WHERE p.Prodotto_id = '".$id_prod."';
        ";
    
        $result = mysqli_query($db, $sql);
        $n_prodotti_totale = mysqli_num_rows($result);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $id_prod = $row['Prodotto_id'];
            $price_prod = $row['Prodotto_prezzo'];
            $img_prod = $row['Prodotto_immagine'];
            $desc_prod = $row['Prodotto_descrizione'];
            $nome_corso = $row['Corso_Nome'];
            $n_lez = $row['N_Lez'];
            $data_corso = $row['Corso_Data'];
            $nome_sala = $row['Sala_Nome'];
            $tipo_sala = $row['Sala_Tipo'];
            $tipo_servizio = $row['Servizio_Tipo'];
            $corso_operatore_nome = $row['Corso_Operatore_Nome'];
            $corso_operatore_cognome = $row['Corso_Operatore_Cognome'];
            $serv_operatore_nome = $row['Servizio_Operatore_Nome'];
            $serv_operatore_cognome = $row['Servizio_Operatore_Cognome'];
            $sala_capienza = $row['Sala_capienza'];

            echo $id_prod. '| ' . $price_prod. '| ' . $img_prod. '| ' . $desc_prod. '| ' . $nome_corso.
            '| ' . $n_lez. '| ' . $data_corso. '| ' . $nome_sala. '| ' . $tipo_sala. '| ' . $tipo_servizio.
            '| ' . $corso_operatore_nome. '| ' . $corso_operatore_cognome. '| ' . $serv_operatore_nome. 
            '| ' . $serv_operatore_cognome. '| ' . $sala_capienza;
        }
    }
?>