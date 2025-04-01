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
        if (quantity > 1) { // Evita che la quantità scenda sotto 1
            quantity--;
            quantityDisplays[index].textContent = quantity;
        }
    });
});

// Attendi che la pagina sia completamente caricata
document.addEventListener('DOMContentLoaded', function () {
    // Seleziona il bottone
    const openModalButton = document.getElementById('openModalButton');
    const openModalModButton = document.getElementById('openModalModButton');

    // Aggiungi un evento al click
    openModalButton.addEventListener('click', function () {
        // Apri il modal usando il suo ID
        const modal = new bootstrap.Modal(document.getElementById('inserimentoProdottoModal'));
        modal.show();
    });
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
    } else if (tipo === "masterclass") {
        document.getElementById("masterclass-fields").style.display = "block";
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
    } else if (tipo === "Masterclass") {
        document.getElementById("masterclass-fieldsm").style.display = "block";
    }
}

function openModalModButton(caller) {
    document.getElementById("id_tb").value = caller.id;

    const id_caller = caller.id;
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

            document.getElementById("nome_masterclass_md").value = values[4];
            document.getElementById("nome_insegnante_masterclass_md").value = values[10];
            document.getElementById("cognome_insegnante_masterclass_md").value = values[11];
            document.getElementById("data_md").value = values[6];

            document.getElementById("tipo_servizio_md").value = values[9];
            document.getElementById("nome_operatore_md").value = values[12];
            document.getElementById("cognome_operatore_md").value = values[13];

            document.getElementById("nome_corso_md").value = values[4];
            document.getElementById("lezioni_md").value = values[5];
            document.getElementById("nome_insegnante_corso_md").value = values[10];
            document.getElementById("cognome_insegnante_corso_md").value = values[11];

            document.getElementById("tipo_sala_md").value = values[8];
            document.getElementById("nome_sala_md").value = values[7];
            document.getElementById("capienza_md").value = values[14];

            var tipo_prod = values[0].includes("Cm") ? "Masterclass" : values[0].includes("SV") ? "Servizio" : values[0].includes("C") ? "Corso" : "Sala";
            document.getElementById("tipo_md").value = tipo_prod;

            showFieldsM(tipo_prod);

        })
        .catch(error => console.error('Errore:', error));

    // Passa le variabili PHP a JavaScript

    const modal = new bootstrap.Modal(document.getElementById('modificaProdottoModal'));
    modal.show();
}