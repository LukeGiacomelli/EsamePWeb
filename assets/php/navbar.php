<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
  <div class="container px-4 px-lg-5">
    <button class="back-btn" onclick="goBack()">
      <i class="bi bi-arrow-left fs-4 me-2 arrow-icon"></i>
    </button>

    <a class="navbar-brand" href="#page-top">PNL STUDIO</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ms-auto my-2 my-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="sale.php">Sale</a></li>
        <li class="nav-item"><a class="nav-link" href="corsi_e_m.php">Workshop</a></li>
        <li class="nav-item"><a class="nav-link" href="prenota.php">Prenota</a></li>

        <?php 
          if (isset($login_email) && $login_type != 'admin') {
            if ($login_type == "cliente") {
              echo '<li class="nav-item"><a class="nav-link" href="ordini.php">Ordini</a></li>';
            } else if ($login_type == "proprietario") {
              echo '<li class="nav-item"><a class="nav-link" href="gestione_ordini.php">Gestione ordini</a></li>';
            }

            echo '<li class="nav-item"><a class="nav-link" href="pg_personale_ut.php">' . $login_username . '</a></li>';
          } else if (!isset($login_email)) {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
          } else if (isset($login_email) && $login_type == 'admin') {
            echo '<li class="nav-item"><a class="nav-link" href="pg_personale_ut.php">Admin tools</a></li>';
          }
        ?>
      </ul>

      <?php 
        if (isset($login_type) && $login_type == 'cliente') {
          echo '
            <form class="d-flex">
              <button type="button" data-bs-toggle="modal" data-bs-target="#carrelloModal" class="btn btn-outline-translucent nav-link btn-responsive d-none d-md-block ms-4">
                <i class="bi-cart-fill me-1 text-dark"></i>
                <span class="badge bg-dark text-white ms-1 rounded-pill cart-badge" data-utente="'.$login_cf.'">0</span>
              </button>

              <!-- quando è collassato -->
              <button type="button" data-bs-toggle="modal" data-bs-target="#carrelloModal" class="btn btn-outline-dark btn-responsive d-block d-md-none">
                <i class="bi-cart-fill me-1"></i>
                <span class="badge bg-dark text-white ms-1 rounded-pill cart-badge" data-utente="'.$login_cf.'">0</span>
              </button>
            </form>
          ';
        }
      ?>
    </div>
  </div>
</nav>

<!-- Modal Carrello -->
<div class="modal fade" id="carrelloModal" tabindex="-1" aria-labelledby="carrelloModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carrelloModalLabel">Il tuo carrello</h5>
        <p class="card-subtitle text-muted ps-2"><strong id="tot_carrello"></strong></p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body" id="contenuto-carrello">
        <p>Caricamento...</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-error" onclick="svuotaCarrello()"><i class="bi bi-trash"></i></button> 
        <button class="btn btn-success" onclick="acquistaCarrello()">Ordina (Pagamento in sede)</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Calendario -->
<div class="modal fade" id="calendarioModal" tabindex="-1" aria-labelledby="calendarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="calendarioModalLabel">Seleziona una data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>

      <!-- ====== BODY: SOLO calendario + slots ====== -->
      <div class="modal-body text-center">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <div class="picker-wrap">
          <!-- Calendario -->
          <input id="cal" type="text" hidden>

          <!-- Colonna slot -->
          <div class="slots">
            <div class="slots-header" id="slotsHeader">—</div>
            <div id="slotsBody" role="listbox" aria-label="Fasce orarie disponibili"></div>
          </div>
        </div>
      </div>

      <!-- ====== FOOTER: picker + bottone inline ====== -->
      <div class="modal-footer justify-content-center mt-3">
        <div class="booking-actions">
          <label for="dataPrenotazione" class="form-label fw-bold mb-0">Quando:</label>
          <input
            type="datetime-local"
            id="dataPrenotazione"
            class="form-control text-center"
            style="width:260px;"
          >

          <label for="durataOre" class="form-label fw-bold mb-0">Ore:</label>
          <input
            type="number"
            id="durataOre"
            class="form-control text-center"
            min="1" max="12"
            value="1"
            style="width:80px;"
          >

          <button type="button" class="btn btn-success px-4" onclick="confermaPrenotazione()">
            Conferma prenotazione
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
<script src="assets/js/goback.js"></script>
<script src="assets/js/button_func.js"></script>
<script src="assets/js/calendar.js"></script>
<script src="assets/js/carrello_modal.js"></script>
<script src="assets/js/gestisci_carrello.js"></script>