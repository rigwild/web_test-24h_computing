<?php
include 'functions.php';
validate_tmp();
validateEvent_update();
?>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>24H Iut</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
  crossorigin="anonymous">
  <link href="_resources/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="style/heroic-features.css" rel="stylesheet">
  <link href="style/var.css" rel="stylesheet">
  <link href="style/style.css" rel="stylesheet">

</head>

<body class="bg-clair">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top bg-secondaire">
    <div class="container">
      <a class="navbar-brand logo" href="#">
        <img src="img/ReunionouLogo.svg" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link color-texte-clair" href="#">Accueil
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link color-texte-clair" href="#" data-toggle="modal" data-target="#connexion">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-success color-texte-clair bg-bouton" href="#" data-toggle="modal" data-target=".bd-creation-modal-lg">
            <i class="fas fa-plus color-texte-clair"></i> Créer</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Fin Navigation -->

  <!-- Modal Création Event-->
  <div class="modal fade bd-creation-modal-lg" id="creerEvent" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Créer Evenement</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Création du formulaire de création -->
        <div class="modal-body">
          <form action="POST">
            <div class="form-group">
              <label for="descriptionLieu">Titre de l'évement</label>
              <input type="text" class="form-control" id="descriptionLieu" placeholder="Exprimez vous">

              <label for="map-canvas">Pour choisir un lieu, cliquez dessus</label>
              <div id="map-canvas">

              </div>
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date">

              <label for="heure">Heure</label>
              <input type="time" class="form-control" id="heure">

              <label for="description">Description</label>
              <textarea class="form-control" id="description" rows="3" placeholder="Ma biiiiiiiite"></textarea>

              <div class="form-check">
                <label class="form-check-label margin">
                  <input class="form-check-input" type="checkbox" id="eventPrive" value="Prive">
                  <small class="form-text text-muted">
                    <i class="fas fa-lock "></i> Privé</small>
                  </label>
                </div>
              </div>

              <!-- Bouttons pour fermer le Modal -->
              <button class="btn btn-primary" type="submit">Envoyer</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </form>
          </div>
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
          <form method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label for="nomdecompte">Nom de Compte</label>
                <input type="text" class="form-control" id="nomdecompte" placeholder="RémyS">

                <label for="motdepasse">Mot de Passe</label>
                <input type="password" class="form-control" name="motdepasse" id="motdepasse">
              </div>
              <!-- Bouttons pour fermer le Modal -->
              <button class="btn btn-primary" type="submit">Connexion</button>
              <a href="#inscription" class="btn btn-secondary">S'inscrire</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin Modal Connnexion -->

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
getEventFromUrlInput();
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

  <script src="_resources/jquery/jquery.min.js"></script>
  <script src="_resources/js/bootstrap.min.js"></script>
</body>

</html>