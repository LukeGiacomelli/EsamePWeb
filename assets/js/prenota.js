// Seleziona tutti i pulsanti di aumento e diminuzione
const increaseBtns = document.querySelectorAll('.increaseBtn');
const decreaseBtns = document.querySelectorAll('.decreaseBtn');
const quantityDisplays = document.querySelectorAll('.quantityDisplay');

// Aggiungi eventi ai pulsanti
increaseBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        let quantity = parseInt(quantityDisplays[index].textContent);
        quantity++;
        quantityDisplays[index].textContent = quantity;
    });
});

decreaseBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        let quantity = parseInt(quantityDisplays[index].textContent);
        if (quantity > 1) { 
            quantity--;
            quantityDisplays[index].textContent = quantity;
        }
    });
});

// Attendi che la pagina sia completamente caricata
document.addEventListener('DOMContentLoaded', function () {
    if (window.postValues) {
        const { priceRange, tipo_prod, desc_tb, hot_box } = window.postValues;

        if (priceRange && document.getElementById("priceRange")) {
            priceRangeInput.value = priceRange;
            priceLabel.textContent = `Price range (${priceRange})`;
        }

        if (tipo_prod && document.getElementById("tipo_prod")) {
            tipo_prodInput.value = tipo_prod;
        }

        if (desc_tb && document.getElementById("desc_textbox")) {
            desc_textboxInput.value = desc_tb;
        }

        if (typeof hot_box !== "undefined") {
            hot_checkbox.checked = hot_box;
        }
    }

    // Seleziona il bottone
    const openModalButton = document.getElementById('openModalButton');
    const openModalModButton = document.getElementById('openModalModButton');

    if(openModalButton != null){
        openModalButton.addEventListener('click', function () {
            const modal = new bootstrap.Modal(document.getElementById('inserimentoProdottoModal'));
            modal.show();
        });
    }
});



function showFields() {
    const tipo = document.getElementById("tipo").value;
    document.querySelectorAll(".dynamic-field").forEach(field => field.style.display = "none");

    if (tipo === "sale") {
        document.getElementById("sale-fields").style.display = "block";
    } else if (tipo === "servizi") {
        document.getElementById("servizi-fields").style.display = "block";
    } else if (tipo === "corsi") {
        document.getElementById("corsi-fields").style.display = "block";
    }
}

function showFieldsM(type) {
    const tipo = type;

    document.querySelectorAll(".dynamic-fieldm").forEach(field => field.style.display = "none");

    if (tipo === "Sala") {
        document.getElementById("sale-fieldsm").style.display = "block";
    } else if (tipo === "Servizio") {
        document.getElementById("servizi-fieldsm").style.display = "block";
    } else if (tipo === "Corso") {
        document.getElementById("corsi-fieldsm").style.display = "block";
    }
}

function openModalModButton(caller) {
    document.getElementById("id_tb").value = caller.id;

    const id_caller = caller.id;
    console.log("--> ", id_caller);
    
    fetch('assets/php/updateProdotti.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_caller: id_caller,
        }),
    })
        .then(response => response.text())
        .then(data => {
            console.log('Risposta da PHP:', data);
            var values = data.split('| ');

            document.getElementById("prezzo_md").value = values[1];
            document.getElementById("img_md").value = values[2];
            document.getElementById("desc_md").value = values[3];

            document.getElementById("tipo_servizio_md").value = values[9];
            document.getElementById("nome_operatore_md").value = values[12];
            document.getElementById("cognome_operatore_md").value = values[13];

            document.getElementById("nome_corso_md").value = values[4];
            document.getElementById("nome_insegnante_corso_md").value = values[10];
            document.getElementById("cognome_insegnante_corso_md").value = values[11];
            document.getElementById("data_md").value = values[6];

            document.getElementById("tipo_sala_md").value = values[8];
            document.getElementById("nome_sala_md").value = values[7];
            document.getElementById("capienza_md").value = values[14];

            var tipo_prod = values[0].includes("C") ? "Corso" : values[0].includes("SV") ? "Servizio" :  "Sala";
            document.getElementById("tipo_md").value = tipo_prod;

            showFieldsM(tipo_prod);

        })
        .catch(error => console.error('Errore:', error));

    const modal = new bootstrap.Modal(document.getElementById('modificaProdottoModal'));
    modal.show();
}