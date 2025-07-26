<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Page ancienne sortie - Prive		    	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_ancien.php");
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>

</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- Bloc comprenant un list des sortie qui sont déja passé donc avec date de l'evenement <= date du jour -->
	<div id="div_tableau">
		<h2>Anciens Événements</h2>
		<table>
			<?php 
			// fonction ancien_balade qui prend comme parametre un base de donnée 
			// qui affichera des bloc avec des info sur les sorties 
			// qui sont des liens pour allé sur la page des messages de la sorties
			ancien_balade($db);
			?>
		</table>
	</div>
</body>
</html>

<script type="text/javascript">
// cree un variable active qui contiendra le 2 li de la liste menue qui se trouve dans le header
// on lui ajoute la classe active 
let active = document.querySelector(".navigation > ul > li:nth-child(2)");
active.classList.add('active');
// création de la fonction updateDiv_img qui permet de recharger toutes les 5s image afin d'afficher aléatoirement les différentes photos de la sortie

// function updateDiv_img()
// { 	
// 	$('table').load(window.location.href + " tbody" );
// }
// setInterval('updateDiv_img()', 5000);
// création de la fonction updateDiv qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
function updateDiv()
{ 	
	$('#notif_img ').load(window.location.href + " #notif_img > a " );
}
setInterval('updateDiv()', 5000);
</script>
<?php 
}else{
    header("Location: ../connexion.php");
}
?>