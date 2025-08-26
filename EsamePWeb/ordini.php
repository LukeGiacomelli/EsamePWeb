<?php 

    $nomepagina = "I MIEI ORDINI";
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
                include("assets/css/allstyle.html");
            ?>

    </head>

    <body id="page-top">

        <?php
        
            include('assets/php/navbar.php');
            include('assets/php/masthead.php');
        
        ?>

        <section class="page-section" id="corso-di-canto">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">

                    <section class="page-section bg-white" id="ords">
                        <div class="container px-4 px-lg-5">
                            <div class="row gx-4 gx-lg-5 justify-content-center">
                                <div class="col-lg-10 text-center">
                                    <div class="ordini-wrapper" style="max-height: 600px; overflow-y: auto; padding-right: 10px;"> 
                                        <div class="rounded-table"> <!-- solo per lo stile, non è una table -->
                                            <?php include("assets/php/mostra_ordini.php"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </section>

        <script src="assets/js/gestione_ordini.js"></script>







        
    </body>


    <?php 
        include("assets/php/footer.php");
    ?>

</html>