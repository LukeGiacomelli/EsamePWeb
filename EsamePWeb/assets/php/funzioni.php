<?php
//forse inutile 
    function connettiDB($hostname,$username, $password, $db){

        $conn = new mysqli($hostname, $username, $password, $db); 
        if ($conn -> connect_errno){
            echo "Errore di connessione" . $conn->connect_errno;
            return null;
        } else {
            return $conn;
        }

    }

?>

