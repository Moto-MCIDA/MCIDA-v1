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
<style>
	body {
		font-family: 'Segoe UI', sans-serif;
		background-color: #f4f4f4;
		margin: 0;
		padding: 0;
	}

	#utilisateur {
		overflow-x: auto;
		grid-row-start: 2;
		grid-column-start: 1;
		grid-row-end: 5;
		grid-column-end: 7;
		width: 95%;
		height: 90%;
		margin: auto;
		margin-bottom: 10px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
		background-color: white;
		box-shadow: 0 0 10px rgba(0,0,0,0.1);
	}

	th, td {
		padding: 8px 10px;
		border: 1px solid #ddd;
		text-align: center;
	}

	thead {
		background-color: #6CA0DC;
		color: white;
	}

	input[type="text"], input[type="number"], input[type="email"], input[type="date"], input[type="tel"] {
		width: 100%;
		padding: 5px;
		box-sizing: border-box;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	input[type="submit"], button {
		padding: 6px 12px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	input[type="submit"][name="modifier"] {
		background-color: #6CA0DC;
		color: white;
	}

	input[type="submit"][name="supprimer"] {
		background-color: #E74F3F;
		color: white;
	}

	button#ajoutBtn {
		background-color: #43DD9D;
		color: white;
		margin: 20px 0;
	}

	#ajoutModal {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0,0,0,0.5);
		display: none;
		justify-content: center;
		align-items: center;
		z-index: 999;
	}

	#ajoutModal form {
		background-color: white;
		padding: 20px;
		border-radius: 8px;
		max-width: 700px;
		width: 90%;
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		justify-content: space-between;
		box-shadow: 0 0 15px rgba(0,0,0,0.2);
	}

	#ajoutModal label {
		flex: 1 1 45%;
		display: flex;
		flex-direction: column;
		font-weight: bold;
		font-size: 14px;
	}

	#ajoutModal input[type="submit"],
	#ajoutModal button {
		flex: 1 1 45%;
		margin-top: 10px;
	}

	@media screen and (max-width: 768px) {
		#ajoutModal label {
			flex: 1 1 100%;
		}
	}
</style>
<body>
	<?php 
	include_once('../fonction/header.php');
	?>
	<div id="utilisateur">
		<table>
			<thead>
				<tr>
					<td>NOM DE FAMILLE</td>
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
					<td>MODIFIER / SUPPRIMER</td>
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
		<button id="ajoutBtn">➕ Ajouter un utilisateur</button>   
	</div>
	<div id="ajoutModal" style="display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: auto;
    height: auto;
    background: white;
    border: 2px solid black;
    padding: 2%;
    z-index: 999;">
	<span onclick="document.getElementById('ajoutModal').style.display='none'" 
      style="position: absolute; top: 10px; right: 15px; font-size: 20px; font-weight: bold; cursor: pointer;">
    ✖
</span>
    <form method="post" action="ajout_utilisateur_admin.php">
        <label>Nom: <input type="text" name="nom" required></label>
        <label>Prénom: <input type="text" name="prenom" required></label>
        <label>Pseudo: <input type="text" name="pseudo" required></label>
        <label>Age: <input type="date" name="age" required></label>
        <label>Marque: <input type="text" name="marque" required></label>
        <label>Modèle: <input type="text" name="model" required></label>
        <label>Cylindrée: <input type="number" name="cylindre" required></label>
        <label>Couleur: <input type="text" name="couleur" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label>Ville: <input type="text" name="ville" required></label>
        <label>Code postal: <input type="number" name="cp" required></label>
        <label>Téléphone: <input type="tel" name="tel" pattern="[0-9]{10}" required></label>
        <br><br>
        <input type="submit" name="ajouter" value="Ajouter" style="padding: 5px 10px;"> 
	</form>
</div>
</body>
</html>

<script type="text/javascript">

	function updateDiv() {
	    $('#notif_img').load(window.location.href + " #notif_img > a");
	}
	setInterval(updateDiv, 5000);

	document.addEventListener('DOMContentLoaded', function () {
		const ajoutModal = document.getElementById('ajoutModal');
		const btnAjout = document.getElementById('ajoutBtn');
		const closeBtn = ajoutModal.querySelector('span');

		btnAjout.addEventListener('click', () => {
			ajoutModal.style.display = 'flex';
		});

		if (closeBtn) {
			closeBtn.addEventListener('click', () => {
				ajoutModal.style.display = 'none';
			});
		}
	});

	$("#img_top > a").attr("href", "admin.php");

</script>

<?php 

	}else{
	    header("Location: index.php");
	}
}else{
    header("Location: ../../connexion.php");
}
?>