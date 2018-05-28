<!DOCTYPE html>
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

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top bg-secondaire">
  <div class="container">
    <a class="navbar-brand logo" href="index.php">
      <img src="img/ReunionouLogo.svg" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
    aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link color-texte-clair" href="index.php">Accueil
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <?php 
      if (!isset($_SESSION['logged_in'])) 
      {
        ?>
        <li class="nav-item">
          <a class="nav-link color-texte-clair" href="connexion.php">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link color-texte-clair" href="inscription.php">inscription</a>
        </li>
        <?php
      }
      if (isset($_SESSION['logged_in'])) 
      {
        ?>
        <li class="nav-item">
          <li class="nav-item">
            <a class="nav-link color-texte-clair" href="create_event.php">Créer un évênement</a>
          </li>
          <li class="nav-item">
            <a class="nav-link color-texte-clair" href="disconnect.php">Se déconnecter</a>
          </li>
          <?php 
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<!-- Fin Navigation -->
<body>