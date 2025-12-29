<?php
session_start();
require_once "pdo.php";

// Récupération de tous les profils avec les noms des utilisateurs
$stmt = $pdo->query("
    SELECT Profile.profile_id, Profile.first_name, Profile.last_name, 
           Profile.headline, users.name as user_name, Profile.user_id
    FROM Profile 
    JOIN users ON Profile.user_id = users.user_id
    ORDER BY Profile.profile_id
");
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion de Profils - Index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Base de données de Profils</h1>
    
    <?php
    // Affichage des messages flash
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green">' . htmlentities($_SESSION['success']) . "</p>\n";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    
    <?php if (!isset($_SESSION['name'])): ?>
        <p><a href="login.php">Veuillez vous connecter</a></p>
    <?php else: ?>
        <p>Bienvenue, <?= htmlentities($_SESSION['name']) ?></p>
        <p><a href="add.php">Ajouter un nouveau profil</a> | <a href="logout.php">Déconnexion</a></p>
    <?php endif; ?>
    
    <h2>Liste des Profils</h2>
    <?php if (count($profiles) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Titre</th>
                    <th>Propriétaire</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td>
                            <a href="view.php?profile_id=<?= $profile['profile_id'] ?>">
                                <?= htmlentities($profile['first_name'] . ' ' . $profile['last_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlentities($profile['headline']) ?></td>
                        <td><?= htmlentities($profile['user_name']) ?></td>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <td>
                                <?php if ($_SESSION['user_id'] == $profile['user_id']): ?>
                                    <a href="edit.php?profile_id=<?= $profile['profile_id'] ?>">Modifier</a> |
                                    <a href="delete.php?profile_id=<?= $profile['profile_id'] ?>">Supprimer</a>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun profil trouvé</p>
    <?php endif; ?>
</div>
</body>
</html>
