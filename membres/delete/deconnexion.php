<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction deconnexion - Prive		    	    //
//																		//
//////////////////////////////////////////////////////////////////////////

// fonction qui permet de supprimer la session active
session_start(); 
session_unset();
session_destroy();

// on inclue la page supprimecookie.php pour supprimer (si il existe) les variables cookies cree pour rester connecter
include_once("supprimecookie.php");

// redirection vers la page de connection
header('Location: http://'.$_SERVER['SERVER_NAME']. '/connexion.php');
?>