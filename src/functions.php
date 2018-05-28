<?php

session_start();

//Connexion à la BDD
$hote='localhost';
$port='5432';
$nom_bd='24h_informatique';
$user='psql_user';
$mot_de_passe='[[SambA]]';
$connexion = new PDO('pgsql:host='.$hote.';port='.$port.';dbname='.$nom_bd, $user, $mot_de_passe);
$connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



/*************************************************************/
/******************** FONCTIONS GENERALES ********************/
/*************************************************************/

//Rediriger avec une notification
//ok pour notif 'Succès', ko pour notif 'Erreur', warn pour motif 'Attention'
function redirectNotification($type, $message, $url = "index.php") {
	$param = "type=".$type."&message=".$message;
	header("Location: ".$url."?".$param);
}

//Afficher une notification
function showNotification() {
	if (isset($_GET['type']) && $_GET['type'] == 'ok' && !empty($_GET['message'])) {
		echo "<div class=\"alert alert-success alert-dismissable\">
		<strong>Succès !</strong> ".cleanBadChar($_GET['message'])."
		</div>";
	}
	elseif (isset($_GET['type']) && $_GET['type'] == 'ko' && !empty($_GET['message'])) {
		echo "<div class=\"alert alert-danger alert-dismissable\">
		<strong>Erreur !</strong> ".cleanBadChar($_GET['message'])."
		</div>";
	}
	elseif (isset($_GET['type']) && $_GET['type'] == 'warn' && !empty($_GET['message'])) {
		echo "<div class=\"alert alert-warning alert-dismissable\">
		<strong>Attention !</strong> ".cleanBadChar($_GET['message'])."
		</div>";
	}
}

//Empeche les XSS
function cleanBadChar($string) {
	return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

//Check si connecté, sinon redirige
function checkLoggedIn() {
	if (!(
		isset($_SESSION['logged_in'])
		&& $_SESSION['logged_in']
		&& isset($_SESSION['username'])
		&& !empty($_SESSION['username'])
	))
	{
		session_destroy();
		header("Location: index.php");
	}
}

//Se connecter
function login($username, $password) {
	global $connexion;
	$query = "SELECT * FROM account WHERE username = :username";

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'username' => $username,
		)))
	{
		$count = $stmt->rowCount();
		/*Si user existe, lui mettre les paramètres dans la var session et rediriger*/
		if ($count == 1) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row["banned"] == 0) {
				if ($row["active"] == 1) {
					/*Compte activé*/
					if (password_verify($password, $row["password"])) {
						/*Mot de passe ok*/
						$_SESSION['logged_in'] = true;
						$_SESSION['username'] = $row["username"];
						$_SESSION['id_user'] = $row["id_user"];
						redirectNotification("ok", "Vous êtes connecté.", "index.php");
					}
					else {
						/*Mauvais mot de passe*/
						session_destroy();
						redirectNotification("ko", "Nom d'utilisateur ou mot de passe incorrect.", "login.php");
					}
				}
				else {
					/*Compte non activé*/
					session_destroy();
					redirectNotification("ko", "Votre compte n'est pas activé.", "login.php");
				}
			}
			else {
				/*Compte banni*/
				session_destroy();
				redirectNotification("ko", "Votre compte est banni.", "login.php");
			}
		}
		/*Mauvais user*/
		else {
			session_destroy();
			redirectNotification("ko", "Nom d'utilisateur ou mot de passe incorrect.", "login.php");
		}
	}
}

//S'inscrire
function register($username, $password) {
	global $connexion;

	/*On check le username n'est pas déjà utilisé*/
	$query = "SELECT username FROM account WHERE username = :username";

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'username' => $username,
		)))
	{
		$count = $stmt->rowCount();
		if ($count == 0) {
			/*Username disponible, on hash le mot de passe*/
			$password = password_hash($password,PASSWORD_DEFAULT);

			$query = 'INSERT INTO account (username, password)
			values (:username, :password)';

			$stmt = $connexion->prepare($query);
			if($stmt->execute(
				array(
					'username' => $username,
					'password' => $password
				)))
			{
				/*Inscription ok*/
				session_destroy();
				redirectNotification("ok", "Votre compte a été créé.", "index.php");
			}
			else {
				/*Fail inscription inconnu*/
				session_destroy();
				redirectNotification("ko", "Votre compte n'a pas été créé.", "login.php");
			}
		}
		/*user déjà pris*/
		else {
			session_destroy();
			redirectNotification("ko", "Le nom d'utilisateur n'est pas disponible.", "login.php");
		}
	}
}

//Créer un évênement
function createEvent($title, $description, $date, $place_gmapid) {
	global $connexion;

	if (!isset($_SESSION['logged_in']))
		return;

	$hash = hash('sha256', time().rand(1,9999));
	$query = 'INSERT INTO event (id_event, title, description, event_date, place_gmapid, id_author)
	values (:id_event, :title, :description, :event_date, :place_gmapid, :id_author)';

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'id_event' => $hash,
			'title' => $title,
			'description' => $description,
			'event_date' => $date,
			'place_gmapid' => $place_gmapid,
			'id_author' => $_SESSION['id_user']
		)))
	{
		/*Inscription ok*/
		redirectNotification("ok", "Votre évênement a été créé.", "index.php");
	}
	else {
		/*Fail inscription inconnu*/
		redirectNotification("ko", "Votre évênement n'a pas été créé.", "index.php");
	}
}


//récupérer les évênement
function generateHomeEvents() {
	global $connexion;

	$query = "SELECT * FROM event ORDER BY event_date DESC LIMIT 4";

	$stmt = $connexion->prepare($query);
	if($stmt->execute())
	{
		$content = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($content as $key => $value) {
			?>
			<div class="col-lg-3 col-md-6 mb-4">	
				<div class="card" id="afficheCarte">
					<img class="card-img-top" id="img-<?=$value['id_event']?>" src="http://placehold.it/500x325" alt="">
					<div class="card-body">
						<h4 class="card-title" id="titreCarte"><?php echo cleanBadChar($value['title']) ?></h4>
						<p class="card-text">
							<i class="fas fa-map-marker"></i>
							<span id="carteAdresse-<?php echo cleanBadChar($value['id_event']) ?>"></span>
							<br>
							<i class="far fa-calendar-alt"></i>
							<span id="carteDate"><?php echo cleanBadChar($value['event_date']) ?></span>
							<br>
							<hr>
							<p class="text-justify" id="carteDesc"><?php echo cleanBadChar($value['description']) ?></p>
						</p>
					</div>
					<div class="card-footer">
						<a href="event.php?id=<?=$value['id_event']?>" class="btn btn-primary bg-principale">Découvrir</a>
					</div>
				</div>
				<script>
					document.addEventListener('DOMContentLoaded', function(){ 
						google.maps.event.addDomListener(window, 'load', () => {
							getPlace("<?=$value['place_gmapid']?>")
							.then(res => {
								document.getElementById("img-<?=$value['id_event']?>").src = getPhotos(res)[0]
								document.getElementById("carteAdresse-<?=$value['id_event']?>").textContent = res.formatted_address
							})
							.catch(err => log(err))
						})
					})

				</script>
			</div>
			<?php
		}
	}
}

//récupérer les évênement
function getEventFromUrl() {
	global $connexion;
	if (!isset($_GET['id']) || empty($_GET['id']))
		return;

	$query = "SELECT * FROM event WHERE id_event = :id";
	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'id' => $_GET['id']
		)))
	{

		$content = $stmt->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 margin-top-card">
					<div class="card" id="afficheCarte">
						<img class="card-img-top" id="img-mdr" src="http://placehold.it/500x325" alt="">
						<div class="card-body">
							<h4 class="card-title" id="titreCarte"><?php echo cleanBadChar($content['title']) ?></h4>
							<p class="card-text">
								<i class="fas fa-map-marker"></i>
								<span id="carteAdresse"></span>
								<br>
								<i class="far fa-calendar-alt"></i>
								<span id="carteDate"><?php echo cleanBadChar($content['event_date']) ?></span>
								<br>
								<hr>
								<p class="text-justify" id="carteDesc"><?php echo cleanBadChar($content['description']) ?></p>
							</p>
						</div>
					</div>
				</div>

				<div class="col-lg-8 col-md-6 mb-8 margin-top-card">
					<div id="map-canvas"  style="height: 400px;"></div>
				</div>
			</div>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', function(){ 
				google.maps.event.addDomListener(window, 'load', () => {
					getPlace("<?=$content['place_gmapid']?>")
					.then(res => {
						map.setCenter({
							lat: res.geometry.location.lat(),
							lng: res.geometry.location.lng()
						})
						document.getElementById("img-mdr").src = getPhotos(res)[0]
						document.getElementById("carteAdresse").textContent = res.formatted_address
					})
					.catch(err => log(err))
				})
			})
		</script>
		<?php
	}
}

function validateEvent($eventId, $msg_inscription) {
	global $connexion;

	if (!isset($_SESSION['logged_in']))
		return;

	$hash = hash('sha256', time().rand(1,9999));
	$query = 'INSERT INTO event_part (id_event, id_author, msg_inscription, validated)
	values (:id_event, :id_author, :msg_inscription, :validated)';

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			"id_event" => $eventId,
			"id_author" => $_SESSION['id_user'],
			"msg_inscription" => $msg_inscription,
			"validated" => "t"
		)))
	{
		/*Inscription ok*/
		redirectNotification("ok", "Votre inscription à l'évênement a été validée.", "index.php");
	}
	else {
		/*Fail inscription inconnu*/
		redirectNotification("ko", "Votre inscription à l'évênement n'a pas été validée.", "index.php");
	}
}

function novalidateEvent($eventId, $msg_inscription) {
	global $connexion;

	if (!isset($_SESSION['logged_in']))
		return;

	$hash = hash('sha256', time().rand(1,9999));
	$query = 'INSERT INTO event_part (id_event, id_author, msg_inscription, validated)
	values (:id_event, :id_author, :msg_inscription, :validated)';

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			"id_event" => $eventId,
			"id_author" => $_SESSION['id_user'],
			"msg_inscription" => $msg_inscription,
			"validated" => "f"
		)))
	{
		/*Inscription ok*/
		redirectNotification("ok", "Votre inscription à l'évênement a été validée.", "index.php");
	}
	else {
		/*Fail inscription inconnu*/
		redirectNotification("ko", "Votre inscription à l'évênement n'a pas été validée.", "index.php");
	}
}


/*************************************************************/
/******************** FONCTIONS POST *************************/
/*************************************************************/

//A mettre en haut de la page de login
function login_post() {
	if (
		isset($_POST['username'])
		&& !empty($_POST['username'])
		&& isset($_POST['password'])
		&& !empty($_POST['password'])
	) {
		login($_POST['username'], $_POST['password']);
	}
}

//A mettre en haut de la page d'inscription
function register_post() {
	if (
		isset($_POST['username'])
		&& !empty($_POST['username'])
		&& isset($_POST['password'])
		&& !empty($_POST['password'])
	) {
		register($_POST['username'], $_POST['password']);
	}
}

//A mettre en haut de la page de création d'évênement
function createEvent_post() {
	if (
		isset($_POST['title']) && !empty($_POST['title'])
		&& isset($_POST['description']) && !empty($_POST['description'])
		&& isset($_POST['date']) && !empty($_POST['date'])
		&& isset($_POST['lieu']) && !empty($_POST['lieu'])
	) {
		createEvent($_POST['title'], $_POST['description'], $_POST['date'], $_POST['lieu']);
	}
}

//A mettre en haut de la page d'activation d'utilisateur
function validateEvent_post() {
	if (isset($_GET['id']) && !empty($_GET['id'])
		&& isset($_POST['validate']) && !empty($_POST['validate'])
		&& isset($_POST['commentaire']) && !empty($_POST['commentaire'])	)
	{
		validateEvent($_GET['id']);
	}
}

function novalidateEvent_post() {
	if (isset($_GET['id']) && !empty($_GET['id'])
		&& isset($_POST['novalidate']) && !empty($_POST['novalidate'])
		&& isset($_POST['commentaire']) && !empty($_POST['commentaire'])	)
	{
		novalidateEvent($_GET['id'], $_POST['commentaire']);
	}
}


function validate_tmp() {
	if (!empty($_SESSION['id_user']));
	global $connexion;
	if (!isset($_GET['id']) || empty($_GET['id'])){
		header('Location: index.php');
		exit();
	}

	$query = "SELECT * FROM event WHERE id_event = :id";
	$stmt = $connexion->prepare($query);
	$stmt->execute(
		array(
			'id' => $_GET['id']
		));
	$content = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($_SESSION['id_user'] != $content['id_author']) {
		header('Location: index.php');
		exit();
	}
}
function validateEvent_update() {
	if (
		!empty($_POST['title']) &&
		!empty($_POST['description']) &&
		!empty($_POST['date']) &&
		//!empty($_POST['place_gmapid']) &&
		!empty($_GET['id'])
	) {
		updateEvent(
			$_GET['id'],
			$_POST['title'],
			$_POST['description'],
			$_POST['date']
			//$_POST['place_gmapid']
		);
	}
}

//récupérer les évênement
function getEventFromUrlInput() {
	global $connexion;
	if (!isset($_GET['id']) || empty($_GET['id']))
		return;

	$query = "SELECT * FROM event WHERE id_event = :id";
	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'id' => $_GET['id']
		)))
	{

		$content = $stmt->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 margin-top-card">
					<div class="card" id="afficheCarte">
						<img class="card-img-top" id="img-mdr" src="http://placehold.it/500x325" alt="">
						<div class="card-body">
							<form method="POST">
								<input type="text" class="card-title" id="titreCarte" name="title" value="<?php echo cleanBadChar($content['title']) ?>" >
								<p class="card-text">
									<i class="fas fa-map-marker"></i>
									<span id="carteAdresse"></span>
									<br>
									<i class="far fa-calendar-alt"></i>
									<input type="text" id="carteDate" name="date" value="<?php echo cleanBadChar($content['event_date']) ?>" >
									<br>
									<hr>
									<textarea name="description"><?php echo cleanBadChar($content['description']) ?></textarea>
								</p>
								<input type="submit">
							</form>
						</div>
					</div>
				</div>

				<div class="col-lg-8 col-md-6 mb-8 margin-top-card">
					<div id="map-canvas"></div>
				</div>
			</div>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', function(){ 
				google.maps.event.addDomListener(window, 'load', () => {
					getPlace("<?=$content['place_gmapid']?>")
					.then(res => {
						map.setCenter({
							lat: res.geometry.location.lat(),
							lng: res.geometry.location.lng()
						})
						document.getElementById("img-mdr").src = getPhotos(res)[0]
						document.getElementById("carteAdresse").textContent = res.formatted_address
					})
					.catch(err => log(err))
				})
			})
		</script>
		<?php
	}
}

//Modifier un un évênement
function updateEvent($id, $title, $description, $date/*, $place_gmapid*/) {
	global $connexion;

	$query = 'UPDATE event SET title=:title, event_date=:event_date, description=:description WHERE id_event=:id_event;';
	//$query = 'UPDATE event SET title=:title, description=:description, event_date=:event_date, place_gmapid=:place_gmapid, id_author=:id_author WHERE id_event=:id_event;';

	$stmt = $connexion->prepare($query);
	if($stmt->execute(
		array(
			'id_event' => $id,
			'title' => $title,
			'description' => $description,
			'event_date' => $date,
			//'place_gmapid' => $place_gmapid
		)))
	{
		/*Inscription ok*/
		redirectNotification("ok", "Votre évênement a été modifié.", "login.php");
	}
	else {
		/*Fail inscription inconnu*/
		redirectNotification("ko", "Votre évênement n'a pas été modifié.", "login.php");
	}
}
?>