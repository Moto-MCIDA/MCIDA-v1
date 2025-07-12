<?php
//////////////////////////////////////////////////////////////////////////
//																		//
// 	    			    Fonction propose - Prive		  		  	    //
//																		//
//////////////////////////////////////////////////////////////////////////

/******************************************************************************************************************************************** */
// fonction recherche_balade va chercher les sorties dont la date est >= a la date du jour
// cette fonction va recuperer toutes balades dont la date est >= a celle du jour et que l'id de l'utilisateur est = a l'id de la personne qui la cree
// puis elle va faire une boucle ligne par ligne afin executer la fonction affiche_balade
/********************************************************************************************************************************************* */
	function rechecher_balade($db){
		$user_id = $_SESSION['user_id'];
		date_default_timezone_set('Europe/Paris');
    	$ajrd = date("Y-m-d"); // on recupere la date du jour dans une variable
		$booleen = $db->query("SELECT count(*) FROM balade WHERE id_createur = '$user_id' AND date_sortie >= '$ajrd'"); // on compte combien de balade on une date <= a la date du jour 
		$bool = $booleen->fetchColumn();
		if($bool >= 1){ // si il y a plus de 1 balade 
			$balade = $db->prepare("SELECT * FROM balade WHERE id_createur = '$user_id' AND date_sortie >= '$ajrd' ORDER BY date_sortie");
			$balade->execute();
			while ($res = $balade->fetch(PDO::FETCH_OBJ)) {
				affiche_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description);// execute la fonction avec affiche_balade avec toutes les info sur la balade en parametre
			}
		}else{
			affiche_pas_balade($db);
		}
	}
/******************************************************************************************************************************************** */
// fonction affiche_balade avec comme parametre la variable de connexion a la db et toutes les infos de la balade 
// dans cette fonction on cree une variable html qui contiendra du code html (partie du tableau) avec a l'interieur les différentes variable de la sortie
/******************************************************************************************************************************************** */
	function affiche_balade($db,$id, $nom, $date_sortie, $id_createur, $description){
		$html = '<tr>';
		$html .= '<td>';
		$html .= '<a href=\'index.php?id='.$id.'\'>';
		$html .= '<div id="new_balade">';
		$html .= '<h5>'.$nom.'</h5>';
		$html .= '<h6>Du : '.$date_sortie.'</h6>';
		$html .= '<h6>Description : '.$description.'</h6>';
		$html .= '<div id="btnMS" style="display: flex;">';
		$html .= '<a id="button" class="supp" onclick="backfunction()" href="delete/delete_balade.php?id_balade='.$id.'">Supprimer</a>';
		$html .= '<a id="button"  onclick="backfunction()" href="modifier_balade.php?id_balade='.$id.'">Modifier</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</a>';
		$html .= '</td>';
		$html .= '</tr>';

		print($html);	
	}
/******************************************************************************************************************************************** */
// fonction affiche_pas_balade avec comme parametre la variable de connexion a la db  
// dans cette fonction on cree une variable html qui contiendra du code html (partie du tableau) avec a l'interieur message signifiant pas de balade
/******************************************************************************************************************************************** */
	function affiche_pas_balade($db){
		$html = '<tr>';
		$html .= '<td>';
		$html .= '<div id="pas_balade">';
		$html .= '<h5>Pas de événement</h5>';
		$html .= '</div>';
		$html .= '</td>';
		$html .= '</tr>';

		print($html);	
	}
/******************************************************************************************************************************************** */
// fonction creer_nouvelle_balade avec comme parametre la variable de connexion a la db  
// dans cette fonction on cree une variable html qui contiendra du code html (formulaire)
// pour cree une nouvelle balade
/******************************************************************************************************************************************** */
	function creer_nouvelle_balade($db){
		$html = '<h1 id="title">Proposer un nouvel événement</h1>';
		$html .= '<form method="post" enctype="multipart/form-data">';
		$html .= '<select name="choix" required>';
		$html .= '<option>Balade</option>';
		$html .= '<option>Réunion</option>';
		$html .= '<option>Restaurant</option>';
		$html .= '<option>Autre</option>';
		$html .= '</select>';
		$html .= '<input type="text" name="nom" placeholder="Nom de l\'évenement ..." required>';
		$html .= '<div style="justify-content: space-around; height: auto; flex-direction: row;">';
		$html .= '<h6 style="color: #1D63EB; font-size: 80%; margin: 0; width: auto; display: flex; flex-direction: column; justify-content: center;">La date de l\'événement :</h6>';
		$html .= '<input style=" width: auto;margin: 2.5px 10px;" type="date" name="date" required>';
		$html .= '</div>';
		$html .= '<textarea name="description" placeholder="Veuillez rentrer la description de l\'évenement ..." required></textarea>';
		$html .= '<div class="input-file-container">';
		$html .= '<p class="file-return">Pas de document</p>';
		$html .= '<input class="input-file" id="my-file" type="file" name="doc[]" multiple accept=".pdf,.gpx,application/pdf,application/gpx+xml">';
		$html .= '<label for="my-file" class="input-file-trigger" tabindex="0">';
		$html .= '+';
		$html .= '</label>';
		$html .= '</div>';
		$html .= '<input type="submit" onclick="backfunction()" name="envoyer" value="Soumettre">';
		$html .= '</form>';

		print($html);	
	}
/******************************************************************************************************************************************** */
// fonction propose_balade avec comme parametre la variable de connexion a la db  
// dans cette fonction on ajout une nouvelle balade avec les information rentrer dans le formulaire de la fonction precedente
/******************************************************************************************************************************************** */
	function propose_balade($db){
		// variables contenant les valeurs rentrer dans les inputs
		$choix = $_POST['choix'];
		$nom = ucwords(addslashes($_POST['nom']));
		$date = $_POST['date'];
		$user_id = $_SESSION['user_id'];
		$description = addslashes($_POST['description']);
		//prend en compte plusieur espace a la suite d'un textarea
    	$text2 = nl2br(htmlentities($description, ENT_QUOTES, 'UTF-8'));
		$doc = $_FILES['doc']["name"][0];
		// on verifie si les varible dessous sont pas vide 
		if($choix&&$nom&&$date&&$description){
			// on regarde si il y a des documents 
			if (!empty($doc)) {
				// si oui on ajoute toutes les variables dans la table balade et on ajoute a la colonne doc la valeurs 1 (qui signifie quil y a des document)
				$ajout_balade=$db->prepare("INSERT INTO `balade`(`type`,`nom`,`date_sortie`,`id_createur`,`description`,`doc`) VALUES ('$choix', '$nom', '$date', '$user_id', '$text2', 1)");
				$ajout_balade->execute();
				// on recuper l'id de la ligne qui vien d'etre inserer 
				$sql_photo = "SELECT id FROM balade WHERE type = '$choix' AND nom = '$nom' AND date_sortie = '$date' AND id_createur = '$user_id'";
			    $select_photo = $db->query($sql_photo);
			    $res_photo = $select_photo->fetch();
				// et on executer la fonction inser_doc afin de cree un dossier pour la balade, et d'y inserer les document 
				inserer_doc($db, $res_photo['id']);
			}else{
				//sinon on ajoute toutes les variables dans la table balade sans rien ajouter a la colonne doc
				$ajout_balade=$db->prepare("INSERT INTO `balade`(`type`,`nom`,`date_sortie`,`id_createur`,`description`) VALUES ('$choix', '$nom', '$date', '$user_id', '$text2')");
				$ajout_balade->execute();
			}
			// on cree une nouvelle notification 
			$sql = "SELECT id FROM balade WHERE type = '$choix' AND nom = '$nom' AND date_sortie = '$date' AND id_createur = '$user_id'";
		    $select = $db->query($sql);
		    $res = $select->fetch();
			creer_notification_creer_balade($db, $user_id, $res['id']);
			// redirection 
			header('Location: balade_propose.php');
		}else{
			// sinon afficher un message pour remplir tout les champs
			echo '<script type="text/javascript">
			       window.onload = function () { alert("Veuillez remplir tous les champs"); } 
			</script>'; 
		}
	}
/******************************************************************************************************************************************** */
// fonction inserer_doc avec comme parametre la variable de connexion a la db et l'id de la sortie 
// on va dabore compter le nombre de document 
// on verifie que le dossier n'existe pas deja ===> si oui on cree un dossier 
// puis apres dans une boucle for on va inserer document par document dans le dossier corespondant avec la fonction inserer_doc_test
/******************************************************************************************************************************************** */
	function inserer_doc($db, $id_balade){
		$myFile = $_FILES['doc'];
        $fileCount = count($myFile["name"]);

        if (!is_dir("document/document_balade/".$id_balade)) { // on verifie si le dossier existe
			mkdir("document/document_balade/".$id_balade, 0777, true);
		}
        for ($i = 0; $i < $fileCount; $i++) { // boucle for afin de faire doc par doc 
        	inserer_doc_test($db, $myFile["tmp_name"][$i], $myFile["name"][$i], $id_balade);
	    }

    } 
/******************************************************************************************************************************************** */
// fonction inserer_doc_test
// regarder l'extension (il faut une extension en .pdf)
// on envoie le fichier vers le bon dossier 
/******************************************************************************************************************************************** */
    function inserer_doc_test($db, $doc, $doc_name, $id_balade){

        $file_extension = strrchr($doc_name, ".");  // on regarde l'extension qu'on mets dans une variable
		
		$file_dest = "document/document_balade/".$id_balade."/".$doc_name; // on mets la destination dans une variable
		//'files/' .$file_name;
		$extension_autorisees = array('.pdf', '.PDF', '.gpx', '.GPX');
 
        if(in_array($file_extension, $extension_autorisees)){ // on verifie que l'extension est bonne 
           	if(move_uploaded_file($doc, $file_dest)){ // on envoie le document 
               echo 'Fichier envoyé avec succès';
            } else {
                echo "Une erreur est survenue lors de l'envoie du fichier";
           	}
        } else {
            echo "Seul les fichiers PDF ou GPX sont autorisées";
        }

    } 
/******************************************************************************************************************************************** */
// fonction modifier_balade
// sert a cree un formulaire prerempli avec les informations de la sortie a modifier 
/******************************************************************************************************************************************** */
	function modifier_balade($db){
		// recuperation des informations de la sortie
		$id_balade = $_GET['id_balade'];
		$sql = "SELECT * FROM balade WHERE id = $id_balade";
	    $select = $db->query($sql);
	    $res = $select->fetch();
		// variable html comprenant du html et des variable de la requet ci-dessus 
		$html = '<h1 id="title">Modifier balade '.$res['nom'].'</h1>';
		$html .= '<form style="height: 100%; overflow-x: auto;" method="post" enctype="multipart/form-data">';
		$html .= '<select name="choix">';
		$html .= '<option>'.$res['type'].'</option>';
		$html .= '<option>Balade</option>';
		$html .= '<option>Réunion</option>';
		$html .= '<option>Restaurant</option>';
		$html .= '<option>Autre</option>';
		$html .= '</select>';
		$html .= '<input type="text" name="nom" value="'.$res['nom'].'"">';
		$html .= '<input type="date" name="date" value="'.$res['date_sortie'].'">';
		$html .= '<textarea name="description">'.$res['description'].'</textarea>';
		if($res['doc'] == 1){
			$html .= '<div id="listDiv">';
	    	$html .= '<p>Document :</p>';
	    	$scandir = scandir("document/document_balade/".$id_balade);
	    	$x = 1;
			foreach($scandir as $fichier){
				if($x != 1 AND $x !=2){
					$html .= '<div id="doc">';
					$html .= '<a href="document/document_balade/'.$id_balade.'/'.$fichier.'">';
					$html .= '<h5>'.$fichier.'</h5>';
					$html .= '</a>';
					$html .= '<a href="delete/supprimer_fichier.php?id_balade='.$id_balade.'&src=../document/document_balade/'.$id_balade.'/'.$fichier.'">Supprimer</a>';
					$html .= '</div>';
					
				}
				$x++;
			}
			$html .= '</div>';	    	
	    }
		$html .= '<div style="margin-top: 5%;" class="input-file-container">';
		$html .= '<p style="margin-bottom: 2.5%; padding-bottom: 15px;" class="file-return">Pas de document</p>';
		$html .= '<input class="input-file" id="my-file" type="file" name="doc[]" multiple accept=".pdf,.gpx,application/pdf,application/gpx+xml">';
		$html .= '<label for="my-file" class="input-file-trigger" tabindex="0">';
		$html .= '+';
		$html .= '</label>';
		$html .= '</div>';
		$html .= '<input type="submit"  onclick="backfunction()" name="envoyer" value="Modifier la balade">';
		$html .= '</form>';
		// afficher ce quil y a dans la variable
		print($html);	
	}

?>