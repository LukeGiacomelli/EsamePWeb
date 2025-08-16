function loadComments(prodottoId) {
    fetch('assets/php/commenti.php?prodotto_id=' + prodottoId.id)
      .then(res => res.text())
      .then(html => {
        document.getElementById('commentiEsistenti').innerHTML = html;
      });
  }
  
  function inviaCommento(prodottoId, utente_cf) {
    const messaggio = document.getElementById('messaggio').value;
    const voto = document.getElementById('voto').value;
  
    fetch('assets/php/salva_commenti.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        prodotto_id: prodottoId.id,
        messaggio,
        punteggio: voto,
        utente_id: utente_cf
      })
    })
    .then(res => res.text())
    .then(() => {
      loadComments(prodottoId);
      document.getElementById('messaggio').value = '';
    });
  }

  document.querySelectorAll('#starRating .star').forEach(star => {
    star.addEventListener('mouseover', function () {
      const val = parseInt(this.dataset.value);
      highlightStars(val);
    });
    star.addEventListener('mouseout', () => {
      highlightStars(parseInt(document.getElementById('voto').value));
    });
    star.addEventListener('click', function () {
      document.getElementById('voto').value = this.dataset.value;
      highlightStars(parseInt(this.dataset.value));
    });
  });
  
  function highlightStars(value) {
    document.querySelectorAll('#starRating .star').forEach(star => {
      if (parseInt(star.dataset.value) <= value) {
        star.classList.remove('bi-star');
        star.classList.add('bi-star-fill', 'text-warning');
      } else {
        star.classList.add('bi-star');
        star.classList.remove('bi-star-fill', 'text-warning');
      }
    });
  }