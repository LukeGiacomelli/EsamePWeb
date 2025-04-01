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
                include("assets/php/allstyle.html");
            ?>

    </head>

    <body id="page-top">

        <?php
        
            include('assets/php/navbar.php');
            include('assets/php/masthead.php');
        
        ?>

        <section class="page-section bg-primary" id="corso-di-canto">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">

                    <section class="page-section bg-white" id="ords">
                        <div class="container px-4 px-lg-5">
                            <div class="row gx-4 gx-lg-5 justify-content-center">
                                <div class="col-lg-10 text-center"> 
                                
                                    <table class="rounded-table">



                                    </table>

                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </section>







        
    </body>


    <?php 
        include("assets/php/footer.php");
    ?>

</html>