<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 						    Page Index - Public						    //
//																		//
//////////////////////////////////////////////////////////////////////////

/* Insertion fonction ***************************************************/

include("fonction/connexion_db.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="image/MCIDA_icon.png"> 
	<link rel="stylesheet" type="text/css" href="style/acceuil.css">
	<link rel="stylesheet" type="text/css" href="style/petit_ecran/acceuil.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | Motard cool ivre d'aventure</title>
	
	
    <link rel="manifest" href="manifest.json">
    <script>
        //if browser support service worker
        if('serviceWorker' in navigator) {
          navigator.serviceWorker.register('sw.js');
        };
      </script>
</head>
<body>
	<!-- Bloc photo / logo et Bloc menu -->
	<div id="img_top">
		<img id="img_top_banniere" src="image/fond.jpg">
		<img id="img_top_banniere_logo" src="image/MCIDA_logo.png">
	</div>

	<div>
		<p>MCIDA <br> Motard Cool Ivre d'Aventure</p>
		<p><a href="connexion.php">Connexion</a><br><a href="inscription.php">Inscription</a></p>
	</div>
	<!-- Bloc Membres -->
	<h1 style="padding-left: 7.5%;margin-top: 2.5%;">Membres </h1>
	<?php 

	$booleen = $db->query("SELECT count(*) FROM utilisateur WHERE public=1");
	$bool = $booleen->fetchColumn();
	$html = '<div id="membre_public">';
	$html .= '<div id="box_scroller">';
	$html .= '<div id="scroller">';
	if($bool >= 1){
		$public = $db->prepare("SELECT email, pseudo FROM utilisateur WHERE public=1 ORDER BY RAND()");
		$public->execute();
		while ($res = $public->fetch()) {
			$html .= '<div id="scrollerItems">';
			$html .= '<img src="membres/image/utilisateurs/'.$res['email'].'/'.$res['email'].'_moto.jpg">';
			$html .= '<h5>'.$res['pseudo'].'</h5>';
			$html .= '</div>';
		}
	}else{
		$html .= '<div id="scrollerItems">';
		$html .= '<h5 style="bottom: 50%;">Pas de profil public</h5>';
		$html .= '</div>';
	}
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	print($html);
	?>
	<div id="contact">
		<div>
			<img src="image/contact.jpg">	
		</div>
		<div>
			<p>MCIDA <br> Motard Cool Ivre d'Aventure</p>
			<p><a href="mailto: bureau.mcida@gmail.com">bureau.mcida@gmail.com</a></p>
			<p>Réseaux</p>
			<a href="https://www.facebook.com/groups/355412681486260/"><img src="image/logo_facebook.png"></a>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	// rechargement des 3 blocs photos toutes les 5000ms (défilement images aléatoire des balades) 
	function updateDiv_1()
	{ 	
	    $('#weekend_1').load(window.location.href + " #defilement_1" );
	}
	setInterval('updateDiv_1()', 5000);

	function updateDiv_2()
	{ 	
	    $('#weekend_2').load(window.location.href + " #defilement_2" );
	}
	setInterval('updateDiv_2()', 5000);

	function updateDiv_3()
	{ 	
	    $('#weekend_3').load(window.location.href + " #defilement_3" );
	}
	setInterval('updateDiv_3()', 5000);

</script>
