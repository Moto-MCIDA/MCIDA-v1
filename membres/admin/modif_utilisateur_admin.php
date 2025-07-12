<?php 
	include("../../fonction/connexion_db.php");

$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
$pseudo = $_GET['pseudo'];
$age = $_GET['age'];
$marque = $_GET['marque'];
$model = $_GET['model'];
$cylindre = $_GET['cylindre'];
$couleur = $_GET['couleur'];
$ville = $_GET['ville'];
$cp = $_GET['cp'];
$tel = $_GET['tel'];
$adresse1 = $_GET['adresse1'];
$adresse2 = $_GET['adresse2'];
$copilote = $_GET['copilote'];
$nom_cop = $_GET['nom_cop'];
$prenom_cop = $_GET['prenom_cop'];
$public = $_GET['public'];
$cotiser = $_GET['cotiser'];

$email = $_GET['email'];

$sql = "UPDATE utilisateur SET nom='$nom', prenom='$prenom', pseudo='$pseudo', age='$age', marque='marque', model='$model', cylindre='$cylindre', couleur='$couleur', ville='$ville', cp='$cp', tel='$tel', adresse1='$adresse1', adresse2='$adresse2', copilote='$copilote', nom_cop='$nom_cop', prenom_cop='$prenom_cop', public='$public', cotiser='$cotiser' WHERE email='$email'";
$modifier_balade = $db->query($sql);
header('Location: utilisateur_admin.php');

?>