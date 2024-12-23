<?php
include "../inc/fonction.php";

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $note = isset($_POST['note']) ? $_POST['note'] : null;
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    
    // Vérifier si des fichiers ont été téléchargés
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
        $images = $_FILES['image'];

        // Créer un tableau pour stocker les chemins des images
        $imageUrls = [];

        // Vérifier si le répertoire 'assets/images' existe, sinon le créer
        if (!is_dir('../assets/images')) {
            if (!mkdir('../assets/images', 0777, true)) {
                die("Erreur lors de la création du répertoire.");
            }
        }

        // Traiter chaque image téléchargée
        foreach ($images['name'] as $index => $imageName) {
            // Vérifier les erreurs pour chaque image
            if ($images['error'][$index] == UPLOAD_ERR_OK) {
                $imageTmpPath = $images['tmp_name'][$index];
                $imageName = basename($imageName);
                $imageDestinationPath = '../assets/images/' . $imageName; // Chemin de destination

                // Déplacer l'image téléchargée dans le répertoire 'assets/images'
                if (move_uploaded_file($imageTmpPath, $imageDestinationPath)) {
                    // Ajouter l'URL de l'image au tableau
                    $imageUrls[] = 'assets/images/' . $imageName;
                } else {
                    die("Erreur lors du téléchargement de l'image.");
                }
            } else {
                die("Une erreur est survenue lors du téléchargement d'une image.");
            }
        }
    } else {
        die("Aucune image sélectionnée ou erreur de téléchargement.");
    }

    // Connexion à la base de données et insertion du produit
    $pdo = connectToDatabase();
    try {
        // Utiliser une transaction pour ajouter plusieurs images
        $pdo->beginTransaction();

        // Insertion du produit (avec la première image)
        $stmt = $pdo->prepare("INSERT INTO produit (nom, note, prix, categorie, image_url) 
                               VALUES (:nom, :note, :prix, :categorie, :image_url)");
        $stmt->execute([
            ':nom' => $nom,
            ':note' => $note,
            ':prix' => $prix,
            ':categorie' => $categorie,
            ':image_url' => $imageUrls[0] // La première image est insérée dans le produit
        ]);
        $productId = $pdo->lastInsertId(); // Récupérer l'ID du produit inséré

        // Insertion des autres images dans la table image_produit
        $stmt = $pdo->prepare("INSERT INTO image_produit (produit_id, image_url) 
                               VALUES (:produit_id, :image_url)");

        // Commencer à partir de la deuxième image (si elle existe)
        for ($i = 1; $i < count($imageUrls); $i++) {
            $stmt->execute([
                ':produit_id' => $productId,
                ':image_url' => $imageUrls[$i]
            ]);
        }

        // Valider la transaction
        $pdo->commit();

        echo "Produit ajouté avec succès avec les images!";
        header("Location: ajouter.php");
        exit;
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        die("Erreur lors de l'ajout du produit : " . $e->getMessage());
    }
}
?>
