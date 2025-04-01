                    
<?php   
    $where_field = "";
    $join_field = "
                    LEFT JOIN CORSO c ON p.Prodotto_id = c.Prodotto_id
                    LEFT JOIN SALA s ON p.Prodotto_id = s.Prodotto_id
                    LEFT JOIN SERVIZIO servizio ON p.Prodotto_id = servizio.Prodotto_id";
    $dinamic_columns = "c.Corso_Nome, 
                        c.N_Lez,  
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
                    //Se è stato toccato lo slider
                    $where_field = $where_field . "p.Prodotto_descrizione LIKE '%" . $_POST["desc_tb"] . "%' AND ";
                }
                if (isset($_POST["hot_box"])){
                    //Se è stato toccato lo slider
                    $where_field = $where_field . "p.hot = 1 AND ";
                }else{
                    $where_field = $where_field . "p.hot = 0 AND ";
                }
                if (isset($_POST["tipo_prod"]) && $_POST["tipo_prod"] != "op"){
                    if ($_POST["tipo_prod"] === "Corso"){
                        $dinamic_columns = "c.Corso_Nome, 
                                            c.N_Lez,  
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
        priceRange.value = <?php echo isset($_POST['priceRange']) ? $_POST['priceRange'] : ""; ?>;
        priceLabel.textContent = '<?php echo isset($_POST['priceRange']) ? ("Price range (" . $_POST['priceRange'] . ")") : "Price range"; ?>';
        tipo_prod.value = '<?php echo isset($_POST['tipo_prod']) ? $_POST['tipo_prod'] : ""; ?>';
        desc_textbox.value = '<?php echo isset($_POST['desc_tb']) ? $_POST['desc_tb'] : ""; ?>';
        hot_checkbox.checked = <?php echo isset($_POST['hot_box']) ? "true" : "false" ?>;
        //date_min.value = '<?php //echo $_POST['date_min']; ?>';
        //date_max.value = '<?php //echo $_POST['date_max']; ?>';
    </script> 
    <?php
    $where_field = ($where_field != "" ? "WHERE " . substr($where_field, 0, -4) : "");
    $sql = "SELECT 
    p.Prodotto_id, 
    p.Prodotto_prezzo, 
    p.Prodotto_immagine, 
    p.Prodotto_descrizione,
    " . $dinamic_columns . "     
    FROM 
    PRODOTTO p
    ". $join_field . " " . $where_field . ";";

    $result = mysqli_query($db, $sql);
    $n_prodotti_totale = mysqli_num_rows($result);
?>

