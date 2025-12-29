<?php
session_start();
require_once "pdo.php"; // fichier avec la connexion PDO

// Flash message
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>79f3577a - Resume Registry</title> <!-- mettre votre nom ou identifiant -->
</head>
<body>
<h1>Resume Registry</h1>

<?php
if ( ! isset($_SESSION['name']) ) {
    // Si pas connecté
    echo '<p><a href="login.php">Please log in</a></p>';
} else {
    // Si connecté
    echo '<p><a href="logout.php">Logout</a></p>';
    echo '<p><a href="add.php">Add New Entry</a></p>';
}

// Récupérer tous les profils
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, headline FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ( count($rows) > 0 ) {
    echo('<table border="1">'."\n");
    echo "<tr><th>Name</th><th>Headline</th>";
    if(isset($_SESSION['user_id'])) echo "<th>Action</th>";
    echo "</tr>\n";

    foreach ( $rows as $row ) {
        echo "<tr><td>";
        echo '<a href="view.php?profile_id='.htmlentities($row['profile_id']).'">';
        echo htmlentities($row['first_name'].' '.$row['last_name']);
        echo "</a></td><td>";
        echo htmlentities($row['headline']);
        echo "</td>";

        // Si connecté et propriétaire, montrer Edit/Delete
        if(isset($_SESSION['user_id'])){
            echo "<td>";
            if($_SESSION['user_id'] == $row['user_id']){
                echo '<a href="edit.php?profile_id='.htmlentities($row['profile_id']).'">Edit</a> / ';
                echo '<a href="delete.php?profile_id='.htmlentities($row['profile_id']).'">Delete</a>';
            }
            echo "</td>";
        }

        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>No profiles found</p>";
}
?>

</body>
</html>
