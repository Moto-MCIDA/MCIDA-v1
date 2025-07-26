<?php 
function list_id($db){
	$user_id = $_SESSION['user_id'];
	$list_id = [];
	$tous_id = $db->query("SELECT id FROM utilisateur WHERE id != '$user_id' AND accepter=1 AND finInscription=1");
	$tous_id->execute(array());
	while ($tous_id_F=$tous_id->fetch()) {
		$list_id[] = $tous_id_F['id'];
	}
	return $list_id;
}

function creer_notification_creer_balade($db, $id_createur, $id_balade){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	$list_id = list_id($db);
	for ($i = 0; $i < count($list_id); $i++) {
		$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'création balade', '$id_balade', '$DateAndTime')";
		$ajout_notification = $db->query($sql);
	}
	mail_notification($db, $id_createur); 
}
function creer_notification_modif_balade($db, $id_createur, $id_balade){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	$list_id = list_id($db);
	for ($i = 0; $i < count($list_id); $i++) {
		$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'modifier balade', '$id_balade', '$DateAndTime')";
		$ajout_notification = $db->query($sql);
	}
	mail_notification($db, $id_createur); 
}
function creer_notification_message_perso($db, $id_createur, $id_destinataire){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	
	$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$id_destinataire', 'message perso', '$id_createur', '$DateAndTime')";
	$ajout_notification = $db->query($sql);
	
	mail_notification($db, $id_createur); 
}
function creer_notification_message_groupe($db, $id_createur, $id_balade){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	
	$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'message groupe actif', '$id_balade', '$DateAndTime')";
	$ajout_notification = $db->query($sql);
	
	mail_notification($db, $id_createur); 
}
function creer_notification_message_groupe_ancien($db, $id_createur, $id_balade){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	
	$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'message groupe ancien', '$id_balade', '$DateAndTime')";
	$ajout_notification = $db->query($sql);
	
	mail_notification($db, $id_createur); 
}
function creer_notification_message_tous($db, $id_createur){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	$list_id = list_id($db);
	for ($i = 0; $i < count($list_id); $i++) {
		
		$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'message tous', 0, '$DateAndTime')";
		$ajout_notification = $db->query($sql);
		
	}
	
	mail_notification($db, $id_createur); 
}
function creer_notification_acpt_balade($db, $id_createur, $id_balade){
	
	date_default_timezone_set('Europe/Paris');
	$dateFr = $ajrd = date("d-m-Y H:i:s");
	$DateAndTime = (new DateTime($dateFr))->format("Y-m-d H:i:s");
	$list_id = list_id($db);
	for ($i = 0; $i < count($list_id); $i++) {

		$sql = "INSERT INTO `notification` (createur, destinataire,  type, id_lien, date_creation) VALUES ('$id_createur', '$list_id[$i]', 'accepter', '$id_balade', '$DateAndTime')";
		$ajout_notification = $db->query($sql);
		
	}
	mail_notification($db, $id_createur); 
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function affiche_notification($db){
	$list_notif=list_notif($db, $_SESSION['user_id']); 

	$html = '';

	if(count($list_notif)!=0){
		$html .= '<p style="text-align: center; margin: 2.5%;"><a id="supprime_tt" href="delete/supprime_notif.php?listid=tous">Supprimer toutes les notifications</a></p>';
		for ($i = 0; $i < count($list_notif); $i++) {
			$id_notif = $list_notif[$i];
	    	$notif = $db->query("SELECT * FROM notification WHERE id='$id_notif'");
			$res = $notif->fetch();

			ajoutLuNotif($db, $_SESSION['user_id'], $res['type'], $res['id_lien'], $res['date_creation']);

			if($res['lu'] != 0){
				$class = 'id="lu"';
				$check = '<h4 class="check">Lu <ion-icon name="checkbox-outline"></ion-icon></h4>';
			}else{
				$class = 'id="nnLu"';
				$check = '';
			}
			$date_mois = substr($res['date_creation'], 5, 2);
			$date_jour = substr($res['date_creation'], 8, 2);

			$date_heure = substr($res['date_creation'], 11, 2);
			$date_min = substr($res['date_creation'], 14, 2);
			if($res['type']=='création balade'){
				$profil = recupe_profil($db, $res['createur']); 
				$balade = recupe_balade($db, $res['id_lien']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="index.php?id='.$res['id_lien'].'" '.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Nouvelle balade '.$balade['nom'].' proposer par '.$profil['nom'].' '.$profil['prenom'].' à été créer</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='modifier balade'){
				$balade = recupe_balade($db, $res['id_lien']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="index.php?id='.$res['id_lien'].'"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Balade '.$balade['nom'].' à été modifié </h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='message perso'){
				$profil = recupe_profil($db, $res['createur']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="message/message_membre_profil.php?id='.$res['id_lien'].'"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Nouveau message de '.$profil['nom'].' '.$profil['prenom'].'</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='message groupe actif'){
				$profil = recupe_profil($db, $res['createur']); 
				$balade = recupe_balade($db, $res['id_lien']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="message/message_groupe_balade.php?id='.$res['id_lien'].'"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='message groupe ancien'){
				$profil = recupe_profil($db, $res['createur']); 
				$balade = recupe_balade($db, $res['id_lien']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="message/message_groupe_balade.php?id='.$res['id_lien'].'"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Nouveau message dans '.$balade['nom'].' par '.$profil['nom'].' '.$profil['prenom'].'</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='message tous'){
				$profil = recupe_profil($db, $res['createur']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="message/message_tous.php"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>Nouveau message dans le groupe commun par '.$profil['nom'].' '.$profil['prenom'].'</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}elseif($res['type']=='accepter'){
				$profil = recupe_profil($db, $res['createur']); 
				$balade = recupe_balade($db, $res['id_lien']); 
				$html .= '<tr>';
				$html .= '<td>';
				$html .= '<div>';
				$html .= '<a href="index.php?id='.$res['id_lien'].'"'.$class.'>';
				$html .= $check;
				$html .= '<p>Notification du '.$date_jour.'/'.$date_mois.' à '.$date_heure.':'.$date_min.'</p>';
				$html .= '<h5>'.$profil['nom'].' '.$profil['prenom'].' a répondu si il était présent dans '.$balade['nom'].'</h5>';
				$html .= '</a>';
				$html .= '<a href="delete/supprime_notif.php?id='.$res['id'].'">supprimer</a>';
				$html .= '</div>';
				$html .= '</td>';
				$html .= '</tr>';
			}
	    }

	}else{
		$html = '<h5>Pas de nouvelles notifications ...</h5>';
	}

	

	print($html);
}

function recupe_profil($db, $id){
	$sql = "SELECT * FROM utilisateur WHERE id = $id";
    $select = $db->query($sql);
    $res = $select->fetch();
    return $res;
}
function recupe_balade($db, $id){
	$sql = "SELECT * FROM balade WHERE id = $id";
    $select = $db->query($sql);
    $res = $select->fetch();
    return $res;
}

function list_notif($db, $user_id){
	$list_notif=[];
	$tous_notif = $db->query("SELECT * FROM notification WHERE destinataire = '$user_id' ORDER BY id DESC");
	$tous_notif->execute(array());
	while ($tout_notif_F=$tous_notif->fetch()) {
		$list_notif[] = $tout_notif_F['id'];
	}
	return $list_notif;
}



function compte_notification($db, $user_id){
	$list_notif=[];
	$tous_notif = $db->query("SELECT * FROM notification WHERE destinataire = '$user_id' AND lu = '0' ORDER BY id DESC");
	$tous_notif->execute(array());
	while ($tout_notif_F=$tous_notif->fetch()) {
		$list_notif[] = $tout_notif_F['id'];
	}
	if(count($list_notif)!=0){
		$html="<p id='nb_notif'>".count($list_notif)."</p>";
	}else{
   		$html="";
   	}
   	print($html);
}


function recupeDateLigneEnLigne($db, $user_id, $link, $id_link){
	$res = null;
	$booleen = $db->query("SELECT count(*) FROM ligne WHERE user = '$user_id' AND link ='$link' AND id_link='$id_link'"); // on compte combien de balade on une date >= a la date du jour 
	$bool = $booleen->fetchColumn();
	if($bool >= 1){
		$sql = "SELECT date_ligne FROM ligne WHERE user = '$user_id' AND link ='$link' AND id_link='$id_link'";
		$select = $db->query($sql);
		$res = $select->fetch();
	}
	return $res;
}

function ajoutLuNotif($db, $user_id, $link, $id_link, $date_notif){
	$date = recupeDateLigneEnLigne($db, $user_id, $link, $id_link);
	if($date != null){
		if($date_notif < $date['date_ligne']){
			$sql = "UPDATE `notification` SET lu='1' WHERE destinataire = '$user_id' AND type = '$link' AND id_lien='$id_link' AND date_creation='$date_notif'";
			$ajout_lu_notification = $db->query($sql);
			//echo $date_notif.' -> '.$date['date_ligne'].' / 1 /<br>';
		}else{
			$sql = "UPDATE `notification` SET lu='0' WHERE destinataire = '$user_id' AND type = '$link' AND id_lien='$id_link' AND date_creation='$date_notif'";
			$ajout_lu_notification = $db->query($sql);
			//echo $date_notif.' -> '.$date['date_ligne'].' / 0 /<br>';
		}
	}
}
?>