function confirmDelete(whocalled) {
            
    let confirmation = confirm("Sei sicuro di voler eliminare?");
    if (confirmation) {
        document.getElementById('deleteForm' + whocalled.id).submit();
    }
}

function aggiungiAlCarrello(prodottoId, utente_cf) {
    fetch('assets/php/aggiungi_carrello.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            prodotto_id: prodottoId.id,
            utente_id: utente_cf
          })
    })
    .then(response => response.text())
    .then(data => {
        aggiornaBadgeCarrello(utente_cf);
    })
    .catch(error => {
        console.error('Errore:', error);
        alert("Errore nell'aggiunta al carrello.");
    });
}


function aggiornaBadgeCarrello(utente_cf) {
    fetch('assets/php/conteggio_carrello.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            utente_id: utente_cf
          })
    })
      .then(response => response.json())
      .then(data => {
        const badgeElements = document.querySelectorAll('.cart-badge');
        badgeElements.forEach(el => {
          el.textContent = data.totale || 0;
        });
      })
      .catch(error => {
        console.error('Errore aggiornamento badge:', error);
      });
  }

  document.addEventListener('DOMContentLoaded', () => {
    const utente_cf = document.querySelector('.cart-badge')?.dataset.utente;

    if (utente_cf) {
      aggiornaBadgeCarrello(utente_cf);
    } else {
      console.warn("Nessun utente loggato trovato per il badge.");
    }
  });

    
  function acquistaCarrello() {
    const utente_cf = document.querySelector('.cart-badge')?.dataset.utente;
  
    fetch('assets/php/acquista.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ utente_id: utente_cf })
    })
    .then(res => res.text())
    .then(msg => {
      if(msg != "Il carrello è vuoto."){
        Swal.fire({
          title: 'Ordine effettuato',
          text: msg,
          icon: 'success',
          showCancelButton: true,
          confirmButtonText: 'Sì, esci',
          cancelButtonText: 'Annulla'
        }).then((result) => {
          if (result.isConfirmed) {
            // Chiudi modal e aggiorna badge
            document.getElementById('carrelloModal').classList.remove('show');
            document.querySelector('.modal-backdrop')?.remove();
            aggiornaBadgeCarrello(utente_cf);
          }
        });
      }
    })
    .catch(err => {
      console.error("Errore acquisto:", err);
      alert("Errore durante l'acquisto.");
    });
  }

  function confermaPrenotazione() {
    const data = document.getElementById('dataPrenotazione').value;
    const durata = document.getElementById('durataOre').value;
    const prodotto_id = document.querySelector('.calendario-btn')?.dataset.salaId;
    const utente_cf = document.querySelector('.cart-badge')?.dataset.utente; // Recupera l'utente loggato
  
    /*alert(data);
    alert(durata);
    alert(prodotto_id);
    alert(utente_cf);*/
    if (!data || !durata || !prodotto_id || !utente_cf) {
      alert("Compila tutti i campi prima di confermare.");
      return;
    }
  
    fetch('assets/php/salva_prenotazione.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        prodotto_id,
        utente_cf,
        data_prenotazione: data,
        durata_prenotazione: durata
      })
    })
    .then(response => response.text())
    .then(text => {
      console.log("Risposta server:", text);
      alert("Prenotazione salvata nel carrello.");
  
      // Chiudi modal dopo conferma
      const modal = bootstrap.Modal.getInstance(document.getElementById('calendarioModal'));
      modal.hide();
    })
    .catch(error => {
      console.error("Errore nel salvataggio:", error);
      alert("Errore durante il salvataggio della prenotazione.");
    });
  }
  