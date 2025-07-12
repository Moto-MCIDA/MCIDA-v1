<?php
include("../../fonction/connexion_db.php");

if (
    isset($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['age'], $_POST['marque'], $_POST['model'],
          $_POST['cylindre'], $_POST['couleur'], $_POST['email'], $_POST['ville'], $_POST['cp'], $_POST['tel'])
) {
    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $pseudo     = $_POST['pseudo'];
    $age        = $_POST['age'];
    $marque     = $_POST['marque'];
    $model      = $_POST['model'];
    $cylindre   = $_POST['cylindre'];
    $couleur    = $_POST['couleur'];
    $raison     = $_POST['raison'] ?? 'xxx';
    $email      = $_POST['email'];
    $ville      = $_POST['ville'];
    $cp         = $_POST['cp'];
    $tel        = $_POST['tel'];
    $adresse1   = $_POST['adresse1'] ?? 'xxx';
    $adresse2   = $_POST['adresse2'] ?? 'xxx';
    $accepter   = 1; 
    $copilote   = $_POST['copilote'] ?? 0;
    $nom_cop    = $_POST['nom_cop'] ?? '';
    $prenom_cop = $_POST['prenom_cop'] ?? '';
    $public     = $_POST['public'] ?? 1;
    $cotiser    = $_POST['cotiser'] ?? null;

    $sql = "INSERT INTO utilisateur 
        (nom, prenom, pseudo, age, marque, model, cylindre, couleur, raison, email, ville, cp, tel, adresse1, adresse2, accepter, copilote, nom_cop, prenom_cop, public, cotiser) 
        VALUES 
        (:nom, :prenom, :pseudo, :age, :marque, :model, :cylindre, :couleur, :raison, :email, :ville, :cp, :tel, :adresse1, :adresse2, :accepter, :copilote, :nom_cop, :prenom_cop, :public, :cotiser)";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':nom'        => $nom,
        ':prenom'     => $prenom,
        ':pseudo'     => $pseudo,
        ':age'        => $age,
        ':marque'     => $marque,
        ':model'      => $model,
        ':cylindre'   => $cylindre,
        ':couleur'    => $couleur,
        ':raison'     => $raison,
        ':email'      => $email,
        ':ville'      => $ville,
        ':cp'         => $cp,
        ':tel'        => $tel,
        ':adresse1'   => $adresse1,
        ':adresse2'   => $adresse2,
        ':copilote'   => $copilote,
        ':nom_cop'    => $nom_cop,
        ':prenom_cop' => $prenom_cop,
        ':accepter'   => $accepter,
        ':public'     => $public,
        ':cotiser'    => empty($cotiser) ? null : $cotiser,
    ]);
}

header('Location: utilisateur_admin.php');
exit();
?>