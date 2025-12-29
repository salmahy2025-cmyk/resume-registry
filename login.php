$_SESSION['name'] = $row['name'];
$_SESSION['user_id'] = $row['user_id'];
header("Location: index.php");
exit();
