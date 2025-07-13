<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction index - Prive		  			  	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/******************************************************************************************************************************************** */
// fonction new_balade 
// va regarder si il y a un type (si l'utilisateur a choisi de trier les evenement a afficher)
// puis va chercher les sorties dont la date est >= a la date du jour
// cette fonction va recuperer toutes balades dont la date est >= a celle du jour 
// puis elle va faire une boucle ligne par ligne afin executer la fonction affiche_new_balade
/********************************************************************************************************************************************* */
	function new_balade($db, $type){
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d"); // on recupere la date du jour dans une variable
    	if ($type == 'Tout') { // verifie si la variable type est egal a tout
    		$booleen = $db->query("SELECT count(*) FROM balade WHERE date_sortie >= '$ajrd'"); // on compte combien de balade on une date >= a la date du jour 
			$bool = $booleen->fetchColumn();
			if($bool >= 1){ // si il y a plus de 1 balade 
				$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie >= '$ajrd' ORDER BY date_sortie");
				$balade->execute();
				while ($res = $balade->fetch(PDO::FETCH_OBJ)) { // on fait une boucle afin d'utiliser une ligne du resultat precedent qui est sous forme de tableau
					affiche_new_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description, $res->active); // execute la fonction avec affiche_new_balade avec toutes les info sur la balade en parametre
				}
			}else{
				echo 'Pas d\'évenement';
			}
    	}else{
			// meme chose que le dessus 
    		$booleen = $db->query("SELECT count(*) FROM balade WHERE date_sortie >= '$ajrd' AND type='$type'");
			$bool = $booleen->fetchColumn();
			if($bool >= 1){
				$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie >= '$ajrd' AND type='$type' ORDER BY date_sortie");
				$balade->execute();
				while ($res = $balade->fetch(PDO::FETCH_OBJ)) {
					affiche_new_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description, $res->active);
				}
			}else{
				echo 'Pas d\'évenement';
			}
    	}
    	
	}
/******************************************************************************************************************************************** */
// fonction present 
// cette fonction va regarder si il y a une ligne dans la table balade_memebre
// si elle existe ca signifie que l'utilisateur a répondu
// et elle renvoie la varible result qui contient un entier 
// si egal a 0 signifie qu'il a pas repondu 
// si egal 1, 2, 3 signifie qu'il a repondu (oui, jsp, non)
/********************************************************************************************************************************************* */
	function present($db, $id){
		$user_id = $_SESSION['user_id'];
		$result = 0;
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // on verifie que la ligne existe 
		$bool = $booleen->fetchColumn();
		if($bool == 1){
			$select = $db->prepare("SELECT * FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // recupere les infos
			$select->execute();
			$res = $select->fetch(PDO::FETCH_OBJ);
			$result = $res->reponse; // on mets le resultat dans la variable result
		}
		return $result; // on return la variable result
	}
/******************************************************************************************************************************************** */
// fonction comm 
// cette fonction va regarder si il y a une ligne dans la table balade_memebre
// si elle existe ca signifie que l'utilisateur a répondu
// et elle renvoie la varible result qui contient un entier 
// si egal a 0 signifie qu'il a pas de commentaire 
// si != de 0 c'est qu'il y a un commentaire
/********************************************************************************************************************************************* */
	function comm($db, $id){
		$user_id = $_SESSION['user_id'];
		$result = 0;
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // on verifie que la ligne existe 
		$bool = $booleen->fetchColumn();
		if($bool == 1){
			$select = $db->prepare("SELECT * FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // recupere les infos
			$select->execute();
			$res = $select->fetch(PDO::FETCH_OBJ);
			$result = $res->commentaire; // on mets le resultat dans la variable result
		}
		return $result; // on return la variable result
	}
/******************************************************************************************************************************************** */
// fonction nb_personne 
// cette fonction va regarder si il y a une ligne dans la table balade_memebre
// si elle existe ca signifie que l'utilisateur a répondu
// et elle renvoie la varible result qui contient un entier 
// si egal a 0 signifie qu'il a pas de personne
// si != de 0 c'est qu'il y a un 1 ou plusieurs personnes
/********************************************************************************************************************************************* */
	function nb_personne($db, $id){
		$user_id = $_SESSION['user_id'];
		$result = 0;
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // on verifie que la ligne existe 
		$bool = $booleen->fetchColumn();
		if($bool == 1){
			$select = $db->prepare("SELECT * FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$id'"); // recupere les infos
			$select->execute();
			$res = $select->fetch(PDO::FETCH_OBJ);
			$result = $res->nb_prs; // on mets le resultat dans la variable result
		}
		return $result; // on return la variable result
	}
/******************************************************************************************************************************************** */
// fonction affiche_new_balade 
// cette fonction va recuperer des informations sur le créateur de la balade 
// cree une variable html qui contient du html et les differnetes variables 
// contient une div reponse_notif qui permetera a l'utilisateur de voir quelle type de reponse l'utilisteur a mis et si il en a mis
// contient aussi une div qui servira de "compteur"
// puis la variable sera afficher
/********************************************************************************************************************************************* */
	function affiche_new_balade($db, $id, $nom, $date_sortie, $id_createur, $description, $active){
		//recuperation d'information sur le createur 
		$sql = "SELECT email, prenom, nom FROM utilisateur WHERE id = $id_createur";
	    $select = $db->query($sql);
	    $res = $select->fetch();
		$reponse = present($db, $id);
		// on ajoute du code html et les différentes variables 
		$html = '<tr>';
		$html .= '<td>';
		$html .= '<a href=\'index.php?id='.$id.'\'>';
		if($active == 1){
			$html .= '<div id="new_balade">';
		}else {
			$html .= '<div id="supp_balade">';
			$html .= '<h4 class="check">Annulé </h4>';
		}
		$html .= '<h5>'.$nom.'</h5>';
		$html .= '<h6>Du : '.$date_sortie.'</h6>';
		$html .= '<h6>Proposé par : '.$res['nom'].' '.$res['prenom'].'</h6>';
		// en fonction de la valeur dans la variable reponse on mets un div avec une classe spcifique 
		if($reponse == 1){
			$html .= '<div class="reponse_notif like"></div>';
		}elseif ($reponse == 2) {
			$html .= '<div class="reponse_notif jsp"></div>';
		}elseif ($reponse == 3) {
			$html .= '<div class="reponse_notif dislike"></div>';
		}else{
			$html .= '<div class="reponse_notif "></div>';
		}
		// bloc contenant limage de profil du createur
		$html .= '<div id="image_profil_propose">';
		$html .= '<img src="image/utilisateurs/'.$res['email'].'/'.$res['email'].'_profil.jpg">';
		$html .= '</div>';
		// partie compteur
		date_default_timezone_set('Europe/Paris');
        $date_expire = $date_sortie;    
        $date = new DateTime($date_expire);
        $now = new DateTime();
		// on regarde si la date de la sortie est celle du jour
        if($date->diff($now)->format('%R')=='+'){
        	$result = $date->diff($now)->format("<div id='date_compteur_green'><div>Aujourd'hui</div>"); // si oui on marque ajrd avec un id specifique
        }else{
        	$result = $date->diff($now)->format("<div id='date_compteur'><div>%a</div><p>jours</p><div>%h</div><p>h</p><div>%i</div><p>m</p><div>%s</div><p>s</p></div>"); // sinon on maque l'heure les minutes et seconde avec un id différent
        }
        $html .= '<div id="date">'.$result.'</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</a>';
		$html .= '</td>';
		$html .= '</tr>';
		print($html); // afficher la variable				
	}
/******************************************************************************************************************************************** */
// fonction balade_info 
// cette fonction va recuperer des informations sur la sortie et aussi sur le createur
// cree une variable html qui contient du html et les differnetes variables 
// contient un formulaire pour repondre a la sortie
/********************************************************************************************************************************************* */
	function balade_info($db, $id){
		//recuperation d'information sur la sortie
		$sql = "SELECT * FROM balade WHERE id = $id";
	    $select = $db->query($sql);
	    $res = $select->fetch();
		//recuperation d'information sur le createur
	    $id_createur =  $res['id_createur'];
	    $sql_profil = "SELECT prenom, nom FROM utilisateur WHERE id = $id_createur";
	    $select_profil = $db->query($sql_profil);
	    $res_profil = $select_profil->fetch();
		// variable comprenant différents information comme la reponse, le nombre de personne, et le commentaire 
		$reponse = present($db, $id);
		$comm = comm($db, $id);
		$nb_personne = nb_personne($db, $id);
		// on ajoute du code html et les différentes variables 
	    $html = '<p>'.$res['nom'].'<br>';
	    $html .= 'Date : '.$res['date_sortie'].'<br>';
	    $html .= 'Proposé par : '.$res_profil['nom'].' '.$res_profil['prenom'].'<br>';
	    $html .= '<a class="message_groupe" href="message/message_groupe_balade.php?id='.$id.'">Chat</a></p>';
	    $html .= '<p>Description </p>';
	    $html .= '<p>'.$res['description'].'</p>';
		// on regarde si dans la table de la balade a la colonne doc il y a 1, ce qui signifie qu'il y a au minimum 1 document 
	    if($res['doc'] == 1){ // si oui on affiche la partie doc avec les documents 
	    	$html .= '<p>Document </p>';
			$html .= '<div id="listDeDoc">';
	    	$scandir = scandir("document/document_balade/".$id);
	    	$x = 1;
			foreach($scandir as $fichier){
				if($x != 1 AND $x !=2){
					$html .= '<a id="document" href="document/document_balade/'.$id.'/'.$fichier.'" download>'.$fichier.'</a><br><br>';
				}
				$x++;
			}
			$html .= '</div>';
	    	
	    }
		// partie reponse
	    $html .= '<p id="divRep">Répondre</p>';
	    $html .= '<form method="post">';
		// en fonction de la variable reponse on mets le champs 'selected' dans une des 4 différentes variable
	    if($reponse == 1){
			$choix = '';
			$choix1 = 'selected';
			$choix2 = '';
			$choix3 = '';
		}elseif ($reponse == 2) {
			$choix = '';
			$choix1 = '';
			$choix2 = 'selected';
			$choix3 = '';
			
		}elseif ($reponse == 3) {
			$choix = '';
			$choix1 = '';
			$choix2 = '';
			$choix3 = 'selected';			

		}else{
			$choix = 'selected';
			$choix1 = '';
			$choix2 = '';
			$choix3 = '';
		}
		// select avec les variables du dessus 
		$html .= '<select name="choix_reponse">';
		$html .= '<option value="">Choisir une réponse</option>';
		$html .= '<option value="1" '.$choix1.'>Présent</option>';
		$html .= '<option value="2" '.$choix2.'>Ne sais pas encore</option>';
		$html .= '<option value="3" '.$choix3.'>Absent</option>';
		$html .= '</select>';
		// si le commantaire est différents de '' ca signifie qu'il y a un commentaire dans la db donc on laffiche
		// sinon on affiche rien 
	    if ($comm != '') {
	    	$html .= '<textarea name="commentaire" placeholder="Laissez un commentaire ...">'.$comm.'</textarea>';
	    }else{
	    	$html .= '<textarea name="commentaire" placeholder="Laissez un commentaire ..."></textarea>';
	    }
		// en fonction de la variable reponse on mets le champs 'selected' dans une des 4 différentes variable
	    if($nb_personne == 1){
			$prs = '';
			$prs1 = 'selected';
			$prs2 = '';
			$prs3 = '';
			$prs4 = '';
			$prs5 = '';
		}elseif ($nb_personne == 2) {
			$prs = '';
			$prs1 = '';
			$prs2 = 'selected';
			$prs3 = '';
			$prs4 = '';
			$prs5 = '';
			
		}elseif ($nb_personne == 3) {
			$prs = '';
			$prs1 = '';
			$prs2 = '';
			$prs3 = 'selected';
			$prs4 = '';
			$prs5 = '';			

		}elseif ($nb_personne == 4) {
			$prs = '';
			$prs1 = '';
			$prs2 = '';
			$prs3 = '';
			$prs4 = 'selected';
			$prs5 = '';			

		}elseif ($nb_personne == 5) {
			$prs = '';
			$prs1 = '';
			$prs2 = '';
			$prs3 = '';
			$prs4 = '';
			$prs5 = 'selected';			

		}else{
			$prs = 'selected';
			$prs1 = '';
			$prs2 = '';
			$prs3 = '';
			$prs4 = '';
			$prs5 = '';
		}
		// select avec les variables du dessus 
		$html .= '<select name="nb_personne">';
		$html .= '<option value="" '.$prs.'>Combien de personnes</option>';
		$html .= '<option value="1" '.$prs1.'>1 personne</option>';
		$html .= '<option value="2" '.$prs2.'>2 personnes</option>';
		$html .= '<option value="3" '.$prs3.'>3 personnes</option>';
		$html .= '<option value="4" '.$prs4.'>4 personnes</option>';
		$html .= '<option value="5" '.$prs5.'>5 personnes</option>';
		$html .= '</select>';
	    $html .= '<input type="submit" onclick="backfunction()" name="envoyer" value="Envoyer">';
	    $html .= '</form>';
		// afficher la variable html
	    print ($html);
		// on execute les 3 fonctions ci dessous afin de voir le profil des personne qui on repondu (oui, jsp, ou non)
		profil_oui($db, $id);
		profil_jsp($db, $id);
		profil_non($db, $id);
		viewMembreBalade($db,$id);
	}
/******************************************************************************************************************************************** */
// fonction profil_oui 
// cette fonction va compter le nombre de personne qui on repondu oui
// si superieur ou egal a 1 on les mettra dans des div qui defilerons
/********************************************************************************************************************************************* */
	function profil_oui($db, $id){
		// compte le nombre de personnes qui ont dit oui
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_balade = '$id' AND reponse = 1");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			// on recuper lid des personnes qui ont dit oui
			$balade = $db->prepare("SELECT * FROM balade_membre WHERE id_balade = '$id' AND reponse = 1");
			$balade->execute();
	    	$html = '<h5>Présent pour la balade</h5>';
		    $html .= '<div id="box_scroller">';
		    $html .= '<div id="scroller">';
			while ($res = $balade->fetch()) { // on fera personne par personne
				$id_utilisateur = $res['id_utilisateur'];
				// on recuper toutes les informations sur la personne
				$profil = $db->query("SELECT * FROM utilisateur WHERE id = '$id_utilisateur'");
	    		$res_profil = $profil->fetch();
	    		$description = $db->query("SELECT * FROM balade_membre WHERE id_utilisateur = '$id_utilisateur' AND id_balade = '$id'");
	    		$res_description = $description->fetch();
				// on affiche sa photo de profil dans une div et on met le commentaire dans une autre div (qui sera visible que au survole de la photo)
			    $hasComment = !empty($res_description['commentaire']);
				$nb_prs = $res_description['nb_prs'];
				$nom = $res_profil['nom'];
				$prenom = $res_profil['prenom'];
				$commentaire = $res_description['commentaire'];
				$email = $res_profil['email'];

				$html .= '<div class="scrollerItem" ' . ($hasComment ? 'onclick="openCommentModal(\''.addslashes($nom).'\', \''.addslashes($prenom).'\', \''.$nb_prs.'\', \''.addslashes(htmlspecialchars($commentaire)).'\')"' : '') . '>';
				$html .= '<div class="badge-top like">'.$nb_prs.'</div>';
				$html .= '<img src="image/utilisateurs/'.$email.'/'.$email.'_profil.jpg">';
				if ($hasComment) {
					$html .= '<div class="badge-bottom like" >💬</div>';
				}
				$html .= '</div>';
			}
		    $html .= '</div>';
		    $html .= '</div>';
			print($html);
		}
	}
/******************************************************************************************************************************************** */
// fonction profil_jsp
// pareil mais avec les profil jsp
/********************************************************************************************************************************************* */
	function profil_jsp($db, $id){
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_balade = '$id' AND reponse = 2");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$balade = $db->prepare("SELECT * FROM balade_membre WHERE id_balade = '$id' AND reponse = 2");
			$balade->execute();
	    	$html = '<h5>Ne sait pas encore</h5>';
		    $html .= '<div id="box_scroller">';
		    $html .= '<div id="scroller">';
			while ($res = $balade->fetch()) {
				$id_utilisateur = $res['id_utilisateur'];
				$profil = $db->query("SELECT * FROM utilisateur WHERE id = '$id_utilisateur'");
	    		$res_profil = $profil->fetch();
	    		$description = $db->query("SELECT * FROM balade_membre WHERE id_utilisateur = '$id_utilisateur' AND id_balade = '$id'");
	    		$res_description = $description->fetch();
			    // on affiche sa photo de profil dans une div et on met le commentaire dans une autre div (qui sera visible que au survole de la photo)
			    $hasComment = !empty($res_description['commentaire']);
				$nb_prs = $res_description['nb_prs'];
				$nom = $res_profil['nom'];
				$prenom = $res_profil['prenom'];
				$commentaire = $res_description['commentaire'];
				$email = $res_profil['email'];

				$html .= '<div class="scrollerItem" ' . ($hasComment ? 'onclick="openCommentModal(\''.addslashes($nom).'\', \''.addslashes($prenom).'\', \''.$nb_prs.'\', \''.addslashes(htmlspecialchars($commentaire)).'\')"' : '') . '>';
				$html .= '<div class="badge-top jsp">'.$nb_prs.'</div>';
				$html .= '<img src="image/utilisateurs/'.$email.'/'.$email.'_profil.jpg">';
				if ($hasComment) {
					$html .= '<div class="badge-bottom jsp" >💬</div>';
				}
				$html .= '</div>';
			}
		    $html .= '</div>';
		    $html .= '</div>';
			print($html);
		}
	}
/******************************************************************************************************************************************** */
// fonction profil_non
// pareil mais avec les profil absent
/********************************************************************************************************************************************* */
	function profil_non($db, $id){
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_balade = '$id' AND reponse = 3");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$balade = $db->prepare("SELECT * FROM balade_membre WHERE id_balade = '$id' AND reponse = 3");
			$balade->execute();
	    	$html = '<h5>Absent pour la balade</h5>';
		    $html .= '<div id="box_scroller">';
		    $html .= '<div id="scroller">';
			while ($res = $balade->fetch()) {
				$id_utilisateur = $res['id_utilisateur'];
				$profil = $db->query("SELECT * FROM utilisateur WHERE id = '$id_utilisateur'");
	    		$res_profil = $profil->fetch();
	    		$description = $db->query("SELECT * FROM balade_membre WHERE id_utilisateur = '$id_utilisateur' AND id_balade = '$id'");
	    		$res_description = $description->fetch();
			    // on affiche sa photo de profil dans une div et on met le commentaire dans une autre div (qui sera visible que au survole de la photo)
			    $hasComment = !empty($res_description['commentaire']);
				$nb_prs = $res_description['nb_prs'];
				$nom = $res_profil['nom'];
				$prenom = $res_profil['prenom'];
				$commentaire = $res_description['commentaire'];
				$email = $res_profil['email'];

				$html .= '<div class="scrollerItem" ' . ($hasComment ? 'onclick="openCommentModal(\''.addslashes($nom).'\', \''.addslashes($prenom).'\', \''.$nb_prs.'\', \''.addslashes(htmlspecialchars($commentaire)).'\')"' : '') . '>';
				$html .= '<div class="badge-top dislike">'.$nb_prs.'</div>';
				$html .= '<img src="image/utilisateurs/'.$email.'/'.$email.'_profil.jpg">';
				if ($hasComment) {
					$html .= '<div class="badge-bottom dislike" >💬</div>';
				}
				$html .= '</div>';
			}
		    $html .= '</div>';
		    $html .= '</div>';
			print($html);
		}
	}
/******************************************************************************************************************************************** */
// fonction envoyer_presence_balade 
// le but de cette fonction est d'ajouter dans la table balade_membre les information rentrer deans le formulaire du bloc repondre 
/********************************************************************************************************************************************* */
	function envoyer_presence_balade($db, $balade_id){
		// on recuper les differentes valeurs rentrer dans le input 
		$choix_reponse = $_POST['choix_reponse'];
		$commentaire = addslashes($_POST['commentaire']);
		$user_id = $_SESSION['user_id'];
		$nb_personne = $_POST['nb_personne'];
		// si nb-personne est diff de 1, 2, 3, 4, ou 5 on met automatiquement 1
		if($nb_personne != 1 AND $nb_personne != 2 AND $nb_personne != 3 AND $nb_personne != 4 AND $nb_personne != 5 ){
			$nb_personne = 1;
		}
		// on regarde si il a fais un choix (present, jsp, absent)
		if($choix_reponse){
			$verif_reponse = $db->query("SELECT count(*) FROM balade_membre WHERE id_utilisateur = '$user_id' AND id_balade = '$balade_id'"); // on compte dans balade_membre pour voir si la ligne existe ou pas 
			$verif_reponse_bool = $verif_reponse->fetchColumn();
			if($verif_reponse_bool == 1){ // si == 1  signifie qu'il a deja repondu donc on update avec les nouvelles variables
				$modifier_reponse = $db->prepare("UPDATE `balade_membre` SET reponse='$choix_reponse', commentaire='$commentaire', nb_prs = '$nb_personne' WHERE id_utilisateur=$user_id AND id_balade=$balade_id");
				$modifier_reponse->execute();
			}elseif($verif_reponse_bool == 0){ // si == 0  signifie qu'il na pas encore repondu donc on inser les variables
				if($commentaire){ // verif si il y a un commentaire si oui on le mets sinon on mets rien
					$sql = "INSERT INTO `balade_membre` (id_balade, id_utilisateur,  reponse, commentaire, nb_prs) VALUES ('$balade_id', '$user_id', '$choix_reponse', '$commentaire', '$nb_personne')";
					$ajout_reponse = $db->query($sql);
				}else{
					$sql = "INSERT INTO `balade_membre` (id_balade, id_utilisateur,  reponse, nb_prs) VALUES ('$balade_id', '$user_id', '$choix_reponse', '$nb_personne')";
					$ajout_reponse = $db->query($sql);
				}
			}
			// on cree une notif et on reactualise la page 
			creer_notification_acpt_balade($db, $user_id, $balade_id);
			header('Location: index.php?id='.$balade_id);
		}else{
			echo '<script type="text/javascript">			
					       window.onload = function () { alert("Veuillez choisir si vous serez présent, pas présent ou si vous ne savez pas encore"); } 
					</script>'; 
		}
	}


	function viewMembreBalade($db,$id){
		affiche_membre_balade($db, $id);
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
			    $html .= '<td style="
				color: white;">'.$res_profil['nom'].'</td>';
			    $html .= '<td style="
				color: white;">'.$res_profil['prenom'].'</td>';
			    $html .= '<td style="
				color: white;">'.$res_description['nb_prs'].'</td>';
				$html .= '<td style="
				color: white;">'.$rep.'</td>';
			    $html .= '</tr>';
			}
			$html .= '</table>';
			print($html) ;
		}
	}

?>