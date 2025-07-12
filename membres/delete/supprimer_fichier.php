<?php 
//////////////////////////////////////////////////////////////////////////
//																		                                  //
// 	    	          Fonction supprime notif - Prive		    		          //
//																	                                  	//
//////////////////////////////////////////////////////////////////////////

// on recupe les variables 
$source = $_GET['src'];
$id = $_GET['id_balade'];
// on verifie que les chemin existe et donc que le dossier avec le fichier existe 
if (file_exists($source)) {
  unlink($source); // si oui on supprime le fichier 
  header('Location: ../modifier_balade.php?id_balade='.$id);
} else {
  echo "pas de fichier avec le nom : ".$source; // si non on affiche un message 
}
?>