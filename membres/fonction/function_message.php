<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction message - Prive		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction pour les balade		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////
/******************************************************************************************************************************************** */
// fonction blocInfoBalade 
// cette fonction va permettre dafficher bloc avec des information sur la balade 
// il y a un bloc photo avec la photo de profil du créateur, ou les photos de la sortie qui defile aléatoirement (si il en a)
/********************************************************************************************************************************************* */
function blocInfoBalade($id_groupe, $db){
    // on recupere les infos de la sortie 
    $sql = "SELECT * FROM balade WHERE id = $id_groupe";
    $select = $db->query($sql);
    $res = $select->fetch();
    // on recupere les infos du créateur
    $id_utilisateur = $res['id_createur'];
    $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
    $profil = $db->query($sql_profil);
    $res_profil = $profil->fetch();
    // on cree une varible html avec du html et les différentes variable
    $html = '<p>'.$res['nom'].'</p>';
    $html .= '<p>Date : '.$res['date_sortie'].'</p>';
    $html .= '<p>'.$res['description'].'</p>';
    // partie bloc photo
    $html .= '<div id="image_bloc_info">';
		$html .= '<div id="img_ab_info">';
    	//On indique le dossier images
		$chem_img = '../document/photo_balade/'.$id_groupe;
		if (is_dir($chem_img)) {
			//On ouvre le dossier images
			$handle  = opendir($chem_img);

			//On parcoure chaque élément du dossier
			while ($file = readdir($handle))
			{
			  //Si les fichiers sont des images
			  if(preg_match ("!(\.jpg|\.jpeg)$!i", $file))
			    {
			      $listef[] = $file;
			    }
			}
			//permet de prendre une image totalement au hasard (RANDom) parmi toutes les images trouvées.
			$html .= "<img id=\"photo_reload\" src=\"".$chem_img."/".$listef[rand(0, count($listef)-1)]."\"/>";
		}else{
			// si le dossier image existe pas on mets la photo de profil du créateur 
			$html .= '<img src="../image/utilisateurs/'.$res_profil['email'].'/'.$res_profil['email'].'_profil.jpg">';
		}
		
		$html .= '</div>';
		$html .= '</div>';
    echo $html;
}

function affiche_membre_balade($db, $id){
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_balade = '$id'");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$balade = $db->prepare("SELECT * FROM balade_membre WHERE id_balade = '$id' ORDER BY reponse ASC");
			$balade->execute();
	    	$html = '<h5>Tableau des présences</h5>';
			$html .= '<table style="
			width: 100%;
			font-size: small;
			font-weight: 400;
			padding: 10px 2.5%;
			margin: auto;">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<td style="
			background-color: #1D63EB;
			text-align: center;
			font-size: small;
			color: white;
			border-radius: 15px 15px 0 0;
			width:20%">NOM</td>';
			$html .= '<td style="
			background-color: #1D63EB;
			text-align: center;
			font-size: small;
			color: white;
			border-radius: 15px 15px 0 0;
			width:20%">PRÉNOM</td>';
			$html .= '<td style="
			background-color: #1D63EB;
			text-align: center;
			font-size: small;
			color: white;
			border-radius: 15px 15px 0 0;
			width:20%">NOMBRE PERSONNES</td>';
			$html .= '<td style="
			background-color: #1D63EB;
			text-align: center;
			font-size: small;
			color: white;
			border-radius: 15px 15px 0 0;
			width:20%">PRÉSENCE</td>';
			$html .= '</tr>';
			$html .= '</thead>';
			while ($res = $balade->fetch()) {
				$id_utilisateur = $res['id_utilisateur'];
				$profil = $db->query("SELECT * FROM utilisateur WHERE id = '$id_utilisateur'");
	    		$res_profil = $profil->fetch();
	    		$description = $db->query("SELECT * FROM balade_membre WHERE id_utilisateur = '$id_utilisateur' AND id_balade = '$id'");
	    		$res_description = $description->fetch();
	    		if ($res_description['reponse'] == 1) {
	    			$html .= '<tr class="like" style="box-shadow: none;">';
	    			$rep = 'Présent';
	    		}elseif ($res_description['reponse'] == 2){
	    			$html .= '<tr class="jsp" style="box-shadow: none;">';
	    			$rep = 'Ne sais pas';
	    		}else{
	    			$html .= '<tr class="dislike" style="box-shadow: none;">';
	    			$rep = 'Pas présent';
	    		}
                if ($res_profil) {
                    $html .= '<td style="
                    color: white;">'.$res_profil['nom'].'</td>';
                    $html .= '<td style="
                    color: white;">'.$res_profil['prenom'].'</td>';
                    $html .= '<td style="
                    color: white;">'.$res_description['nb_prs'].'</td>';
                    $html .= '<td style="
                    color: white;">'.$rep.'</td>';
                    $html .= '</tr>';
                } else {
                    $html .= '<td style="
                    color: white;">Ancien memebre</td>';
                    $html .= '<td style="
                    color: white;">Ancien memebre</td>';
                    $html .= '<td style="
                    color: white;">...</td>';
                    $html .= '<td style="
                    color: white;">...</td>';
                    $html .= '</tr>';
                }
			    
			}
			$html .= '</table>';
			print($html) ;
		}
	}
/******************************************************************************************************************************************** */
// fonction recup_nom_balade avec comme parametre a variable de connexion a la db et l'id de la balade 
// sert a recuperer le nom et la date de sortie de la sortie 
/******************************************************************************************************************************************** */
function recup_nom_balade($id_groupe, $db){
    $sql = "SELECT nom, date_sortie FROM balade WHERE id = $id_groupe";
    $select = $db->query($sql);
    $res = $select->fetch();
    return $res;
}
/******************************************************************************************************************************************** */
// fonction affiche_nom_balade avec comme parametre un tableau (avec dedans le nom et la date de la balade)
// sert a afficher dans une div les info de la sortie
/******************************************************************************************************************************************** */
function affiche_nom_balade($np_groupe){
    $nom = $np_groupe['nom'];
    $date = $np_groupe['date_sortie'];
    $html = "<div id='nom_bar'><h1 id = 'nom'> $nom du $date</h1></div>";
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction recup_message_balade avec comme parametre a variable de connexion a la db et l'id de la balade 
// sert recuperer les messages de la balade
/******************************************************************************************************************************************** */
function recup_message_balade($id_groupe, $db){
    $sql = "SELECT * FROM `message_groupe` WHERE id_balade = $id_groupe ORDER BY id ASC";
    $select = $db->query($sql);
    return $select;
}
/******************************************************************************************************************************************** */
// fonction affiche_message_balade avec comme parametre un tableau avec les infos des messages, l'id de la balade, et avec la variable de connection a la db
// dans cette fonction on va afficher sous forme de liste les messages
// on mets l'id droit pour les li qui correspond au message de l'utilisateur, sinon on mets l'id gauche
// on afficher un bloc avec si les photos si envoyer photo
/******************************************************************************************************************************************** */
function affiche_message_balade($messages, $id_groupe, $db){
    $id_usr = $_SESSION['user_id'];
    $dst = recup_nom_balade($id_groupe, $db);
    $html = "<ul id='ul'>";
    // on fait une boucle for pour chaque message 
    foreach($messages as $key => $message){
        // on recupere le mois et le jour
        $date_mess_mois = substr($message['date_heure'], 0, 2);
        $date_mess_jour = substr($message['date_heure'], 3, 2);
        if ($message['nb_photo'] != 0) { // on regarde si le message contient une ou des photos
            $image_html = '';
            if (is_dir('../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'])) { // on verifie que le dossier pour les documents existe 
                // si oui on fais une boucle for pour afficher tout les documents
                $scandir = scandir('../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur']);
                $x = 1;
                foreach($scandir as $fichier){
                    if($x != 1 AND $x !=2){ // on enleve les 2  premier documents (qui sont des dossier masquer)
                        $image_html .= '<p style="width: 225px;"><a id="document" href="../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'].'/'.$fichier.'">'.$fichier.'</a></p>';
                    }
                    $x++;
                }
                $nb_photo_fin = $message['nb_photo']-$x+3; // on compte le nombre de photos et on mets dans variables
                if (file_exists('../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg')) { // on verifie si il existe au moin une photo
                    $image_html .= '<div id="image_bloc_msg">';
                    // on ajoute dans variable image_html la premiere photo et un paragraphe avec le nombre de photo
                    // cest un lien qui permet d'acceder a une autre page pour voir toutes les photos du message
                    $image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><img src="../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg"></a>';
                    $image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><p>Nombre de photo : '.$nb_photo_fin.'</p></a>';
                    $image_html .= '</div>';
                }
            }else{
                // on ajoute dans variable image_html la premiere photo et un paragraphe avec le nombre de photo
                // cest un lien qui permet d'acceder a une autre page pour voir toutes les photos du message
                $image_html .= '<div id="image_bloc_msg">';
                $image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><img src="../document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg"></a>';
                $image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><p>Nombre de photo : '.$message['nb_photo'].'</p></a>';
                $image_html .= '</div>';
            }
        }else{
            // sinon on mets rien dans la variable 
            $image_html = '';
        }
        // on regarde de qui vien le message 
        // si il vien de l'utilisateur on ajoute un li avec comme id droite
        if($message["id_utilisateur"] == $id_usr){
            $html .= "<li id = 'droite'> <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$_SESSION['user_email']."/".$_SESSION['user_email']."_profil.jpg\"> <strong>Moi le $date_mess_jour / $date_mess_mois :</strong> <p>$message[message] <br> $image_html </p></li>";
        }
        // sinon il vien d'un membre on ajoute un li avec comme id gauche
        else{
            $id_utilisateur = $message["id_utilisateur"];
            $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
            $profil = $db->query($sql_profil);
            $res_profil = $profil->fetch();
            $html .= "<li id = 'gauche'> <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$res_profil['email']."/".$res_profil['email']."_profil.jpg\"><strong>$res_profil[nom] $res_profil[prenom] le $date_mess_jour / $date_mess_mois :</strong><p> $message[message] <br> $image_html </p></li>";
        }
    }
    $html .= "</ul>";
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction envoye_message_balade avec comme parametre la variable de connection a la db
// dans cette fonction on va ajouter dans la table_message groupe les nouveau message
/******************************************************************************************************************************************** */
function envoye_message_balade($db){
    // on cree les variables
    $message = addslashes($_POST['texte']);
    //prend en compte plusieur espace a la suite d'un textarea
    $text2 = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
    $id_usr = $_SESSION['user_id'];
    $id_groupe = $_GET['id'];
    $photo = $_FILES["photo"]["name"][0];
    date_default_timezone_set('Europe/Paris');
    $DateAndTime = date('m-d-Y H:i:s', time()); 
    if(isset($message) AND !empty($photo)){
        $myFile = $_FILES['photo'];
        $fileCount = count($myFile["name"]);
        $sql = "INSERT INTO `message_groupe`(`id_balade`, `id_utilisateur`, `message`,`date_heure`, `nb_photo`) VALUES ('$id_groupe', '$id_usr', '$text2', '$DateAndTime', '$fileCount')";
        $insert = $db->query($sql);
        inserer_photo($db, $id_groupe, $DateAndTime, $id_usr, $fileCount, $myFile); // on execute le programe pour inserer les photos au bonne endroit
        creer_notification_message_groupe_ancien($db, $id_usr, $id_groupe); // on cree une notif 
        header('Location: message_groupe_balade.php?id='.$id_groupe);
    }elseif(isset($message) AND !empty($message) AND empty($photo)){
        $sql = "INSERT INTO `message_groupe`(`id_balade`, `id_utilisateur`, `message`,`date_heure`, `nb_photo`) VALUES ('$id_groupe', '$id_usr', '$text2', '$DateAndTime', 0)";
        $insert = $db->query($sql);
        creer_notification_message_groupe_ancien($db, $id_usr, $id_groupe); // on cree une notif
        header('Location: message_groupe_balade.php?id='.$id_groupe);
    }
}
/******************************************************************************************************************************************** */
// fonction inserer_photo 
// on va cree le dossier avec tous le droit si il n'existe pas deja 
// et on fais une boucle for pour soccuper afin d'executer la fonction inserer_photo_un (pour inserer les photos au bonne endroit une par une)
/******************************************************************************************************************************************** */
function inserer_photo($db, $id_groupe, $DateAndTime, $id_usr, $fileCount, $myFile){
    $chemain = '../document/photo_balade/'.$id_groupe;
    if (!is_dir($chemain)) {
        mkdir($chemain, 0777, true);
    }
    for ($i = 0; $i < $fileCount; $i++) {
        inserer_photo_un($db, $myFile["tmp_name"][$i], $myFile["name"][$i], $id_groupe, $DateAndTime, $id_usr, $i);
    }
    //header('Location: message_groupe_balade.php?id='.$id_groupe);
} 
/******************************************************************************************************************************************** */
// fonction inserer_photo_un 
// regarder l'extension (il faut une extension en '.jpg', '.JPG', '.png', '.PNG', '.jpeg', '.JPEG')
// on envoie le fichier vers le bon dossier 
/******************************************************************************************************************************************** */
function inserer_photo_un($db, $photo, $photo_name, $id_groupe, $DateAndTime, $id_usr, $i){
    $file_extension = strrchr($photo_name, ".");  // on regarde l'extension
    $name_fin = $DateAndTime.'_'.$id_usr.'_'.$i.'.jpg'; // on le renomme 
    $file_dest = '../document/photo_balade/'.$id_groupe."/".$name_fin;
    //'files/' .$file_name;
    $extension_autorisees = array('.jpg', '.JPG', '.png', '.PNG', '.jpeg', '.JPEG');

    if(in_array($file_extension, $extension_autorisees)){ // on verifie que l'extension est bonne 
        if(move_uploaded_file($photo, $file_dest)){ // on envoie la photo  
           echo 'Fichier envoyé avec succès';
        } else {
            echo "Une erreur est survenue lors de l'envoie du fichier";
        }
    }else{
        inserer_doc_un($db, $photo, $photo_name, $id_groupe, $DateAndTime, $id_usr, $i); // si l'extension correspond pas on appele la fonction inserer_doc_un
    }
} 
/******************************************************************************************************************************************** */
// fonction inserer_doc_un
// regarder l'extension (il faut une extension en .pdf)
// on envoie le fichier vers le bon dossier 
/******************************************************************************************************************************************** */
function inserer_doc_un($db, $photo, $photo_name, $id_groupe, $DateAndTime, $id_usr, $i){
     $chemain = '../document/photo_balade/'.$id_groupe.'/'.$DateAndTime.'_'.$id_usr;
    if (!is_dir($chemain)) { // on regarde si un dossier pour les document existe deja ou pas (normalement pas)
        mkdir($chemain, 0777, true); // on le cree avec tt les droit
    }
    $file_extension = strrchr($photo_name, ".");  // on regarde l'extension
    $file_dest = $chemain."/".$photo_name;
    $extension_autorisees = array('.pdf', '.PDF');
 
    if(in_array($file_extension, $extension_autorisees)){ // on verifie que l'extension est bonne 
        if(move_uploaded_file($photo, $file_dest)){ // on envoie la photo 
           echo 'Fichier envoyé avec succès';
        } else {
            echo "Une erreur est survenue lors de l'envoie du fichier";
        }
    } else {
        echo "Seul les photos en .jpg, .png et .jpeg sont autorisées et les documenten .pdf";
    }
}

//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction pour les profils		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////
/******************************************************************************************************************************************** */
// fonction blocInfoProfil 
// cette fonction va permettre dafficher bloc avec des information sur le profil a qui on envoie le message 
// il y a un bloc photo avec la photo de profil du créateur
/********************************************************************************************************************************************* */
function blocInfoProfil($id_utilisateur, $db){
    // on recupere des informations sur le profil
    $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
    $profil = $db->query($sql_profil);
    $res_profil = $profil->fetch();
    // on cree une varible html avec du html et les différentes variable
    $html = '<p>'.$res_profil['nom'].' '.$res_profil['prenom'].'</p>';
    $html .= '<p>Pseudo : '.$res_profil['pseudo'].'</p>';
    // partie bloc photo
    $html .= '<div id="image_bloc_info">';
		$html .= '<div id="img_ab_info">';
    	$html .= '<img src="../image/utilisateurs/'.$res_profil['email'].'/'.$res_profil['email'].'_profil.jpg">';
		
		$html .= '</div>';
		$html .= '</div>';
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction recup_nom_prenom_profil avec comme parametre a variable de connexion a la db et l'id du profil 
// sert a recuperer le nom, email et prenom du profil
/******************************************************************************************************************************************** */
function recup_nom_prenom_profil($id, $db){
    $sql = "SELECT nom, prenom, email FROM utilisateur WHERE id = $id";
    $select = $db->query($sql);
    $res = $select->fetch();
    return $res;
}
/******************************************************************************************************************************************** */
// fonction affiche_nom_prenom_profil avec comme parametre un tableau (avec dedans le nom, prenom, et email)
// sert a afficher dans une div les info du profil
/******************************************************************************************************************************************** */
function affiche_nom_prenom_profil($np_profil){
    $nom = $np_profil['nom'];
    $prenom = $np_profil['prenom'];
    $email = $np_profil['email'];
    $html = "<div id='nom_bar'><h1 id = 'nom'> $nom $prenom</h1><div><img src=\"../image/utilisateurs/".$email."/".$email."_profil.jpg\"></div></div>";
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction recup_message_profil avec comme parametre a variable de connexion a la db et l'id du profil 
// sert recuperer les messages entre l'utilisateur et le profil
/******************************************************************************************************************************************** */
function recup_message_profil($id, $db){
    $user_id = $_SESSION['user_id'];
    // on regarde quand l'utilisateur est exediteur et aussi quand il est receveur (donc OR)
    $sql = "SELECT * FROM `message`  WHERE (expediteur = $user_id AND destinataire = $id) OR (expediteur = $id AND destinataire = $user_id) ORDER BY id ASC"; 
    $select = $db->query($sql);
    return $select;
}
/******************************************************************************************************************************************** */
// fonction affiche_message_profil avec comme parametre un tableau avec les infos des messages, l'id du profil, et avec la variable de connection a la db
// dans cette fonction on va afficher sous forme de liste les messages
// on mets l'id droit pour les li qui correspond au message de l'utilisateur, sinon on mets l'id gauche
/******************************************************************************************************************************************** */
function affiche_message_profil($messages, $id, $db){
    $id_usr = $_SESSION['user_id'];
    $dst = recup_nom_prenom_profil($id, $db);
    $np_dst = $dst['prenom'];
    $np_dst .= " ";
    $np_dst .= $dst['nom'];
    $html = "<ul id='ul'>";
    // on fait une boucle for pour chaque message 
    foreach($messages as $key => $message){
        // on recupere le mois et le jour
        $date_mess_mois = substr($message['date_heure'], 0, 2);
        $date_mess_jour = substr($message['date_heure'], 3, 2);

        // on regarde de qui vien le message 
        // si il vien de l'utilisateur on ajoute un li avec comme id droite
        if($message["expediteur"] == $id_usr){
            $html .= "<li id = 'droite'> <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$_SESSION['user_email']."/".$_SESSION['user_email']."_profil.jpg\"> <strong>Moi le $date_mess_jour / $date_mess_mois :</strong> <p>$message[message]  </p></li>";
        }
        // sinon il vien d'un membre on ajoute un li avec comme id gauche
        else{
            $id_utilisateur = $message["expediteur"];
            $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
            $profil = $db->query($sql_profil);
            $res_profil = $profil->fetch();
            $html .= "<li id = 'gauche'>  <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$res_profil['email']."/".$res_profil['email']."_profil.jpg\"><strong>$res_profil[nom] $res_profil[prenom] le $date_mess_jour / $date_mess_mois :</strong><p> $message[message] </p></li>";
        }
    }
    $html .= "</ul>";
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction envoye_message avec comme parametre la variable de connection a la db
// dans cette fonction on va ajouter dans la table message les nouveau message
/******************************************************************************************************************************************** */
function envoye_message($db){
    // creation de variable
    $message = addslashes($_POST['texte']);
    //prend en compte plusieur espace a la suite d'un textarea
    $text2 = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));

    $id_usr = $_SESSION['user_id'];
    $id_profil = $_GET['id'];
    date_default_timezone_set('Europe/Paris');
    $DateAndTime = date('m-d-Y H:i:s', time());
    // on verifie que la variable message existe et est non nul 
    if(isset($message) AND !empty($message)){
        $sql = "INSERT INTO `message`(`destinataire`, `expediteur`, `message`, `date_heure`) VALUES ('$id_profil', '$id_usr', '$text2', '$DateAndTime')";
        $insert = $db->query($sql);
        creer_notification_message_perso($db, $id_usr, $id_profil); // creation de notification 
        header("Location: message_membre_profil.php?id=$id_profil");
    }
}

//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction pour groupe commun		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////
/******************************************************************************************************************************************** */
// fonction blocInfoTous 
// cette fonction va permettre dafficher bloc avec des information 
// il y a un bloc photo avec la photo de profil du créateur, ou les photos de la sortie qui defile aléatoirement (si il en a)
/********************************************************************************************************************************************* */
function blocInfoTous(){
    // on cree une varible html avec du html et les différentes variable
    $html = '<p>Groupe Commun</p>';
    $html .= '<p>MCIDA</p>';
    // partie bloc photo
    $html .= '<div id="image_bloc_info">';
		$html .= '<div id="img_ab_info">';
    	//On indique le dossier images
		// $chem_img = '../document/photo_balade/tous';
		// if (is_dir($chem_img)) {
		// 	//On ouvre le dossier images
		// 	$handle  = opendir($chem_img);
		// 	//On parcoure chaque élément du dossier
		// 	while ($file = readdir($handle))
		// 	{
		// 	  //Si les fichiers sont des images
		// 	  if(preg_match ("!(\.jpg|\.jpeg)$!i", $file))
		// 	    {
		// 	      $listef[] = $file;
		// 	    }
		// 	}
			//permet de prendre une image totalement au hasard (RANDom) parmi toutes les images trouvées.
			$html .= "<img id=\"photo_reload\" src=\"http://".$_SERVER['SERVER_NAME']."/image/MCIDA_icon.png\"/>";
		// }
		
		$html .= '</div>';
		$html .= '</div>';
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction recup_message_tous avec comme parametre a variable de connexion a la db
// sert recuperer les messages dans la table message_tous
/******************************************************************************************************************************************** */
function recup_message_tous($db){
    $sql = "SELECT * FROM `message_tous` ORDER BY id ASC";
    $select = $db->query($sql);
    return $select;
}
/******************************************************************************************************************************************** */
// fonction affiche_message_tous avec comme parametre un tableau avec les infos des messages et avec la variable de connection a la db
// dans cette fonction on va afficher sous forme de liste les messages
// on mets l'id droit pour les li qui correspond au message de l'utilisateur, sinon on mets l'id gauche
// on afficher un bloc avec si les photos si envoyer photo
/******************************************************************************************************************************************** */
function affiche_message_tous($messages, $db){
    $id_usr = $_SESSION['user_id'];
    $html = "<ul id='ul'>";
    // on fait une boucle for pour chaque message 
    foreach($messages as $key => $message){
        // on recupere le mois et le jour
        $date_mess_mois = substr($message['date_heure'], 0, 2);
        $date_mess_jour = substr($message['date_heure'], 3, 2);
        if ($message['nb_photo'] != 0) {// on regarde si le message contient une ou des photos
            $image_html = '';
            if (is_dir('../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur'])) {// on verifie que le dossier pour les documents existe 
                // si oui on fais une boucle for pour afficher tout les documents
                $scandir = scandir('../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur']);
                $x = 1;
                foreach($scandir as $fichier){
                    if($x != 1 AND $x !=2){// on enleve les 2  premier documents (qui sont des dossier masquer)
                        $image_html .= '<p style="width: 225px;"><a id="document" href="../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur'].'/'.$fichier.'">'.$fichier.'</a></p>';
                    }
                    $x++;
                }
                $nb_photo_fin = $message['nb_photo']-$x+3; // on compte le nombre de photos et on mets dans variables
                if (file_exists('../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg')) {
                    $image_html .= '<div id="image_bloc_msg">';
                    // on ajoute dans variable image_html la premiere photo et un paragraphe avec le nombre de photo
                    // cest un lien qui permet d'acceder a une autre page pour voir toutes les photos du message
                    $image_html .= '<a href="affiche_photo.php?idg=tous&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><img src="../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg"></a>';
                    $image_html .= '<a href="affiche_photo.php?idg=tous&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><p>Nombre de photo : '.$nb_photo_fin.'</p></a>';
                    $image_html .= '</div>';
                }
            }else{
                $image_html .= '<div id="image_bloc_msg">';
                // on ajoute dans variable image_html la premiere photo et un paragraphe avec le nombre de photo
                // cest un lien qui permet d'acceder a une autre page pour voir toutes les photos du message
                $image_html .= '<a href="affiche_photo.php?idg=tous&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><img src="../document/photo_balade/tous/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg"></a>';
                $image_html .= '<a href="affiche_photo.php?idg=tous&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><p>Nombre de photo : '.$message['nb_photo'].'</p></a>';
                $image_html .= '</div>';
            }
        }else{
            // sinon on mets rien dans la variable 
            $image_html = '';
        }
        // on regarde de qui vien le message 
        // si il vien de l'utilisateur on ajoute un li avec comme id droite
        if($message["id_utilisateur"] == $id_usr){
            $html .= "<li id = 'droite'> <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$_SESSION['user_email']."/".$_SESSION['user_email']."_profil.jpg\"> <strong>Moi le $date_mess_jour / $date_mess_mois :</strong> <p>$message[message] <br> $image_html </p></li>";
        }
        // sinon il vien d'un membre on ajoute un li avec comme id gauche
        else{
            $id_utilisateur = $message["id_utilisateur"];
            $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
            $profil = $db->query($sql_profil);
            $res_profil = $profil->fetch();
            $html .= "<li id = 'gauche'> <img class='profilPhoto' src=\"http://".$_SERVER['SERVER_NAME']."/membres/image/utilisateurs/".$res_profil['email']."/".$res_profil['email']."_profil.jpg\"><strong>$res_profil[nom] $res_profil[prenom] le $date_mess_jour / $date_mess_mois :</strong><p> $message[message] <br> $image_html </p></li>";
        }
    }
    $html .= "</ul>";
    echo $html;
}
/******************************************************************************************************************************************** */
// fonction envoye_message_tous avec comme parametre la variable de connection a la db
// dans cette fonction on va ajouter dans la message_tous groupe les nouveau message
/******************************************************************************************************************************************** */
function envoye_message_tous($db){
    // on cree les variables
    $message = addslashes($_POST['texte']);
    //prend en compte plusieur espace a la suite d'un textarea
    $text2 = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
    $id_usr = $_SESSION['user_id'];
    $photo = $_FILES["photo"]["name"][0];
    date_default_timezone_set('Europe/Paris');
    $DateAndTime = date('m-d-Y H:i:s', time()); 
    if(isset($message) AND !empty($photo)){
        $myFile = $_FILES['photo'];
        $fileCount = count($myFile["name"]);
        $sql = "INSERT INTO `message_tous`(`id_utilisateur`, `message`,`date_heure`, `nb_photo`) VALUES ('$id_usr', '$text2', '$DateAndTime', '$fileCount')";
        $insert = $db->query($sql);
        inserer_photo($db, 'tous', $DateAndTime, $id_usr, $fileCount, $myFile); // on execute le programe pour inserer les photos au bonne endroit
        creer_notification_message_tous($db, $id_usr);// on cree une notif 
        header('Location: message_tous.php');
    }elseif(isset($message) AND !empty($message) AND empty($photo)){
        $sql = "INSERT INTO `message_tous`(`id_utilisateur`, `message`,`date_heure`, `nb_photo`) VALUES ('$id_usr', '$text2', '$DateAndTime', 0)";
        $insert = $db->query($sql);
        creer_notification_message_tous($db, $id_usr);// on cree une notif 
        header('Location: message_tous.php');
    }
}
?>