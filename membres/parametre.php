<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    				    Page membres - Prive		    	 	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_parametre.php");
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
	<link rel="stylesheet" type="text/css" href="style/parametre.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/parametre.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
		// fonction javascript qui affichera un message quand l'utilisateur aura choisi une nouvelle photo
    	$(document).ready(function() {
		    $('input[type="file"]').change(function(e) {
		        var file = e.target.files[0].name;
		        alert('La photo"' + file + '" a bien été séléctionnée, mais ne sera visible qu\'après quelques minutes, pour accélérer la procédure vider le cache de votre téléphone ou ctrl + maj + R sur votre pc après avoir cliqué sur "Valider modifications" à droite de l\'écran.');
		    });
		});
    </script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- 
	Bloc parametre 
	===> appelant la fonction bloc1, qui va appeler bloc2, qui va appeler bloc3, et qui va appeler bloc4 
	===> contient un formulaire pre rempli avec les information de l'utilisateur
	-->
	<div id="parametre_bloc">
		<div id="tableau_choix">
			<div id="modif_profil" class="bloc">
				<form method="post" enctype="multipart/form-data">
					<?php 
					bloc1($db);
					?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
// cree un variable active qui contiendra le 5 li de la liste menue qui se trouve dans le header
// on lui ajoute la classe active 
let active = document.querySelector(".navigation > ul > li:nth-child(5)");
active.classList.add('active');
// recuperation des différentes choix (type switch)
const cb = document.querySelector('#switch');
affiche_public_bloc(cb.checked);// si le choix est checked afficher profil public
// fonction choix, ajoutera ou supprimera le bloc5 (profil public) si l'utilisateur clique dessus
function choix() {
	setTimeout(function() {
		const cb = document.querySelector('#switch');
		console.log(cb.checked);
		affiche_public_bloc(cb.checked);
	}, 100);
}
// si le choix est sur vrai, afficher bloc sinon faire disparaitre bloc 
function affiche_public_bloc(cb){
	if (cb === true) {
		document.getElementById('bloc5').className = "bloc";
	}else{
		document.getElementById('bloc5').className = "none_b";
	}
}
// meme chose q'au dessus mais avec le 2eme choix switch
const cb_cop = document.querySelector('#switch_cop');
affiche_cop_bloc(cb_cop.checked);
function choix_cop() {
	setTimeout(function() {
		const cb_cop = document.querySelector('#switch_cop');
		console.log(cb_cop.checked);
		affiche_cop_bloc(cb_cop.checked);
	}, 100);
}
function affiche_cop_bloc(cb_cop){
	if (cb_cop === true) {
		document.getElementById('bloc6').className = "bloc";
	}else{
		document.getElementById('bloc6').className = "none_b";
	}
}
// 4 fonction qui permets de d'afficher 1 des blocs et de ne pas afficher les autres
function bloc1_function(){
	document.getElementById('bloc1').className = "bloc";
	document.getElementById('bloc2').className = "none_b";
	document.getElementById('bloc3').className = "none_b";
	document.getElementById('bloc4').className = "none_b";
}
function bloc2_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "bloc";
	document.getElementById('bloc3').className = "none_b";
	document.getElementById('bloc4').className = "none_b";
}
function bloc3_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "none_b";
	document.getElementById('bloc3').className = "bloc";
	document.getElementById('bloc4').className = "none_b";
}
function bloc4_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "none_b";
	document.getElementById('bloc3').className = "none_b";
	document.getElementById('bloc4').className = "bloc";
}
// en fonction du bouton cliquer on execute une des fonction precedentes pour afficher un des blocs
document.getElementById("buttonn1").addEventListener("click", bloc2_function);
document.getElementById("buttonn2_s").addEventListener("click", bloc3_function);
document.getElementById("buttonn2_p").addEventListener("click", bloc1_function);
document.getElementById("buttonn3_s").addEventListener("click", bloc4_function);
document.getElementById("buttonn3").addEventListener("click", bloc2_function);
document.getElementById("buttonn4").addEventListener("click", bloc3_function);
// création de la fonction updatenotif qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
function updatenotif()
	{ 	
		$('#notif_img ').load(window.location.href + " #notif_img > a " );
	}
	setInterval('updatenotif()', 5000);
</script>
<?php 
// On vérifie si le bouton de la variable $_POST['profil'] est cliquer 
// si la le bouton est on execute la fonction modifier_profil avec comme paramètre la variable de connection a la db 
if(isset($_POST['profil'])){
	modifier_profil($db);
}
}else{
    header("Location: ../connexion.php");
}
?>

