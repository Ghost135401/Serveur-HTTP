<?php
$racine="/home/ralevazaha/Documents/projetHttp/www/";
include($racine . "20241126/inc/fonction.php");

// Gestion des actions
if (isset($_POST['submit_add'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $message = addCategorie($nom, $description); // Appel de la fonction d'ajout
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message = deleteCategorie($id); // Appel de la fonction de suppression
}

$categories = getAllCategories(); // Récupérer toutes les catégories
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des catégories</title>
    <link rel="stylesheet" href="../assets/css/style7.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <br><br>
    <a href="modifcat.php">Modifier Categorie</a>
    <br>
        <a href="ajouter.php">Ajouter Produit</a>

    <h1>Gestion des catégories</h1>

    <?php if (isset($message)): ?>
        <p class="message"><?= $message; ?></p>
    <?php endif; ?>

    <div class="form-container">
        <h2>Ajouter une catégorie</h2>
        <form action="gestionCat.php" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit" name="submit_add">Ajouter</button>
        </form>
    </div>

    <div class="category-list">
        <br>
        <br>
        <h2>Liste des catégories</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie): ?>
                    <tr>
                        <td><?= htmlspecialchars($categorie['nom']); ?></td>
                        <td><?= htmlspecialchars($categorie['description']); ?></td>
                        <td>
                            <a href="modifcat.php?id=<?= $categorie['id']; ?>">Modifier</a> |
                            <a href="gestionCat.php?delete=<?= $categorie['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
