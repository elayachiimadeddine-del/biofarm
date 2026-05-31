<?php
/**
 * Traitement et formulaire d'ajout de produit
 * Gestion réglementaire via la superglobale $_POST - Chapitre 13 (Page 27)
 */
require_once 'config/database.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Réception simple des variables POST (Chapitre 13)
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'];
    
    // Validation stricte
    if (empty($nom) || empty($prix) || empty($quantite) || empty($description)) {
        $error = "Tous les champs obligatoires doivent être remplis.";
    } elseif ($prix <= 0) {
        $error = "Le prix doit être supérieur à 0 DH.";
    } elseif ($quantite < 0) {
        $error = "La quantité ne peut pas être négative.";
    } else {
        if (empty($image_url)) {
            $image_url = 'https://via.placeholder.com/400x300/28a745/ffffff?text=Produit+Bio';
        }
        
        try {
            // Insertion conforme à votre table sql (image_url et quantite)
            $sql = "INSERT INTO produits (nom, prix, quantite, stock, image_url, description) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prix, $quantite, $quantite, $image_url, $description]);
            $success = "Le produit a été ajouté avec succès !";
        } catch(PDOException $e) {
            $error = "Une erreur est survenue lors de l'enregistrement sur le serveur.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - BioFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-sm navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">🌱 BioFarm</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="produits.php">Nos Produits</a></li>
                    <li class="nav-item"><a class="nav-link active" href="ajouter.php">Ajouter un produit</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-success mb-4 text-center">Ajouter un nouveau produit bio</h1>

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="ajouter.php" method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label fw-bold">Nom du produit *</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="prix" class="form-label fw-bold">Prix (en DH) *</label>
                                    <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quantite" class="form-label fw-bold">Quantité en stock *</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image_url" class="form-label fw-bold">URL de l'image</label>
                                <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://...">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="text-end">
                                <a href="produits.php" class="btn btn-secondary me-2">Annuler</a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>