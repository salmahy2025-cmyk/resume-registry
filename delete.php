<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('Non connecté');
}

require_once "pdo.php";

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "ID de profil manquant";
    header("Location: index.php");
    return;
}

// Vérification que le profil existe et appartient à l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(':pid' => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($profile === false) {
    $_SESSION['error'] = "Profil non trouvé ou vous n'avez pas les permissions";
    header("Location: index.php");
    return;
}

if (isset($_POST['delete'])) {
    // Suppression du profil
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid AND user_id = :uid');
    $stmt->execute(array(':pid' => $_POST['profile_id'], ':uid' => $_SESSION['user_id']));
    
    $_SESSION['success'] = "Profil supprimé avec succès";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un Profil - Gestion de Profils</title>
</head>
<body>
<div class="container">
    <h1>Supprimer le profil</h1>
    
    <p>Êtes-vous sûr de vouloir supprimer le profil de 
    <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?> ?</p>
    
    <form method="POST">
        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
        <input type="submit" name="delete" value="Supprimer">
        <input type="button" onclick="location.href='index.php';" value="Annuler">
    </form>
</div>
</body>
</html>
