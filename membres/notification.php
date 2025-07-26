<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Page notification - Prive		        	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
include("../fonction/cookieconn.php");
include("../fonction/connexion_db.php");
include("fonction/function_balade_propose.php");
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
	<link rel="stylesheet" type="text/css" href="style/notif.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/notif.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>

</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- bloc notif qui contiendra une liste de bloc qui seront des lien avec les infos de la notif --> 
	<div id="notif_bloc">
		<?php 
		affiche_notification($db);
		?>
	</div>
</body>
</html>
<script type="text/javascript">
// cree un variable active qui contiendra le 1 li de la liste menue qui se trouve dans le header (de base)
// cree un variable indict qui contiendra le div d'indication
// on enleve la class active a active
// on fais disparaitre la class indict
let active = document.querySelector(".navigation > ul > li:nth-child(1)");
let indict = document.querySelector(".indicatoract");
active.classList.remove('active');
indict.style.display = 'none';
// création de la fonction updateDiv qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
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