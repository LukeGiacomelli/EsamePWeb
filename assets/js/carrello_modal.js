const modal = document.getElementById('carrelloModal');
modal.addEventListener('show.bs.modal', () => {
  const utente_cf = document.querySelector('.cart-badge')?.dataset.utente;

  fetch('assets/php/carrello_contenuto.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ utente_id: utente_cf })
  })
  .then(res => res.text())
  .then(html => {
    document.getElementById('contenuto-carrello').innerHTML = html;
  })
  .catch(err => {
    console.error('Errore caricamento carrello:', err);
    document.getElementById('contenuto-carrello').innerHTML = "<p>Errore durante il caricamento.</p>";
  });
});

