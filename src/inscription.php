<?php 
include 'functions.php';
register_post();

include 'header.php';
?>
<!-- Connexion -->
<div class="container">
    <div class="row">
        <div class="offset-md-4 col-md-4 connexionDesign margin-top bg-clair">
            <h2>Inscription</h2>
            <form method="POST">

                <div class="form-group margin-top ">
                    <label for="nomdecompte">Nom de Compte</label>
                    <input type="text" class="form-control" name="username" placeholder="RémyS">

                    <label for="motdepasse">Mot de Passe</label>
                    <input type="password" class="form-control" name="password" id="motdepasse">
                </div>
                <!-- Bouttons pour fermer le Modal -->
                <button class="btn btn-success bg-principale" type="submit">S'inscrire</button>

            </form>
        </div>
    </div>
</div>

<!-- Fin connexion -->

<!-- Bootstrap core JavaScript -->
<script src="_resources/jquery/jquery.min.js"></script>
<script src="_resources/js/bootstrap.min.js"></script>

</body>

</html>