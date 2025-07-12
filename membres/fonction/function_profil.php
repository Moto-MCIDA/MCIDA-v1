<?php 

	function recuper_info($db){
		$id = $_GET['id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil = $db->query($sql_profil);
        $res_profil = $profil->fetch();

    	return $res_profil;
	}

	function affiche_profil($db){
		$profil = recuper_info($db);

		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d");
    	$age_fin = date_diff(date_create($profil['age']), date_create($ajrd));

		$html = '<div id="bloc1" class="bloc">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<img src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_profil.jpg">';
		$html .= '</div>';
		$html .= '<div><h4>Nom : </h4>&ensp;';
		$html .= '<h4>'.$profil['nom'].'</h4></div>';
		$html .= '<div><h4>Prénom : </h4>&ensp;';
		$html .= '<h4>'.$profil['prenom'].'</h4></div>';
		$html .= '<div><h4>Pseudo : </h4>&ensp;';
		$html .= '<h4>'.$profil['pseudo'].'</h4></div>';
		$html .= '<div><h4>Age : </h4>&ensp;';
		$html .= '<h4>'.$age_fin->format('%y').'</h4></div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn1">Suivant</p>';
		$html .= '</div>';
		$html .= '</div>';
		
		affiche_moto($db);		
		print($html);		
	}

	function affiche_moto($db){
		$profil = recuper_info($db);

		$html = '<div id="bloc2" class="none_b">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<img src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_moto.jpg">';
		$html .= '</div>';
		$html .= '<div><h4>Marque : </h4>&ensp;';
		$html .= '<h4>'.$profil['marque'].'</h4></div>';
		$html .= '<div><h4>Model : </h4>&ensp;';
		$html .= '<h4>'.$profil['model'].'</h4></div>';
		$html .= '<div><h4>Cylindrée : </h4>&ensp;';
		$html .= '<h4>'.$profil['cylindre'].'</h4></div>';
		$html .= '<div><h4>Couleur : </h4>&ensp;';
		$html .= '<h4>'.$profil['couleur'].'</h4></div>';
		$html .= '</div>';
		if ($profil['copilote'] == 1) {
			$html .= '<div id="button_bloc">';
			$html .= '<p id="buttonn2_p">Précedent</p>';
			$html .= '<p id="buttonn2_s">Suivant</p>';
			$html .= '</div>';
			$html .= '</div>';
			affiche_copilote($db);
		}else{
			$html .= '<div id="button_bloc">';
			$html .= '<p id="buttonn2_p">Précedent</p>';
			$html .= '<p style="display: none;" id="buttonn2_s">Suivant</p>';
			$html .= '</div>';
			$html .= '</div>';
		}		
		print($html);		
	}

	function affiche_copilote($db){
		$profil = recuper_info($db);

		$html = '<div id="bloc3" class="none_b">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<img src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_copilote.jpg">';
		$html .= '</div>';
		$html .= '<div><h4>Copilote de '.$profil['nom'].' '.$profil['prenom'].'</h4></div>';
		$html .= '<div><h4>Nom : </h4>&ensp;';
		$html .= '<h4>'.$profil['nom_cop'].'</h4></div>';
		$html .= '<div><h4>Prénom : </h4>&ensp;';
		$html .= '<h4>'.$profil['prenom_cop'].'</h4></div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn3">Précedent</p>';
		$html .= '</div>';
		$html .= '</div>';
		
		print($html);		
	}
?>