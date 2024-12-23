<?php
$racine="/home/ralevazaha/Documents/projetHttp/www/";
include($racine . "20241126/inc/fonction.php");
$produits = getAllProduits();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des produits</title>

    <!-- Lien vers le fichier CSS externe -->
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body>
    <br>
    <br>
    <a href="ajouter.php">ajouter Produit</a>
    <a href="gestionCat.php">ajouter Categorie</a>
    <h1>Gestion des produits</h1>

    <div class="product-container">
        <!-- Afficher tous les produits dans un tableau -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Note</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= htmlspecialchars($produit['note']) ?></td>
                        <td><?= htmlspecialchars($produit['prix']) ?> €</td>
                        <td><?= htmlspecialchars($produit['categorie']) ?></td>
                        <td><img src="../<?= htmlspecialchars($produit['image_url']) ?>" alt="Image produit" class="product-image"></td>
                        <td>
                            <a href="modifier.php?id=<?= $produit['id'] ?>" class="modify-button">Modifier</a>
                            <a href="valider.php?id=<?= $produit['id'] ?>" class="supp-button">Supprimer</a>
                            
                            <!-- Formulaire pour ajouter une image -->
                             <br>
                            <form action="add_image.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="produit_id" value="<?= $produit['id']; ?>">
                                <input type="file" name="image" required>
                                <button type="submit" name="submit_image" class="add-image-button">Add Image</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
