<?php 
    include(__DIR__ .'/../common/session.php');
    if(!isset($login_type)) {
        header("location: login.php");
        exit;
    }else if(isset($login_type) && $login_type != "proprietario"){
        header("location: index.php");
        exit;
    }

    include(__DIR__ .'/../common/admintools.php');
  
    if($_SERVER["REQUEST_METHOD"] == "POST"){
  
      if(isset($_POST['bottone_approva'])){
        approvautenti($db, $_POST['bottone_approva']);
      }
      if(isset($_POST['bottone_blocca'])){
        bloccautenti($db,$_POST['bottone_blocca']);
      }
      if(isset($_POST['bottone_sblocca'])){
        sbloccautenti($db,$_POST['bottone_sblocca']);
      }
      if(isset($_POST['conferma_elimina'])){
        eliminautenti($db,$_POST['conferma_elimina']);
      }

    }
?>

<section class="page-section bg-white" id="usr">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-10 text-center"> 
                <?php
                    getUtentiTable($db);
                ?>
            </div>
        </div>
    </div>
</section>