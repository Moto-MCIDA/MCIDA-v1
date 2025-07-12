<?php 
	function bloc1($db){
		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

		$html = '<div id="bloc1" class="bloc">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<label for="photo_profil"><img src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_profil.jpg"></label>';
		$html .= '<input id="photo_profil" type="file" name="photo_profil">';
		$html .= '<small style="margin: auto; padding-top: 2.5%; text-align: center;">Cliquer sur la photo pour la modifier</small>';
		$html .= '</div>';
		$html .= '<div><h4>Nom : </h4>';
		$html .= '<input type="text" name="nom" value="'.$profil['nom'].'"></div>';
		$html .= '<div><h4>Prénom : </h4>';
		$html .= '<input type="text" name="prenom" value="'.$profil['prenom'].'"></div>';
		$html .= '<div><h4>Pseudo : </h4>';
		$html .= '<input type="text" name="pseudo" value="'.$profil['pseudo'].'"></div>';
		$html .= '<div><h4>Age : </h4>';
		$html .= '<input type="date" name="date" value="'.$profil['age'].'"></div>';
		$html .= '<div id="buttonValid"><input type="submit" name="profil" value="Valider modifications"></div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn1">Suivant</p>';
		$html .= '</div>';
		$html .= '</div>';

		bloc2($db);		
		print($html);
	}
	function bloc2($db){
		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

		$html = '<div id="bloc2" class="none_b">';
		$html .= '<div id="grandTableau">';
		$html .= '<div id="notifParam">';
		
		if ($profil['public'] == 1) {
			$public_check = 'checked="true"';
		}else{
			$public_check = '';
		}
		if ($profil['acpt_mail'] == 1) {
			$mail_check = 'checked="true"';
		}else{
			$mail_check = '';
		}
		$html .= '<div>';
		$html .= '<input type="checkbox" id="switch_mail" name="mail_checkbox" class="switch-input" value="yes" '.$mail_check.'>';
		$html .= '<label for="switch_mail" class="switch" onclick="choix()"></label>';
		$html .= '<small>Recevoir toutes les notifications du site par email pour rester informé</small>';
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<input type="checkbox" id="switch" name="public_checkbox" class="switch-input" value="yes" '.$public_check.'>';
		$html .= '<label for="switch" class="switch" onclick="choix()"></label>';
		$html .= '<small>Afficher la photo de votre moto et votre pseudo</small>';
		$html .= '</div>';
		$html .= '<div id="bloc5" class="none_b">';
		$html .= '<div id="scrollerItems">';
		$html .= '<img style="width: 80%; height: 55%;" src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_moto.jpg">';
		$html .= '<h5>'.$profil['pseudo'].'</h5>';
		$html .= '</div>';
		$html .= '</div>';


		$html .= '</div>';
		$html .= '<div><h4>Téléphone : </h4>';
		$html .= '<input type="tel" name="phone" pattern="[0-9]{10}" value="'.$profil['tel'].'"></div>';
		$html .= '<div><h4>CP : </h4>';
		$html .= '<input type="text" name="cp" value="'.$profil['cp'].'"></div>';
		$html .= '<div><h4>Ville : </h4>';
		$html .= '<input type="text" name="ville" value="'.$profil['ville'].'"></div>';
		$html .= '<div><h4>Adresse : </h4>';
		$html .= '<input type="text" name="adress1" value="'.$profil['adresse1'].'"></div>';
		$html .= '<div id="buttonValid"><input type="submit" name="profil" value="Valider modifications"></div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn2_p">Précedent</p>';
		$html .= '<p id="buttonn2_s">Suivant</p>';
		$html .= '</div>';
		$html .= '</div>';

		bloc3($db);		
		print($html);
	}
	
	function bloc3($db){
		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

		$html = '<div id="bloc3" class="none_b">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<label for="photo_moto"><img src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_moto.jpg"></label>';
		$html .= '<input id="photo_moto" type="file" name="photo_moto">';
		$html .= '<small style="margin: auto; padding-top: 2.5%;">Cliquer sur la photo pour la modifier</small>';
		$html .= '</div>';
		$html .= '<div><h4>Marque : </h4>';
		$html .= '<select name="marque">';
		$html .= '<option>'.$profil['marque'].'</option>';
		$html .= '<option>Aprilia</option>';
		$html .= '<option>Benelli</option>';
		$html .= '<option>Bimota</option>';
		$html .= '<option>BMW</option>';
		$html .= '<option>Ducati</option>';
		$html .= '<option>Harley-Davidson</option>';
		$html .= '<option>Honda</option>';
		$html .= '<option>Husqvarna</option>';
		$html .= '<option>Kawasaki</option>';
		$html .= '<option>KTM</option>';
		$html .= '<option>Moto Guzzi</option>';
		$html .= '<option>MV Agusta</option>';
		$html .= '<option>Norton</option>';
		$html .= '<option>Suzuki</option>';
		$html .= '<option>Triumph</option>';
		$html .= '<option>Yamaha</option>';
		$html .= '<option>Autre</option>';
		$html .= '<option>Autre</option>';
		$html .= '</select></div>';
		$html .= '<div><h4>Model : </h4>';
		$html .= '<input type="text" name="model" value="'.$profil['model'].'"></div>';
		$html .= '<div><h4>Cylindrée : </h4>';
		$html .= '<input type="number" name="cylindre" value="'.$profil['cylindre'].'"></div>';
		$html .= '<div><h4>Couleur : </h4>';
		$html .= '<input type="text" name="couleur" value="'.$profil['couleur'].'"></div>';
		$html .= '<div id="buttonValid"><input type="submit" name="profil" value="Valider modifications"></div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn3">Précedent</p>';
		$html .= '<p id="buttonn3_s">Suivant</p>';
		$html .= '</div>';
		$html .= '</div>';
		bloc4($db);
		print($html);	
	}

	function bloc4($db){
		
		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

		
		if ($profil['copilote'] == 1) {
			$copilote_check = 'checked="true"';
		}else{
			$copilote_check = '';
		}

		if(file_exists('image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_copilote.jpg')){
			$copilote_img = 'src="image/utilisateurs/'.$profil['email'].'/'.$profil['email'].'_copilote.jpg"';
		}else{
			$copilote_img = 'src="../image/inscription/anonyme_copilote.jpg"';
		}
		$html = '<div id="bloc4" class="none_b">';
		$html .= '<div>';
		$html .= '<p>Copilote :</p>';
		$html .= '<input type="checkbox" id="switch_cop" name="cop_checkbox" class="switch-input" value="yes" '.$copilote_check.'>';
		$html .= '<label for="switch_cop" class="switch" onclick="choix_cop()"></label>';
		$html .= '</div>';
		$html .= '<div id="bloc6" class="none_b">';
		$html .= '<div id="grandTableau">';
		$html .= '<div>';
		$html .= '<label for="photo_copilote"><img '.$copilote_img.' ></label>';
		$html .= '<input id="photo_copilote" type="file" name="photo_copilote">';
		$html .= '<small style="margin: auto; padding-top: 2.5%;">Cliquer sur la photo pour la modifier</small>';
		$html .= '</div>';
		$html .= '<div><h4>Copilote de '.$profil['nom'].' '.$profil['prenom'].'</h4></div>';
		$html .= '<div><h4>Nom : </h4>';
		$html .= '<input type="text" name="nom_cop" value="'.$profil['nom_cop'].'"></div>';
		$html .= '<div><h4>Prénom : </h4>';
		$html .= '<input type="text" name="prenom_cop" value="'.$profil['prenom_cop'].'"></div>';
		$html .= '<div id="buttonValid"><input type="submit" name="profil" value="Valider modifications"></div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div id="button_bloc">';
		$html .= '<p id="buttonn4">Précedent</p>';
		$html .= '</div>';
		$html .= '</div>';
		print($html);
		
	}
	

	function modifier_profil($db){
		$user_id = $_SESSION['user_id'];

		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

        $email = $profil['email'];

		$nom = strtoupper($_POST['nom']);
		$prenom = ucwords($_POST['prenom']);
		$pseudo = $_POST['pseudo'];
		$age = $_POST['date'];

		$marque = $_POST['marque'];
		$model = $_POST['model'];
		$cylindre = $_POST['cylindre'];
		$couleur = $_POST['couleur'];

		$tel = $_POST['phone'];
		$ville =  addslashes($_POST['ville']);
		$cp = $_POST['cp'];
		$adresse1 =  addslashes($_POST['adress1']);
		$adresse2 =  addslashes($_POST['adress2']);

		if ($nom&&$prenom&&$pseudo&&$age&&$marque&&$model&&$cylindre&&$couleur&&$ville&&$cp&&$adresse1) {
			$modifier_profil = $db->prepare("UPDATE utilisateur SET nom = '$nom', prenom = '$prenom', pseudo = '$pseudo', age = '$age' , marque = '$marque', model = '$model', cylindre = '$cylindre', couleur = '$couleur', ville = '$ville', cp = '$cp', tel = '$tel', adresse1 = '$adresse1', adresse2 = '$adresse2' WHERE id='$user_id'");
			$modifier_profil->execute();
			modifier_photo($db, $email);
		}

		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();

		
		if (isset($_POST['public_checkbox']) and ($_POST['public_checkbox']) ) {
			$modifier_public= $db->prepare("UPDATE utilisateur SET public = 1 WHERE id='$user_id'");
			$modifier_public->execute();
		}else{
			$modifier_public = $db->prepare("UPDATE utilisateur SET public = 0 WHERE id='$user_id'");
			$modifier_public->execute();
		}
		if (isset($_POST['mail_checkbox']) and ($_POST['mail_checkbox']) ) {
			$modifier_public= $db->prepare("UPDATE utilisateur SET acpt_mail = 1 WHERE id='$user_id'");
			$modifier_public->execute();
		}else{
			$modifier_public = $db->prepare("UPDATE utilisateur SET acpt_mail = 0 WHERE id='$user_id'");
			$modifier_public->execute();
		}
		if (isset($_POST['cop_checkbox']) and ($_POST['cop_checkbox']) ) {
			$modifier_public= $db->prepare("UPDATE utilisateur SET copilote = 1 WHERE id='$user_id'");
			$modifier_public->execute();
			$nom_cop = strtoupper($_POST['nom_cop']);
			$prenom_cop = ucwords($_POST['prenom_cop']);
			if ($nom_cop&&$prenom_cop) {
				$modifier_profil_cop = $db->prepare("UPDATE utilisateur SET nom_cop = '$nom_cop', prenom_cop = '$prenom_cop' WHERE id='$user_id'");
				$modifier_profil_cop->execute();
			}
		}else{
			$modifier_public = $db->prepare("UPDATE utilisateur SET copilote = 0 WHERE id='$user_id'");
			$modifier_public->execute();
		}
		header('Location: parametre.php');
	}


	function imageProfilUpdate($email, $photo, $name){																							
		if (!empty($photo)) { 	
			$taille = getimagesize($photo);																							    
			$largeur = $taille[0];																										
			$hauteur = $taille[1];																										
			$largeur_miniature = $taille[0];																									
			$hauteur_miniature = $taille[1];																
			$im = imagecreatefromjpeg($photo);																							
			$im_miniature = imagecreatetruecolor($largeur_miniature, $hauteur_miniature);												
			imagecopyresampled($im_miniature, $im, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur);				
			imagejpeg($im_miniature, 'image/utilisateurs/'.$email.'/'.$email.'_'.$name.'.jpg');			
		}
	}	
	function modifier_photo($db, $email){
		$id = $_SESSION['user_id'];
        $sql_profil = "SELECT * FROM `utilisateur` WHERE id = $id";
        $profil_select = $db->query($sql_profil);
        $profil = $profil_select->fetch();
        
		$photoUserProfil = $_FILES['photo_profil']['tmp_name'];
		$photoUserMoto = $_FILES['photo_moto']['tmp_name'];
		
		
		if (isset($_POST['cop_checkbox']) and ($_POST['cop_checkbox']) ) {
			$photoUserCopilote = $_FILES['photo_copilote']['tmp_name'];

			imageProfilUpdate($email, $photoUserProfil, 'profil');
			imageProfilUpdate($email, $photoUserMoto, 'moto');
			imageProfilUpdate($email, $photoUserCopilote, 'copilote');
		}else{
			imageProfilUpdate($email, $photoUserProfil, 'profil');
			imageProfilUpdate($email, $photoUserMoto, 'moto');
		}
		
	}


	function modifier_public($db){
		$user_id = $_SESSION['user_id'];

		if (isset($_POST['public_checkbox']) and ($_POST['public_checkbox']) ) {
			$modifier_public= $db->prepare("UPDATE utilisateur SET public = 1 WHERE id='$user_id'");
			$modifier_public->execute();
		}else{
			$modifier_public = $db->prepare("UPDATE utilisateur SET public = 0 WHERE id='$user_id'");
			$modifier_public->execute();
		}
		
		header('Location: parametre.php');
	}
?>