<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Page Index - Public						    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/

include("fonction/connexion_db.php");
include("fonction/inscription_connexion.php");
include("fonction/fonction_email.php");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MCIDA | accepter</title>
</head>
<body>
	<?php 
	// exécute la fonction pour accepter la personne
	accepter_demande($db);
	?>
</body>
</html>