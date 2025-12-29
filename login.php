<?php
$email = $_POST['email'] ?? '';
$pass  = $_POST['pass'] ?? '';

if ($email === 'umsi@umich.edu' && $pass === 'php123') {
    // rediriger vers add.php après login réussi
    header('Location: add.php');
    exit();
} else {
    echo "<p>Invalid credentials!</p>";
    echo '<a href="index.php">Back to login</a>';
}
?>
