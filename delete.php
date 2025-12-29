<?php
require_once "pdo.php";
require_once "util.php";
checkLoggedIn();

if ( !isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Profile ID manquant";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id=:pid AND user_id=:uid");
$stmt->execute(array(':pid'=>$_GET['profile_id'], ':uid'=>$_SESSION['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = "Profil introuvable ou non autorisé";
    header("Location: index.php");
    return;
}

if ( isset($_POST['delete']) && $_POST['delete']=='Yes' ) {
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id=:pid AND user_id=:uid");
    $stmt->execute(array(':pid'=>$_POST['profile_id'], ':uid'=>$_SESSION['user_id']));
    $_SESSION['success'] = "Profil supprimé";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Profile - TonNom</title>
</head>
<body>
<h1>Supprimer le profil</h1>
<p>Êtes-vous sûr de vouloir supprimer ce profil ?</p>
<form method="post">
<input type="hidden" name="profile_id" value="<?= htmlentities($row['profile_id']); ?>">
<input type="submit" name="delete" value="Yes">
<input type="submit" name="delete" value="No">
</form>
<p><a href="index.php">Back to index</a></p>
</body>
</html>
