function confermaPrenotazione() {
  const data = document.getElementById('dataPrenotazione').value;
  const durata = document.getElementById('durataOre').value;
  const prodotto_id = document.querySelector('.calendario-btn')?.dataset.salaId;
  const utente_cf = document.querySelector('.cart-badge')?.dataset.utente; 

  if (!data || !durata || !prodotto_id || !utente_cf) {
    alert("Compila tutti i campi prima di confermare.");
    return;
  }

  
  const start = window.__selectedStart;
  const end   = window.__selectedEnd;
  if(!start || !end){
    alert('Seleziona una data e una fascia oraria.');
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

    // Chiudi modal dopo conferma
    const modal = bootstrap.Modal.getInstance(document.getElementById('calendarioModal'));
    modal.hide();
  })
  .catch(error => {
    console.error("Errore nel salvataggio:", error);
    alert("Errore durante il salvataggio della prenotazione.");
  });
}
  // Configurazione “tipo Bookly”
  const BUSINESS_HOURS = { start: 8, end: 20, stepMin: 120 }; // 08:00→20:00 ogni 120'
  const CLOSED_DAYS    = [0];   // 0=Dom, 6=Sab. Metti [0,6] se chiuso weekend.
  const EXCEPTIONS     = {
      "2025-09-03": ["12:00","14:00"],  // Da sincronizzare con gli ordini!!!!!!!!!!!!!!!!!!!!!!
      "2025-09-04": ["10:00","18:00"], 
  };

  const slotsHeader = document.getElementById('slotsHeader');
  const slotsBody   = document.getElementById('slotsBody');
  const durataOreEl = document.getElementById('durataOre');
  const dtLocalEl   = document.getElementById('dataPrenotazione');

  // Inizializza input datetime (min = adesso, step 15')
  (function initDateTimeLocal(){
    if(!dtLocalEl) return;
    const now = new Date();
    now.setSeconds(0,0);
    const step = 15, m = now.getMinutes();
    now.setMinutes(m + (step - (m % step)) % step);
    dtLocalEl.min   = toLocalDatetimeValue(now);
    dtLocalEl.step  = 900; // 15 minuti
    if(!dtLocalEl.value) dtLocalEl.value = toLocalDatetimeValue(now);
    if(!durataOreEl.value) durataOreEl.value = 1;
  })();

  // Calendario inline
  const fp = flatpickr('#cal', {
    inline: true,
    locale: 'it',
    minDate: 'today',
    disable: [ d => CLOSED_DAYS.includes(d.getDay()) ],
    onReady: (sel, str, inst) => updateSlots(inst.selectedDates[0] || new Date()),
    onChange: (sel) => updateSlots(sel[0])
  });

  // Genera e stampa gli slot della data scelta
  function updateSlots(date){
    if(!date) return;
    const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const label = d.toLocaleDateString('it-IT',{ weekday:'short', day:'2-digit', month:'short' });
    slotsHeader.textContent = label.charAt(0).toUpperCase() + label.slice(1);

    const disabledList = EXCEPTIONS[toYMD(d)] || [];
    const times = buildTimes(BUSINESS_HOURS);

    slotsBody.innerHTML = times.map(t => slotTemplate(t, disabledList.includes(t))).join('');
    attachSlotHandlers(d);
  }

  function buildTimes({start,end,stepMin}){
    const out=[]; for(let m=start*60; m<=end*60; m+=stepMin){
      const hh=String(Math.floor(m/60)).padStart(2,'0');
      const mm=String(m%60).padStart(2,'0');
      out.push(`${hh}:${mm}`);
    } return out;
  }

  function slotTemplate(time, disabled){
    return `<div class="slot ${disabled?'disabled':''}" data-time="${time}">
              <input type="radio" name="slot" ${disabled?'disabled':''}/>
              <span>${time}</span>
            </div>`;
  }

  function attachSlotHandlers(date){
    [...slotsBody.querySelectorAll('.slot:not(.disabled)')].forEach(el=>{
      el.addEventListener('click', ()=>{
        slotsBody.querySelectorAll('.slot').forEach(s=>s.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;

        const [hh,mm] = el.dataset.time.split(':').map(Number);
        const start = new Date(date);
        start.setHours(hh, mm, 0, 0);

        const hours = parseInt(durataOreEl?.value || 1,10);
        const end   = new Date(start.getTime() + hours*60*60*1000);

        if(dtLocalEl) dtLocalEl.value = toLocalDatetimeValue(start);
        window.__selectedStart = start;
        window.__selectedEnd   = end;
      }, false);
    });
  }

  function toYMD(d){
    const p = n => String(n).padStart(2,'0');
    return `${d.getFullYear()}-${p(d.getMonth()+1)}-${p(d.getDate())}`;
  }
  function toLocalDatetimeValue(d){
    const p=n=>String(n).padStart(2,'0');
    return `${d.getFullYear()}-${p(d.getMonth()+1)}-${p(d.getDate())}T${p(d.getHours())}:${p(d.getMinutes())}`;
  }
