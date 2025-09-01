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
    const utente_cf = document.querySelector('.cart-badge')?.dataset.utente; 

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

        const start = window.__selectedStart;
    const end   = window.__selectedEnd;
    if(!start || !end){
      alert('Seleziona una data e una fascia oraria.');
      return;
    }

  }
  
  // === CONFIG ===
  const BUSINESS_HOURS = { start: 8, end: 20, stepMin: 120 }; // 08→20 ogni 120'
  const CLOSED_DAYS    = [0]; // 0=Dom, 6=Sab
  const TZ             = 'Europe/Rome';
  const SALA_ID        = window.currentSalaId || 1; // imposta l’id della sala da qualche parte

  const slotsHeader = document.getElementById('slotsHeader');
  const slotsBody   = document.getElementById('slotsBody');
  const durataOreEl = document.getElementById('durataOre');
  const dtLocalEl   = document.getElementById('dataPrenotazione');

  // 👇 MAPPA dinamica: { 'YYYY-MM-DD': [ {start:'HH:MM', end:'HH:MM'}, ... ] }
  let BUSY = {};

  // ---- utils ----
  const pad = n => String(n).padStart(2,'0');
  const toYMD = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
  const t2m   = s => { const [h,m]=s.split(':').map(Number); return h*60+m; };
  const overlap = (a0,a1,b0,b1) => Math.max(a0,b0) < Math.min(a1,b1);

  function toLocalDatetimeValue(d){
    return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
  }

  function buildTimes({start,end,stepMin}){
    const out=[]; for(let m=start*60; m<=end*60; m+=stepMin){
      out.push(`${pad(Math.floor(m/60))}:${pad(m%60)}`);
    } return out;
  }

  // ---- calendario ----
  const fp = flatpickr('#cal', {
    inline: true,
    locale: 'it',
    minDate: 'today',
    disable: [ d => CLOSED_DAYS.includes(d.getDay()) ],
    onReady: (_, __, inst) => { loadBusyForMonth(inst); },
    onMonthChange: (_, __, inst) => { loadBusyForMonth(inst); },
    onChange: (sel) => updateSlots(sel[0]),
  });

  async function loadBusyForMonth(inst){
    const base = new Date(inst.currentYear, inst.currentMonth, 1);
    const from = `${inst.currentYear}-${pad(inst.currentMonth+1)}-01`;
    const last = new Date(inst.currentYear, inst.currentMonth+1, 0).getDate();
    const to   = `${inst.currentYear}-${pad(inst.currentMonth+1)}-${pad(last)}`;

    try{
      const res = await fetch(`/api/availability.php?sala_id=${encodeURIComponent(SALA_ID)}&from=${from}&to=${to}`);
      BUSY = await res.json();  // { '2025-09-01': [{start:'12:00',end:'14:00'}], ... }
    }catch(e){
      console.error('Errore caricando disponibilità', e);
      BUSY = {};
    }
    updateSlots(fp.selectedDates[0] || base);
  }

  // ---- stampa slot del giorno selezionato (disabilita se si sovrappone ai busy) ----
  function updateSlots(date){
    if(!date) return;
    const day = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const label = day.toLocaleDateString('it-IT',{ weekday:'short', day:'2-digit', month:'short' });
    slotsHeader.textContent = label.charAt(0).toUpperCase() + label.slice(1);

    const intervals = (BUSY[toYMD(day)] || []); // [{start,end}...]
    const durMin = Math.max(1, parseInt(durataOreEl?.value || 1, 10)) * 60;

    const items = buildTimes(BUSINESS_HOURS).map(t => {
      const startMin = t2m(t);
      const endMin   = startMin + durMin;
      const disabled = intervals.some(({start,end}) => overlap(startMin, endMin, t2m(start), t2m(end)));
      return slotTemplate(t, disabled);
    });

    slotsBody.innerHTML = items.join('') || `<div class="p-3">Nessuno slot disponibile</div>`;
    attachSlotHandlers(day);
  }

  function slotTemplate(time, disabled=false){
    return `
      <div class="slot ${disabled?'disabled':''}" data-time="${time}">
        <input type="radio" name="slot" ${disabled?'disabled':''}/>
        <span>${time}</span>
      </div>`;
  }

  function attachSlotHandlers(date){
    [...document.querySelectorAll('#slotsBody .slot:not(.disabled)')].forEach(el=>{
      el.addEventListener('click', ()=>{
        document.querySelectorAll('#slotsBody .slot').forEach(s=>s.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;

        const [hh,mm] = el.dataset.time.split(':').map(Number);
        const start = new Date(date);
        start.setHours(hh, mm, 0, 0);

        const hours = Math.max(1, parseInt(durataOreEl?.value || 1,10));
        const end   = new Date(start.getTime() + hours*60*60*1000);

        if(dtLocalEl) dtLocalEl.value = toLocalDatetimeValue(start);
        window.__selectedStart = start;
        window.__selectedEnd   = end;
      }, false);
    });
  }

  // se cambia la durata, ricalcola gli slot del giorno corrente
  if(durataOreEl){
    durataOreEl.addEventListener('input', () => updateSlots(fp.selectedDates[0] || new Date()));
  }