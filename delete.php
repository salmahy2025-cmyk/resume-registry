<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {

    $stmt = $pdo->prepare(
        "DELETE FROM Profile
         WHERE profile_id=:pid AND user_id=:uid"
    );
    $stmt->execute([
        ':pid' => $_POST['profile_id'],
        ':uid' => $_SESSION['user_id']
    ]);

    $_SESSION['success'] = "Profile deleted";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare(
    "SELECT first_name, last_name, profile_id
     FROM Profile
     WHERE profile_id=:pid AND user_id=:uid"
);
$stmt->execute([
    ':pid' => $_GET['profile_id'],
    ':uid' => $_SESSION['user_id']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    $_SESSION['error'] = "Bad value";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SS - Delete</title>
</head>
<body>

<h1>Confirm Deletion</h1>
<p>
<?=htmlentities($row['first_name'].' '.$row['last_name'])?>
</p>

<form method="POST">
<input type="hidden" name="profile_id"
value="<?=$row['profile_id']?>">
<input type="submit" name="delete" value="Delete">
<a href="index.php">Cancel</a>
</form>

</body>
</html>
