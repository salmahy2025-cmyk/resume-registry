<?php
$pdo = new PDO('mysql:host=localhost;dbname=misc;charset=utf8', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
