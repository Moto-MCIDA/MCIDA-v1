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

	// Récupération de la ville, du code postal de la personne et d'information accepter et finInscription
	$email = $_GET['perso'];
	$select = $db->query("SELECT cp,ville,accepter,finInscription FROM utilisateur WHERE email = '$email'");
	$select_f = $select->fetch();
	if($select_f['accepter'] == 1 AND $select_f['fininscription'] == 0) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="style/acceuil.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/acceuil.css">
	<link rel="stylesheet" type="text/css" href="style/inscription_fin.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/inscription_fin.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    	// fonction javascript qui informe la personne que la photo est bien pris en compte 
    	$(document).ready(function() {
		    $('input[type="file"]').change(function(e) {
		        var file = e.target.files[0].name;
		        alert('La photo"' + file + '" sera visible à la fin de l\'inscription');
		    });
		});
    </script>
	<title>MCIDA | Inscription</title>
</head>
<body>
	<div id="img_top">
		<img id="img_top_banniere" src="image/fond.jpg">
		<h1>MCIDA</h1>
		<img id="img_top_banniere_logo" src="image/MCIDA_logo.png">
	</div>
	<div id="block_principal">
		<div id="second_block">
			<form method="post" enctype="multipart/form-data">
				<div id="inscription">
					<h1 style="margin-bottom: 1%;">Fin d'inscription</h1>
					<div id="sous_box">
						<div id="box_defilement">
							<div id="bloc1" class="bloc">
								<img src="image/inscription/anonyme_profil.jpg">
								<div id="paragraphe">
									<label class="button" for="input_file_profil" title="Attention, seulement les photos en .jpg ou .jpeg sont acceptées">Choisir une photo de profil</label>
									<input id="input_file_profil" type="file" name="photoProfil">
									<input type="password" name="mdp" placeholder="Votre mot de passe *" required>
									<input type="password" name="cmdp" placeholder="Confirmer votre mot de passe *" required>
									<h4 style="margin: 1%;"><?php echo $select_f['cp'].' '.$select_f['ville']; ?></h4>
									<input type="text" name="adress1" placeholder="Votre adresse 1 *" required>
									<input type="text" name="adress2" placeholder="Votre adresse 2">
									<small style="font-size: x-small;">Merci de remplir tous les champs obligatoires (*)</small>
									<div id="button_bloc">
										<h6 id="buttonn1s">Suivant</h6>
									</div>
								</div>
							</div>
							<div id="bloc2" class="none_b">
								<img src="image/inscription/anonyme_moto.jpg">
								<div id="paragraphe">
									<label class="button" for="input_file_moto" title="Attention, seulement les photos en .jpg ou .jpeg sont accepter">Choisir une photo de votre moto</label>
									<input id="input_file_moto" type="file" name="photoMoto">
									<div id="button_bloc">
										<h6 id="buttonn2p">Précedent</h6>
										<h6 id="buttonn2s">Suivant</h6>
									</div>
								</div>
							</div>
							<div id="bloc3" class="none_b" style="flex-direction: column;">
								<select name="copilote" id="valeur_copilote" onchange="choix()">
									<option value="0">Pas de copilote</option>
									<option value="1">Copilote</option>
								</select>
								<div id="button_bloc" style="margin: auto;">
									<h6 id="buttonn3p">Précedent</h6>
									<h6 id="buttonn3s">Suivant</h6>
								</div>
							</div>
							<div id="bloc4_1" class="none_b">
								<img src="image/inscription/anonyme_profil.jpg">
								<div id="paragraphe">
									<label class="button" for="input_file_profil_cop" title="Attention, seulement les photos en .jpg ou .jpeg sont accepter">Choisir une photo de profil pour le copilote</label>
									<input id="input_file_profil_cop" type="file" name="photoProfilCop">
									<input type="text" name="copilote_nom" placeholder="Nom du copilote *">
									<input type="text" name="copilote_prenom" placeholder="Prénom du copilote *">
									<input type="submit" name="inscription" value="Terminer l'inscription">
									<small style="font-size: x-small;">Merci de remplir tous les champs obligatoires (*)</small>
									<small style="font-size: x-small;">Une fois l'inscription terminée vous serez redirigé vers la page de connexion</small>
									<small style="font-size: x-small;">Pour modifiez ultérieurement votre profil allez dans les paramètres de votre compte</small>
									<div id="button_bloc">
										<h6 id="buttonn41">Précedent</h6>
									</div>
								</div>
							</div>
							<div id="bloc4_0" class="none_b">
								<div id="paragraphe" style="width: 75%;">
									<input type="submit" name="inscription" value="Terminer l'inscription">
									<small style="font-size: x-small;">Une fois l'inscription terminée vous serez redirigé vers la page de connexion</small>
									<small style="font-size: x-small;">Pour modifiez ultérieurement votre profil allez dans les paramètres de votre compte</small>
									<div id="button_bloc">
										<h6 id="buttonn40">Précedent</h6>
									</div>
								</div>
							</div>
						</div>
					</div> 
				</div>	
			</form>
		</div>
	</div>	
</body>
</html>
<script type="text/javascript">
	// fonction qui vois si l'utilisateur à un copilote ou pas
	function choix() {
    	var select = document.getElementById( "valeur_copilote" ), index = select.selectedIndex;
        var result = select.options[ index ].value;
        return result;
    }
    // les 4 fonctions suivante permet d'afficher les 4 blocs différents
	function bloc1_function(){
		document.getElementById('bloc1').className = "bloc";
		document.getElementById('bloc2').className = "none_b";
		document.getElementById('bloc3').className = "none_b";
		document.getElementById('bloc4_0').className = "none_b";
		document.getElementById('bloc4_1').className = "none_b";
	}
	function bloc2_function(){
		document.getElementById('bloc1').className = "none_b";
		document.getElementById('bloc2').className = "bloc";
		document.getElementById('bloc3').className = "none_b";
		document.getElementById('bloc4_0').className = "none_b";
		document.getElementById('bloc4_1').className = "none_b";
	}
	function bloc3_function(){
		document.getElementById('bloc1').className = "none_b";
		document.getElementById('bloc2').className = "none_b";
		document.getElementById('bloc3').className = "bloc";
		document.getElementById('bloc4_0').className = "none_b";
		document.getElementById('bloc4_1').className = "none_b";
	}
	function bloc4_function(){
		var result = choix();
		if(result == 1){
			document.getElementById('bloc1').className = "none_b";
			document.getElementById('bloc2').className = "none_b";
			document.getElementById('bloc3').className = "none_b";
			document.getElementById('bloc4_0').className = "none_b";
			document.getElementById('bloc4_1').className = "bloc";
		}else{
			document.getElementById('bloc1').className = "none_b";
			document.getElementById('bloc2').className = "none_b";
			document.getElementById('bloc3').className = "none_b";
			document.getElementById('bloc4_0').className = "bloc";
			document.getElementById('bloc4_1').className = "none_b";
		}
	}
	// permet d'executer les différentes fonctions précedentes en fonction des boutons cliquer 
	document.getElementById("buttonn1s").addEventListener("click", bloc2_function);
	document.getElementById("buttonn2s").addEventListener("click", bloc3_function);
	document.getElementById("buttonn3s").addEventListener("click", bloc4_function);
	document.getElementById("buttonn2p").addEventListener("click", bloc1_function);
	document.getElementById("buttonn3p").addEventListener("click", bloc2_function);
	document.getElementById("buttonn41").addEventListener("click", bloc3_function);
	document.getElementById("buttonn40").addEventListener("click", bloc3_function);

</script>
<?php 

		if (isset($_POST['inscription'])) {	// Si bouton est cliquer on éxécute la fonction pour terminer l'inscription  
			termine_inscription($db);
		}
	}else{
	    header("Location: membres/index.php");
	}
}else{
    header("Location: membres/index.php");
}
?>