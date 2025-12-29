<?php
require_once "pdo.php";
require_once "util.php";
checkLoggedIn();

if ( isset($_POST['first_name']) && isset($_POST['last_name']) &&
     isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) ) {

    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 ||
        strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1 ) {
        $_SESSION['error'] = "Tous les champs sont obligatoires";
        header("Location: add.php");
        return;
    }

    if ( strpos($_POST['email'], '@') === false ) {
        $_SESSION['error'] = "L'adresse électronique doit contenir @";
        header("Location: add.php");
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );

    $_SESSION['success'] = "Profil ajouté";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Profile - TonNom</title>
</head>
<body>
<h1>Ajouter un profil</h1>
<?php flashMessages(); ?>
<form method="post">
First Name: <input type="text" name="first_name"><br>
Last Name: <input type="text" name="last_name"><br>
Email: <input type="text" name="email"><br>
Headline: <input type="text" name="headline"><br>
Summary:<br><textarea name="summary" rows="8" cols="80"></textarea><br>
<input type="submit" value="Add">
</form>
<p><a href="index.php">Back to index</a></p>
</body>
</html>
