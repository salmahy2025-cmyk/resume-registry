<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('Non connecté');
}

require_once "pdo.php";

// Vérification que le profil existe et appartient à l'utilisateur connecté
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "ID de profil manquant";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(':pid' => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($profile === false) {
    $_SESSION['error'] = "Profil non trouvé ou vous n'avez pas les permissions";
    header("Location: index.php");
    return;
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && 
    isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {
    
    // Validation des données
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || 
        strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || 
        strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = "Tous les champs sont requis";
        header("Location: edit.php?profile_id=" . $_POST['profile_id']);
        return;
    }
    
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "L'adresse email doit contenir @";
        header("Location: edit.php?profile_id=" . $_POST['profile_id']);
        return;
    }
    
    // Mise à jour du profil
    $stmt = $pdo->prepare('UPDATE Profile SET 
        first_name = :fn, last_name = :ln, email = :em, 
        headline = :he, summary = :su
        WHERE profile_id = :pid AND user_id = :uid');
    
    $stmt->execute(array(
        ':pid' => $_POST['profile_id'],
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );
    
    $_SESSION['success'] = "Profil modifié avec succès";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Profil - Gestion de Profils</title>
</head>
<body>
<div class="container">
    <h1>Modifier le profil</h1>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="POST">
        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
        <p>Prénom: <input type="text" name="first_name" value="<?= htmlentities($profile['first_name']) ?>"></p>
        <p>Nom: <input type="text" name="last_name" value="<?= htmlentities($profile['last_name']) ?>"></p>
        <p>Email: <input type="text" name="email" value="<?= htmlentities($profile['email']) ?>"></p>
        <p>Titre: <input type="text" name="headline" value="<?= htmlentities($profile['headline']) ?>"></p>
        <p>Résumé: <br><textarea name="summary" rows="5" cols="50"><?= htmlentities($profile['summary']) ?></textarea></p>
        <p>
            <input type="submit" value="Enregistrer">
            <input type="button" onclick="location.href='index.php';" value="Annuler">
        </p>
    </form>
</div>
</body>
</html>
