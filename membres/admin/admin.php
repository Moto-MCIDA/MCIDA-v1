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
	<?php 
	include_once('../fonction/header.php');
	?>
	<div id="admin_bloc">
		<table id="tableau_choix">
			<thead>
				<tr>
					<td>Administrateur</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<a href="utilisateur_admin.php">Informations utilisateurs</a>	
					</td>
				</tr>
				<tr>
					<td>
						<a href="balade_admin.php">Information balades</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="public_admin.php">Balades pages public</a>
					</td>
				</tr>
			</tbody>
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