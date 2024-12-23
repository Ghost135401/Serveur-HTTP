<?php
$racine="/home/ralevazaha/Documents/projetHttp/www/";
include($racine . "20241126/inc/fonction.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $note = $_POST['note'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];

    // Appelle la fonction pour mettre à jour le produit
    updateProduit($id, $nom, $note, $prix, $categorie);
    header("Location: gestion.php");
    exit;
}

// Récupère l'ID du produit à modifier
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID du produit non spécifié.");
}

// Charge les informations du produit existant
$produit = getProduitById($id);

if (!$produit) {
    die("Produit introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="../assets/css/style3.css">
    <script src="confirmation.js" defer></script>
</head>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="../assets/css/style3.css">
    <script src="confirmer.js" defer></script>
</head>
<body>
    <div class="modifier-container">
        <h2>Modifier le Produit</h2>
        <form id="modifier-form" action="modifier.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>

            <label for="note">Note :</label>
            <input type="number" id="note" name="note" min="1" max="5" value="<?= htmlspecialchars($produit['note']) ?>" required>

            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($produit['prix']) ?>" required>

            <label for="categorie">Catégorie :</label>
            <input type="text" id="categorie" name="categorie" value="<?= htmlspecialchars($produit['categorie']) ?>" required>

            <button type="submit" id="submit-button">Modifier</button>
       

        <!-- Message de confirmation -->
        <div id="confirmation-dialog" class="confirmation-dialog" style="display: none;">
            <p>Êtes-vous sûr de vouloir modifier ce produit ?</p>
            <button id="confirm-yes">Oui</button>
            <button id="confirm-no">Non</button>
        </div>
         </form>
    </div>
</body>
</html>
