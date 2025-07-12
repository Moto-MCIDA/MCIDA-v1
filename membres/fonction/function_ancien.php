<?php
function ancien_balade($db){
	date_default_timezone_set('Europe/Paris');
    $ajrd = date("Y-m-d");
	$booleen = $db->query("SELECT count(*) FROM balade WHERE date_sortie <= '$ajrd'");
	$bool = $booleen->fetchColumn();
	if($bool >= 1){
		$balade = $db->prepare("SELECT * FROM balade WHERE date_sortie <= '$ajrd' ORDER BY date_sortie DESC");
		$balade->execute();
		while ($res = $balade->fetch(PDO::FETCH_OBJ)) {
			affiche_ancien_balade($db,$res->id, $res->nom, $res->date_sortie, $res->id_createur, $res->description);
		}
	}else{
		echo 'pas d\'ancienne balade';
	}
}

function affiche_ancien_balade($db, $id, $nom, $date_sortie, $id_createur, $description){
	$sql = "SELECT email, prenom, nom FROM utilisateur WHERE id = $id_createur";
    $select = $db->query($sql);
    $res = $select->fetch();
	$html = '<tr>';
	$html .= '<td>';
	$html .= '<a href="message/message_groupe_balade.php?id='.$id.'">';
	$html .= '<div id="ancien_balade">';
	$html .= '<h5 style="display: flex;flex-direction: column;justify-content: center;">'.$nom.'</h5>';
	$html .= '<h6>Du : '.$date_sortie.'</h6>';
	$html .= '<h6>Proposé par : '.$res['nom'].' '.$res['prenom'].'</h6>';
	$html .= '<div id="image_bloc">';
	$html .= '<div id="img_ab">';
	$chem_img = 'document/photo_balade/'.$id;
	if (is_dir($chem_img)) {
		$handle  = opendir($chem_img);
		while ($file = readdir($handle)) {
		  if(preg_match ("!(\.jpg|\.jpeg)$!i", $file)) {
		    $listef[] = $file;
		  }
		}
		$html .= "<img id=\"photo_reload\" src=\"".$chem_img."/".$listef[rand(0, count($listef)-1)]."\"/>";
	}else{
		$html .= '<img src="image/utilisateurs/'.$res['email'].'/'.$res['email'].'_profil.jpg">';
	}
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</a>';
	$html .= '</td>';
	$html .= '</tr>';
	print($html);				
}


function ancienne_balade_info($db, $id_balade) {
    $sql = "SELECT * FROM balade WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_balade]);
    $balade = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($balade) {
        $createur = recup_nom_utilisateur($db, $balade['id_createur']);

        echo "<div id='information'>";
        echo "<h2>" . htmlspecialchars($balade['nom']) . "</h2>";

        echo "<div class='info-section'>";
        echo "<strong>Date :</strong> " . htmlspecialchars($balade['date_sortie']);
        echo "</div>";

        echo "<div class='info-section'>";
        echo "<strong>Description :</strong><br>" . nl2br(htmlspecialchars($balade['description']));
        echo "</div>";

        echo "<div class='info-section'>";
        echo "<strong>Créée par :</strong> " . htmlspecialchars($createur);
        echo "</div>";

        // // Documents attachés
        // $stmt_docs = $db->prepare("SELECT * FROM balade WHERE id_balade = ?");
        // $stmt_docs->execute([$id_balade]);
        // $docs = $stmt_docs->fetchAll(PDO::FETCH_ASSOC);
        // if ($docs) {
        //     echo "<div class='info-section'>";
        //     echo "<strong>Documents :</strong><br>";
        //     foreach ($docs as $doc) {
        //         echo "<a href='" . htmlspecialchars($doc['chemin']) . "' target='_blank' id='document'>📎 " . htmlspecialchars($doc['nom']) . "</a><br>";
        //     }
        //     echo "</div>";
        // }

        echo "<a href='message_groupe.php?id=" . $id_balade . "'><div id='boutton'>Accéder au groupe</div></a>";

        echo "<h2 style='margin-top: 30px;'>Participants</h2>";
        echo "<div id='participants-list'>";

        $stmt_participants = $db->prepare("SELECT utilisateur.nom, utilisateur.prenom, utilisateur.email, utilisateur.id FROM balade_membre JOIN utilisateur ON utilisateur.id = balade_membre.id_utilisateur WHERE id_balade = ?");
        $stmt_participants->execute([$id_balade]);

        while ($row = $stmt_participants->fetch(PDO::FETCH_ASSOC)) {
            $img_path = 'img/photos_profil/' . strtolower($row['prenom']) . '.png';
            if (!file_exists($img_path)) {
                $img_path = 'img/default.png';
            }

            echo "<div class='participant-card'>";
            echo "<img src='" . $img_path . "' alt='photo' >";
            echo "<span> ". htmlspecialchars($row['prenom'] . " " . $row['nom']) ." </span>";
            echo "</div>";
        }

        echo "</div>"; // end #participants-list


        echo "</div>"; // end #information
    } else {
        echo "<p>❌ Balade introuvable.</p>";
    }
}

function recup_nom_utilisateur($db, $id_utilisateur) {
    $sql = "SELECT nom, prenom FROM utilisateur WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_utilisateur]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res ? ($res['nom'] . ' ' . $res['prenom']) : 'Inconnu';
}

function affiche_reponses_participants($db, $id_balade) {
    echo "<div class='info-section'>";
    echo "<strong>Réponses complémentaires des participants :</strong><br>";

    $sql = "SELECT u.prenom, u.nom, br.reponse FROM balade_reponses br JOIN utilisateur u ON u.id = br.id_utilisateur WHERE br.id_balade = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_balade]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($res) {
        echo "<ul>";
        foreach ($res as $r) {
            echo "<li><strong>" . htmlspecialchars($r['prenom'] . ' ' . $r['nom']) . " :</strong> " . htmlspecialchars($r['reponse']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune réponse enregistrée.";
    }

    echo "</div>";
}
?>