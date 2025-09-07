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
    
                    <!--SALE DI REGISTRAZIONE-->
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg" title="Lumen">
                            <img class="img-portfolio" src="https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Studio di registrazione</div>
                                <div class="project-name">Lumen</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg" title="Arcadia">
                            <img class="img-portfolio" src="https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Studio di registrazione</div>
                                <div class="project-name">Arcadia</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="https://www.tagvenue.com/images/location-pages/1920x1080/3056.jpg" title="Perseide">
                            <img class="img-portfolio" src="https://www.tagvenue.com/images/location-pages/1920x1080/3056.jpg" alt="..." />
                            <div class="portfolio-box-caption p-3">
                                <div class="project-category text-white-50">Studio di registrazione</div>
                                <div class="project-name">Perseide</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="https://pbs.twimg.com/media/ESxRMBAWoAAcOWV.jpg" title="Aeternum">
                            <img class="img-portfolio" src="https://pbs.twimg.com/media/ESxRMBAWoAAcOWV.jpg" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Studio di registrazione</div>
                                <div class="project-name">Aeternum</div>
                            </div>
                        </a>
                    </div>

                    <!--SALE PROVA-->
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href=" https://cdn.shopify.com/s/files/1/0557/2860/3188/files/5_109347f1-b561-4389-b1f6-ba7ecb17896d_600x600.png?v=1685708932" title="Altiora">
                            <img class="img-portfolio" src=" https://cdn.shopify.com/s/files/1/0557/2860/3188/files/5_109347f1-b561-4389-b1f6-ba7ecb17896d_600x600.png?v=1685708932" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Sala prove</div>
                                <div class="project-name">Altiora</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="https://ledlightsdirect.com/cdn/shop/articles/1_103194a9-37a6-4a32-b4d7-d3dbe18d9c9a.png?v=1684920353" title="Armonia">
                            <img class="img-portfolio" src="https://ledlightsdirect.com/cdn/shop/articles/1_103194a9-37a6-4a32-b4d7-d3dbe18d9c9a.png?v=1684920353" alt="..." />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Sala prove</div>
                                <div class="project-name">Armonia</div>
                            </div>
                        </a>
                    </div>
    <?php 
        include("assets/php/footer.php");
    ?>
    </body>
</html>