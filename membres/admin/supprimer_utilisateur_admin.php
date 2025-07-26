<?php
include("../../fonction/connexion_db.php");

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];

    // 1. Récupérer l'ID de l'utilisateur à partir de son email
    $stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $id_utilisateur = $user['id'];

        // 2. Supprimer les dépendances dans les autres tables
        $tables = [
            ['Message_tous',      'id_utilisateur'],
            ['Message_groupe',    'id_utilisateur'],
            ['Message',           'expediteur'],
            ['Message',           'destinataire'],
            ['Balade_membre',     'id_utilisateur'],
            ['Balade',            'Id_createur']
        ];

        foreach ($tables as [$table, $col]) {
            $stmt = $db->prepare("DELETE FROM `$table` WHERE `$col` = :id");
            $stmt->execute([':id' => $id_utilisateur]);
        }

        // 3. Supprimer l'utilisateur
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->execute([':id' => $id_utilisateur]);
    }
}

header('Location: utilisateur_admin.php');
exit();
?>