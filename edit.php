$stmt = $pdo->prepare('UPDATE Profile SET
    first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su
    WHERE profile_id = :pid AND user_id = :uid');
$stmt->execute(array(
    ':fn' => $_POST['first_name'],
    ':ln' => $_POST['last_name'],
    ':em' => $_POST['email'],
    ':he' => $_POST['headline'],
    ':su' => $_POST['summary'],
    ':pid' => $_POST['profile_id'],
    ':uid' => $_SESSION['user_id']
));
header("Location: index.php");
exit();
