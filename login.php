<?php  
    $nomepagina = "Login";

    include("assets/php/config.php");
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    include("assets/php/auth.php");



    if($_SERVER["REQUEST_METHOD"] == "POST"){
        auth_log($db,$_POST['email'], $_POST['password']);
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

        <!-- importo la navbar --> 
        <script src="assets/js/alerts.js"></script>
        <?php include("assets/php/navbar.php");?>
        <section id="login_section" class="bg-dark text-white py-7">
            <div class="container px-4 px-lg-5 h-100">
                <form method="post">
                    <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                        <div class="col-md-5 align-self-end" style="margin-top: 80px; margin-bottom: 20px">
                            <div class="row mb-3 align-items-center">
                                <div class="col-4">
                                    <h3 class="form-label text-white">Email</h3>
                                </div>
                                <div class="col-8">
                                    <input class="form-control p-4 fs-6" type="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-4">
                                    <h3 class="form-label text-white">Password</h3>
                                </div>
                                <div class="col-8">
                                    <input class="form-control p-4 fs-6" type="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mb-1">
                                <!-- Center the "Invia" button -->
                                <div class="d-flex justify-content-center col-auto">
                                    <input class="btn btn-primary btn-xl fs-2m py-3" type="Submit" value="Invia" />
                                </div>
                                <!-- Center the "Hai già un account? Accedi" link -->
                                <div class="d-flex justify-content-center col-auto mt-0">
                                    <p class="text-light mb-0">
                                        Non hai un account? <a href="registra.php">Registrati</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    <?php
        // Footer
        include("assets/php/footer.php");
    ?>
    </body>
</html>
