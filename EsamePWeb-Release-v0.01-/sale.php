<?php  
    $nomepagina = "Sale";
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

        <!--importo la navbar e l'header-->
        <?php 
        include("assets/php/navbar.php");
        include("assets/php/masthead.php");
        ?>


        <!--Portfolio-->
        <div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <?php include("assets/php/stampa_sale.php"); ?>
                </div>
            </div>
        </div>
    <?php 
        include("assets/php/footer.php");
    ?>
    </body>
</html>