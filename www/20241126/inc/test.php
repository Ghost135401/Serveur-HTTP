<?php
include "fonction.php";
$host = 'localhost';
$dbname = 'commerce';
$username = 'root';
$password = '';

$pdo = connectToDatabase($host, $dbname, $username, $password);

// Vérifiez si la connexion est réussie
if ($pdo) {
    echo "Connexion réussie à la base de données !";
}
?>