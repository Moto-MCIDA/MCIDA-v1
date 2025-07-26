<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Page Index - Prive						    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/

	include("../fonction/cookieconn.php");
	include("../fonction/connexion_db.php");
	include("fonction/function_index.php");
	include("fonction/function_notification.php");
	include("../fonction/fonction_email.php");


/* On vérifie que la variable session existe et n'est pas vide **********/
/* Si non on renvoie l'utilisateur vers la page ../connexion.php *******/
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	if(isset($_GET['id']) AND !empty($_GET['id'])) {
		$user_id = $_SESSION['user_id'];
		date_default_timezone_set('Europe/Paris');
		$dateFr = $ajrd = date("d-m-Y H:i:s");
		$date = (new DateTime($dateFr))->format("Y-m-d H:i:s");
		$id_link = $_GET['id'];

		$booleen = $db->query("SELECT count(*) FROM ligne WHERE user = '$user_id' AND link ='accepter' AND id_link='$id_link'"); // on compte combien de balade on une date >= a la date du jour 
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			// UPDATE `balade_membre` SET reponse='$choix_reponse', commentaire='$commentaire', nb_prs = '$nb_personne' WHERE id_utilisateur=$user_id AND id_balade=$balade_id"
			$sql = "UPDATE `ligne` SET date_ligne='$date' WHERE user = '$user_id' AND link = 'accepter' AND id_link='$id_link'";
		}else{
			$sql = "INSERT INTO `ligne` (user, link, id_link, date_ligne) VALUES ('$user_id', 'accepter', '$id_link', '$date')";
		}
		$ajout_ligne = $db->query($sql);

		
		$booleen = $db->query("SELECT count(*) FROM ligne WHERE user = '$user_id' AND link ='création balade' AND id_link='$id_link'"); // on compte combien de balade on une date >= a la date du jour 
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$sql1 = "UPDATE `ligne` SET date_ligne='$date' WHERE user = '$user_id' AND link = 'création balade' AND id_link='$id_link'";
		}else{
			$sql1 = "INSERT INTO `ligne` (user, link, id_link, date_ligne) VALUES ('$user_id', 'création balade', '$id_link', '$date')";
		}
		$ajout_ligne1 = $db->query($sql1);

		$booleen = $db->query("SELECT count(*) FROM ligne WHERE user = '$user_id' AND link ='modifier balade' AND id_link='$id_link'"); // on compte combien de balade on une date >= a la date du jour 
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$sql2 = "UPDATE `ligne` SET date_ligne='$date' WHERE user = '$user_id' AND link = 'modifier balade' AND id_link='$id_link'";
		}else{
			$sql2 = "INSERT INTO `ligne` (user, link, id_link, date_ligne) VALUES ('$user_id', 'modifier balade', '$id_link', '$date')";
		}
		$ajout_ligne2 = $db->query($sql2);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/index.css">
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- ajoute de bibliothèque ajax -->
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<style>
	#scroller {
		display: flex;
		gap: 15px;
		flex-wrap: wrap;
		padding: 10px;
	}

	.scrollerItem {
		position: relative;
		width: 80px;
		height: 80px;
		cursor: pointer;
	}

	.scrollerItem img {
		width: 100%;
		height: 100%;
		border-radius: 50%;
		object-fit: cover;
		box-shadow: 0 2px 6px rgba(0,0,0,0.2);
	}

	.badge-top {
		position: absolute;
		top: -5px;
		right: -5px;
		color: white;
		border-radius: 50%;
		width: 24px;
		height: 24px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 12px;
		font-weight: bold;
	}

	.badge-bottom {
		position: absolute;
		bottom: -5px;
		left: 50%;
		transform: translateX(-50%);
		color: white;
		border-radius: 10px;
		padding: 2px 6px;
		font-size: 12px;
	}
</style>
<body>
	<?php 
	// Ajout de la page fonction/header.php 
	// Page contien la barre de profil de base 
	include_once('fonction/header.php');
	?>
	<!-- 
		Bloc partie1 qui contiendra :
		===> les Sorties que les utilisateurs on proposé 
		===> seulement celle dont la date >= à la date du jour 
		===> un select qui permetera de choisir le types de sorti voulu
	-->
	<div class="partie1">
		<?php 
			// vérifie si la variable $_GET['type'] existe et si elle est non nulle
			// si elle existe on mets le champs 'selected' dans une des 6 différentes variable en fonction de la valeur dans $_GET['type']
			if(isset($_GET['type']) AND !empty($_GET['type'])){	
				if($_GET['type'] == 'Balade'){
					$choix = '';
					$choix1 = 'selected';
					$choix2 = '';
					$choix3 = '';
					$choix4 = '';
					$choix5 = '';
				}elseif ($_GET['type'] == 'Réunion') {
					$choix = '';
					$choix1 = '';
					$choix2 = 'selected';
					$choix3 = '';
					$choix4 = '';
					$choix5 = '';
					
				}elseif ($_GET['type'] == 'Restaurant') {
					$choix = '';
					$choix1 = '';
					$choix2 = '';
					$choix3 = 'selected';
					$choix4 = '';
					$choix5 = '';			

				}elseif ($_GET['type'] == 'Autre') {
					$choix = '';
					$choix1 = '';
					$choix2 = '';
					$choix3 = '';
					$choix4 = 'selected';
					$choix5 = '';			

				}elseif ($_GET['type'] == 'Tout') {
					$choix = '';
					$choix1 = '';
					$choix2 = '';
					$choix3 = '';
					$choix4 = '';
					$choix5 = 'selected';			

				}
			}else{
				$choix = 'selected';
				$choix1 = '';
				$choix2 = '';
				$choix3 = '';
				$choix4 = '';
				$choix5 = '';	
			}
		?>

		<h2>Prochains Événements</h2>
		<!-- Formulaire de choix de type de sortie, avec a chaque options une des 6 variables php définie au dessus -->
		<form method="get">
			<select class='choixEvenement'name="type">
				<option value="" <?php echo $choix; ?>>Choisir un type d'événement</option>
				<option <?php echo $choix1; ?>>Balade</option>
				<option <?php echo $choix2; ?>>Réunion</option>
				<option <?php echo $choix3; ?>>Restaurant</option>
				<option <?php echo $choix4; ?>>Autre</option>
				<option <?php echo $choix5; ?>>Tout</option>
			</select>
			<input type="submit" name="choisir" value="Validez">
		</form>
		<!-- tableau contenant la liste des sorties à venir -->
		<table>
			<?php 
			// vérifie si la variable $_GET['type'] existe et si elle est non nulle
			// si elle existe on execute la fonction new_balade avec comme paramètre la variable de connection a la db et la valeur dans $_GET['type']
			// sinon on execute la fonction new_balade avec comme paramètre la variable de connection a la db et la chaine 'Tous'
			if(isset($_GET['type']) AND !empty($_GET['type'])){	
				new_balade($db, $_GET['type']); 
			}else{
				new_balade($db, 'Tout'); 
			}
			?>
		</table>
	</div>
	<!-- 
		Bloc partie2 qui contiendra :
		===> les informations de la sortie choisi
		===> un bloc pour répondre a cette sortie (dire si on est présent ou non, le nombre de personne, et un commentaire facultatif)
		===> un bloc avec les différents profils des personnes présentes a la sortie, qui ne save pas, et absent 
	-->
	<div class="partie2">
		<?php 
		// vérifie si la variable $_GET['id'] existe et si elle est non nulle
		// si elle existe on execute la fonction balade_info avec comme paramètre la variable de connection a la db et la valeur dans $_GET['id']
		// ===> pour afficher les information de la sortie sur la qu'elle l'utilisateur a cliqué
		// sinon 
		// ===> on cherche dans la base de donnée, dans la table balade, la sortie dont la date est la plus proche de la date du jour
		// ===> on execute la fonction balade_info avec comme paramètre la variable de connection a la db et l'id de la prochaine sortie
		if(isset($_GET['id']) AND !empty($_GET['id'])) {
			balade_info($db, $_GET['id']);
		}else{
			date_default_timezone_set('Europe/Paris');
			$ajrd = date("Y-m-d");
			$booleen = $db->query("SELECT count(*) FROM balade WHERE date_sortie >= '$ajrd'"); // on compte le nombre de sortie qu'il y a apres la date du jour
			$bool = $booleen->fetchColumn();
			if($bool >= 1){ // si il y a une sortie ou plus 
				$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie >= '$ajrd' ORDER BY date_sortie"); // on recupère les valeurs des sortie dans la table balade par ordre de date
				$balade->execute();
				$res = $balade->fetch(PDO::FETCH_OBJ);
				balade_info($db, $res->id); // on execute la fonction avec le resultat
			}else{
				echo 'Pas d\'évenement'; // s'il ya 0 sortie on affiche le message pas de balade
			}
		}
		?>
	</div>
	<div id="commentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
	<div style="background:white; padding:20px; border-radius:8px; max-width:400px; width:90%; position:relative;">
		<span onclick="closeCommentModal()" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:18px;">✖</span>
		<h3 id="modalNomPrenom"></h3>
		<p><strong>Nombre de personnes :</strong> <span id="modalNbPrs"></span></p>
		<p><strong>Commentaire :</strong></p>
		<p id="modalCommentaire"></p>
	</div>
</div>
</body>
</html>

<script type="text/javascript">
// cree un variable active qui contiendra le 1 li de la liste menue qui se trouve dans le header
// on lui ajoute la classe active 
let active = document.querySelector(".navigation > ul > li:nth-child(1)");
active.classList.add('active');
// création de la fonction updateDiv qui permet de recharger toutes les 5s le bloc notification afin d'afficher le nombre de notification
function updateDiv()
{ 	
	$('#notif_img ').load(window.location.href + " #notif_img > a " );
}
setInterval('updateDiv()', 5000);
// création de la fonction heure qui permet de recharger toutes les 1s le afin d'actualiser le compteur
function heure(){   
	$('#partie1 table').load(window.location.href + " #partie1 tbody" );
}
setInterval('heure()', 1000);
// création de la fonction backfunction afin d'afficher un bloc de chargement pour eviter les double clique 
function backfunction(){
	var loading = $('#loading');
	loading.addClass('yes');
	loading.removeClass('no');
}

function openCommentModal(nom, prenom, nb, comm) {
	document.getElementById('modalNomPrenom').innerText = nom + ' ' + prenom;
	document.getElementById('modalNbPrs').innerText = nb;
	document.getElementById('modalCommentaire').innerText = comm;
	document.getElementById('commentModal').style.display = 'flex';
}

function closeCommentModal() {
	document.getElementById('commentModal').style.display = 'none';
}
</script>

<?php 
// On vérifie si le bouton de la variable $_POST['envoyer'] est cliquer 
// si la le bouton est cliquer on vérifie si la variable $_GET['id'] existe et si elle est non nulle
// si elle existe on execute la fonction envoyer_presence_balade avec comme paramètre la variable de connection a la db et la valeur dans $_GET['id']
// sinon 
// ===> on cherche dans la base de donnée, dans la table balade, la sortie dont la date est la plus proche de la date du jour
// ===> on execute la fonction balade_info avec comme paramètre la variable de connection a la db et l'id de la prochaine sortie
if(isset($_POST['envoyer'])){
	if(isset($_GET['id']) AND !empty($_GET['id'])) {
		envoyer_presence_balade($db, $_GET['id']);
	}else{
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d");
		$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie >= '$ajrd' ORDER BY date_sortie");
		$balade->execute();
		$res = $balade->fetch(PDO::FETCH_OBJ);
		envoyer_presence_balade($db, $res->id);
	}
}

if(isset($_GET['id']) AND !empty($_GET['id'])) {
?>
	<script>
		document.querySelector('.partie2').setAttribute('id','partie_Block');
		document.querySelector('.partie1').setAttribute('id','partie_None');
	</script>
<?php
}

}else{
    header("Location: ../connexion.php");
}
?>