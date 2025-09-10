                    
<?php   
    $where_field = "";
    $join_field = "
                    LEFT JOIN CORSO c ON p.Prodotto_id = c.Prodotto_id
                    LEFT JOIN SALA s ON p.Prodotto_id = s.Prodotto_id
                    LEFT JOIN SERVIZIO servizio ON p.Prodotto_id = servizio.Prodotto_id";
    $dinamic_columns = "c.Corso_Nome, 
                        c.N_iscritti,
                        c.Max_Iscritti,  
                        c.Corso_Data,
                        s.Sala_Nome,
                        s.Sala_Tipo,
                        servizio.Servizio_Tipo";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['act'])){
            if($act === 'filtra'){
                if (isset($_POST["priceRange"]) && $_POST["priceRange"] != 1000){
                    //Se è stato toccato lo slider
                    $where_field = $where_field . "p.Prodotto_prezzo <= " . $_POST["priceRange"] . " AND ";
                }
                if (isset($_POST["desc_tb"]) && $_POST["desc_tb"] != ""){
                    $where_field = $where_field . "p.Prodotto_descrizione LIKE '%" . $_POST["desc_tb"] . "%' AND ";
                }
                if (isset($_POST["hot_box"])){
                    $where_field = $where_field . "p.hot = 1 AND ";
                }
                if (isset($_POST["tipo_prod"]) && $_POST["tipo_prod"] != "op"){
                    if ($_POST["tipo_prod"] === "Corso"){
                        $dinamic_columns = "c.Corso_Nome, 
                                            c.N_iscritti,
                                            c.Max_Iscritti,  
                                            c.Corso_Data";
                        $join_field = "INNER JOIN CORSO c ON p.Prodotto_id = c.Prodotto_id";
                    }else if ($_POST["tipo_prod"] === "Sala"){
                        $dinamic_columns = " s.Sala_Nome,
                                            s.Sala_Tipo";
                        $join_field =  "INNER JOIN SALA s ON p.Prodotto_id = s.Prodotto_id";
                    }else if ($_POST["tipo_prod"] === "Servizio"){
                        $dinamic_columns = "servizio.Servizio_Tipo";
                        $join_field = "INNER JOIN SERVIZIO servizio ON p.Prodotto_id = servizio.Prodotto_id";
                    }else{
                        $join_field = "
                                       LEFT JOIN CORSO c ON p.Prodotto_id = c.Prodotto_id
                                       LEFT JOIN SALA s ON p.Prodotto_id = s.Prodotto_id
                                       LEFT JOIN SERVIZIO servizio ON p.Prodotto_id = servizio.Prodotto_id";
                    }
                }
                if ((isset($_POST["data_min"]) && isset($_POST["data_max"])) && ($_POST["data_min"] != "" && $_POST["data_max"] != "")){
                    $where_field = $where_field . "STR_TO_DATE(c.Corso_data, '%Y-%m-%d') BETWEEN '".$_POST["data_min"]."' AND '".$_POST["data_max"]."',";
                }
            }
        }
    }

    ?> 
    <script>
    window.postValues = <?php echo json_encode([
        'priceRange' => $_POST['priceRange'] ?? '',
        'tipo_prod' => $_POST['tipo_prod'] ?? '',
        'desc_tb' => $_POST['desc_tb'] ?? '',
        'hot_box' => isset($_POST['hot_box']) && $_POST['hot_box'],
    ]); ?>;
    </script>
    
    <?php
    $where_field = rtrim($where_field); // togli spazi finali
    $where_field = preg_replace('/\s*(AND|,)\s*$/i', '', $where_field); // rimuovi AND o virgola finale
    $where_field = $where_field !== '' ? 'WHERE '.$where_field : '';

    $sql = "SELECT 
    p.Prodotto_id, 
    p.Prodotto_prezzo, 
    p.Prodotto_immagine, 
    p.Prodotto_descrizione,
    p.hot,
    " . $dinamic_columns . "     
    FROM 
    PRODOTTO p
    ". $join_field . " " . $where_field . ";";

    $result = mysqli_query($db, $sql);
    $n_prodotti_totale = mysqli_num_rows($result);
?>

