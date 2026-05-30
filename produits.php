<?php
/**
 * Page d'affichage des produits
 * Récupère et affiche tous les produits depuis la base de données
 */

// Inclusion du fichier de connexion à la base de données
require_once 'config/database.php';

// Requête pour récupérer tous les produits
try {
    $sql = "SELECT * FROM produits ORDER BY nom ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produits = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Erreur lors de la récupération des produits: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - BioFarm</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bootstrap (identique à index.html) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="index.php">
                🌱 BioFarm
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="produits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ajouter.php">Ajouter Produit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center text-success mb-5">Nos Produits Bio</h1>
                
                <!-- Affichage des erreurs s'il y en a -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Vérification s'il y a des produits -->
                <?php if (empty($produits)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        <h4>Aucun produit disponible</h4>
                        <p>Il n'y a pas encore de produits dans notre catalogue.</p>
                        <a href="ajouter.php" class="btn btn-success">Ajouter le premier produit</a>
                    </div>
                <?php else: ?>
                    <!-- Affichage des produits en cartes Bootstrap -->
                    <div class="row">
                        <?php foreach ($produits as $produit): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <!-- Image du produit -->
                                    <img src="<?php echo htmlspecialchars($produit['image_url']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($produit['nom']); ?>"
                                         onerror="this.src='images/default-product.jpg'">
                                    
                                    <div class="card-body d-flex flex-column">
                                        <!-- Nom du produit -->
                                        <h5 class="card-title text-success">
                                            <?php echo htmlspecialchars($produit['nom']); ?>
                                        </h5>
                                        
                                        <!-- Description -->
                                        <p class="card-text flex-grow-1">
                                            <?php echo htmlspecialchars($produit['description']); ?>
                                        </p>
                                        
                                        <!-- Prix et quantité -->
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="price">
                                                    <?php echo number_format($produit['prix'], 2); ?> DH
                                                </span>
                                                <span class="badge badge-quantity">
                                                    Stock: <?php echo $produit['quantite']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Bouton pour ajouter un produit -->
                <div class="text-center mt-5">
                    <a href="ajouter.php" class="btn btn-success btn-lg">
                        ➕ Ajouter un nouveau produit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-success text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 BioFarm - Produits Bio de Qualité</p>
            <p>🌱 Cultivé avec amour pour votre santé</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript personnalisé -->
    <script src="script.js"></script>
</body>
</html>