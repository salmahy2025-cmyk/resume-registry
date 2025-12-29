<?php
require_once "pdo.php";
require_once "util.php";

if ( !isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Profile ID manquant";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id=:pid");
$stmt->execute(array(':pid'=>$_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = "Profil introuvable";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>View Profile - TonNom</title>
</head>
<body>
<h1>Profil de <?= htmlentities($row['first_name']).' '.htmlentities($row['last_name']); ?></h1>
<p>Email: <?= htmlentities($row['email']); ?></p>
<p>Headline: <?= htmlentities($row['headline']); ?></p>
<p>Summary: <?= htmlentities($row['summary']); ?></p>
<p><a href="index.php">Back to index</a></p>
</body>
</html>
