<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Page modifier sortie - Prive		    	    //
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
	<!-- bloc modif qui contiendra un formulaire prérempli par les informations sur la sortie -->
	<div id="modif">
		<?php 
		// fonction balade avec comme parametre la varible de cennection a la db
		modifier_balade($db);
		?>
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
});
</script>
<?php 
// On vérifie si le bouton de la variable $_POST['envoyer'] est cliquer 
if(isset($_POST['envoyer'])){
	// si la le bouton est on execute on recuper les différents variables 
	$id_balade = $_GET['id_balade'];
	$choix = $_POST['choix'];
	$nom = ucwords($_POST['nom']);
	$date = $_POST['date'];
	$description = addslashes($_POST['description']);
	$doc = $_FILES['doc']["name"][0];
	$user_id = $_SESSION['user_id'];
	// on verifie si les variable choix, nom, date, et description ne sont pas vide 
	if($choix&&$nom&&$date&&$description){
		// si oui on mets ajour toutes la ligne de la table balade quand l'id est egal a la variable id_balade 
		$modifier_balade = $db->prepare("UPDATE balade SET type = '$choix', nom = '$nom', date_sortie = '$date', description = '$description' WHERE id='$id_balade'");
		$modifier_balade->execute();
		// on verifi si la variable doc n'est pas vide
		if (!empty($doc)) {
			// si oui on mets ajour la colonne doc de la ligne de la table balade quand l'id est egal a la variable id_balade
			$modifier_balade_doc = $db->prepare("UPDATE balade SET doc = 1 WHERE id='$id_balade'");
			$modifier_balade_doc->execute();
			inserer_doc($db, $id_balade); // et on execute la fonction inserer_doc afin de mettre les document dans un dossier pour la balade
		}
		// puis on execute la fonction creer_notification_modif_balade
		creer_notification_modif_balade($db, $user_id, $id_balade);
		header('Location: balade_propose.php'); // et on se redirige vers la page de base
	}else{
		// sinon on precise qui faut remplir tout les champs
		echo '<script type="text/javascript">
		       window.onload = function () { alert("Veuillez remplir tous les champs"); } 
		</script>'; 
	}
}
}else{
    header("Location: ../connexion.php");
}
?>