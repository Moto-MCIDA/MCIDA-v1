<?php
	include("../../fonction/cookieconn.php");
	include("../../fonction/connexion_db.php");
	include("../fonction/function_index.php");
	include("../fonction/function_admin.php");
	include("../fonction/function_notification.php");

if(isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])) {
	if($_SESSION['user_id'] == 1 OR $_SESSION['user_id'] == 2 OR $_SESSION['user_id'] == 3) {

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../../image/MCIDA_icon.png">
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/index.css">
	<link rel="stylesheet" type="text/css" href="../style/admin.css">
	<link rel="stylesheet" type="text/css" href="../style/petit_ecran/admin.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>MCIDA | Administrateur</title>

</head>
<body>
	<p><a style="padding: 1% 2.5%;
			    margin: 1%;
			    background-color: black;
			    color: white;" href="admin.php">Page administrateur</a></p>
	<div id="utilisateur">
		<table>
			<thead>
				<tr>
					<td>NOM</td>
					<td>PRÉNOM</td>
					<td>NOMBRE PERSONNES</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>PRÉSENCE</td>
				</tr>
			</thead>
			<?php 
			affiche_membre_balade($db, $_GET['id']);
			?>
		</table>		
	</div>
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

	}else{
	    header("Location: index.php");
	}
}else{
    header("Location: ../../connexion.php");
}
?>