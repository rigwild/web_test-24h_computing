<?php
include 'functions.php';
getEventFromUrl();
validateEvent_post();
novalidateEvent_post();
include 'header.php';
?>


<!-- Modal commentaire -->
<div class="modal fade" id="commentaire" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Laisser un commentaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Création du formulaire de création -->
      <form method="POST">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="validate">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" id="commentairee" cols="30" rows="5"></textarea>
          </div>
          <!-- Bouttons pour fermer le Modal -->
          <button class="btn btn-primary" type="submit" id="participe">Envoyer</button>
          <button class="btn btn-secondary" type="submit" id="participePas">Fermer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="commentaire2" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Laisser un commentaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Création du formulaire de création -->
      <form method="POST">
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="novalidate">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" id="commentaire" cols="30" rows="5"></textarea>
          </div>
          <!-- Bouttons pour fermer le Modal -->
          <button class="btn btn-primary" type="submit" id="participe2">Envoyer</button>
          <button class="btn btn-secondary" type="submit" id="participePas2">Fermer</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Fin Modal commentaire -->


<!-- Page Features -->

<?php 
if (isset($_SESSION['logged_in'])) {
  ?>
  <div class="row">
    <div class="col-md-4">
      <button class="btn btn-primary bg-principale" data-toggle="modal" data-target="#commentaire2">
        <i class="fas fa-plus"></i> Je participe</button></form>
        <button class="btn btn-secondary bg-sombre margin-left" data-toggle="modal" data-target="#commentaire2">
          <i class="fas fa-minus"></i> Je ne participe pas</button>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
  <!--
    <div class="container">
      <div class="row">
        <div class="offset-md-4 col-md-4 offset-md-4">
          <p id="personneCommentaire">Test</p>
          <p id="contenucommentaire">Test</p>
        </div>
      </div>
    </div>
  -->

  <script src="_resources/jquery/jquery.min.js"></script>
  <script src="_resources/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDsynSWZCHcYK75Ciev7xqGL3q4k5CYX2Y&libraries=places"></script>
  <script src="js/script.js"></script>
</body>

</html>