<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=votre_base_de_donnees', 
               'votre_utilisateur', 'votre_mot_de_passe');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
