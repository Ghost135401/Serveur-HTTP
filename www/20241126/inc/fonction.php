<?php
function connectToDatabase() {
    $host = '127.0.0.1'; // Utiliser l'IP pour forcer une connexion TCP/IP
    $dbname = 'commerce';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
function getCategories() {
    $pdo=connectToDatabase();
    try {
        $stmt = $pdo->prepare("SELECT * FROM categorie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des catégories : " . $e->getMessage());
    }
}
function getAllProduits() {
    $pdo = connectToDatabase();
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM produit");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des produits : " . $e->getMessage());
    }
}
function getProduitById($id) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération du produit : " . $e->getMessage());
    }
}

function updateProduit($id, $nom, $note, $prix, $categorie) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("
            UPDATE produit 
            SET nom = :nom, note = :note, prix = :prix, categorie = :categorie 
            WHERE id = :id
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':note' => $note,
            ':prix' => $prix,
            ':categorie' => $categorie,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du produit : " . $e->getMessage());
    }
}

function searchProduits($critere, $valeur) {
    $pdo = connectToDatabase();
    try {
        $query = "SELECT * FROM produit WHERE $critere LIKE :valeur";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':valeur' => "%$valeur%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la recherche des produits : " . $e->getMessage());
    }
}
function deleteProduit($id) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("DELETE FROM produit WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        die("Erreur lors de la suppression du produit : " . $e->getMessage());
    }
}
function SearchMultiCritereProduits($nom, $note, $minPrice, $maxPrice) {
    $pdo = connectToDatabase();
    
    try {
        $query = "SELECT * FROM produit WHERE 1=1";
        $params = [];

        if (!empty($nom)) {
            $query .= " AND nom LIKE :nom";
            $params[':nom'] = "%$nom%";
        }

        if (!empty($note)) {
            $query .= " AND note = :note";
            $params[':note'] = $note;
        }

        if (!empty($minPrice)) {
            $query .= " AND prix >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }

        if (!empty($maxPrice)) {
            $query .= " AND prix <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la recherche des produits : " . $e->getMessage());
    }
}
// Ajouter une nouvelle catégorie
function addCategorie($nom, $description) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("INSERT INTO categorie (nom, description) VALUES (:nom, :description)");
        $stmt->execute([
            ':nom' => $nom,
            ':description' => $description
        ]);
        return "Catégorie ajoutée avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la catégorie : " . $e->getMessage());
    }
}

// Récupérer toutes les catégories
function getAllCategories() {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("SELECT * FROM categorie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des catégories : " . $e->getMessage());
    }
}

// Récupérer une catégorie par son ID
function getCategorieById($id) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération de la catégorie : " . $e->getMessage());
    }
}

// Mettre à jour une catégorie
function updateCategorie($id, $nom, $description) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("UPDATE categorie SET nom = :nom, description = :description WHERE id = :id");
        $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':id' => $id
        ]);
        return "Catégorie mise à jour avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour de la catégorie : " . $e->getMessage());
    }
}

// Supprimer une catégorie
function deleteCategorie($id) {
    $pdo = connectToDatabase();
    try {
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return "Catégorie supprimée avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de la catégorie : " . $e->getMessage());
    }
}

?>


