<?php
$nomepagina = "Prenota";
include('assets/php/session.php');
include("assets/php/proprietariotools.php");
include("assets/php/config.php");

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['act'])) {
        $act = $_POST['act'];

        if ($act === 'newprod') {
            $post_general_data = [
                'id' => $_POST['id'],
                'prezzo' => $_POST['prezzo'],
                'img' => $_POST['img'],
                'desc' => $_POST['desc'],
                'tipo' => $_POST['tipo'],
            ];

            $tipo = $_POST['tipo'];

            if ($tipo === "sale") {
                $post_specific_data = [
                    'tipo_sala' => $_POST['tipo_sala'],
                    'nome_sala' => $_POST['nome_sala'],
                    'capienza' => $_POST['capienza'],
                ];
            } elseif ($tipo === "servizi") {
                $post_specific_data = [
                    'tipo_servizio' => $_POST['tipo_servizio'],
                    'nome_operatore' => $_POST['nome_operatore'],
                    'cognome_operatore' => $_POST['cognome_operatore'],
                ];
            } elseif ($tipo === "corsi") {
                $post_specific_data = [
                    'nome_corso' => $_POST['nome_corso'],
                    'lezioni' => $_POST['lezioni'],
                    'nome_insegnante_corso' => $_POST['nome_insegnante_corso'],
                    'cognome_insegnante_corso' => $_POST['cognome_insegnante_corso'],
                ];
            } elseif ($tipo === "masterclass") {
                $post_specific_data = [
                    'nome_corso' => $_POST['nome_masterclass'],
                    'lezioni' => 1,
                    'nome_insegnante_corso' => $_POST['nome_insegnante_masterclass'],
                    'cognome_insegnante_corso' => $_POST['cognome_insegnante_masterclass'],
                    'data_corso' => $_POST['data'],
                ];
            }

            creaProdotto($db, $post_general_data, $post_specific_data);

        } else if (str_contains($act, 'delprod')) {
            $sql = "DELETE FROM prodotto WHERE Prodotto_id = '" . explode("_", $act)[1] . "'";
            $result = mysqli_query($db, $sql);

        } else if ($act === 'modprod') {
            $post_general_data = [
                'id' => $_POST['id_tb'],
                'prezzo' => $_POST['prezzo_md'],
                'img' => $_POST['img_md'],
                'desc' => $_POST['desc_md'],
                'tipo' => $_POST['tipo_md'],
            ];

            $tipo = $_POST['tipo_md'];

            if ($tipo === "Sala") {
                $post_specific_data = [
                    'tipo_sala' => $_POST['tipo_sala_md'],
                    'nome_sala' => $_POST['nome_sala_md'],
                    'capienza' => $_POST['capienza_md'],
                ];
            } elseif ($tipo === "Servizio") {
                $post_specific_data = [
                    'tipo_servizio' => $_POST['tipo_servizio_md'],
                    'nome_operatore' => $_POST['nome_operatore_md'],
                    'cognome_operatore' => $_POST['cognome_operatore_md'],
                ];
            } elseif ($tipo === "Corso") {
                $post_specific_data = [
                    'nome_corso' => $_POST['nome_corso_md'],
                    'lezioni' => $_POST['lezioni_md'],
                    'nome_insegnante_corso' => $_POST['nome_insegnante_corso_md'],
                    'cognome_insegnante_corso' => $_POST['cognome_insegnante_corso_md'],
                ];
            } elseif ($tipo === "Masterclass") {
                $post_specific_data = [
                    'nome_corso' => $_POST['nome_masterclass_md'],
                    'lezioni' => 1,
                    'nome_insegnante_corso' => $_POST['nome_insegnante_masterclass_md'],
                    'cognome_insegnante_corso' => $_POST['cognome_insegnante_masterclass_md'],
                    'data_corso' => $_POST['data_md'],
                ];
            }

            aggiornaProdotto($db, $post_general_data, $post_specific_data);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PNL - <?php echo $nomepagina; ?></title>

    <?php
    include("assets/css/allstyle.html");
    ?>

</head>

<body id="page-top">

    <!--importo la navbar e l'header-->
    <?php
    include("assets/php/navbar.php");
    include("assets/php/masthead.php");
    include("assets/php/filtri_prodotti.php")
    ?>


    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php include("assets/php/stampa_prodotti.php"); ?>

                <!-- Bottone per aggiungere nuovi prodotti -->
                <?php
                if (isset($login_type) && ($login_type == 'proprietario')) {
                    echo '  <div class="text-center mt-5">
                                    <button id="openModalButton" class="btn btn-outline-dark btn-lg">+</button>
                                </div> ';
                }
                ?>

            </div>
        </div>
    </section>


    <!-- Modal per Inserimento Prodotto -->
    <div class="modal fade inserimento-prodotto-modal" id="inserimentoProdottoModal" tabindex="-1"
        aria-labelledby="inserimentoProdottoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inserimentoProdottoModalLabel">Nuovo Prodotto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">

                        <label for="id">ID:</label>
                        <input type="text" id="id" name="id" class="form-control" required><br>

                        <label for="prezzo">Prezzo:</label>
                        <input type="number" id="prezzo" name="prezzo" class="form-control" required><br>

                        <label for="img">Immagine (URL):</label>
                        <input type="text" id="img" name="img" class="form-control" required><br><br>

                        <label for="desc">Descrizione:</label>
                        <textarea id="desc" name="desc" class="form-control" required></textarea><br>

                        <label for="tipo">Tipo di prodotto:</label>
                        <select id="tipo" name="tipo" class="form-select" onchange="showFields()" required>
                            <option value="">-- Seleziona --</option>
                            <option value="sale">Sala</option>
                            <option value="servizi">Servizio</option>
                            <option value="corsi">Corso</option>
                            <option value="masterclass">Masterclass</option>
                        </select><br><br>

                        <!-- Campi dinamici per Sale -->
                        <div id="sale-fields" class="dynamic-field" style="display: none;">
                            <label for="tipo_sala">Tipo di sala:</label>
                            <select id="tipo_sala" name="tipo_sala" class="form-select">
                                <option value="sala prove">Sala Prove</option>
                                <option value="sala registrazione">Sala di Registrazione</option>
                            </select><br>

                            <label for="nome_sala">Nome:</label>
                            <input type="text" id="nome_sala" name="nome_sala" class="form-control"><br>

                            <label for="capienza">Capienza:</label>
                            <input type="number" id="capienza" name="capienza" class="form-control"><br>
                        </div>

                        <!-- Campi dinamici per Servizi -->
                        <div id="servizi-fields" class="dynamic-field" style="display: none;">
                            <label for="tipo_servizio">Tipo di servizio:</label>
                            <select id="tipo_servizio" name="tipo_servizio" class="form-select">
                                <option value="mix">Mix</option>
                                <option value="master">Master</option>
                                <option value="mix&master">Mix & Master</option>
                            </select><br>

                            <label for="operatore">Operatore:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_operatore" name="nome_operatore" class="form-control"
                                        placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_operatore" name="cognome_operatore"
                                        class="form-control" placeholder="Cognome">
                                </div>
                            </div><br>
                        </div>

                        <!-- Campi dinamici per Corsi -->
                        <div id="corsi-fields" class="dynamic-field" style="display: none;">
                            <label for="nome_corso">Nome:</label>
                            <input type="text" id="nome_corso" name="nome_corso" class="form-control"><br>

                            <label for="lezioni">Numero di lezioni:</label>
                            <select id="lezioni" name="lezioni" class="form-select">
                                <option value="15">15</option>
                                <option value="30">30</option>
                            </select><br>

                            <label for="insegnante_corso">Insegnante:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_insegnante_corso" name="nome_insegnante_corso"
                                        class="form-control" placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_insegnante_corso" name="cognome_insegnante_corso"
                                        class="form-control" placeholder="Cognome">
                                </div>
                            </div><br>
                        </div>

                        <!-- Campi dinamici per Masterclass -->
                        <div id="masterclass-fields" class="dynamic-field" style="display: none;">
                            <label for="nome_masterclass">Nome:</label>
                            <input type="text" id="nome_masterclass" name="nome_masterclass" class="form-control"><br>

                            <label for="insegnante_masterclass">Insegnante:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_insegnante_masterclass"
                                        name="nome_insegnante_masterclass" class="form-control" placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_insegnante_masterclass"
                                        name="cognome_insegnante_masterclass" class="form-control"
                                        placeholder="Cognome">
                                </div>
                            </div><br>

                            <label for="data">Data:</label>
                            <input type="date" id="data" name="data" class="form-control"><br>

                        </div>

                        <button type="submit" name="act" value="newprod" class="btn btn-primary">Invia</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal per Modifica Prodotto -->
    <div class="modal fade modifica-prodotto-modal" id="modificaProdottoModal" tabindex="-1"
        aria-labelledby="modificaProdottoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificaProdottoModalLabel">Modifica Prodotto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="id">ID:</label>
                        <input type="text" id="id_tb" name="id_tb" class="form-control" value="" readonly><br>

                        <label for="prezzo">Prezzo:</label>
                        <input type="number" id="prezzo_md" name="prezzo_md" class="form-control" required><br>

                        <label for="img">Immagine (URL):</label>
                        <input type="text" id="img_md" name="img_md" class="form-control" required><br><br>

                        <label for="desc">Descrizione:</label>
                        <textarea id="desc_md" name="desc_md" class="form-control" required></textarea><br>

                        <label for="tipo">Tipo di prodotto: </label>
                        <input type="text" id="tipo_md" name="tipo_md" class="form-control" value="" readonly><br>

                        <!--<button id="more_btn" value="more" class="btn btn-primary" onclick="showFieldsM(this)">More options...</button>-->

                        <!-- Campi dinamici per Sale -->
                        <div id="sale-fieldsm" class="dynamic-fieldm" style="display: none;">
                            <label for="tipo_sala_md">Tipo di sala:</label>
                            <select id="tipo_sala_md" name="tipo_sala_md" class="form-select">
                                <option value="Sala prove">Sala Prove</option>
                                <option value="Sala registrazione">Sala di Registrazione</option>
                            </select><br>

                            <label for="nome_sala">Nome:</label>
                            <input type="text" id="nome_sala_md" name="nome_sala_md" class="form-control"><br>

                            <label for="capienza">Capienza:</label>
                            <input type="number" id="capienza_md" name="capienza_md" class="form-control"><br>
                        </div>

                        <!-- Campi dinamici per Servizi -->
                        <div id="servizi-fieldsm" class="dynamic-fieldm" style="display: none;">
                            <label for="tipo_servizio">Tipo di servizio:</label>
                            <select id="tipo_servizio_md" name="tipo_servizio_md" class="form-select">
                                <option value="Mix">Mix</option>
                                <option value="Master">Master</option>
                                <option value="Mix&Master">Mix & Master</option>
                            </select><br>

                            <label for="operatore">Operatore:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_operatore_md" name="nome_operatore_md"
                                        class="form-control" placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_operatore_md" name="cognome_operatore_md"
                                        class="form-control" placeholder="Cognome">
                                </div>
                            </div><br>
                        </div>

                        <!-- Campi dinamici per Corsi -->
                        <div id="corsi-fieldsm" class="dynamic-fieldm" style="display: none;">
                            <label for="nome_corso">Nome:</label>
                            <input type="text" id="nome_corso_md" name="nome_corso_md" class="form-control"><br>

                            <label for="lezioni">Numero di lezioni:</label>
                            <select id="lezioni_md" name="lezioni_md" class="form-select">
                                <option value="15">15</option>
                                <option value="30">30</option>
                            </select><br>

                            <label for="insegnante_corso">Insegnante:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_insegnante_corso_md" name="nome_insegnante_corso_md"
                                        class="form-control" placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_insegnante_corso_md"
                                        name="cognome_insegnante_corso_md" class="form-control" placeholder="Cognome">
                                </div>
                            </div><br>
                        </div>

                        <!-- Campi dinamici per Masterclass -->
                        <div id="masterclass-fieldsm" class="dynamic-fieldm" style="display: none;">
                            <label for="nome_masterclass">Nome:</label>
                            <input type="text" id="nome_masterclass_md" name="nome_masterclass_md"
                                class="form-control"><br>

                            <label for="insegnante_masterclass">Insegnante:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="nome_insegnante_masterclass_md"
                                        name="nome_insegnante_masterclass_md" class="form-control" placeholder="Nome">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="cognome_insegnante_masterclass_md"
                                        name="cognome_insegnante_masterclass_md" class="form-control"
                                        placeholder="Cognome">
                                </div>
                            </div><br>

                            <label for="data">Data:</label>
                            <input type="date" id="data_md" name="data_md" class="form-control"><br>

                        </div>

                        <button type="submit" name="act" value="modprod" class="btn btn-primary">Aggiorna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/prenota.js"></script>
    <?php
    include("assets/php/footer.php");
    ?>
</body>

</html>