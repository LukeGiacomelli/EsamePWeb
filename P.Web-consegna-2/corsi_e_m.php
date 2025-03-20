<?php  
    $nomepagina = "Corsi e Masterclass";
    include('assets/php/session.php');
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
            include("assets/php/allstyle.html");
        ?>

    </head>
    <body id="page-top">

        <!--importo la navbar e l'header-->
        <?php 
        include("assets/php/navbar.php");
        include("assets/php/masthead.php");
        ?>


        
<!-- Corso di canto -->

<section class="page-section bg-primary" id="corso-di-canto">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <!-- Colonna per l'immagine -->
            <div class="col-lg-6 text-center mb-4 mb-lg-0">
                <img src="https://www.donnad.it/sites/default/files/styles/r_visual_d/public/201448/shutterstock_162783689.jpg?itok=7TnaoYPl" 
                     alt="Corso di canto" class="img-fluid rounded">
            </div>
            <!-- Colonna per il testo -->
            <div class="col-lg-6 text-center">
                <h2 class="text-white mt-0 titolo-CeM">Corso di canto</h2>
                <hr class="divider divider-light" />
                <p class="text-white-75 mb-4">
                    Che tu sia un tipo da live o sia in procinto di registrare il tuo nuovo disco, ti forniremo tutti gli strumenti per essere la versione migliore di te stesso nel canto.
                </p> 
                <p class="text-white-75 mb-4">
                    Questo corso è adatto a tutti i livelli - dai principianti agli esperti - e a tutte le età. 
                </p>
                <p class="text-white-75 mb-4">
                    Insieme creeremo un percorso personalizzato che ti permetta di raggiungere i tuoi obbiettivi a corto, medio e lungo termine.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- Corso di Mix&Master -->

<section class="page-section bg-dark text-white" id="corso-di-canto">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <!-- Colonna per l'immagine -->
            <div class="col-lg-6 text-center mb-4 mb-lg-0">
                <img src="https://static.wixstatic.com/media/11062b_d8286a39310944e984f8cc728423b66a~mv2.jpg/v1/fill/w_736,h_414,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/11062b_d8286a39310944e984f8cc728423b66a~mv2.jpg" 
                     alt="Corso di Mix&Master" class="img-fluid rounded">
            </div>
            <!-- Colonna per il testo -->
            <div class="col-lg-6 text-center">
                <h2 class="text-white mt-0 titolo-CeM">Corso di Mix&Master</h2>
                <hr class="divider divider-light" />
                <p class="text-white-75 mb-4">
                    Che tu sia un tipo da live o sia in procinto di registrare il tuo nuovo disco, ti forniremo tutti gli strumenti per essere la versione migliore di te stesso nel canto.
                </p> 
                <p class="text-white-75 mb-4">
                    Questo corso è adatto a tutti i livelli - dai principianti agli esperti - e a tutte le età. 
                </p>
                <p class="text-white-75 mb-4">
                    Insieme creeremo un percorso personalizzato che ti permetta di raggiungere i tuoi obbiettivi a corto, medio e lungo termine.
                </p>
            </div>
        </div>
    </div>
</section>

    <?php 
        include("assets/php/footer.php");
    ?>
    </body>
</html>
