<?php
// Inclure la fonction pour se connecter à la base de données et récupérer les catégories
include "../inc/fonction.php";

// Récupérer toutes les catégories
$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <br>
    <br>
     <a href="gestion.php">gerer les produits</a>
     <br>
     <a href="gestionCat.php">ajouter Categorie</a>
    <h1>Ajouter un nouveau produit</h1>

    <div class="form-container">
        <form action="ajouter_produit.php" method="POST" enctype="multipart/form-data">
            
            <div class="input-group">
                <label for="nom">Nom du produit :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            
            <div class="input-group">
                <label for="note">Note :</label>
                <input type="number" id="note" name="note" class="note-input" min="0" max="5">
                <div class="note-info">Entrez une note de 0 à 5.</div>
            </div>
            
            <div class="input-group">
                <label for="prix">Prix :</label>
                <input type="number" id="prix" name="prix" step="0.01" required>
            </div>
            
            <div class="input-group">
                <label for="categorie">Catégorie :</label>
                <select name="categorie" id="categorie" required>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['nom']) ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <label for="image">Image :</label>
                <input type="file" name="image[]" id="image" required multiple>
            </div>

            <button type="submit" name="submit">Ajouter le produit</button>
        </form>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                Produit ajouté avec succès !
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="error-message">
                Erreur lors de l'ajout du produit. Veuillez réessayer.
            </div>
        <?php endif; ?>

    </div>

</body>
</html>
