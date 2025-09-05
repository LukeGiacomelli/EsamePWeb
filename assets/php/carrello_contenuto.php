<?php
include("config.php");
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$utente_cf = $_POST['utente_id']; 

$sql = "
  SELECT 
    c.C_quantità,
    c.data_prenotazione,
    c.durata_prenotazione,
    p.Prodotto_id,
    p.Prodotto_immagine,
    p.Prodotto_descrizione,
    p.Prodotto_prezzo,
    co.Corso_Nome,
    co.Corso_Data,
    s.Sala_Nome,
    se.Servizio_Tipo
  FROM carrello c
  JOIN prodotto p ON p.Prodotto_id = c.Prodotto_id
  LEFT JOIN corso co ON co.Prodotto_id = p.Prodotto_id
  LEFT JOIN sala s ON s.Prodotto_id = p.Prodotto_id
  LEFT JOIN servizio se ON se.Prodotto_id = p.Prodotto_id
  WHERE c.U_cf = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $utente_cf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "<p>Il carrello è vuoto.</p>";
  exit;
}

while ($row = $result->fetch_assoc()) {
    echo "<div class='d-flex mb-4' style='gap: 1rem;'>";

    // Immagine fissa a sinistra
    $immagine = htmlspecialchars($row['Prodotto_immagine'] ?? "...");
    echo "
      <div style='width: 100px; height: 100px; flex-shrink: 0;'>
        <img 
          src='$immagine' 
          alt='Immagine prodotto'
          style='width: 100%; height: 100%; object-fit: cover; border-radius: 8px;'
        >
      </div>
    ";
  
    // Testo a destra
    echo "<div style='flex-grow: 1;'>";
  
    if (!empty($row['Corso_Nome'])) {
      echo "<strong>Nome:</strong> " . htmlspecialchars($row['Corso_Nome']) . "<span class='badge bg-info text-dark ms-2'>" . $row['Corso_Data'] . "</span>";
    } elseif (!empty($row['Sala_Nome'])) {
      echo "<strong>Nome:</strong> " . htmlspecialchars($row['Sala_Nome']) . "<br>";
    } elseif (!empty($row['Servizio_Tipo'])) {
      echo "<strong>Nome:</strong> " . htmlspecialchars($row['Servizio_Tipo']) . "<br>";
    } else {
      echo "<strong>Nome:</strong> Error... <br>";
    }
  
    echo "<strong>Prezzo:</strong> €" . number_format($row['Prodotto_prezzo'], 2) . "<br>";

    // Mostra data e durata se presenti
    if (!empty($row['data_prenotazione']) && !empty($row['durata_prenotazione'])) {
      
      $dataFormatted = date("d/m/Y H:i", strtotime($row['data_prenotazione']));
      echo "<strong>Prenotazione:</strong> $dataFormatted<br>";
      
     $durata = (int)$row['durata_prenotazione'];

     echo "<strong>Durata:</strong> $durata ora/e<br>";

    }

    echo "<div class='d-flex align-items-center' style='gap: 0.5rem;'>";

    if (!empty($row['Sala_Nome'])) {

      echo "<button class='btn btn-sm btn-outline-secondary' onclick='modificaQuantita(\"decrementa\", \"{$row['Prodotto_id']}\")' disabled>−</button>";
      echo "<span id='quantita-{$row['Prodotto_id']}' disabled>{$row['C_quantità']}</span>";
      echo "<button class='btn btn-sm btn-outline-secondary' onclick='modificaQuantita(\"incrementa\", \"{$row['Prodotto_id']}\")' disabled>+</button>";

    }else{
      echo "<button class='btn btn-sm btn-outline-secondary' onclick='modificaQuantita(\"decrementa\", \"{$row['Prodotto_id']}\")'>−</button>";
      echo "<span id='quantita-{$row['Prodotto_id']}'>{$row['C_quantità']}</span>";
      echo "<button class='btn btn-sm btn-outline-secondary' onclick='modificaQuantita(\"incrementa\", \"{$row['Prodotto_id']}\")'>+</button>";
    }
    echo "<button class='btn btn-sm btn-primary ms-2' onclick='rimuoviDalCarrello(\"{$row['Prodotto_id']}\")'>Rimuovi</button>";
    
    if (!empty($row['Sala_Nome']) && empty($row['data_prenotazione']) && empty($row['durata_prenotazione'])) {
      echo "<button 
              class='btn btn-outline-secondary ms-auto calendario-btn' 
              data-bs-toggle='modal' 
              data-bs-target='#calendarioModal' 
              data-sala-id='{$row['Prodotto_id']}'
              title='Prenota data'>
              <i class='bi bi-calendar-event'></i>
            </button>";
    }
    echo "</div>";
  
    echo "</div>"; 
    echo "</div><hr>";
}
?>
