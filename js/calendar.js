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

  fetch('/../EsamePWeb/backend/salva_prenotazione.php', {
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
    const modalCarrello = bootstrap.Modal.getInstance(document.getElementById('carrelloModal'));

    modal.hide();
    modalCarrello.show();
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
    "2025-01-01": [["8:00","20:00"]],  
};

const modalCalendario = document.getElementById('calendarioModal');
modalCalendario.addEventListener('show.bs.modal', () => {
  const prodotto= document.querySelector('.calendario-btn')?.dataset.salaId;
  //Fetch
  fetch('/../EsamePWeb/backend/get_prenotazioni.php',{
    method : 'POST',
    headers : {'Content-Type': 'application/x-www-form-urlencoded'},
    body : new URLSearchParams({prodotto_id: prodotto})
  })
  .then(response => response.text())
  .then(msg => {
      //msg="2025-09-10,10:00,2|2025-09-10,16:00,2"; //Data,ora,durata
      if(msg === "Errore"){
        Swal.fire({
        title: 'Attenzione',
        text: "Errore nel caricare il calendario",
        icon: 'error',
        showCancelButton: false,
        confirmButtonText: 'Ok, esci'
        }).then((result) => {
          if (true) {
            bootstrap.Modal.getInstance(modalCalendario).hide();
          }
        });
      }else if(msg === ""){
        console.log("Nessuna prenotazione nel db");
      }else{
        const temp_array = msg.split("|");
        temp_array.forEach(function(e){
          let ora = e.split(",")[1].trim();
          let date = e.split(",")[0].trim();
          let durata = parseInt(e.split(",")[2]);

          // inizializza l'array se la chiave non esiste ancora
          if (!EXCEPTIONS[date]) {
            EXCEPTIONS[date] = [];
          }

          // aggiungi un intervallo [ora, ora+durata]
          EXCEPTIONS[date].push([ora, addHours(ora, durata)]);
          console.log(ora);
        });
      }

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
  })
});
  //Genera il calendario
  const slotsHeader = document.getElementById('slotsHeader');
  const slotsBody   = document.getElementById('slotsBody');
  const durataOreEl = document.getElementById('durataOre');
  const dtLocalEl   = document.getElementById('dataPrenotazione');

  const toMin = s => { const [h,m] = s.split(":").map(Number); return h*60 + m; };
  function isInException(t, intervals){
    const tm = toMin(t);
    return intervals.some(([s,e]) => tm >= toMin(s) && tm <= toMin(e));
  }
  function addHours(time, h) {
    let [hours, minutes] = time.split(":").map(Number);
    hours += h;
    if (hours >= 24) hours -= 24;
    return `${String(hours).padStart(2,"0")}:${String(minutes).padStart(2,"0")}`;
  }
  
  // Genera e stampa gli slot della data scelta
  function updateSlots(selDate){
    if(!selDate) return;

    const d = new Date(selDate.getFullYear(), selDate.getMonth(), selDate.getDate());
    const ymd = toYMD(d);                        
    const intervals = EXCEPTIONS[ymd] || [];         
    const times = buildTimes(BUSINESS_HOURS);  

    // disabilita gli slot che cadono dentro a un intervallo di eccezione
    const disabledList = times.filter(t => isInException(t, intervals));
    slotsBody.innerHTML = times
      .map(t => slotTemplate(t, disabledList.includes(t)))
      .join('');

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

        console.log(start);
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
