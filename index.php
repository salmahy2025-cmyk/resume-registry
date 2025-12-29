<?php
require_once "pdo.php";
require_once "util.php";

?>
<!DOCTYPE html>
<html>
<head>
<title>Liste des profils - '79f3577a</title>
</head>
<body>
<h1>Liste des profils</h1>
<?php
flashMessages();
$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM Profile");
echo '<table border="1">';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td>";
    echo htmlentities($row['first_name'])." ".htmlentities($row['last_name']);
    echo "</td><td>";
    echo htmlentities($row['headline']);
    echo "</td><td>";
    echo '<a href="view.php?profile_id='.$row['profile_id'].'">View</a>';
    echo "</td><td>";
    if ( isset($_SESSION['user_id']) ) {
        echo '<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ';
        echo '<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>';
    }
    echo "</td></tr>";
}
echo '</table>';

if ( isset($_SESSION['user_id']) ) {
    echo '<p><a href="add.php">Add New Profile</a></p>';
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo '<p><a href="login.php">Please log in</a></p>';
}
?>
</body>
</html>
