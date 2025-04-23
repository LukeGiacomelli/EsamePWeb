<script src="assets/js/commenti.js"></script>
<?php 
if (isset($login_email)) { 

    if ($login_type == 'cliente'){
        echo '
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
             <div class="text-center">
                 <a class="btn btn-outline-dark mt-auto me-2" href="#">Aggiungi al carrello</a>
                 <button class="btn btn-outline-dark mt-auto" id="'.$id_prodotto.'" data-bs-toggle="modal" data-bs-target="#commentModal" onclick="loadComments(this)" href="#">Vota/Commenta</button>
             </div>
         </div>
     ';
 
    }else if ($login_type == 'proprietario'){
        echo '
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
                <button id="'.$id_prodotto.'" onclick="openModalModButton(this)" class="btn btn-outline-dark btn-lg">Modifica</button>
            
                <form id="deleteForm'.$id_prodotto.'" method="post">
                    <button type="button" id="'.$id_prodotto.'" onclick="confirmDelete(this)" class="btn btn-outline-dark">Elimina</button>
                    <input type="hidden" name="act" value="delprod_'.$id_prodotto.'">
                </form>
            </div>
         </div>
     '; 

    }else{

        //nulla

    }
 
      
    
}else{
    echo '
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="login.php"> Login/Registrati per aggiungere al carrello</a></div>
        </div>
    '; 
}


?>
<!-- MODAL -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentModalLabel">Lascia un commento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="commentiEsistenti" class="mb-3"></div>

        <textarea class="form-control mb-2" id="messaggio" placeholder="Scrivi il tuo commento..."></textarea>
        <div class="mb-2">
            <label class="form-label">Voto:</label>
            <div id="starRating">
                <!-- Le stelle -->
                <i class="bi bi-star star" data-value="1"></i>
                <i class="bi bi-star star" data-value="2"></i>
                <i class="bi bi-star star" data-value="3"></i>
                <i class="bi bi-star star" data-value="4"></i>
                <i class="bi bi-star star" data-value="5"></i>
            </div>
        </div>
        <input type="hidden" id="voto" value="0">
        <button class="btn btn-primary w-100" id= "<?= $id_prodotto ?>" onclick="inviaCommento(this,'<?= $login_cf ?>')">Invia</button>
      </div>
    </div>
  </div>
</div>

<script>
        function confirmDelete(whocalled) {
            
            let confirmation = confirm("Sei sicuro di voler eliminare?");
            if (confirmation) {
                document.getElementById('deleteForm' + whocalled.id).submit();
            }
        }
</script>