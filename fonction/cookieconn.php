<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mysqli ==> Base de donnée exclusivement Mysql | PDO ==> Tout type de base de donnée (PDO est plus simple que mysqli)			//						
// Connexion a la base de donnée																								//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
try
{
	$db = new PDO('mysql:host=localhost;dbname=mica;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);								// Force les noms de colonnes en minuscule
	$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 					// Reporter les erreurs de PDO
}
catch(Exception $e){
	echo "une erreur est survenue";
	die();
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On vérifie que la variable session est n'existe pas 																			//						
// On vérifie que les variables cookie user et password existe et ne sont pas nulles											//
// Si toutes ces conditions sont validés on peut connecter dirèctement la personne à l'aide des cookie 							//	
// Cela permet aux utilisateurs de ne pas forcement se reconnecter à chaque fois 												//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!isset($_SESSION['user_id']) AND isset($_COOKIE['user']) AND isset($_COOKIE['password']) AND !empty($_COOKIE['user']) AND !empty($_COOKIE['password'])) {
	$email = $_COOKIE['user'];	// on dit que la variable $email est égale a la variable cookie -> user
	$mdp = $_COOKIE['password'];	// on dit que la variable $mdp est égale a la variable cookie -> password
	// On peut après executer la même fonction que la connexion normal afin de se connecter automatiquement
	$select = $db->query("SELECT id FROM utilisateur WHERE email='$email'");
	if($select->fetchColumn()){
		$select = $db->query("SELECT * FROM utilisateur WHERE email='$email'");
		$result = $select->fetch(PDO::FETCH_OBJ);
		if ($result->accepter == 1) {
			if($result->fininscription == 1){
				if (password_verify($mdp, $result->mdp)){
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
}
	

?>