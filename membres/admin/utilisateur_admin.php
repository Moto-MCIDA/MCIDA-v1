<?php
	include("../../fonction/cookieconn.php");
	include("../../fonction/connexion_db.php");
	include("../fonction/function_index.php");
	include("../fonction/function_admin.php");
	include("../fonction/function_notification.php");

if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	if($_SESSION['user_id'] == 1 OR $_SESSION['user_id'] == 2 OR $_SESSION['user_id'] == 3) {

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/index.css">
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/admin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | Administrateur</title>

</head>
<body>
	<p><a style="padding: 1% 2.5%;
			    margin: 1%;
			    background-color: black;
			    color: white;" href="admin.php">Page administrateur</a></p>
	<div id="utilisateur">
		<table>
			<thead>
				<tr>
					<td>NOM</td>
					<td>PRÉNOM</td>
					<td>PSEUDO</td>
					<td>AGE</td>
					<td>MARQUE</td>
					<td>MODEL</td>
					<td>CYLINDRÉE</td>
					<td>COULEUR</td>
					<td>EMAIL</td>
					<td>VILLE</td>
					<td>CODE POSTAL</td>
					<td>TÉLÉPHONE</td>
					<td>ADRESSE 1</td>
					<td>ADRESSE 2</td>
					<td>COPILOTE</td>
					<td>NOM COP</td>
					<td>PRENOM COP</td>
					<td>PUBLIC</td>
					<td>COTISATION</td>
					<td>MODIFIER</td>
				</tr>
			</thead>
			<?php 
			$sql = "SELECT * FROM utilisateur";
			$all_profil = $db->query($sql);

			$html = '';
			while($profil = $all_profil->fetch()){
				$html .= '<tr>';
				$html .= '<form method="get" action="modif_utilisateur_admin.php">';
				$html .= '<td><input type="text" name="nom" value="'.$profil['nom'].'" required></td>';
				$html .= '<td><input type="text" name="prenom" value="'.$profil['prenom'].'" required></td>';
				$html .= '<td><input type="text" name="pseudo" value="'.$profil['pseudo'].'" required></td>';
				$html .= '<td><input type="date" name="age" value="'.$profil['age'].'" required></td>';
				$html .= '<td><input type="text" name="marque" value="'.$profil['marque'].'" required></td>';
				$html .= '<td><input type="text" name="model" value="'.$profil['model'].'" required></td>';
				$html .= '<td><input type="number" name="cylindre" value="'.$profil['cylindre'].'" required></td>';
				$html .= '<td><input type="text" name="couleur" value="'.$profil['couleur'].'" required></td>';
				$html .= '<td><p>'.$profil['email'].'</p>';
				$html .= '<td><input type="text" name="ville" value="'.$profil['ville'].'" required></td>';
				$html .= '<td><input type="number" name="cp" pattern="[0-9]{5}" value="'.$profil['cp'].'" required></td>';
				$html .= '<td><input type="tel" name="tel" pattern="[0-9]{10}" value="'.$profil['tel'].'"></td>';//
				$html .= '<td><input type="text" name="adresse1" value="'.$profil['adresse1'].'" required></td>';
				$html .= '<td><input type=text"" name="adresse2" value="'.$profil['adresse2'].'"></td>';
				$html .= '<td><input type="number" name="copilote" pattern="[0-1]{1}" value="'.$profil['copilote'].'" required></td>';
				$html .= '<td><input type="text" name="nom_cop" value="'.$profil['nom_cop'].'"></td>';
				$html .= '<td><input type="text" name="prenom_cop" value="'.$profil['prenom_cop'].'"></td>';
				$html .= '<td><input type="number" name="public" pattern="[0-1]{1}" value="'.$profil['public'].'" required></td>';
				$html .= '<td><input type="date" name="cotiser" value="'.$profil['cotiser'].'"></td>';
				$html .= '<td>';
				// Bouton Modifier
				$html .= '<input type="submit" name="modifier" value="Modifier" style="width: 100%; margin-bottom: 4px;">';
				// Champ email caché pour modification
				$html .= '<input type="hidden" name="email" value="'.$profil['email'].'">';
				$html .= '</form>';

				// Formulaire pour Supprimer
				$html .= '<form method="post" action="supprimer_utilisateur_admin.php" onsubmit="return confirm(\'Confirmer la suppression ?\')">';
				$html .= '<input type="hidden" name="email" value="'.$profil['email'].'">';
				$html .= '<input type="submit" name="supprimer" value="Supprimer" style="width: 100%; background-color: red; color: white;">';
				$html .= '</form>';

				$html .= '</td>';
				$html .= '</tr>';
			}
			print($html);
			?>
		</table>		
	</div>
</body>
</html>

<script type="text/javascript">

	function updateDiv()
	{ 	
	    $('#notif_img ').load(window.location.href + " #notif_img > a " );
	}

	setInterval('updateDiv()', 5000);

</script>

<?php 

	}else{
	    header("Location: index.php");
	}
}else{
    header("Location: ../../connexion.php");
}
?>