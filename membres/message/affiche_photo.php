<?php
//////////////////////////////////////////////////////////////////////////////////////
//																					//
//										 PHP 										//
//                                                                                  // 
//////////////////////////////////////////////////////////////////////////////////////

// Include les différentes pages PHP (fonction)
include("../../fonction/cookieconn.php");
include("../../fonction/connexion_db.php");
include("../fonction/function_notification.php");
include("../../fonction/fonction_email.php");


// Vérification qu'on a bien une session, qu'on est bien connecter sinon redirection page 'connexion.php'
if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	
$user_id = $_SESSION['user_id'];
?>
<!-- ---------------------------------------------------------------------------------- -->
<!--										 	 										-->
<!--										 HTML 										-->
<!--										 	 										-->
<!-- ---------------------------------------------------------------------------------- -->   

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/index.css">
	<link rel="stylesheet" type="text/css" href="../style/message_groupe.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/message_groupe.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | <?php echo $_SESSION['user_nom'].' '.$_SESSION['user_prenom']; ?></title>
</head>
<body>
	<?php 
	include_once('../fonction/header.php');
	?>
<!-- -------------------------------- Affichage des messages -------------------------------- -->
<?php 
if ($_GET['idg']=='tous') {
?>
	<a href="message_tous.php" id="boutton" class="retour">Retour</a>
<?php 
}else{
?>
	<a href="message_groupe_balade.php?id=<?php echo $_GET['idg']; ?>" id="boutton" class="retour">Retour</a>
<?php 	
}
?>
		<?php
		
	    	if ($_GET['nbp'] != 0) {
	    		$image_html = '<div id="image_bloc">';
	    		for ($i = 0; $i < $_GET['nbp']; $i++) {
	    			if (file_exists('../document/photo_balade/'.$_GET['idg'].'/'.$_GET['msgdh'].'_'.$_GET['msgiu'].'_'.$i.'.jpg')) {
	    				$image_html .= '<a href="../document/photo_balade/'.$_GET['idg'].'/'.$_GET['msgdh'].'_'.$_GET['msgiu'].'_'.$i.'.jpg"><img src="../document/photo_balade/'.$_GET['idg'].'/'.$_GET['msgdh'].'_'.$_GET['msgiu'].'_'.$i.'.jpg"></a>';
	    			}else{
						$image_html .= '';
					}
	    		}
	    		$image_html .= '</div>';
	    	}else{
	    		$image_html = '';
	    	}

    	print($image_html);
        ?>
</body>
</html>	

<script type="text/javascript">

	function updateDiv()
	{ 	
	    $('#notif_img ').load(window.location.href + " #notif_img > a " );
	}
	setInterval('updateDiv()', 5000);


</script>

<?php
if(isset($_POST['envoyerMsg'])){
	message($db);
}
}
?>
