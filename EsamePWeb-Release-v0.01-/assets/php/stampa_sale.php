<?php
    include "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (!$conn) { die("Errore connessione DB"); }

    $sql = "SELECT
            s.Prodotto_id,
            s.Sala_Nome,
            s.Sala_Tipo,
            s.Sala_capienza,
            p.Prodotto_immagine,
            p.Prodotto_descrizione
            FROM sala s
            LEFT JOIN prodotto p ON p.Prodotto_id = s.Prodotto_id
            ORDER BY s.Sala_Tipo, s.Sala_Nome";

    $rs = mysqli_query($conn, $sql);

    if ($rs && mysqli_num_rows($rs) > 0) {
    while ($r = mysqli_fetch_assoc($rs)) {
        $img  = $r['Prodotto_immagine'] ?: 'assets/img/placeholder-sala.jpg';
        $img  = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');
        $nome = htmlspecialchars($r['Sala_Nome'], ENT_QUOTES, 'UTF-8');
        $tipo = htmlspecialchars($r['Sala_Tipo'], ENT_QUOTES, 'UTF-8');

        echo '      <div class="col-lg-4 col-sm-6">';
        echo '        <a class="portfolio-box" href="'.$img.'" title="'.$nome.'">';
        echo '          <img class="img-portfolio" src="'.$img.'" alt="'.$nome.'">';
        echo '          <div class="portfolio-box-caption">';
        echo '            <div class="project-category text-white-50">'.$tipo.'</div>';
        echo '            <div class="project-name">'.$nome.'</div>';
        echo '          </div>';
        echo '        </a>';
        echo '      </div>';
    }
    } else {
    echo '      <div class="col-12 text-center py-5 text-muted">Nessuna sala disponibile.</div>';
    }

    if ($rs) mysqli_free_result($rs);
    mysqli_close($conn);
?>