<?php
include "../inc/fonction.php";

if (isset($_POST['submit_image'])) {
    $produit_id = $_POST['produit_id'];
    
    // Vérifier si un fichier image a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        
        // Définir le chemin de destination de l'image
        $imageDestinationPath = '../assets/images/' . $imageName;

        // Déplacer le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($imageTmpPath, $imageDestinationPath)) {
            // Insérer l'image dans la table image_produit
            $pdo = connectToDatabase();
            try {
                $stmt = $pdo->prepare("INSERT INTO image_produit (produit_id, image_url) VALUES (:produit_id, :image_url)");
                $stmt->execute([
                    ':produit_id' => $produit_id,
                    ':image_url' => 'assets/images/' . $imageName
                ]);
                // Rediriger vers la page de gestion des produits après ajout de l'image
                header("Location: gestion.php");
                exit;
            } catch (PDOException $e) {
                die("Erreur lors de l'ajout de l'image : " . $e->getMessage());
            }
        } else {
            die("Erreur lors du téléchargement de l'image.");
        }
    } else {
        die("Aucune image sélectionnée ou erreur de téléchargement.");
    }
}
?>
