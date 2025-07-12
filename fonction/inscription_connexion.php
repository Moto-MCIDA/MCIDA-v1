<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction demande_inscription() qui recupère les infos rentré dans les champs input											//
// On vérifie d'abord que les infos obligatoires ne sont pas vide 																//
// Ensuite on vérifie que l'email n'existe pas déja dans la d'abord																//
// Si elle existe pas on insert toutes les infos néssesaire dans la db 															//
// Execute la fonction envoie_email_demande_inscription() afin d'envoyer un email a l'admin pour valider l'inscription			//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function demande_inscription($db){
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$pseudo = $_POST['pseudo'];
		$age = $_POST['age'];
		$marque = $_POST['marque'];
		$model = $_POST['model'];
		$cylindre = $_POST['cylindre'];
		$couleur = $_POST['couleur'];
		$raison = addslashes($_POST['raison']);
		$email = $_POST['email'];
		$tel = $_POST['phone'];
		$ville = $_POST['ville'];
		$cp = $_POST['cp'];

		if($nom&$prenom&$pseudo&$age&$marque&$model&$cylindre&$couleur&$raison&$email&$ville&$cp){
			// On vérifie que l'email n'existe pas déja
			$verif_email = $db->query("SELECT count(*) FROM utilisateur WHERE email='$email'");
			$verif_email_bool = $verif_email->fetchColumn();
			if($verif_email_bool == 0){
				// On modifie les variable nom (en mettant tout en majuscule) et prenom (en mettant la première lettre en majuscule)
				$nom_final = strtoupper($nom);
				$prenom_final = ucwords($prenom);
				// Insertion des différentes infos dans la db
				$ajout_utilisateur=$db->prepare("INSERT INTO `utilisateur`(`nom`,`prenom`,`pseudo`,`age`,`marque`,`model`,`cylindre`,`couleur`,`raison`,`email`,`ville`, `cp`,`tel`,`accepter`,`copilote`) VALUES ('$nom_final', '$prenom_final', '$pseudo', '$age', '$marque', '$model', '$cylindre', '$couleur', '$raison', '$email', '$ville', '$cp', '$tel', 0, 0)");
				$ajout_utilisateur->execute();
				// Envoie email admin
				envoie_email_demande_inscription($db, $nom_final, $prenom_final, $pseudo, $age, $marque, $model, $cylindre, $couleur, $raison, $email, $tel, $ville, $cp);
				// Changemant de page
				header('Location: compteur_moto.html');	
			}else{
				echo '<script type="text/javascript">			
					       window.onload = function () { alert("cette addresse email existe déjà"); } 
					</script>'; 
			}				
		}else{																															
		echo '<script type="text/javascript">
			       window.onload = function () { alert("Veuillez remplir tous les champs"); } 
			</script>'; 																											
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction accepter_demande() qui recupère l'email de la personne qu'on veux accepter											//
// On vérifie d'abord qu'il ya une ligne correspondant a cette email dans la db													//
// Ensuite on récupère les infos correspondant et on vérifie que la colonne accepter est = à 0									//
// Si c'est oui on modifie ce cette colonne en la mettant à 1 																	//
// Execute la fonction envoie_email_fin_inscription() afin d'envoyer un email a l'utilisateur pour terminer l'inscription		//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function accepter_demande($db){
		// Récup variable dans le lien a l'aide de la variable get
		$email = $_GET['perso'];
		// Vérification que la personne existe bien dans la db
		$select = $db->query("SELECT id FROM utilisateur WHERE email='$email'");
		if($select->fetchColumn()){
			// Récup tout les info dans la db
			$select = $db->query("SELECT * FROM utilisateur WHERE email='$email'");
			$result = $select->fetch(PDO::FETCH_OBJ);
			// Vérifie que l'utilisateur n'est pas déja accepter
			if ($result->accepter == 0) {
				// On change la colone accepter en 1 puis on envoie un mail à l'utilisateur
				$update = $db->prepare("UPDATE utilisateur SET accepter=1 WHERE email='$email'");
				$update->execute();
				echo "La personne a bien été accepté";
				envoie_email_fin_inscription($db, $email);
			}else{
				echo "La personne a déja été accepté";
			}
		}else{
			echo '<script type="text/javascript">			
			       window.onload = function () { alert("Aucune personne dans la base de donnée à cette email"); } 
			</script>'; 	
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction connexion() qui recupère l'email et le mdp que la personne a rentré     											//
// On vérifie d'abord que les variables sont pas vides 																			//
// Ensuite on vérifie qu'il ya une ligne correspondant a cette email dans la db													//
// Si c'est oui on récupère toutes les info dans la db 																			//
// Pour finir on mes les valeurs récuperer dans des variables session, puis on redirige l'utilisateur vers la page de chargement//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function connexion($db){
		// On récup les valeurs rentré 
		$email = $_POST['email'];
		$mdp = $_POST['mdp'];
		// On verifie si elle sont pas vide 
		if($email&$mdp){
			// On verifie que le compte existe
			$select = $db->query("SELECT id FROM utilisateur WHERE email='$email'");
			if($select->fetchColumn()){
				// On récup les infos dans la db
				// On vérifie si il a été accepter et qu'il a fini son inscription
				$select = $db->query("SELECT * FROM utilisateur WHERE email='$email'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				if ($result->accepter == 1) {
					if($result->fininscription == 1){
						// On vérifie que le mdp correspond au mdp de la db
						if (password_verify($mdp, $result->mdp)){
							// On regard si l'utilisateur a choisi que l'on se souvienne de lui
							// Si oui on créer les différents cookies
							if(isset($_POST['rememberme'])){
								setcookie('user',$email,time()+365*24*3600,'/','mcida.fr');
								setcookie('password',$mdp,time()+365*24*3600,'/','mcida.fr');
							}
							// On créer des variables session qui contiendrons les différentes valeurs dans la db
							$_SESSION['user_id'] = $result->id;
							$_SESSION['user_nom'] = $result->nom;
							$_SESSION['user_prenom'] = $result->prenom;
							$_SESSION['user_pseudo'] = $result->pseudo;
							$_SESSION['user_age'] = $result->age;
							$_SESSION['user_marque'] = $result->marque;
							$_SESSION['user_model'] = $result->model;
							$_SESSION['user_cylindre'] = $result->cylindre;
							$_SESSION['user_couleur'] = $result->couleur;
							$_SESSION['user_raison'] = $result->raison;
							$_SESSION['user_email'] = $result->email;
							$_SESSION['user_ville'] = $result->ville;
							$_SESSION['user_cp'] = $result->cp;
							$_SESSION['user_tel'] = $result->tel;
							$_SESSION['user_adresse1'] = $result->adresse1;
							$_SESSION['user_adresse2'] = $result->adresse2;
							$_SESSION['user_copilote'] = $result->copilote;
							$_SESSION['user_nom_cop'] = $result->nom_cop;
							$_SESSION['user_prenom_cop'] = $result->prenom_cop;
							// On se redirige vers la page de chargement
							header('Location: compteur_moto_connexion.html');
						}else{
							echo '<script type="text/javascript">			
							       window.onload = function () { alert("Le mot de passe ne correpond pas à ladresse email"); } 
							</script>'; 
						}
					}else{
						echo '<script type="text/javascript">			
						       window.onload = function () { alert("Vous avez pas fini votre inscription"); } 
						</script>'; 
					}
				}else{
					echo '<script type="text/javascript">			
					       window.onload = function () { alert("Votre demande na pas encore été accepter"); } 
					</script>'; 
				}
			}else{
				echo '<script type="text/javascript">			
				       window.onload = function () { alert("Aucune personne dans la base de donnée à cette email"); } 
				</script>'; 
			}
		}else{																															
		echo '<script type="text/javascript">
			       window.onload = function () { alert("Veuillez remplir tous les champs"); } 
			</script>'; 																											
		}

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction imageProfilAjout(), cette fonction insert les différentes images de profil dans le dossier corespandeant(email)		//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function imageProfilAjout($email, $photo, $name){	
		//on vérifie si la valeur photo n'est pa vide																						
		if (!empty($photo)) { 	
			// On s'occupe des dimension de l'image
			$taille = getimagesize($photo);																							    
			$largeur = $taille[0];																										
			$hauteur = $taille[1];																										
			$largeur_miniature = $taille[0];																									
			$hauteur_miniature = $taille[1];
			// On change l'extension de l'image en .jpg et certaine info de l'image																
			$im = imagecreatefromjpeg($photo);																							
			$im_miniature = imagecreatetruecolor($largeur_miniature, $hauteur_miniature);												
			imagecopyresampled($im_miniature, $im, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur);		
			// On insert  la nouvelle image dans le bon dossier en modifiant le nom		
			imagejpeg($im_miniature, './membres/image/utilisateurs/'.$email.'/'.$email.'_'.$name.'.jpg');			
		}else{
			// On copie l'image de base dans la bon dossier en le renoment correctement
			copy('./image/inscription/anonyme_'.$name.'.jpg','./membres/image/utilisateurs/'.$email.'/'.$email.'_'.$name.'.jpg');	
		}																																	
	}	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction termine_inscription() qui recupère l'email avec la variable get, et aussi les différente variable rentrer 			//
// On vérifie d'abord que les variables obligatoire sont pas vides et on créer le dossier pour les photo 						//
// Ensuite on vérifie que le mot de passe correspond à la confiramtion de mot de passe 											//
// Si c'est oui insert les infos dans la db (en hachant le mdp)																	//
// On verifie ensuite la valeur de la variable copilote 																		//
// Si c'est égale à 1 on inser les valeurs dans la db (copilote = 1 et on insert nom et prenom) 								//
// De plus on execute la fonction imageProfilAjout() afin d'ajouter les différents image de profil dans le dossier correspondant//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function termine_inscription($db){
		// Récup les différentes variables 
		$email = $_GET['perso'];
		$photoUserProfil = $_FILES['photoProfil']['tmp_name'];
		$photoUserMoto = $_FILES['photoMoto']['tmp_name'];
		$copilote = $_POST['copilote'];
		$mdp = $_POST['mdp'];
		$cmdp = $_POST['cmdp'];
		$adrs1 = addslashes($_POST['adress1']);
		$adrs2 = addslashes($_POST['adress2']);
		// On vérifie par précaution que le dossier existe pas, ensuite on le crée
		if (!is_dir("./membres/image/utilisateurs/".$email)) {
			mkdir("./membres/image/utilisateurs/".$email, 0777, true);
		}
		// On vérifie que les variables ne sont pas vides
		if($mdp&$cmdp&$adrs1){
			if ($mdp == $cmdp) {
				// On hash le mdp et remplace dans la db les différentes valeures prédefinie par les variables
				$mdp_fin = password_hash($mdp, PASSWORD_DEFAULT);
				$update_mdp = $db->prepare("UPDATE utilisateur SET mdp='$mdp_fin', adresse1 = '$adrs1', adresse2 = '$adrs2', finInscription = 1 WHERE email='$email'");
				$update_mdp->execute();
				// On vérifie le choix fais par l'utilisateur pour le copilote
				if ($copilote == 1) {
					// On récup les variables relatif au copilote 
					$photoUserCopilote = $_FILES['photoProfilCop']['tmp_name'];
					$copilote_nom = $_POST['copilote_nom'];
					$copilote_prenom = $_POST['copilote_prenom'];
					// On vérifie quel ne sont pas vide
					if($copilote_nom&$copilote_prenom){
						// On modifie les variable correctement
						$nom_final = strtoupper($copilote_nom);
						$prenom_final = ucwords($copilote_prenom);
						// On appele la fonction imageProfilAjout() pour ajouter les différentes images
						imageProfilAjout($email, $photoUserProfil, 'profil');
						imageProfilAjout($email, $photoUserMoto, 'moto');
						imageProfilAjout($email, $photoUserCopilote, 'copilote');
						// On modifie les valeurs dans la db
						$update = $db->prepare("UPDATE utilisateur SET copilote=1, nom_cop='$nom_final', prenom_cop='$prenom_final' WHERE email='$email'");
						$update->execute();
						// On se redirige sur la page connexion
						header('Location: connexion.php');
					}else{																															
						echo '<script type="text/javascript">
							       window.onload = function () { alert("Veuillez remplir les champs nom et prenom"); } 
							</script>'; 																											
					}
				}else{
					// On appele la fonction imageProfilAjout() pour ajouter les différentes images
					imageProfilAjout($email, $photoUserProfil, 'profil');
					imageProfilAjout($email, $photoUserMoto, 'moto');
					header('Location: connexion.php');
				}
			}else{
				echo '<script type="text/javascript">
					       window.onload = function () { alert("le mot de passe et la confirmation de mot de passe ne corresponde pas "); } 
					</script>'; 
			}
		}else{
			echo '<script type="text/javascript">
				       window.onload = function () { alert("Veuillez remplir les champs obligatoir *"); } 
				</script>'; 
		}
		
	}

?>