<?php 
    $nomepagina = "GESTIONE ORDINI";
    include(__DIR__ .'/../common/session.php');
    if(!isset($login_type)) {
        header("location: login.php");
        exit;
    }else if(isset($login_type) && $login_type != "proprietario"){
        header("location: index.php");
        exit;
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
                include(__DIR__ ."/../css/allstyle.html");
            ?>

    </head>

    <body id="page-top">

        <?php
        
            include(__DIR__ .'/../frontend/navbar.php');
            include(__DIR__ .'/../frontend/masthead.php');
        
        ?>

        <section class="page-section" id="corso-di-canto">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">

                    <section class="page-section bg-white" id="ords">
                        <div class="container px-4 px-lg-5">
                            <div class="row gx-4 gx-lg-5 justify-content-center">
                                <div class="col-lg-10 text-center">
                                    <div class="ordini-wrapper" style="max-height: 600px; overflow-y: auto; padding-right: 10px;"> 
                                        <div class="rounded-table"> 
                                            <?php include(__DIR__ ."/../backend/ordini_proprietario.php"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </section>

        <script src="/../EsamePWeb/js/gestione_ordini.js"></script>







        
    </body>


    <?php 
        include(__DIR__ ."/../frontend/footer.php");
    ?>

</html>