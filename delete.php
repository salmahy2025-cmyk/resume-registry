$stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid AND user_id = :uid');
$stmt->execute(array(':pid' => $_POST['profile_id'], ':uid' => $_SESSION['user_id']));
header("Location: index.php");
exit();
