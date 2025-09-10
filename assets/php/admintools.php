<?php
include("assets/css/allstyle.html");


function getUtentiTable($db) {
    $sql = "SELECT * FROM utente WHERE U_tipo = 'cliente'";
    $result = mysqli_query($db, $sql);

    // Check se ci sono risultati
    if (mysqli_num_rows($result) > 0) {
        $utentiAttesa = [];
        $utentiApprovati = [];

        // Dividi gli utenti in due gruppi
        while ($row = $result->fetch_assoc()) {
            if ($row["U_stato"] == 'attesa') {
                $utentiAttesa[] = $row;
            }else {
                $utentiApprovati[] = $row;
            }
        }

        // Tabella per utenti in attesa
        if (count($utentiAttesa) > 0) {
            echo "<div class='table-container' style='margin-bottom: 40px;'>"; // Spazio sotto la tabella
            echo "<h3 class='table-title'>Gestione utenti in attesa</h3><br>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr class='text-center'>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Azione</th>
                    </tr>";
            echo "</thead><tbody>";
        
            foreach ($utentiAttesa as $row) {
                $btnApprova = "<form method='POST' style='display: inline-block; margin: 5px;'> 
                                <button class='btn btn-success btn-sm' type='submit' name='bottone_approva' value=".$row["U_cf"].">
                                    Approva
                                </button> 
                                </form>";
                $btnElimina = "<button class='btn btn-danger btn-sm' type='button' style='margin: 5px;' onclick='confirmElimina(\"".$row["U_cf"]."\")'>
                                Rifiuta
                                </button>";
        
                echo "<tr class='text-center align-middle'>
                        <td>".$row["U_cf"]."</td>
                        <td>".$row["U_nome"]." ".$row["U_cognome"]."</td>
                        <td>".$btnApprova . $btnElimina."</td>
                        </tr>";
            }
        
            echo "</tbody></table></div></div>";
        } else {
            echo "<div class='alert alert-info text-center'>Nessun utente in attesa di approvazione.</div>";
        }
        

        // Tabella per utenti già Approvati
        if (count($utentiApprovati) > 0) {
            echo "<div class='table-container' style='margin-bottom: 40px;'>"; // Spazio sotto la tabella
            echo "<h3 class='table-title'>Gestione utenti approvati</h3><br>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr class='text-center'>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Azione</th>
                    </tr>";
            echo "</thead><tbody>";
        
            foreach ($utentiApprovati as $row) {
                $btnBlocca = "<form method='POST' style='display: inline-block; margin: 5px;'> 
                                <button class='btn btn-primary btn-sm' type='submit' name='bottone_blocca' value=".$row["U_cf"].">
                                    Blocca
                                </button> 
                                </form>";
                $btnSblocca = "<form method='POST' style='display: inline-block; margin: 5px;'> 
                                <button class='btn btn-warning btn-sm' type='submit' name='bottone_sblocca' value=".$row["U_cf"].">
                                    Sblocca
                                </button> 
                                </form>";
                $btnElimina = "<button class='btn btn-danger btn-sm' type='button' style='margin: 5px;' onclick='confirmElimina(\"".$row["U_cf"]."\")'>
                                Elimina
                                </button>";
        
                $actionCell = $row["U_stato"] == 'bloccato' ? $btnSblocca : $btnBlocca;
        
                echo "<tr class='text-center align-middle'>
                        <td>".$row["U_cf"]."</td>
                        <td>".$row["U_nome"]." ".$row["U_cognome"]."</td>
                        <td>".$actionCell . $btnElimina."</td>
                        </tr>";
            }
        
            echo "</tbody></table></div></div>";
        } else {
            echo "<div class='alert alert-info text-center'>Nessun utente approvato trovato</div>";
        }
    } else {
        echo "<div class='alert alert-info text-center'>Nessun risultato trovato.</div>";
    }
}
    



    function approvautenti($db,$codice_fiscale_bottone){
        $sql = "UPDATE utente SET U_stato = 'attivo'  WHERE U_cf = '$codice_fiscale_bottone' " ;
        $result = mysqli_query($db,$sql);

        if(!$result){
            echo "errore nell'approvazione dell'utente";
        }
    }


    function bloccautenti($db,$codice_fiscale_bottone){
        $sql = "UPDATE utente SET U_stato = 'bloccato' WHERE U_cf = '$codice_fiscale_bottone' " ;
        $result = mysqli_query($db,$sql);

        if(!$result){
            echo "errore nel bloccare l'utente";
        }
    }  

    function sbloccautenti($db, $codice_fiscale_bottone) {
        $sql = "UPDATE utente SET U_stato = 'attivo' WHERE U_cf = '$codice_fiscale_bottone'";
        $result = mysqli_query($db, $sql);
    
        if (!$result) {
            echo "Errore nello sblocco dell'utente";
        }
    }

    function eliminautenti($db, $codice_fiscale_bottone) {
        $sql = "DELETE FROM utente WHERE U_cf = '$codice_fiscale_bottone'";
        $result = mysqli_query($db, $sql);
    
        if (!$result) {
            echo "Errore nell'eliminazione dell'utente";
        }
    }


?>


<script>
function confirmElimina(utenteCf) {
    Swal.fire({
        title: 'Sei sicuro?',
        text:`Vuoi veramente eliminare l'utente il cui CF è "${utenteCf}"? Questa azione non può essere annullata!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sì, elimina!',
        cancelButtonText: 'Annulla'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crea un form temporaneo per inviare la richiesta di eliminazione
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = ''; // Assicurati che l'azione del form sia corretta

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'conferma_elimina';
            input.value = utenteCf;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    })
}
</script>