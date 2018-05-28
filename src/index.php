<?php 
include 'functions.php';
include 'header.php';
?>

<!-- Modal Création Event-->
<div class="modal fade bd-creation-modal-lg" id="creerEvent" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <?php 
      if (isset($_SESSION['logged_in'])) 
      {
        ?>
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Créer Evenement</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php 
      }
      ?>

      
    </div>
  </div>
</div>
<!-- Fin Modal Event -->

<!-- Modal Création Connexion-->
<div class="modal fade" id="connexion" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Connexion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Création du formulaire de création -->
      <form action="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="nomdecompte">Nom de Compte</label>
            <input type="text" class="form-control" id="nomdecompte" placeholder="RémyS">

            <label for="motdepasse">Mot de Passe</label>
            <input type="password" class="form-control" name="motdepasse" id="motdepasse">
          </div>
          <!-- Bouttons pour fermer le Modal -->
          <button class="btn btn-primary bg-principale" type="submit">Connexion</button>
          <a href="inscription.php" class="btn btn-secondary bg-sombre">S'inscrire</a>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Fin Modal Event -->

<!-- Page Content -->
<div class="container">

  <!-- Jumbotron Header -->
  <header class="jumbotron my-4">
    <h1>Bienvenue sur Reunionou</h1>
    <h4 class="text-muted">On a pas choisi le nom</h4>
    <p class="lead">Un rendez-vous à fixer ? Gérez vos événement d'un simple clique, partagez les avec vos proches ou bien rendez les publiques ! Organisez vous en temps réel en fonction du nombre de participant !</p>
    <a href="#" class="btn btn-primary bg-principale" data-toggle="modal" data-target="#creerEvent">Créer un évenement !</a>
  </div>
</header>

<!-- Page Features -->
<div class="container">
  <div class="row text-center">
    <div id="map-canvas"  style="display: none;"></div>
    <?php generateHomeEvents(); ?>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
  </div>
  <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="_resources/jquery/jquery.min.js"></script>
<script src="_resources/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDsynSWZCHcYK75Ciev7xqGL3q4k5CYX2Y&libraries=places"></script>
<script src="js/script.js"></script>

</body>

</html>