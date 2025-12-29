<?php
require_once "pdo.php";
require_once "util.php";
checkLoggedIn();

if ( !isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Profile ID manquant";
    header("Location: index.php");
    return;
}

// Vérification que le profil appartient à l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid");
$stmt->execute(array(':pid'=>$_GET['profile_id'], ':uid'=>$_SESSION['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = "Profil introuvable ou non autorisé";
    header("Location: index.php");
    return;
}

// Traitement du formulaire
if ( isset($_POST['first_name']) && isset($_POST['last_name']) &&
     isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) ) {

    // Validation PHP
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 ||
        strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1 ) {
        $_SESSION['error'] = "Tous les champs sont obligatoires";
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    if ( strpos($_POST['email'], '@') === false ) {
        $_SESSION['error'] = "L'adresse électronique doit contenir @";
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    // Mise à jour de la DB
    $stmt = $pdo->prepare('UPDATE Profile SET first_name=:fn, last_name=:ln, email=:em, headline=:he, summary=:su
                           WHERE profile_id=:pid AND user_id=:uid');
    $stmt->execute(array(
        ':fn'=>$_POST['first_name'],
        ':ln'=>$_POST['last_name'],
        ':em'=>$_POST['email'],
        ':he'=>$_POST['headline'],
        ':su'=>$_POST['summary'],
        ':pid'=>$_POST['profile_id'],
        ':uid'=>$_SESSION['user_id']
    ));
    $_SESSION['success'] = "Profil mis à jour";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Profile - TonNom</title>
<script src="app.js"></script>
</head>
<body>
<h1>Edit Profile</h1>
<?php flashMessages(); ?>
<form method="post">
<input type="hidden" name="profile_id" value="<?= htmlentities($row['profile_id']); ?>">
First Name: <input type="text" name="first_name" id="id_first_name" value="<?= htmlentities($row['first_name']); ?>"><br>
Last Name: <input type="text" name="last_name" id="id_last_name" value="<?= htmlentities($row['last_name']); ?>"><br>
Email: <input type="text" name="email" id="id_email" value="<?= htmlentities($row['email']); ?>"><br>
Headline: <input type="text" name="headline" id="id_headline" value="<?= htmlentities($row['headline']); ?>"><br>
Summary:<br><textarea name="summary" id="id_summary" rows="8" cols="80"><?= htmlentities($row['summary']); ?></textarea><br>
<input type="submit" value="Save" onclick="return validateProfile();">
</form>
<p><a href="index.php">Back to index</a></p>
</body>
</html>
