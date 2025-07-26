<?php 
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction memebre - Prive		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/******************************************************************************************************************************************** */
// fonction affiche_message_tous 
// cette fonction va permettre dafficher bloc qui sera un lien vers le chat groupe commun pour envoyer un message a tous les utilisateur
/********************************************************************************************************************************************* */
	function affiche_message_tous($db){
		$html = '<div style="justify-content: space-evenly;" id="profil">';
		$html .= '<h4>Groupe commun</h4> &ensp;';
		$html .= '<div id="img_div">';
		$html .= '<img src="../image/MCIDA_logo.png">';
		$html .= '</div>';
		$html .= '<div id="button">';
		$html .= '<a href="message/message_tous.php">Messagerie</a>';
		$html .= '</div>';
		$html .= '</div>';

		print($html);
	}
/******************************************************************************************************************************************** */
// fonction recupe_info_profil 
// cette fonction va permettre de rcuperer tous les infos sur les profils qui on ete accepter et qui on fini leur inscription
// et on va executer la fonction affiche_profil_bloc personne par personne avec leur infos 
/********************************************************************************************************************************************* */
	function recupe_info_profil($db){
		$user_id = $_SESSION['user_id'];
    	$booleen = $db->query("SELECT count(*) FROM utilisateur WHERE id != '$user_id' AND accepter = 1 AND finInscription = 1");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$profil = $db->prepare("SELECT * FROM utilisateur WHERE id != '$user_id' AND accepter = 1 AND finInscription = 1 ORDER BY nom"); // on recupere les infos des profils 
			$profil->execute();
			while ($res = $profil->fetch(PDO::FETCH_OBJ)) { // on fais une boucle pour utiliser les infos profil par profil
				affiche_profil_bloc($db,$res->id, $res->nom, $res->prenom, $res->email); // fonction qui permet d'afficher le bloc du profil
			}
		}else{
			echo 'erreur';
		}
	}
/******************************************************************************************************************************************** */
// fonction recupe_info_profil_recherche 
// cette fonction fais pareil que la precedente mais avec ce que l'utilisateur a rechercher
/********************************************************************************************************************************************* */
	function recupe_info_profil_recherche($db, $recherche){
		$user_id = $_SESSION['user_id'];
    	$booleen =  $db->query('SELECT count(*) FROM utilisateur WHERE prenom LIKE "'.$recherche.'%" AND id!='.$user_id.' AND accepter = 1 AND finInscription = 1 ORDER BY prenom DESC'); // compte combien de personne avec un prenom commencant par la recherche
		$bool = $booleen->fetchColumn();
		if($bool >= 1){// si superieur ou egal a 1
			$profil = $db->prepare('SELECT * FROM utilisateur WHERE prenom LIKE "'.$recherche.'%" AND id!='.$user_id.' AND accepter = 1 AND finInscription = 1 ORDER BY prenom DESC'); // on recupere les infos des profils  
			$profil->execute();
			while ($res = $profil->fetch(PDO::FETCH_OBJ)) { // on fais une boucle pour utiliser les infos profil par profil
				affiche_profil_bloc($db,$res->id, $res->nom, $res->prenom, $res->email); // fonction qui permet d'afficher le bloc du profil
			}
		}else{ // sinon on affiche un message indiquant qu'il n'y a pas de profil commancant par la recherche
			$html = '<div id="profil">';
			$html .= '<h4>Pas de profil commencant par : '.$recherche.'</h4>';
			$html .= '</div>';

			print($html);
		}
	}
/******************************************************************************************************************************************** */
// fonction affiche_profil_bloc 
// cette fonction permet d'afficher les profils sous forme de lien 
/********************************************************************************************************************************************* */
	function affiche_profil_bloc($db,$id, $nom, $prenom, $email){
		$html = '<div id="profil">';
		$html .= '<div id="img_div">';
		$html .= '<img src="image/utilisateurs/'.$email.'/'.$email.'_profil.jpg">';
		$html .= '</div>';
		$html .= '<h4>'.$nom.' '.$prenom.'</h4>';
		$html .= '<div id="img_div">';
		$html .= '<img src="image/utilisateurs/'.$email.'/'.$email.'_moto.jpg">';
		$html .= '</div>';
		$html .= '<div id="button">';
		$html .= '<a href="profil.php?id='.$id.'">Voir le profil</a>';
		$html .= '<a href="message/message_membre_profil.php?id='.$id.'">Messagerie</a>';
		$html .= '</div>';
		$html .= '</div>';

		print($html);
	}

?>