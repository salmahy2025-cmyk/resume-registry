<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

if (isset($_POST['first_name'])) {

    if (
        strlen($_POST['first_name']) < 1 ||
        strlen($_POST['last_name']) < 1 ||
        strlen($_POST['email']) < 1 ||
        strlen($_POST['headline']) < 1 ||
        strlen($_POST['summary']) < 1
    ) {
        $_SESSION['error'] = "Tous les champs sont obligatoires";
        header("Location: add.php");
        return;
    }

    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "L'adresse électronique doit contenir @";
        header("Location: add.php");
        return;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES (:uid, :fn, :ln, :em, :he, :su)'
    );

    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary']
    ]);

    $_SESSION['success'] = "Profile added";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SS - Add</title>
</head>
<body>

<h1>Add Profile</h1>

<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">'.htmlentities($_SESSION['error'])."</p>";
    unset($_SESSION['error']);
}
?>

<form method="POST">
<p>First Name:
<input type="text" name="first_name"></p>
<p>Last Name:
<input type="text" name="last_name"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Headline:
<input type="text" name="headline"></p>
<p>Summary:
<textarea name="summary"></textarea></p>
<p>
<input type="submit" value="Add">
<a href="index.php">Cancel</a>
</p>
</form>

</body>
</html>
