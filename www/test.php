<?php
$host = '127.0.0.1'; // Utiliser l'IP pour forcer une connexion TCP/IP
$dbname = 'commerce';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Réponse si connexion réussie
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Database Connection</title>";
    echo "</head>";
    echo "<body>";
    echo "<h1>Connexion réussie à la base de données !</h1>";
    echo "</body>";
    echo "</html>";
} catch (PDOException $e) {
    // Réponse si connexion échoue
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Database Error</title>";
    echo "</head>";
    echo "<body>";
    echo "<h1>Erreur de connexion à la base de données</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</body>";
    echo "</html>";
}
?>
