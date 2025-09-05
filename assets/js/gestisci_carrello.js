function modificaQuantita(azione, prodotto_id) {
    fetch('assets/php/aggiorna_quantita.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        azione: azione,
        prodotto_id: prodotto_id,
        utente_id: document.querySelector('.cart-badge')?.dataset.utente
      })
    })
    .then(res => res.text())
    .then(nuovaQuantita => {
      if (parseInt(nuovaQuantita) > 0) {
        document.getElementById(`quantita-${prodotto_id}`).textContent = nuovaQuantita;
      } else {
        // ricarica il modal (o rimuovi l'elemento)
        document.getElementById('carrelloModal').dispatchEvent(new Event('show.bs.modal'));
      }
      aggiornaBadgeCarrello(document.querySelector('.cart-badge')?.dataset.utente);
    });
  }




  function rimuoviDalCarrello(prodotto_id) {
    fetch('assets/php/rimuovi_dal_carrello.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        prodotto_id: prodotto_id,
        utente_id: document.querySelector('.cart-badge')?.dataset.utente
      })
    })
    .then(() => {
      // Ricarica il modal per aggiornare la lista
      document.getElementById('carrelloModal').dispatchEvent(new Event('show.bs.modal'));
      aggiornaBadgeCarrello(document.querySelector('.cart-badge')?.dataset.utente);
    });
  }