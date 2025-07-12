<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page qui gere les envoie d'email 																	 						//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Fonction qui envoie un mail à l'administrateur quand quelqu'un demande de s'inscrire, avec dedans toutes les informations de l'utilisateur
// On peut le contacter par mail et/ou téléphone (si il la rentrer), puis on peut accepter ca demande d'inscription
function envoie_email_demande_inscription($db, $nom_final, $prenom_final, $pseudo, $age, $marque, $model, $cylindre, $couleur, $raison, $email, $tel, $ville, $cp){
	// Instantiation and passing `true` enables exceptions

	try {
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d");
    	$age_fin = date_diff(date_create($age), date_create($ajrd));

		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
		$mail->isSMTP();
		$mail->Host       = 'smtp.hostinger.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;

		//Recipients
		$mail->setFrom('mcida@mcida.fr', 'mcida');
		$mail->addAddress('kylian.grandy@gmail.com');               // Name is optional

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Demande d\'inscription de : '.$nom_final.' '.$prenom_final;
		$mail->Body    = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Demande d\'inscription de : '.$nom_final.' '.$prenom_final.'</h4>
								</div>

								<div id="notif_bloc">
									Demande d\'inscription de '.$nom_final.' '.$prenom_final.'<br>
									<h5>Informations Personnelles</h5>
									Nom => '.$nom_final.'<br>
									Prénom => '.$prenom_final.'<br>
									Pseudo => '.$pseudo.'<br> 
									Age => '.$age_fin->format('%y').'<br>
									Ville => '.$ville.'<br>
									Code Postale => '.$cp.'<br>
									<h5>Informations Moto</h5>
									Marque => '.$marque.'<br>
									Model => '.$model.'<br>
									Cylindre => '.$cylindre.'<br> 
									Couleur => '.$couleur.'<br>
									<h5>Raison</h5>
									'.$raison.'<br>
									<a href="mailto:'.$email.'">'.$email.'</a><br>
									<a href="tel:'.$tel.'">'.$tel.'</a><br>
									<a style="bottom: 0%;" href="http://mcida.fr/accepter.php?perso='.$email.'">Accepter</a>
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->AltBody = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Demande d\'inscription de : '.$nom_final.' '.$prenom_final.'</h4>
								</div>

								<div id="notif_bloc">
									Demande d\'inscription de '.$nom_final.' '.$prenom_final.'<br>
									<h5>Information Personnel</h5>
									Nom => '.$nom_final.'<br>
									Prénom => '.$prenom_final.'<br>
									Pseudo => '.$pseudo.'<br> 
									Age => '.$age_fin->format('%y').'<br>
									Ville => '.$ville.'<br>
									Code Postale => '.$cp.'<br>
									<h5>Information Moto</h5>
									Marque => '.$marque.'<br>
									Model => '.$model.'<br>
									Cylindre => '.$cylindre.'<br> 
									Couleur => '.$couleur.'<br>
									<h5>Raison</h5>
									'.$raison.'<br>
									<a href="mailto:'.$email.'">'.$email.'</a><br>
									<a style="bottom: 0%;" href="http://mcida.fr/accepter.php?perso='.$email.'">Accepter</a>
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

// Fonction qui envoie un mail à l'utilisateur quand ca demande a été accepté afin qu'il puisse terminer son inscription
function envoie_email_fin_inscription($db, $email){
	// Instantiation and passing `true` enables exceptions

	try {
		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
		$mail->isSMTP();
		$mail->Host       = 'smtp.hostinger.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;

		//Recipients
		$mail->setFrom('mcida@mcida.fr', 'mcida');
		$mail->addBCC($email);               // Name is optional

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Finaliser votre inscription';
		$mail->Body    = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Finaliser votre inscription</h4>
								</div>

								<div id="notif_bloc">
									Votre demande d\'inscription a été accepter<br>
									Terminer votre inscription<br>
									Cliquer sur le lien <a href="http://mcida.fr/fin_inscription.php?perso='.$email.'">ici</a> pour terminer votre compte
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->AltBody = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Fin d\'inscription</h4>
								</div>

								<div id="notif_bloc">
									Votre demande d\'inscription a été accepter<br>
									Terminer votre inscription<br>
									Cliquer sur le lien <a href="http://mcida.fr/fin_inscription.php?perso='.$email.'">ici</a> pour terminer votre compte
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

// Fonction qui envoie un mail à l'utilisateur quand il a oublier son mot de passe 
function envoyer_email_mdp_oublier($db, $email){
	// Instantiation and passing `true` enables exceptions

	try {
		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
		$mail->isSMTP();
		$mail->Host       = 'smtp.hostinger.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;

		//Recipients
		$mail->setFrom('mcida@mcida.fr', 'mcida');
		$mail->addBCC($email);               // Name is optional

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Modifier votre mot de passe';
		$mail->Body    = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Modifier votre mot de passe</h4>
								</div>

								<div id="notif_bloc">
									Modifier votre mot de passe<br>
									Cliquer sur le lien <a href="http://mcida.fr/mdpModif/mdp_modifier.php?email='.$email.'">ici</a> pour modifier votre mot de passe
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->AltBody = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div id="img_top">
									<h1>MCIDA</h1>
									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div id="bar_profil">
									<h4>Modifier votre mot de passe</h4>
								</div>

								<div id="notif_bloc">
									Modifier votre mot de passe<br>
									Cliquer sur le lien <a href="http://mcida.fr/mdpModif/mdp_modifier.php?email='.$email.'">ici</a> pour modifier votre mot de passe
								</div>
							</body>
							</html>
							<style type="text/css">
							body,html{
								margin: 0;
								width: 100%;
								height: 100%;
								font-family: "Geneva", sans-serif;
							}

							#img_top{
								margin-top: 0;
								width: 100%;
							    height: 30%;
							    background-color: white;
							    display: flex;
							    flex-direction: row;
							    justify-content: center;
							}
							#img_top_banniere_logo{
							    width: 25px;
							    margin: auto;
							    height: auto;
							    border-radius: 100%;
							    margin-left: 5%;
							}

							#img_top h1{
							    width: 100%;
							    height: 100%;
							    color: #fff;
							    display: flex;
							    flex-direction: column;
							    justify-content: center;
							    text-align: center;
							}




							#bar_profil{
								display: flex;
							    height: 75px;
							    justify-content: space-between;
							    background-color: black;
							}

							#bar_profil h4{
							    font-size: 150%;
							    font-weight: 900;
							    color: white;
							    padding: 1.5%;
							    margin: auto;
							}

							#notif_bloc{
								width: 90%;
							    margin: 2.5%;
							    background-color: black;
							    color: white;
							    padding: 2.5%;
							}

							a{
								padding: 1.5% 2.5%;
							    background-color: white;
							    color: black;
							    text-decoration: none;
							}
							a:hover{
							    background-color: black;
							    color: white;
							}
							</style>';
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

// Fonction qui envoie un mail à tout les utilisateurs (si il on pas déja une notification pour ce motif) pour les informer qu'il y à une balade qui est modifier
function mail_notification($db, $id_createur){

	$profil = recupe_profil($db, $id_createur); 

	try {
		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
		$mail->isSMTP();
		$mail->Host       = 'smtp.hostinger.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;

		//Recipients
		$mail->setFrom('mcida@mcida.fr', 'mcida');
		//requete de recuperation des email
		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
		$sqlMail->execute(array());
		$sqlMail_tab = [];
		$sqlMail_tab_fin = [];

		while ($sqlMail_F=$sqlMail->fetch()) {
			$sqlMail_tab[] = $sqlMail_F['email'];
		}
		foreach($sqlMail_tab as $key => $val) {
		  $sqlMail_tab_fin[]=$val;
		}

		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
			$mail->addBCC($sqlMail_tab_fin[$i]);
		}
		  

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Notification';
		$mail->Body    = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div style=" padding: 10px 25px; margin: 2.5% auto;	width: auto; height: 30%; background-color: #1D63EB; display: flex; flex-direction: row; justify-content: center; border-radius: 15px;">
									<h1 style=" width: 50%; height: 100%; color: #fff; display: flex; flex-direction: column; justify-content: center; text-align: center;">MCIDA</h1>
									<img style="width: 50px; margin: auto; height: auto; border-radius: 15px; margin-left: 5%;" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div style="display: flex; height: 75px; justify-content: space-between; background-color: #1D63EB;">
									<h4 style="font-size: 150%; font-weight: 900; color: white; padding: 1.5%; margin: auto;">Notification MCIDA</h4>
								</div>

								<div style="width: 90%; margin: 2.5%; background-color: #1D63EB; color: white; padding: 2.5%;">
									<h5>Vous avez une nouvelle notification !!!</h5>
									<h5>Cliquez sur le lien ci-dessous pour allez au site</h5>
									<a style="padding: 1.5% 2.5%; background-color: white; color: #1D63EB; text-decoration: none; cursor: pointer;" href="http://mcida.fr/membres/notification.php" target="_blank">Ouvrir</a>
								</div>
							</body>
							</html>';
		$mail->AltBody = '<!DOCTYPE html>
							<html>
							<head>
								<meta charset="utf-8">
							</head>
							<body>
								<div style=" padding: 10px 25px; margin: 2.5% auto;	width: auto; height: 30%; background-color: #1D63EB; display: flex; flex-direction: row; justify-content: center; border-radius: 15px;">
									<h1 style=" width: 50%; height: 100%; color: #fff; display: flex; flex-direction: column; justify-content: center; text-align: center;">MCIDA</h1>
									<img style="width: 50px; margin: auto; height: auto; border-radius: 15px; margin-left: 5%;" src="http://mcida.fr/image/MCIDA_logo.png">
								</div>

								<div style="display: flex; height: 75px; justify-content: space-between; background-color: #1D63EB;">
									<h4 style="font-size: 150%; font-weight: 900; color: white; padding: 1.5%; margin: auto;">Notification MCIDA</h4>
								</div>

								<div style="width: 90%; margin: 2.5%; background-color: #1D63EB; color: white; padding: 2.5%;">
									<h5>Vous avez une nouvelle notification !!!</h5>
									<h5>Cliquez sur le lien ci-dessous pour allez au site</h5>
									<a style="padding: 1.5% 2.5%; background-color: white; color: #1D63EB; text-decoration: none; cursor: pointer;" href="http://mcida.fr/membres/notification.php" target="_blank">Ouvrir</a>
								</div>
							</body>
							</html>';
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

// // Fonction qui envoie un mail à tout les utilisateurs (si il on pas déja une notification pour ce motif) pour les informer qu'il y à une nouvelle balade
// function mail_notification_creer_balade($db, $id_createur, $id_balade){

// 	$profil = recupe_profil($db, $id_createur); 
// 	$balade = recupe_balade($db, $id_balade);

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		//requete de recuperation des email
// 		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
// 		$sqlMail->execute(array());
// 		$sqlMail_tab = [];
// 		$sqlMail_tab_fin = [];

// 		while ($sqlMail_F=$sqlMail->fetch()) {
// 			$sqlMail_tab[] = $sqlMail_F['email'];
// 		}
// 		foreach($sqlMail_tab as $key => $val) {
// 		  $sqlMail_tab_fin[]=$val;
// 		}

// 		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
// 			$mail->addBCC($sqlMail_tab_fin[$i]);
// 		}
		  

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouvelle balade '.$balade['nom'].' proposer par '.$profil['nom'].' '.$profil['prenom'].' à été créé</h5>
// 									<a href="http://mcida.fr/membres/index.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<img id="img_top_banniere" src="http://mcida.fr/image/fond.jpg">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouvelle balade '.$balade['nom'].' proposer par '.$profil['nom'].' '.$profil['prenom'].' à été créé</h5>
// 									<a href="http://mcida.fr/membres/index.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }

// // Fonction qui envoie un mail au destinataire du message (si il on pas déja une notification pour ce motif) 
// function mail_notification_message_perso($db, $id_createur, $id_destinataire){

// 	$profil = recupe_profil($db, $id_createur); 
// 	$profil_des = recupe_profil($db, $id_destinataire); 

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		$mail->addBCC($profil_des['email']);

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message de '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_membre_profil.php?id='.$id_createur.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message de '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_membre_profil.php?id='.$id_destinataire.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }

// // Fonction qui envoie un mail à tout les utilisateurs (si il on pas déja une notification pour ce motif) pour les informer qu'il y à un message dans une balades 
// function mail_notification_message_groupe($db, $id_createur, $id_balade){

// 	$profil = recupe_profil($db, $id_createur); 
// 	$balade = recupe_balade($db, $id_balade);

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		//requete de recuperation des email
// 		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
// 		$sqlMail->execute(array());
// 		$sqlMail_tab = [];
// 		$sqlMail_tab_fin = [];

// 		while ($sqlMail_F=$sqlMail->fetch()) {
// 			$sqlMail_tab[] = $sqlMail_F['email'];
// 		}
// 		foreach($sqlMail_tab as $key => $val) {
// 		  $sqlMail_tab_fin[]=$val;
// 		}

// 		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
// 			$mail->addBCC($sqlMail_tab_fin[$i]);
// 		}

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<img id="img_top_banniere" src="http://mcida.fr/image/fond.jpg">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }
// function mail_notification_message_tous($db, $id_createur){

// 	$profil = recupe_profil($db, $id_createur); 

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		//requete de recuperation des email
// 		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
// 		$sqlMail->execute(array());
// 		$sqlMail_tab = [];
// 		$sqlMail_tab_fin = [];

// 		while ($sqlMail_F=$sqlMail->fetch()) {
// 			$sqlMail_tab[] = $sqlMail_F['email'];
// 		}
// 		foreach($sqlMail_tab as $key => $val) {
// 		  $sqlMail_tab_fin[]=$val;
// 		}

// 		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
// 			$mail->addBCC($sqlMail_tab_fin[$i]);
// 		}

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans le groupe commun par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_tous.php" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<img id="img_top_banniere" src="http://mcida.fr/image/fond.jpg">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans le groupe commun par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_tous.php" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }
// // Fonction qui envoie un mail à tout les utilisateurs (si il on pas déja une notification pour ce motif) pour les informer qu'il y à un message dans une balades déja passé
// function mail_notification_message_groupe_ancien($db, $id_createur, $id_balade){

// 	$profil = recupe_profil($db, $id_createur); 
// 	$balade = recupe_balade($db, $id_balade);

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		//requete de recuperation des email
// 		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
// 		$sqlMail->execute(array());
// 		$sqlMail_tab = [];
// 		$sqlMail_tab_fin = [];

// 		while ($sqlMail_F=$sqlMail->fetch()) {
// 			$sqlMail_tab[] = $sqlMail_F['email'];
// 		}
// 		foreach($sqlMail_tab as $key => $val) {
// 		  $sqlMail_tab_fin[]=$val;
// 		}

// 		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
// 			$mail->addBCC($sqlMail_tab_fin[$i]);
// 		}

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<img id="img_top_banniere" src="http://mcida.fr/image/fond.jpg">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }

// // Fonction qui envoie un mail à tout les utilisateurs (si il on pas déja une notification pour ce motif) pour les informer qu'il y à un message dans une balades déja passé
// function mail_notification_acpt_balade($db, $id_createur, $id_balade){

// 	$profil = recupe_profil($db, $id_createur); 
// 	$balade = recupe_balade($db, $id_balade);

// 	try {
// 		$mail = new PHPMailer();
// 		//Server settings
// 		$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // or SMTP::DEBUG_OFF in production
// 		$mail->isSMTP();
// 		$mail->Host       = 'smtp.hostinger.com';
// 		$mail->SMTPAuth   = true;
// 		$mail->Username   = 'mcida@mcida.fr';               // SMTP username
// 		$mail->Password   = '29062003$Kykygrd';                     // SMTP password
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Port       = 465;

// 		//Recipients
// 		$mail->setFrom('mcida@mcida.fr', 'mcida');
// 		//requete de recuperation des email
// 		$sqlMail = $db->prepare("SELECT email FROM utilisateur WHERE id != '$id_createur' AND accepter=1 AND finInscription=1 AND acpt_mail=1");
// 		$sqlMail->execute(array());
// 		$sqlMail_tab = [];
// 		$sqlMail_tab_fin = [];

// 		while ($sqlMail_F=$sqlMail->fetch()) {
// 			$sqlMail_tab[] = $sqlMail_F['email'];
// 		}
// 		foreach($sqlMail_tab as $key => $val) {
// 		  $sqlMail_tab_fin[]=$val;
// 		}

// 		for ($i = 0; $i < count($sqlMail_tab_fin); $i++) {
// 			$mail->addBCC($sqlMail_tab_fin[$i]);
// 		}

// 		// Content
// 		$mail->isHTML(true);                                  // Set email format to HTML
// 		$mail->Subject = 'Notification';
// 		$mail->Body    = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>'.$profil['nom'].' '.$profil['prenom'].' a répondu si il était présent dans '.$balade['nom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->AltBody = '<!DOCTYPE html>
// 							<html>
// 							<head>
// 								<meta charset="utf-8">
// 							</head>
// 							<body>
// 								<div id="img_top">
// 									<img id="img_top_banniere" src="http://mcida.fr/image/fond.jpg">
// 									<h1>MCIDA</h1>
// 									<img id="img_top_banniere_logo" src="http://mcida.fr/image/MCIDA_logo.png">
// 								</div>

// 								<div id="bar_profil">
// 									<h4>Notification</h4>
// 								</div>

// 								<div id="notif_bloc">
// 									<h5>Vous avez une nouvelle notification</h5>
// 									<h5>'.$profil['nom'].' '.$profil['prenom'].' a répondu si il était présent dans '.$balade['nom'].'</h5>
// 									<a href="http://mcida.fr/membres/message/message_groupe_balade.php?id='.$id_balade.'" target="_blank">Ouvrir</a>
// 								</div>
// 							</body>
// 							</html>
// 							<style type="text/css">
// 							body,html{
// 								margin: 0;
// 								width: 100%;
// 								height: 100%;
// 								font-family: "Geneva", sans-serif;
// 							}

// 							#img_top{
// 								margin-top: 0;
// 								width: 100%;
// 							    height: 30%;
// 							    background-color: white;
// 							    display: flex;
// 							    flex-direction: row;
// 							    justify-content: center;
// 							}
// 							#img_top_banniere_logo{
// 							    width: 25px;
// 							    margin: auto;
// 							    height: auto;
// 							    border-radius: 100%;
// 							    margin-left: 5%;
// 							}

// 							#img_top h1{
// 							    width: 100%;
// 							    height: 100%;
// 							    color: #fff;
// 							    display: flex;
// 							    flex-direction: column;
// 							    justify-content: center;
// 							    text-align: center;
// 							}




// 							#bar_profil{
// 								display: flex;
// 							    height: 75px;
// 							    justify-content: space-between;
// 							    background-color: black;
// 							}

// 							#bar_profil h4{
// 							    font-size: 150%;
// 							    font-weight: 900;
// 							    color: white;
// 							    padding: 1.5%;
// 							    margin: auto;
// 							}

// 							#notif_bloc{
// 								width: 90%;
// 							    margin: 2.5%;
// 							    background-color: black;
// 							    color: white;
// 							    padding: 2.5%;
// 							}

// 							a{
// 								padding: 1.5% 2.5%;
// 							    background-color: white;
// 							    color: black;
// 							    text-decoration: none;
// 							}
// 							a:hover{
// 							    background-color: black;
// 							    color: white;
// 							}
// 							</style>';
// 		$mail->send();
// 		echo 'Message has been sent';
// 	} catch (Exception $e) {
// 		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 	}
// }
?>