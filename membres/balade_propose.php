<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Page proposer sortie - Prive		    	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_balade_propose.php");
	include("fonction/function_notification.php");
	include('../fonction/fonction_email.php');
/* On vérifie que la variable session existe et n'est pas vide **********/
/* Si non on renvoie l'utilisateur vers la page ../connexion.php *******/
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/index.css">
	<link rel="stylesheet" type="text/css" href="style/balade_propose.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/balade_propose.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- bloc contenant les 2 partie de la page -->
	<div id="corps">
		<!-- partie comprenant une liste avec toutes les balades cree par l'utilisateur -->
		<div id="balade_propose">
			<h2>Mes Événements</h2>
			<?php
			// fonction rechecher_balade qui a comme paramètre la variable de connection a la db 
			// ===> fonction qui nous affichera la list de bloc avec des info sur les sorties cree + 2 boutons afin de supprimer, modifier la sortie
			rechecher_balade($db);
			?>
		</div>
		<div id="propose">
			<?php
			// fonction creer_nouvelle_balade qui a comme paramètre la variable de connection a la db 
			// ===> fonction qui affichera un formulaire pour cree une sortie
			creer_nouvelle_balade($db); 

			?>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
// cree un variable active qui contiendra le 3 li de la liste menue qui se trouve dans le header
// on lui ajoute la classe active 
let active = document.querySelector(".navigation > ul > li:nth-child(3)");
active.classList.add('active');
// création de la fonction updateDiv qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
function updatenotif()
{ 	
	$('#notif_img ').load(window.location.href + " #notif_img > a " );
}
setInterval('updatenotif()', 5000);
// partie gestion des document 
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
	the_return.innerHTML = 'Document(s) séléctionné(s)';
	the_return.style.display = 'flex';
});
// création de la fonction backfunction afin d'afficher un bloc de chargement pour eviter les double clique 
function backfunction(){
	var loading = $('#loading');
	loading.addClass('yes');
	loading.removeClass('no');
}
</script>
<?php 
// On vérifie si le bouton de la variable $_POST['envoyer'] est cliquer 
// si la le bouton est on execute la fonction propose_balade avec comme paramètre la variable de connection a la db 
if(isset($_POST['envoyer'])){
	propose_balade($db);
}
}else{
    header("Location: ../connexion.php");
}
?>