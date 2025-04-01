<?php  
    $nomepagina = "Registrazione";

    include("assets/php/config.php");
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    include("assets/php/auth.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $post_data = [
            'nome' => $_POST['nome'],
            'cognome' => $_POST['cognome'],
            'cf' => $_POST['cf'],
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'],
            'password' => $_POST['password'],
            'birthdate' => $_POST['birthdate'],
        ];
        auth_reg($db, $post_data);
    }
    
?>

<!DOCTYPE html>
<html lang="it">
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

        <!-- Importa la navbar --> 
        <?php include("assets/php/navbar.php");?>

        <section id="registra_section" class="bg-dark text-white py-7">
    <div class="container px-4 px-lg-5 h-100">
        <form method="post">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-md-5 align-self-end" style="margin-top: 70px; margin-bottom: 20px">
                    <!-- Codice fiscale -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Codice fiscale</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="text" name="cf" placeholder="Codice fiscale" required>
                        </div>
                    </div>
                    <!-- Nome -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Nome</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="text" name="nome" placeholder="Nome" required>
                        </div>
                    </div>
                    <!-- Cognome -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Cognome</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="text" name="cognome" placeholder="Cognome" required>
                        </div>
                    </div>
                    <!-- Data di nascita -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Data di nascita</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="date" name="birthdate" placeholder="YYYY-MM-DD" required>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Email</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Password</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <!-- Telefono -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-4">
                            <h3 class="form-label text-white">Telefono</h3>
                        </div>
                        <div class="col-8">
                            <input class="form-control p-4 fs-6" type="text" name="telefono" placeholder="Telefono" 
                                pattern="[0-9]*" maxlength="10" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>    
                    <!-- Submit button and link -->
                    <div class="row justify-content-center align-items-center mb-1">
                        <!-- Center the "Invia" button -->
                        <div class="d-flex justify-content-center col-auto">
                            <input class="btn btn-primary btn-xl fs-2m py-3" type="submit" value="Invia" />
                        </div>
                        <!-- Center the "Hai già un account? Accedi" link -->
                        <div class="d-flex justify-content-center col-auto mt-0">
                            <p class="text-light mb-0">
                                Hai già un account? <a href="login.php">Accedi</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
    <?php if (isset($_SESSION['reg_message'])): ?>
        var regMessage = <?php echo json_encode($_SESSION['reg_message']); ?>;
        console.log("Messaggio di errore: " + regMessage);  // Debug in JavaScript
        <?php if ($_SESSION['reg_message'] == 'success'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Registrazione completata',
                text: 'La registrazione è andata a buon fine. Sei in attesa di approvazione da parte degli amministratori.',
                confirmButtonText: 'OK'
            });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Credenziali già registrate',
                text: regMessage,
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
        <?php unset($_SESSION['reg_message']); ?>
    <?php endif; ?>
</script>


        <!-- Footer -->
        <?php 
            include("assets/php/footer.php");
        ?>
    </body>
</html>
