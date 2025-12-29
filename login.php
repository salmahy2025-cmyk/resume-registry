<?php
require_once "pdo.php";
require_once "util.php";

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    $salt = 'XyZzy12*_';
    $check = hash('md5', $salt.$_POST['pass']);

    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em'=>$_POST['email'], ':pw'=>$check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect";
        header("Location: login.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - TonNom</title>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        var pw = document.getElementById('id_pass').value;
        var em = document.getElementById('id_email').value;
        if (pw == null || pw == "" || em == null || em == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if (em.indexOf('@') == -1) {
            alert("Email must have an at-sign (@)");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
}
</script>
</head>
<body>
<h1>Login</h1>
<?php flashMessages(); ?>
<form method="post">
Email: <input type="text" name="email" id="id_email"><br>
Password: <input type="password" name="pass" id="id_pass"><br>
<input type="submit" onclick="return doValidate();" value="Log In">
</form>
</body>
</html>
