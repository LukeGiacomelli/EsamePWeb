
function confirmDelete(whocalled) {
    Swal.fire({
      title: 'Elimina prodotto',
      text: 'Sei sicuro di voler procedere? Non si potrà tornare indietro.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sì, procedi',
      cancelButtonText: 'Annulla'
    }).then((result) => {
      if (result.isConfirmed) {
          document.getElementById('deleteForm' + whocalled.id).submit();
      }
    });
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
    .then(msg => {
        if(msg === "Aggiunto al carrello"){
          aggiornaBadgeCarrello(utente_cf);
        }else{
          Swal.fire({
          title: 'Attenzione',
          text: msg,
          icon: 'error',
          showCancelButton: false,
          confirmButtonText: 'Ok, esci'
          });
        }
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

  function svuotaCarrello() {
    Swal.fire({
      title: 'Svuota carrello',
      text: 'Sei sicuro di voler procedere?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sì, procedi',
      cancelButtonText: 'Annulla'
    }).then((result) => {
      if (result.isConfirmed) {
        svuota()
      }
    });
  }
function svuota(){
  const utente_cf = document.querySelector('.cart-badge')?.dataset.utente;
  fetch('assets/php/svuota_carrello.php',{
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ utente_id: utente_cf })
  })
  .then(msg =>{
      document.getElementById('carrelloModal').classList.remove('show');
      document.querySelector('.modal-backdrop')?.remove();
      aggiornaBadgeCarrello(utente_cf);
  })
}
  
function acquistaCarrello() {
  const utente_cf = document.querySelector('.cart-badge')?.dataset.utente;

  fetch('assets/php/acquista.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ utente_id: utente_cf })
  })
  .then(res => res.text())
  .then(msg => {
    if(msg === "Grazie per l'acquisto!"){
      Swal.fire({
        title: 'Ordine effettuato',
        text: msg + " Verrai contattato da noi via mail per ulteriori informazioni su come procedere",
        icon: 'success',
        showCancelButton: false,
        confirmButtonText: 'Sì, esci',
      }).then((result) => {
        if (result.isConfirmed) {
          // Chiudi modal e aggiorna badge
          document.getElementById('carrelloModal').classList.remove('show');
          document.querySelector('.modal-backdrop')?.remove();
          aggiornaBadgeCarrello(utente_cf);
        }
      });
    }else{
      Swal.fire({
        title: 'Attenzione',
        text: msg,
        icon: 'error',
        showCancelButton: false,
        confirmButtonText: 'Ok, esci'
      });
    }
  })
  .catch(err => {
    console.error("Errore acquisto:", err);
    alert("Errore durante l'acquisto.");
  });
}

  