<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('Non connecté');
}

require_once "pdo.php";

if (isset($_POST['first_name']) && isset($_POST['last_name']) && 
    isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {
    
    // Validation des données
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || 
        strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || 
        strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = "Tous les champs sont requis";
        header("Location: add.php");
        return;
    }
    
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "L'adresse email doit contenir @";
        header("Location: add.php");
        return;
    }
    
    // Insertion du profil
    $stmt = $pdo->prepare('INSERT INTO Profile 
        (user_id, first_name, last_name, email, headline, summary)
        VALUES (:uid, :fn, :ln, :em, :he, :su)');
    
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );
    
    $_SESSION['success'] = "Profil ajouté avec succès";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Profil - Gestion de Profils</title>
</head>
<body>
<div class="container">
    <h1>Ajouter un nouveau profil pour <?= htmlentities($_SESSION['name']) ?></h1>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="POST">
        <p>Prénom: <input type="text" name="first_name"></p>
        <p>Nom: <input type="text" name="last_name"></p>
        <p>Email: <input type="text" name="email"></p>
        <p>Titre: <input type="text" name="headline"></p>
        <p>Résumé: <br><textarea name="summary" rows="5" cols="50"></textarea></p>
        <p>
            <input type="submit" value="Ajouter">
            <input type="button" onclick="location.href='index.php';" value="Annuler">
        </p>
    </form>
</div>
</body>
</html>
