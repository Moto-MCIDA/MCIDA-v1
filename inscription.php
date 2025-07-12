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
include("fonction/fonction_email.php");

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
	<title>MCIDA | Inscription</title>
</head>
<body>
	<!-- Bloc photo  -->
	<div id="img_top">
		<img id="img_top_banniere" src="image/fond.jpg">
		<h1>MCIDA</h1>
		<img id="img_top_banniere_logo" src="image/MCIDA_logo.png">
	</div>
	<!-- 
	Bloc inscription 
	divisé en 3 partie (1 = Info perso, 2 = Info moto, 3 = Info connexion) 
	-->
	<div id="block_principal">
		<div id="second_block">
			<form method="post">
				<div id="inscription">
					<h1>Inscription</h1>
					<br>
					<div id="bloc">
						<h4>Informations Personnelles</h4>
						<input type="text" name="nom" placeholder="Votre nom *" required>
						<input type="text" name="pseudo" placeholder="Votre pseudo *" required>
						<input type="text" name="prenom" placeholder="Votre prenom *" required>
						<div style="justify-content: center; width: 100%;">
							<h6 style="font-size: 80%; margin: 0; display: flex; flex-direction: column; justify-content: center;">Votre date de naissance :</h6>
							<input type="date" name="age" value="<?php echo $DateAndTime; ?>" required>
						</div>
					</div>
				</div>
				<div id="inscription">
					<div id="bloc">
						<h4>Informations Moto</h4>
						<select name="marque" required>
							<option value="">Choisir une marque *</option>
							<option>Aprilia</option>
							<option>Benelli</option>
							<option>Bimota</option>
							<option>BMW</option>
							<option>Ducati</option>
							<option>Harley-Davidson</option>
							<option>Honda</option>
							<option>Husqvarna</option>
							<option>Kawasaki</option>
							<option>KTM</option>
							<option>Moto Guzzi</option>
							<option>MV Agusta</option>
							<option>Norton</option>
							<option>Suzuki</option>
							<option>Triumph</option>
							<option>Yamaha</option>
							<option>Autre</option>
						</select>
						<input type="text" name="model" placeholder="Model de la moto *" required>
						<input type="number" name="cylindre" placeholder="Cylindrée de la moto *" required>
						<input type="text" name="couleur" placeholder="Couleur de la moto *" required>
					</div>
				</div>
				<div id="inscription">
					<div id="bloc">
						<h4>Pourquoi voulez vous integrer le club ?</h4>
						<textarea name="raison" placeholder="Je voudrais intégrer ce club car ... *" required></textarea> 
					</div>
				</div>
				<div id="inscription">
					<div id="bloc">
						<h4>Informations Pré-enregistrement</h4>
						<input type="email" name="email" placeholder="Votre email *" required>
						<input type="tel" name="phone" pattern="[0-9]{10}" placeholder="Votre téléphone (Format: 0102030405)">
						<input type="number" name="cp" pattern="[0-9]{5}" placeholder="Votre code postal *" required>
						<input type="text" name="ville" placeholder="Votre ville *" required>
					</div>
					<br>
					<input type="submit" name="button" value="Demande d'inscription">
					<small style="font-size: x-small;">Merci de remplir tous les champs obligatoires (*)</small>
					<a href="connexion.php">Déja inscrit ?</a>	
				</div>	
			</form>
		</div>
	</div>	
<a id="acceuil" href="index.php"><img src="image/home_b.png"><img src="image/home_g.png"></a>
</body>
</html>
<?php 

	if (isset($_POST['button'])){	// Si bouton est cliquer on éxécute la fonction de demande d'inscription  
		demande_inscription($db);
	}

}else{
    header("Location: membres/index.php");
}
?>