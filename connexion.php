<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Page Index - Public						    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/

include("fonction/connexion_db.php");
include("fonction/cookieconn.php");
include("fonction/inscription_connexion.php");

/* On vérifie que la variable session n'existe pas et n'est pas vide ****/
/* Si non on renvoie l'utilisateur vers la page index membre ************/

if(!isset($_SESSION['user_id']) AND empty($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="style/acceuil.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/acceuil.css">
	<link rel="stylesheet" type="text/css" href="style/inscription.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/inscription.css">
	<title>MCIDA | Connexion</title>
</head>
<body>
	<div id="img_top">
		<img id="img_top_banniere" src="image/fond.jpg">
		<h1>MCIDA</h1>
		<img id="img_top_banniere_logo" src="image/MCIDA_logo.png">
	</div>
	<div id="block_principal">
		<div id="second_block">
			<form method="post">
				<div id="inscription">
					<h1>Connexion</h1>
					<div id="bloc">
						<br>
					    <input type="text" name="email" placeholder="Votre email" required>
						<input type="password" name="mdp" placeholder="Votre mot de passe" required>
					</div>
					<br>
					<input type="submit" name="button" value="Se connecter" style="margin-bottom: 2.5%;">
					<label for="remember"><input type="checkbox" name="rememberme" id="remember"> Se souvenir de moi</label>
					<div style="width: 100%; display: flex; flex-direction: row; justify-content: center; margin: 0;">
						<a href="inscription.php">Pas encore de compte ?</a>	
						<a href="mdpModif/mdp_oublier.php">Mot de passe oublié ?</a>
					</div>	
				</div>	
			</form>
		</div>
	</div>
<a id="acceuil" href="index.php"><img src="image/home_b.png"><img src="image/home_g.png"></a>
</body>
</html>
<?php 

	if (isset($_POST['button'])){ // Si bouton est cliquer on éxécute la fonction pour se connecter
		connexion($db);
	}

}else{
    header("Location: membres/index.php");
}
?>