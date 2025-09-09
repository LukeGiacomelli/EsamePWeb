<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$ordine_id = $_POST['ordine_id'] ?? null;

if (!$ordine_id) {
    echo "Ordine non specificato.";
    exit;
}

// Verifica che lo stato sia ancora "in elaborazione"
$check = $conn->prepare("SELECT stato FROM ordine WHERE Ordine_id = ?");
$check->bind_param("s", $ordine_id);
$check->execute();
$res = $check->get_result()->fetch_assoc();

if (!$res || $res['stato'] !== 'In elaborazione') {
    echo "Ordine già elaborato o non valido.";
    exit;
}

//Incremento iscritti per corso
$sub = $conn->prepare("UPDATE corso AS c
                        INNER JOIN prodotto AS p
                        ON c.Prodotto_id = p.Prodotto_id
                        INNER JOIN ordine_prodotto AS op
                        ON p.Prodotto_id = op.prodotto_id
                        INNER JOIN ordine AS o
                        ON op.ordine_id = o.Ordine_id
                        SET c.N_Iscritti = (c.N_Iscritti + 1)
                        WHERE o.Ordine_id = ?"
                    );
$sub->bind_param("s", $ordine_id);
$sub->execute();

//Salva prenotazione
$sel = $conn->prepare("
    SELECT 
        op.prodotto_id,
        op.data_prenotazione                 AS start_date,
        COALESCE(op.durata_prenotazione, 1)  AS durata_ore,
        o.cf_cliente                          AS utente_cf
    FROM ordine_prodotto op
    INNER JOIN ordine o
        ON o.Ordine_id = op.ordine_id
    WHERE op.ordine_id = ?
      AND op.data_prenotazione IS NOT NULL
      AND EXISTS (
            SELECT 1
            FROM sala s             
            WHERE s.Prodotto_id = op.prodotto_id
      )
");
$sel->bind_param("s", $ordine_id);
$sel->execute();
$righe = $sel->get_result();

if ($righe && $righe->num_rows > 0) {
    // Inserisco solo se NON esiste già stessa (prodotto, utente, start_date)
    $ins = $conn->prepare("
        INSERT INTO prenotazioni (prodotto_id, utente_cf, start_date, durata, note)
        SELECT ?, ?, ?, ?, ?
        FROM DUAL
        WHERE NOT EXISTS (
            SELECT 1
            FROM prenotazioni
            WHERE prodotto_id = ?
              AND utente_cf   = ?
              AND start_date  = ?
        )
    ");

    while ($r = $righe->fetch_assoc()) {
        $prod   = $r['prodotto_id'];     // VARCHAR(255)
        $cf     = $r['utente_cf'];       // da tabella ordine
        $start  = $r['start_date'];      // DATETIME "YYYY-MM-DD HH:MM:SS"
        $durata = (int)$r['durata_ore']; // ore intere, default 1
        $note   = "Ordine ".$ordine_id;

        // types: s s s i s s s s
        $ins->bind_param("sssissss",
            $prod, $cf, $start, $durata, $note,
            $prod, $cf, $start
        );
        $ins->execute();
    }
    $ins->close();
}
$sel->close();

// Conferma l'ordine
$update = $conn->prepare("UPDATE ordine SET stato = 'Confermato' WHERE Ordine_id = ?");
$update->bind_param("s", $ordine_id);
$update->execute();

echo "Ordine confermato con successo.";
?>