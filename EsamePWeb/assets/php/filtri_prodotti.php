<div class="card bg-light p-4 ">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleContent" aria-expanded="false" aria-controls="collapsibleContent">
                Filtra...
            </button>
        </div>
    </div>
    <div class="row align-items-center collapse" id="collapsibleContent">
        <form method="post">
            <div class="col-3-sm align-self-center w-100">
                <label for="priceRange" class="form-label text-secondary" id='priceLabel'>Max price (250)</label>
                <input type="range" class="form-range" id="priceRange" name="priceRange" min="0" max="1000" value = "1000" step="5">
            </div>
            <div class="col-3-sm align-self-center w-100">
                <label for="desc_tb" class="form-label text-secondary" id='desc_label'>Cerca in descrizione...</label>
                <input type="text" class="form-control" id="desc_tb" name="desc_tb">
            </div>
            <div class="col-3-sm align-self-center w-100">
                <label for="tipo_prod" class="form-label text-secondary">Tipo prodotto:</label>
                <select id="tipo_prod" name="tipo_prod" class="form-select">
                    <option value="op">Tutti</option>
                    <option value="Sala">Sala</option>
                    <option value="Servizio">Servizio</option>
                    <option value="Corso">Corso</option>
                </select>
                </div>
            <div class="col-3-sm align-self-center w-100">
                <label for="daterange" class="form-label text-secondary">Quando?</label>
                <div class="row py-7">
                    <div class="col-sm-6">
                        <input type="date" id="data_min" name="data_min" class="form-control" disabled><br>
                    </div>
                    <div class="col-sm-6">
                        <input type="date" id="data_max" name="data_max" class="form-control" disabled><br>
                    </div>
                </div>
            </div>
            <div class="col-3-sm align-self-center w-100">
                    <label for="hot_box" class="form-label text-secondary" id='desc_label'>Prodotti raccomandati...</label>
                    <input type="checkbox" class="form-check-input" id="hot_box" name="hot_box">
            </div><br>
            <div class="col-3-sm align-self-center w-100">
                <button type="submit" name="act" value="filtra" class="btn btn-primary">Filtra</button>
            </div>
        </form>
    </div>
</div>

<script>
    const priceRange = document.getElementById("priceRange");
    const priceLabel = document.getElementById("priceLabel");

    const desc_textbox = document.getElementById("desc_tb");

    const hot_checkbox = document.getElementById("hot_box");

    const tipo_prod = document.getElementById("tipo_prod");
    const date_min = document.getElementById("data_min");
    const date_max = document.getElementById("data_max");

    priceRange.addEventListener("input", e => {
            let val = parseInt(priceRange.value);
            priceLabel.textContent = "Price range (" + val + ")";
    });

    tipo_prod.addEventListener("input", e => {
            let val = tipo_prod.value;

            if (val == "Corso"){
                date_min.disabled = false;
                date_max.disabled = false;
            }else{
                date_min.disabled = true;
                date_max.disabled = true;
            }
    });
</script>