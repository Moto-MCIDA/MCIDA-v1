<?php
//////////////////////////////////////////////////////////////////////////////////////
//																					//
//										 PHP 										//
//                                                                                  // 
//////////////////////////////////////////////////////////////////////////////////////

// Include les différentes pages PHP (fonction)
include("../../fonction/cookieconn.php");
include("../../fonction/connexion_db.php");
include("../fonction/function_message.php");
include("../fonction/function_notification.php");
include("../../fonction/fonction_email.php");

// Vérification qu'on a bien une session, qu'on est bien connecter sinon redirection page 'connexion.php'
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	
$user_id = $_SESSION['user_id'];
if(isset($_GET['id']) AND !empty($_GET['id'])) {

	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$date = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	$id_link = $_GET['id'];

	$booleen = $db->query("SELECT count(*) FROM ligne WHERE user = '$user_id' AND link ='message perso' AND id_link='$id_link'"); // on compte combien de balade on une date >= a la date du jour 
	$bool = $booleen->fetchColumn();
	if($bool >= 1){
		// UPDATE `balade_membre` SET reponse='$choix_reponse', commentaire='$commentaire', nb_prs = '$nb_personne' WHERE id_utilisateur=$user_id AND id_balade=$balade_id"
		$sql = "UPDATE `ligne` SET date_ligne='$date' WHERE user = '$user_id' AND link = 'message perso' AND id_link='$id_link'";
	}else{
		$sql = "INSERT INTO `ligne` (user, link, id_link, date_ligne) VALUES ('$user_id', 'message perso', '$id_link', '$date')";
	}
	$ajout_ligne = $db->query($sql);
}
?>
<!-- ---------------------------------------------------------------------------------- -->
<!--										 	 										-->
<!--										 HTML 										-->
<!--										 	 										-->
<!-- ---------------------------------------------------------------------------------- -->   

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/index.css">
	<link rel="stylesheet" type="text/css" href="../style/message_groupe.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/message_groupe.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	
	<?php 
	include_once('../fonction/header.php');
	?>
	<div id="information">
		<?php
			$id_profil = $_GET['id'];
			blocInfoProfil($id_profil, $db);
		?>
	</div>
<!-- -------------------------------- Affichage des messages -------------------------------- -->	
	<div id="message">
		<div id="afficheMsg">
			<div>
				<?php 
					affiche_nom_prenom_profil(recup_nom_prenom_profil($id_profil,$db));
					affiche_message_profil(recup_message_profil($id_profil,$db), $id_profil ,$db);
				?>
			</div>
		</div>
<!-- -------------------------------- Ecrire un message -------------------------------- -->
		<form id="envoyerMsg" method="post" enctype="multipart/form-data">
			<div>
				<input id='bouton' onclick="backfunction()" type="submit"name="envoyerMsg" value="Envoyer" />
			</div>
			<div>
				<textarea id="texte" name="texte" placeholder="Ecrivez votre message"></textarea>
			</div>
		</form>
	</div>
</body>
</html>	
<script type="text/javascript">
let active = document.querySelector(".navigation > ul > li:nth-child(4)");
active.classList.add('active');

	element_b = document.getElementById('ul'); // Ne Fonctionne Pas
	element_b.scrollTop = element_b.scrollHeight;

function updateDiv()
{ 	
    $('#afficheMsg > div > ul').load(window.location.href + " #afficheMsg > div > ul > li" );
}
setInterval('updateDiv()', 5000);
function updatenotif()
{ 	
    $('#notif_img ').load(window.location.href + " #notif_img > a " );
}
setInterval('updatenotif()', 5000);
		

// ajout de la classe JS à HTML
document.querySelector("html").classList.add('js');

// initialisation des variables
var fileInput = document.querySelector( ".input-file" ),
	button = document.querySelector( ".input-file-trigger" ),
	the_return = document.querySelector(".file-return");

// action lorsque la "barre d'espace" ou "Entrée" est pressée
button.addEventListener( "keydown", function( event ) {
	if ( event.keyCode == 13 || event.keyCode == 32 ) {
		fileInput.focus();
	}
});

// action lorsque le label est cliqué
button.addEventListener( "click", function( event ) {
	fileInput.focus();
	return false;
});

// affiche un retour visuel dès que input:file change
fileInput.addEventListener( "change", function( event ) {
	the_return.innerHTML = 'Photo(s) séléctionnée(s)';
	the_return.style.display = 'flex';
});

function backfunction(){
	var loading = $('#loading');
	loading.addClass('yes');
	loading.removeClass('no');
}
</script>


<?php
if(isset($_POST['envoyerMsg'])){
	envoye_message($db);
}
}else{
    header("Location: ../../connexion.php");
}
?>
