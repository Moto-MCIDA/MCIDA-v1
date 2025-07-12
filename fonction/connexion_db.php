<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant						//
// de session passé dans une requête GET, POST ou par un cookie.																//
// Fonction ob_start() permet d'utiliser les fonctions header.																	//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_start();
ob_start();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mysqli ==> Base de donnée exclusivement Mysql | PDO ==> Tout type de base de donnée (PDO est plus simple que mysqli)			//						
// Connexion a la base de donnée																								//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
try
{
	$db = new PDO('mysql:host=localhost;dbname=mica;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);								// Force les noms de colonnes en minuscule
	$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 					// Reporter les erreurs de PDO
}
catch(Exception $e){
	echo "une erreur est survenue". $e->getMessage();
	die("Erreur PDO : " . $e->getMessage());
}
?>