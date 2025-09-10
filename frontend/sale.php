<?php  
    $nomepagina = "Sale";
    include(__DIR__ .'/../common/session.php');
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

        <!--importo la navbar e l'header-->
        <?php 
        include(__DIR__ ."/../frontend/navbar.php");
        include(__DIR__ ."/../frontend/masthead.php");
        ?>


        <!--Portfolio-->
        <div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <?php include(__DIR__ ."/../frontend/stampa_sale.php"); ?>
                </div>
            </div>
        </div>
    <?php 
        include(__DIR__ ."/../frontend/footer.php");
    ?>
    </body>
</html>