<?php
$racine="/home/ralevazaha/Documents/projetHttp/www/";
include($racine . "20241126/inc/fonction.php");

// Récupérer l'ID de la catégorie à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $categorie = getCategorieById($id);
}

if (isset($_POST['submit_update'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    updateCategorie($id, $nom, $description); // Mettre à jour la catégorie
    header("Location: gestionCat.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier catégorie</title>
    <link rel="stylesheet" href="../assets/css/style7.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
     <br>
     <br>
     <a href="gestionCat.php">Gestion Categorie</a>
    <h1>Modifier la catégorie</h1>

    <div class="form-container">
        <form action="modifcat.php?id=<?= $id; ?>" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($categorie['nom']); ?>" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($categorie['description']); ?></textarea>

            <button type="submit" name="submit_update">Mettre à jour</button>
        </form>
    </div>

</body>
</html>
