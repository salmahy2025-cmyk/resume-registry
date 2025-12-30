<?php
session_start();
require_once "pdo.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>SS - Profiles</title>
</head>
<body>

<h1>Profiles</h1>

<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">'.htmlentities($_SESSION['error'])."</p>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p style="color:green">'.htmlentities($_SESSION['success'])."</p>";
    unset($_SESSION['success']);
}

$stmt = $pdo->query(
    "SELECT profile_id, first_name, last_name, headline
     FROM Profile"
);

echo "<ul>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<li>";
    echo '<a href="view.php?profile_id='.$row['profile_id'].'">';
    echo htmlentities($row['first_name'].' '.$row['last_name']);
    echo "</a>";
    echo " : ".htmlentities($row['headline']);

    if (isset($_SESSION['user_id'])) {
        echo ' <a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a>';
        echo ' <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>';
    }
    echo "</li>";
}
echo "</ul>";

if (!isset($_SESSION['user_id'])) {
    echo '<p><a href="login.php">Please log in</a></p>';
} else {
    echo '<p><a href="add.php">Add New Entry</a> | ';
    echo '<a href="logout.php">Logout</a></p>';
}
?>

</body>
</html>
