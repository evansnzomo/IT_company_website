<?php
$host = 'localhost';
$db   = 'kplc';
$user = 'evans';
$pass = 'YES';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
