<?php 
    //SQL querys
    include("assets/php/extract_prodotti.php");

    while ($row = $result->fetch_assoc()) {

        $data_corso = null;

        // Estrazione dei dati dal database
        $id_prodotto = $row["Prodotto_id"];
        $hot = $row["hot"];
        $prezzo = $row["Prodotto_prezzo"] . "€";
        $immagine = $row["Prodotto_immagine"] ?: "default.jpg";
        $descrizione = $row["Prodotto_descrizione"];
        $badge_text = "Prodotto";
        $nome_prodotto = "Prodotto generico";

        // Determinazione del badge e del nome prodotto
        if (isset($row["Corso_Nome"])) {
            $n_iscritti = $row["N_iscritti"];
            $max_iscritti = $row["Max_Iscritti"];
            $badge_text = "Workshop";
            $data_corso = $row["Corso_Data"];
            $nome_prodotto = $row["Corso_Nome"];
        } elseif (isset($row["Sala_Tipo"])) {
            $badge_text = $row["Sala_Tipo"];
            $nome_prodotto = $row["Sala_Nome"];
            $prezzo = $row["Prodotto_prezzo"] . "€/h";
        } elseif (isset($row["Servizio_Tipo"])) {
            $badge_text = "Servizio";
            $nome_prodotto = $row["Servizio_Tipo"];
        }
?>

        <div class="col mb-5">
        <div class="card h-100 position-relative <?php if($hot) echo 'hot-border'; ?>">
            
            <!-- Badge -->
            <div class="badge bg-dark text-white position-absolute">
            <?php echo $badge_text; ?>
            </div>

            <!-- Cartellino HOT -->
            <?php if($hot): ?>
            <div class="hot-badge">HOT</div>
            <?php endif; ?>

            <!-- Immagine del prodotto -->
            <img class="card-img-top" 
                src="<?php echo $immagine; ?>" 
                alt="<?php echo htmlspecialchars($nome_prodotto); ?>" />

            <!-- Dettagli del prodotto -->
            <div class="card-body p-4">
            <div class="text-center">
                
                <!-- Nome prodotto -->
                <h5 class="fw-bolder"><?php echo $nome_prodotto; ?></h5>

                <!-- Descrizione prodotto -->
                <p class="text-muted small"><?php echo $descrizione; ?></p>

                <!-- Data del corso (se esiste) -->
                <?php if (isset($data_corso)) { ?>
                <p>
                    <i class="bi bi-calendar-event text-success me-2"></i><br>
                    <strong>Data:</strong> <?php echo $data_corso; ?>
                </p>
                <p>
                    <strong>Iscritti</strong>
                    <?php echo "(" . $n_iscritti . "/" . $max_iscritti . ")"; ?>
                </p>
                <?php } ?>

                <!-- Prezzo del prodotto -->
                <p><strong>Prezzo:</strong> <?php echo $prezzo; ?></p>
            </div>
            </div>

            <!-- Bottoni per le azioni sui prodotti -->
            <?php include("assets/php/bottoni_prodotti.php"); ?>

        </div>
        </div>

<?php 
    } 
?>
