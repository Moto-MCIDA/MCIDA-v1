<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			   Fonction ancien - Prive		 			   	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/******************************************************************************************************************************************** */
// fonction ancien_balade avec un parametre qui est la variable de connexion a la db 
// cette fonction va recuperer toutes balades dont la date est <= a celle du jour 
// puis elle va faire une boucle ligne par ligne afin executer la fonction affiche_ancien_balade
/******************************************************************************************************************************************* */
	function ancien_balade($db){
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d"); // on recupere la date du jour dans une variable
		$booleen = $db->query("SELECT count(*) FROM balade WHERE date_sortie <= '$ajrd'"); // on compte combien de balade on une date <= a la date du jour 
		$bool = $booleen->fetchColumn();
		if($bool >= 1){ // si il y a plus de 1 balade 
			$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie <= '$ajrd' ORDER BY date_sortie DESC"); // on recuper tous les infos de toutes les balades concerner (trier par date decroissant)
			$balade->execute();
			while ($res = $balade->fetch(PDO::FETCH_OBJ)) { // on fait une boucle afin d'utiliser une ligne du resultat precedent qui est sous forme de tableau
				affiche_ancien_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description); // execute la fonction avec affiche_ancien_balade avec toutes les info sur la balade en parametre
			}
		}else{
			// si il a 0 balade on affiche un message
			echo 'pas d\'ancienne balade';
		}
    	
	}
/******************************************************************************************************************************************** */
// fonction affiche_ancien_balade avec comme parametre la variable de connexion a la db  et toutes les infos de la balade 
// dans cette fonction on recupere des info sur la personne qui la cree 
// puis on cree une variable html qui contiendra du code html (partie du tableau) avec a l'interieur les différentes variable de la sortie et de l'utilisateur
// il y a un bloc photo avec la photo de profil du créateur, ou les photos de la sortie qui defile aléatoirement (si il en a)
/******************************************************************************************************************************************** */
	function affiche_ancien_balade($db, $id, $nom, $date_sortie, $id_createur, $description){
		// recuperation des informations sur l'utilisateur (email, nom, prenom) 
		$sql = "SELECT email, prenom, nom FROM utilisateur WHERE id = $id_createur";
	    $select = $db->query($sql);
	    $res = $select->fetch();
		// on ajoute du code html et les différentes variables 
		$html = '<tr>';
		$html .= '<td>';
		$html .= '<a href=\'message/message_groupe_balade.php?id='.$id.'\'>';
		$html .= '<div id="ancien_balade">';
		$html .= '<h5 style="display: flex;flex-direction: column;justify-content: center;">'.$nom.'</h5>';
		$html .= '<h6>Du : '.$date_sortie.'</h6>';
		$html .= '<h6>Proposé par : '.$res['nom'].' '.$res['prenom'].'</h6>';
		// partie bloc photo
		$html .= '<div id="image_bloc">';
		$html .= '<div id="img_ab">';
    	//On indique le dossier images
		$chem_img = 'document/photo_balade/'.$id;
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
			$html .= '<img src="image/utilisateurs/'.$res['email'].'/'.$res['email'].'_profil.jpg">';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</a>';
		$html .= '</td>';
		$html .= '</tr>';
		print($html);	// on affiche la variable 				
	}
/******************************************************************************************************************************************** */
// fonction recup_nom_date avec comme parametre a variable de connexion a la db et l'id de la balade 
// sert a recuperer le nom et la date de sortie de la sortie 
/******************************************************************************************************************************************** */
	function recup_nom_date($id_groupe, $db){
	    $sql = "SELECT nom, date_sortie FROM balade WHERE id = $id_groupe";
	    $select = $db->query($sql);
	    $res = $select->fetch();
	    return $res;
	}
/******************************************************************************************************************************************** */
// fonction affiche_nom avec comme parametre un tableau (avec dedans le nom et la date de la balade)
// sert a afficher dans une div les info de la sortie
/******************************************************************************************************************************************** */
	function affiche_nom($np_groupe){
	    $nom = $np_groupe['nom'];
	    $date = $np_groupe['date_sortie'];
	    $html = "<div id='nom_bar'><h1 id = 'nom'> $nom du $date</h1></div>";
	    echo $html;
	}
/******************************************************************************************************************************************** */
// fonction recup_message avec comme parametre a variable de connexion a la db et l'id de la balade 
// sert recuperer les messages de la balade
/******************************************************************************************************************************************** */
	function recup_message($id_groupe, $db){
	    $sql = "SELECT * FROM `message_groupe` WHERE id_balade = $id_groupe";
	    $select = $db->query($sql);
	    return $select;
	}
/******************************************************************************************************************************************** */
// fonction affiche_message avec comme parametre un tableau avec les infos des messages, l'id de la balade, et avec la variable de connection a la db
// dans cette fonction on va afficher sous forme de liste les messages
// on mets l'id droit pour les li qui correspond au message de l'utilisateur, sinon on mets l'id gauche
/******************************************************************************************************************************************** */
	function affiche_message($messages, $id_groupe, $db){
	    $id_usr = $_SESSION['user_id'];
	    $dst = recup_nom_date($id_groupe, $db); // utilisation de la fonction precedente
	    $html = "<ul id='ul'>";
		// on fait une boucle for pour chaque message 
	    foreach($messages as $key => $message){
			// on recupere le mois et le jour
	        $date_mess_mois = substr($message['date_heure'], 0, 2);
	        $date_mess_jour = substr($message['date_heure'], 3, 2);
	        if ($message['nb_photo'] != 0) {
	    		$image_html = '<div id="image_bloc_msg">';
        		//for ($i = 0; $i < $message['nb_photo']; $i++) {
        			$image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><img src="document/photo_balade/'.$id_groupe.'/'.$message['date_heure'].'_'.$message['id_utilisateur'].'_0.jpg"></a>';
        			$image_html .= '<a href="affiche_photo.php?idg='.$id_groupe.'&msgdh='.$message['date_heure'].'&msgiu='.$message['id_utilisateur'].'&nbp='.$message['nb_photo'].'"><p>Nombre de photo : '.$message['nb_photo'].'</p></a>';
        		//}
        		$image_html .= '</div>';
        	}else{
        		$image_html = '';
        	}

	        if($message["id_utilisateur"] == $id_usr){
	            $html .= "<li id = 'droite'> <strong>Moi le $date_mess_jour / $date_mess_mois :</strong> $message[message] <br> $image_html </li>";
	        }
	        else{
	            $id_utilisateur = $message["id_utilisateur"];
	            $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id_utilisateur";
	            $profil = $db->query($sql_profil);
	            $res_profil = $profil->fetch();
	            $html .= "<li id = 'gauche'> <strong>$res_profil[nom] $res_profil[prenom] le $date_mess_jour / $date_mess_mois :</strong> $message[message] <br> $image_html </li>";
	        }
	    }
	    $html .= "</ul>";
	    echo $html;
	}

?>