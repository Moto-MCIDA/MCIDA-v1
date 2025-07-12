<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    				    Page membres - Prive		    	 	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_profil.php");
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
	<link rel="stylesheet" type="text/css" href="style/profil.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/profil.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- 
	Bloc  
	===> appelant la fonction affiche_profil, qui va appeler dautre fonction afin d'afficher les différents bloc 
	-->
	<div id="block_principal">
		<div id="box_defilement">
			<?php
			affiche_profil($db);
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
//fonction qui permet de voir si le membre que l'utilsateur a choisi a un copilote ou non
function choix() {
	var select = document.getElementById( "valeur_copilote" ), index = select.selectedIndex;
	var result = select.options[ index ].value;
	return result;
}
// 4 fonction qui permets de d'afficher 1 des blocs et de ne pas afficher les autres
function bloc1_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "bloc";
	document.getElementById('bloc3').className = "none_b";
}
function bloc2_s_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "none_b";
	document.getElementById('bloc3').className = "bloc";
}
function bloc2_p_function(){
	document.getElementById('bloc1').className = "bloc";
	document.getElementById('bloc2').className = "none_b";
	document.getElementById('bloc3').className = "none_b";
}
function bloc3_function(){
	document.getElementById('bloc1').className = "none_b";
	document.getElementById('bloc2').className = "bloc";
	document.getElementById('bloc3').className = "none_b";
}
// en fonction du bouton cliquer on execute une des fonction precedentes pour afficher un des blocs
document.getElementById("buttonn1").addEventListener("click", bloc1_function);
document.getElementById("buttonn2_s").addEventListener("click", bloc2_s_function);
document.getElementById("buttonn2_p").addEventListener("click", bloc2_p_function);
document.getElementById("buttonn3").addEventListener("click", bloc3_function);
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