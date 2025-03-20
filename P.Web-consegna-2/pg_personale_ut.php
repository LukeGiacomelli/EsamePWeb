<?php  
$nomepagina = "Profilo";

include('assets/php/session.php');
include('assets/php/usertools.php');
include('assets/php/config.php');

// Non permette di arrivare a questa pagina se non passando da dentro il sito (da loggati)
if (!isset($login_email)) {
    // If not logged in, redirect to the index page
    header('Location: index.php');
    exit(); // Make sure to stop the script after redirection
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logoutbutton'])) {
        logout();
    }

    if (isset($_POST['modEmailButton'])) {
        modificaEmail($db, $_POST['newEmail'], $login_cf);
    }

    if (isset($_POST['modTelButton'])) {
        modificaTel($db, $_POST['newPhone'], $login_cf);
    }

    if (isset($_POST['modPasswButton'])) {
        modificaPassword($db, $_POST['oldPassw'], $_POST['newPassw'], $login_cf);
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
    
    <?php include("assets/php/allstyle.html"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">

    <!-- Importo la navbar -->
    <?php include("assets/php/navbar.php"); ?>



    <section class="d-flex flex-column align-items-center bg-dark" style="padding-top: 60px;">
    <div class="container" style="padding-top: 30px; padding-bottom: 35px;">
        <div class="row d-flex justify-content-center">
            <div class="col col-lg-6">
                <div class="card text-center mb-3" style="border-radius: .5rem; max-height: 85vh; overflow-y: auto; position: relative;">
                    <div class="card-body p-4">
                        <!-- Profile Image -->
                        <h3>Utente:</h3>
                        <p><?php echo $login_username; ?> <?php echo $login_surname; ?></p>

                        <h6 class="mt-4">Informazioni su di te</h6>
                        <hr class="mt-0 mb-4">

                        <div class="row">
                            <!-- Name, Surname, and Codice Fiscale (non-editable) -->
                            <div class="d-flex justify-content-between mb-3">
                                <div class="col-4 text-start">
                                    <h6>Nome</h6>
                                    <p class="text-muted"><?php echo $login_username; ?></p>
                                </div>
                                <div class="col-4 text-center">
                                    <h6>Cognome</h6>
                                    <p class="text-muted"><?php echo $login_surname; ?></p>
                                </div>
                                <div class="col-4 text-end">
                                    <h6>Codice Fiscale</h6>
                                    <p class="text-muted"><?php echo $login_cf; ?></p>
                                </div>
                            </div>

                            <!-- Phone and Email with Edit Buttons -->
                            <div class="d-flex justify-content-between mb-3">
                                <div class="col-4 text-start">
                                    <h6>Telefono
                                        <button class="btn btn-link p-0 ms-2" style="font-size: 14px;" onclick="openModal('editPhoneModal')">
                                            <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                                        </button>
                                    </h6>
                                    <p class="text-muted" id="phone"><?php echo $login_tel; ?></p>
                                </div>
                                <div class="col-4 text-center">
                                    <h6>Email 
                                        <button class="btn btn-link p-0 ms-2" style="font-size: 14px;" onclick="openModal('editEmailModal')">
                                            <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
                                        </button>
                                    </h6>
                                    <p class="text-muted" id="email"><?php echo $login_email; ?></p>
                                </div>
                                <div class="col-4 text-end">
                                    <h6>Data di nascita</h6>
                                    <p class="text-muted"><?php echo $login_birth; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center mt-3 text-white">Modifica Password 
            <button class="btn btn-link p-0 ms-2" style="font-size: 14px;" onclick="openModal('editPasswModal')">
                <i class="bi bi-pencil-square" style="font-size: 16px;"></i>
            </button>
        </p>
        <!-- Logout Button -->
        <form id="logoutForm" method="post" class="text-center mt-3">
            <button type="button" id="logoutButton" class="btn btn-danger">Logout</button> 
            <input type="hidden" name="logoutbutton" value="1">
        </form>
    </div>
</section>

<!-- Modal for Editing Phone -->
<div class="modal fade" id="editPhoneModal" tabindex="-1" aria-labelledby="editPhoneModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPhoneModalLabel">Modifica numero di telefono</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="mb-3">
            <label for="newPhone" class="form-label">Numero attuale: <?php echo $login_tel; ?></label>
            <input type="text" class="form-control" id="newPhone" name="newPhone" placeholder="Nuovo telefono" required>
          </div>
          <button type="submit" class="btn btn-primary" name="modTelButton">Salva</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Editing Email -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEmailModalLabel">Modifica Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="mb-3">
            <label for="newEmail" class="form-label">Email attuale: <?php echo $login_email; ?></label>
            <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="Nuova email" required>
          </div>
          <button type="submit" class="btn btn-primary" name="modEmailButton">Salva</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Editing Password -->
<div class="modal fade" id="editPasswModal" tabindex="-1" aria-labelledby="editPasswModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPasswModalLabel">Modifica Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- Old Password Field -->
          <div class="mb-3 position-relative">
            <input type="password" class="form-control" id="oldPassw" name="oldPassw" placeholder="Vecchia password" required>
            <button type="button" class="btn btn-sm btn-link position-absolute" style="top: 50%; transform: translateY(-50%); right: 10px;" onclick="togglePasswordVisibility('oldPassw')">
              <i class="bi bi-eye-slash" id="toggleIcon-oldPassw"></i>
            </button>
          </div>
          <!-- New Password Field -->
          <div class="mb-3 position-relative">
            <input type="password" class="form-control" id="newPassw" name="newPassw" placeholder="Nuova password" required>
            <button type="button" class="btn btn-sm btn-link position-absolute" style="top: 50%; transform: translateY(-50%); right: 10px;" onclick="togglePasswordVisibility('newPassw')">
              <i class="bi bi-eye-slash" id="toggleIcon-newPassw"></i>
            </button>
          </div>
          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary" name="modPasswButton">Salva</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php 
        if ($login_type == 'admin') {  // mostra gestione utenti solo se l'utente è un admin
            include("gestione_utenti.php");
        }
    ?>

    <?php include("assets/php/footer.php"); ?>

    <script>
    document.getElementById('logoutButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Sei sicuro?',
            text: "Vuoi davvero effettuare il logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sì, esci',
            cancelButtonText: 'Annulla'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
  </script>

<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Successo',
            text: '<?php echo $_SESSION['success_message']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php elseif (isset($_SESSION['error_message'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Errore nella modifica',
            text: '<?php echo $_SESSION['error_message']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

</body>
</html>


<script>

// Function to open a modal
function openModal(modalId) {
  const modal = new bootstrap.Modal(document.getElementById(modalId));
  modal.show();
}


function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const toggleIcon = document.getElementById('toggleIcon-' + fieldId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    }
}
</script>