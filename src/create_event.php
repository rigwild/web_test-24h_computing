<?php 
include 'functions.php';
createEvent_post();


if (!isset($_SESSION['logged_in'])) 
{
    redirectNotification("ko", "Vous n'êtes pas connecté.", "index.php");
}
include 'header.php';
?>
<!-- Fin Modal Event -->
<!-- Connexion -->
<div class="container">
    <div class="row">
        <div class="offset-md-4 col-md-4 connexionDesign margin-top bg-clair">
            <h2>Créer un évênement</h2>
            <form method="POST">
              <div class="form-group">
                <label for="descriptionLieu">Titre de l'évement</label>
                <input type="text" class="form-control" name="title" placeholder="Exprimez vous">

                <label for="map-canvas">Pour choisir un lieu, cliquez dessus.</label>
                <div id="errorLocation"></div>
                <div id="map-canvas" style="width:100%;height:400px"></div> 

            </div> 
            <label for="date">Lieu choisi :</label>
            <input type="text" class="form-control" id="lieu_name" >
            <input type="hidden" id="lieu" name="lieu">

            <label for="date">Date</label>
            <input type="date" class="form-control" name="date">

            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Votre message"></textarea>

            <button class="btn btn-primary bg-principale" type="submit">Envoyer</button>
            <button type="button" class="btn btn-secondary bg-sombre" data-dismiss="modal">Fermer</button>
        </div>

        <!-- Bouttons pour fermer le Modal -->
    </form>
</div>
</div>
</div>

<!-- Fin connexion -->

<!-- Bootstrap core JavaScript -->
<script src="_resources/jquery/jquery.min.js"></script>
<script src="_resources/js/bootstrap.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDsynSWZCHcYK75Ciev7xqGL3q4k5CYX2Y&libraries=places"></script>
<script src="js/script.js"></script>

<script type="text/javascript">
    const dLat = 48.682762
    const dLong = 6.161252

    const callbackSuccess = pos => {console.log(pos);getMap(pos.coords.latitude, pos.coords.longitude)}
    const callbackFail = () => {getMap(dLat, dLong);document.getElementById('errorLocation').innerHTML = 'Vous avez refusé la demande de localisation. Centrage sur l\'IUT de Nancy.<br><br>'}
    getLocation(callbackSuccess, callbackFail)

    const getMap = (lat, long) => {
        getNearbyPosition(lat, long)
            .then(res => {
                log(res)
            })
            .catch(err => log(err))
    }


</script>

</body>
</html>