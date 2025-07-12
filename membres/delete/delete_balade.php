<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    		    Fonction supprime sortie - Prive		    	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/
include("../../fonction/cookieconn.php");
include("../../fonction/connexion_db.php");
/********************************************************************** */

$id_balade = $_GET['id_balade'];// on mets dans une varible l'id qui se trouve dans le get
// on supprime tous se qui est en rapport avec la balade 
$sup = $db->query("UPDATE balade SET active = 0 WHERE id='$id_balade'"); // dans balade
$sup->execute();

header('Location: ../balade_propose.php');

?>