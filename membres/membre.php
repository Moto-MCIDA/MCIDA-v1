<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    				    Page membres - Prive		    	 	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_membre.php");
	include("fonction/function_notification.php");
	include("../fonction/fonction_email.php");
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
	<link rel="stylesheet" type="text/css" href="style/membre.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/membre.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- bloc principal -->
	<div id="membreDiv">
		<!-- formulaire de recherche -->
		<form method="get">
		<input type="search" name="recherche" id="search_box" placeholder="Recherche..." />
		<input type="submit" value="Rechercher" id="button_recherche" /><br>
		</form>
		<!-- bloc contenant la list des membres -->
		<div id="list_profil">
			<?php
			// si variable $_GET['recherche'] existe et est non nul 
			// ===> alors on execute recupe_info_profil_recherche avec comme parametre la varible de connection a la db et la varible chain de recherche 
			// sinon
			// ===> on utilise la fonction affiche_message_tous avec comme parametre la varible de connection a la db qui affichera le groupe commun
			// ===> on utilise la fonction recupe_info_profil avec comme parametre la varible de connection a la db qui affichera tous les membres
			if(isset($_GET['recherche']) AND !empty($_GET['recherche'])) {
				$recherche = htmlspecialchars($_GET['recherche']);
				recupe_info_profil_recherche($db, $recherche);
			}else{
				affiche_message_tous($db);
				recupe_info_profil($db);	
			}
			?>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
// cree un variable active qui contiendra le 4 li de la liste menue qui se trouve dans le header
// on lui ajoute la classe active 
let active = document.querySelector(".navigation > ul > li:nth-child(4)");
active.classList.add('active');
// création de la fonction updatenotif qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
function updatenotif()
{ 	
	$('#notif_img ').load(window.location.href + " #notif_img > a " );
}
setInterval('updatenotif()', 5000);
</script>
<?php 
}else{
    header("Location: ../connexion.php");
}
?>