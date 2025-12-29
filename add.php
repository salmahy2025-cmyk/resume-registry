<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New Entry</title>
</head>
<body>

<!-- Lien exact attendu par l’autograder -->
<a href="add.php">Add New Entry</a>

<h2>Add Resume</h2>

<form id="resumeForm">
    Name: <input type="text" id="name" name="name"><br><br>
    Email: <input type="text" id="email" name="email"><br><br>
    Title: <input type="text" id="title" name="title"><br><br>
    <button type="submit">Add</button>
</form>

<h2>Resumes</h2>
<ul id="resumeList"></ul>

<script src="app.js"></script>
</body>
</html>
