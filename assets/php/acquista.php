<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$utente_cf = $_POST['utente_id'] ?? null;

if (!$utente_cf) {
  echo "Utente non specificato";
  exit;
}

// Check se le date sono selezionate
$sql = "SELECT 
          c.data_prenotazione, 
          c.Prodotto_id
        FROM carrello c
        JOIN prodotto p ON p.Prodotto_id = c.Prodotto_id
        JOIN sala s ON p.Prodotto_id = s.Prodotto_id
        WHERE c.U_cf = ? 
        AND c.Prodotto_id LIKE 'S%'
        AND c.data_prenotazione IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $utente_cf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo "Selezionare la data per tutte le sale...";
  exit;
}

// Recupera prodotti dal carrello
$sql = "SELECT 
          c.data_prenotazione, 
          c.durata_prenotazione, 
          c.Prodotto_id, 
          c.C_quantità, 
          p.Prodotto_prezzo
        FROM carrello c
        JOIN prodotto p ON p.Prodotto_id = c.Prodotto_id
        WHERE c.U_cf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $utente_cf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "Il carrello è vuoto.";
  exit;
}

// Genera ID ordine univoco
$ordine_id = uniqid("ORD");

// Crea ordine
$insertOrdine = $conn->prepare("
  INSERT INTO ordine (Ordine_id, cf_cliente, Data_ordine, stato) 
  VALUES (?, ?, NOW(), 'In elaborazione')
");
$insertOrdine->bind_param("ss", $ordine_id, $utente_cf);
$insertOrdine->execute();

// Inserisce ogni prodotto
$insertProd = $conn->prepare("
  INSERT INTO ordine_prodotto 
    (ordine_id, prodotto_id, prezzo_unitario, quantita, data_prenotazione, durata_prenotazione) 
  VALUES (?, ?, ?, ?, ?, ?)
");

while ($row = $result->fetch_assoc()) {
    $data = $row['data_prenotazione']  ?? null;
    $durata  = $row['durata_prenotazione']  ?? null;

    $molt_durata = ($durata !== null && $durata !== '') ? (int)$durata : 1;
    $prezzo = $molt_durata * (float)$row['Prodotto_prezzo'] * (int)$row['C_quantità'];

    $insertProd->bind_param(
        "ssdisi",
        $ordine_id,              
        $row['Prodotto_id'],        
        $prezzo,                    
        $row['C_quantità'],         
        $data,                       
        $durata                      
    );

    $insertProd->execute();
}

// Svuota il carrello
$delete = $conn->prepare("DELETE FROM carrello WHERE U_cf = ?");
$delete->bind_param("s", $utente_cf);
$delete->execute();

echo "Grazie per l'acquisto!";
