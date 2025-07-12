<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Page Index - Public						    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/

include("../fonction/connexion_db.php");
include("../fonction/cookieconn.php");
include("../fonction/fonction_email.php");

/* On vérifie que la variable session n'existe pas et n'est pas vide ****/
/* Si non on renvoie l'utilisateur vers la page index membre ************/

if(!isset($_SESSION['user_id']) AND empty($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="../style/acceuil.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/acceuil.css">
	<link rel="stylesheet" type="text/css" href="../style/inscription.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/inscription.css">
	<title>MCIDA | MOT DE PASSE OUBLIÉ</title>
</head>
<body>
	<div id="img_top">
		<img id="img_top_banniere" src="../image/fond.jpg">
		<h1>MCIDA</h1>
		<img id="img_top_banniere_logo" src="../image/MCIDA_logo.png">
	</div>
	<div id="block_principal">
		<div id="second_block">
			<form method="post">
				<div id="inscription">
					<h1>MOT DE PASSE OUBLIÉ</h1>
					<div id="bloc" style="display: flex; flex-direction: column; justify-content: center;">
						<br>
						<input style="margin: auto;" type="email" name="email" placeholder="Votre email" required><br>
						<small>Veuillez saisir votre adresse e-mail, si votre adresse existe dans la base de donnée, nous vous enverrons un e-mail avec un lien pour modifier votre mot de passe !</small>
					</div>
					<br>
					<input type="submit" name="button" value="Valider" style="margin-bottom: 2.5%;">
					<a href="connexion.php">Page de connexion</a>	
				</div>	
			</form>
		</div>
	</div>
<a id="acceuil" href="../index.php"><img src="../image/home_b.png"><img src="../image/home_g.png"></a>
</body>
</html>
<?php 

	if (isset($_POST['button'])){ // Si bouton est cliquer on éxécute la fonction pour se connecter
		demandeModifMdp($db);
	}

}else{
    header("Location: ../membres/index.php");
}


function demandeModifMdp($db){
	$email = $_POST['email'];
	$booleen = $db->query("SELECT count(*) FROM utilisateur WHERE email = '$email'");
	$bool = $booleen->fetchColumn();
	if($bool == 1){
		envoyer_email_mdp_oublier($db, $email);
		header('Location: ../connexion.php');
	}else{
		echo '<script type="text/javascript">
			       window.onload = function () { alert("Pas de compte correspondant à cette adresse e-mail !"); } 
			</script>'; 	
	}
}
?>