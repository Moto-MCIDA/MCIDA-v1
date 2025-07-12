<?php 
	function recupe_info_balade($db){
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d");
		$booleen = $db->query("SELECT count(*) FROM balade");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$balade = $db->prepare("SELECT * FROM balade ORDER BY date_sortie DESC");
			$balade->execute();
			while ($res = $balade->fetch(PDO::FETCH_OBJ)) {
				affiche_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description);
			}
		}else{
			echo 'pas d\'ancienne balade';
		}
    	
	}

	function affiche_balade($db, $id, $nom, $date_sortie, $id_createur, $description){
		$sql = "SELECT email, prenom, nom FROM utilisateur WHERE id = $id_createur";
	    $select = $db->query($sql);
	    $res = $select->fetch();

		$html = '<tr>';
		$html .= '<td>';
		$html .= '<a href=\'balade_admin_info_membre.php?id='.$id.'\'>';
		$html .= '<div id="new_balade">';
		$html .= '<h5>'.$nom.'</h5>';
		$html .= '<h6>Du : '.$date_sortie.'</h6>';
		$html .= '<h6>Proposé par : '.$res['nom'].' '.$res['prenom'].'</h6>';
		$html .= '<div id="image_profil_propose">';
		$html .= '<img src="../image/utilisateurs/'.$res['email'].'/'.$res['email'].'_profil.jpg">';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</a>';
		$html .= '</td>';
		$html .= '</tr>';

		print($html);					
	}
	function affiche_membre_balade($db, $id){
		$booleen = $db->query("SELECT count(*) FROM balade_membre WHERE id_balade = '$id'");
		$bool = $booleen->fetchColumn();
		if($bool >= 1){
			$balade = $db->prepare("SELECT * FROM balade_membre WHERE id_balade = '$id' ORDER BY reponse ASC");
			$balade->execute();
	    	$html = '<h5>Réponse balade :</h5>';
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
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;">'.$res_profil['nom'].'</td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;">'.$res_profil['prenom'].'</td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;">'.$res_description['nb_prs'].'</td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;"></td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;"></td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;"></td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;"></td>';
			    $html .= '<td style="
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: 1px solid black;">'.$rep.'</td>';
			    $html .= '</tr>';
			}
			print($html) ;
		}
	}

?>