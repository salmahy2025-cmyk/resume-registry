<?php
session_start();

$salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "L'email et le mot de passe sont requis";
        header("Location: login.php");
        return;
    }
    
    if (!strpos($_POST['email'], '@')) {
        $_SESSION['error'] = "L'email doit contenir un @";
        header("Location: login.php");
        return;
    }
    
    require_once "pdo.php";
    $check = hash('md5', $salt . $_POST['pass']);
    
    $stmt = $pdo->prepare('SELECT user_id, name FROM users 
                           WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
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
    <title>Connexion - Gestion de Profils</title>
    <script>
    function doValidate() {
        console.log('Validating...');
        try {
            email = document.getElementById('email').value;
            pw = document.getElementById('id_1723').value;
            console.log("Validating email=" + email + " pw=" + pw);
            
            if (email == null || email == "" || pw == null || pw == "") {
                alert("Les deux champs doivent être remplis");
                return false;
            }
            
            if (email.indexOf('@') == -1) {
                alert("L'adresse email doit contenir un @");
                return false;
            }
            
            return true;
        } catch(e) {
            console.error("Validation error:", e);
            return false;
        }
    }
    </script>
</head>
<body>
<div class="container">
    <h1>Connexion</h1>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="POST">
        <p>Email: <input type="text" name="email" id="email"></p>
        <p>Mot de passe: <input type="password" name="pass" id="id_1723"></p>
        <p>
            <input type="submit" onclick="return doValidate();" value="Se connecter">
            <input type="button" onclick="location.href='index.php';" value="Annuler">
        </p>
    </form>
    <p>Pour un indice de mot de passe, regardez le code source et trouvez le hash.</p>
</div>
</body>
</html>
