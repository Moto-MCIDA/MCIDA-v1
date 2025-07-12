<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    		    Fonction supprime notif - Prive		    		    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
include("../../fonction/cookieconn.php");
include("../../fonction/connexion_db.php");
include("../fonction/function_notification.php");
/********************************************************************** */
// on verifie si la variable $_GET['id'] existe et est nn vide 
if (isset($_GET['id']) AND !empty($_GET['id'])) {
	$id_notif = $_GET['id'];
	$id_usr = $_SESSION['user_id'];
	$sup = $db->query("DELETE FROM notification WHERE id='$id_notif'"); // on supprime la notif
	header('Location: ../notification.php');
}
// on verifie si la variable $_GET['listid'] existe et est nn vide 
elseif(isset($_GET['listid']) AND !empty($_GET['listid'])) {
	$id_usr = $_SESSION['user_id'];
	$sup = $db->query("DELETE FROM notification WHERE destinataire='$id_usr'"); // on supprime toutes les notifs
	header('Location: ../notification.php');
}


?>