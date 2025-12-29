<?php
session_start();
require_once "pdo.php";

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "ID de profil manquant";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT Profile.*, users.name as user_name 
                       FROM Profile 
                       JOIN users ON Profile.user_id = users.user_id
                       WHERE profile_id = :pid");
$stmt->execute(array(':pid' => $_GET['profile_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($profile === false) {
    $_SESSION['error'] = "Profil non trouvé";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Voir le Profil - Gestion de Profils</title>
</head>
<body>
<div class="container">
    <h1>Profil de <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?></h1>
    
    <p><strong>Prénom:</strong> <?= htmlentities($profile['first_name']) ?></p>
    <p><strong>Nom:</strong> <?= htmlentities($profile['last_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlentities($profile['email']) ?></p>
    <p><strong>Titre:</strong> <?= htmlentities($profile['headline']) ?></p>
    <p><strong>Résumé:</strong><br><?= nl2br(htmlentities($profile['summary'])) ?></p>
    <p><strong>Propriétaire:</strong> <?= htmlentities($profile['user_name']) ?></p>
    
    <p><a href="index.php">Retour à la liste</a></p>
</div>
</body>
</html>
