<?php
// Récupérer la chaîne de requête brute
$query_string = $_SERVER['QUERY_STRING'];

// Analyser la chaîne de requête
parse_str($query_string, $params);

// Vérifier si 'id' existe dans les paramètres GET
$id = isset($params['id']) ? $params['id'] : 'inconnu';

// Afficher l'ID reçu
echo "<!DOCTYPE html>";
echo "<html lang='fr'>";
echo "<head><meta charset='UTF-8'><title>Test PHP</title></head>";
echo "<body>";
echo "<h1>L'ID reçu est : " . htmlspecialchars($id) . "</h1>";
echo "</body>";
echo "</html>";
?>
