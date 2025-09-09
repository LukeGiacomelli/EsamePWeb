function annullaOrdine(ordine_id) {
Swal.fire({
    title: 'Sei sicuro?',
    text: "Vuoi davvero annullare l'ordine?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sì, annulla',
    cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('assets/php/annulla_ordine.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ ordine_id: ordine_id })
        })
        .then(res => res.text())
        .then(msg => {
          location.reload(); // Ricarica la pagina per aggiornare lo stato
        })
        .catch(err => {
          console.error('Errore:', err);
          alert("Si è verificato un errore durante l'annullamento.");
        });
      }
  });
}

function confermaOrdine(ordine_id) {
Swal.fire({
    title: 'Sei sicuro?',
    text: "Vuoi davvero confermare l'ordine?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sì, procedi',
    cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        //Conferma ordine
        fetch('assets/php/conferma_ordine.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ ordine_id: ordine_id })
        })
        .then(res => res.text())
        .then(msg => {
          location.reload(); // Ricarica la pagina per aggiornare lo stato
        })
        .catch(err => {
          console.error('Errore:', err);
          alert("Si è verificato un errore durante l'aggiornamento.");
        });
      }
  });
}

function rifiutaOrdine(ordine_id) {
Swal.fire({
    title: 'Sei sicuro?',
    text: "Vuoi davvero rifiutare l'ordine?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sì, procedi',
    cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('assets/php/rifiuta_ordine.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ ordine_id: ordine_id })
        })
        .then(res => res.text())
        .then(msg => {
          location.reload(); // Ricarica la pagina per aggiornare lo stato
        })
        .catch(err => {
          console.error('Errore:', err);
          alert("Si è verificato un errore durante l'aggiornamento.");
        });
      }
  });
}

function aggiornaOrdine(id, stato){
    if(stato == "Annullato"){
      annullaOrdine(id);
    }else if(stato == "Confermato"){
      confermaOrdine(id);
    }else if(stato == "Rifiutato"){
      rifiutaOrdine(id);
    }
}