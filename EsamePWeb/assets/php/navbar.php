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
        <li class="nav-item"><a class="nav-link" href="corsi_e_m.php">Corsi e Masterclass</a></li>
        <li class="nav-item"><a class="nav-link" href="prenota.php">Prenota</a></li>

        <?php 
          if (isset($login_email) && $login_type != 'admin') {
            echo '<li class="nav-item"><a class="nav-link" href="pg_personale_ut.php">' . $login_username . '</a></li>';
          } else if (!isset($login_email)) {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
          } else if (isset($login_email) && $login_type == 'admin') {
            echo '<li class="nav-item"><a class="nav-link" href="pg_personale_ut.php">Admin tools</a></li>';
          }

          if (isset($login_email) && $login_type == "cliente") {
            echo '<li class="nav-item"><a class="nav-link" href="ordini.php">Ordini</a></li>';
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body" id="contenuto-carrello">
        <p>Caricamento...</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="acquistaCarrello()">Ordina</button>
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

      <div class="modal-body text-center">
        <iframe 
          src="https://calendar.google.com/calendar/embed?height=500&wkst=2&ctz=Europe%2FRome&showTitle=0&showPrint=0&showTabs=0&mode=WEEK&src=Zjc5NzMzOTAzOTE2YTA1NTRlNjRkYzAwYTY4OGM5YjVlZTMyMjU5MzBjMzJkM2FhYTE2MTEwMjVjZThjZjAzZUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4uaXRhbGlhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&color=%23EF6C00&color=%230B8043" 
          class="w-100 rounded shadow-sm mb-4"
          style="border-width:0; height:500px;" 
          frameborder="0" 
          scrolling="no">
        </iframe>

        <div class="d-flex align-items-center justify-content-center mt-3 gap-3">
            <label for="dataPrenotazione" class="form-label fw-bold mb-0">Data e ora:</label>
            <input 
                type="datetime-local"
                id="dataPrenotazione"
                class="form-control text-center"
                style="max-width: 260px;"
            >

            <label for="durataOre" class="form-label fw-bold mb-0">Ore:</label>
            <input 
                type="number"
                id="durataOre"
                class="form-control text-center"
                min="1" max="12"
                style="max-width: 80px;"
            >
        </div>


        <button class="btn btn-success mt-4 px-4" onclick="confermaPrenotazione()">Conferma prenotazione</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="assets/js/goback.js"></script>
<script src="assets/js/button_func.js"></script>
<script src="assets/js/carrello_modal.js"></script>
<script src="assets/js/gestisci_carrello.js"></script>
