<?php
   // Start the session
   session_start();


   if(isset($_SESSION['email'])) {
      $login_cf = $_SESSION['cf'];
      $login_email = $_SESSION['email'];
      $login_username = $_SESSION['name'];
      $login_surname = $_SESSION['surname'];

      $login_type = $_SESSION['type'];

      $login_birth = $_SESSION['birth'];
      $login_tel = $_SESSION['tel'];
    
   }  

   
   function logout() {

      // Distruggi i dati della sessione
      session_unset();
      session_destroy();
  
      // Reindirizza alla homepage
      header("Location: index.php");
      exit();
  }

   
?>