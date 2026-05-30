<?php
/**
 * Page d'accueil BioFarm
 * Affiche les produits en vedette depuis la base de données
 */
require_once 'config/database.php';

// Récupérer les 3 derniers produits ajoutés pour la section "en vedette"
try {
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY date_creation DESC LIMIT 3");
    $produits_vedette = $stmt->fetchAll();
} catch(PDOException $e) {
    $produits_vedette = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioFarm - Produits Bio de la Ferme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation -->
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
                        <a class="nav-link text-white active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="produits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ajouter.php">Ajouter Produit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bannière d'accueil -->
    <section class="hero-section bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 text-success fw-bold">Bienvenue chez BioFarm</h1>
                    <p class="lead text-muted">
                        Découvrez nos produits bio frais directement de nos fermes locales.
                        Des fruits et légumes cultivés avec amour et respect de l'environnement.
                    </p>
                    <a href="produits.php" class="btn btn-success btn-lg">Voir nos produits</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/400x300/28a745/ffffff?text=Ferme+Bio" alt="Ferme Bio" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Section produits en vedette -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center text-success mb-5">Nos Produits Bio en Vedette</h2>

            <?php if (empty($produits_vedette)): ?>
                <div class="alert alert-info text-center">
                    <p>Aucun produit disponible pour le moment.</p>
                    <a href="ajouter.php" class="btn btn-success">Ajouter le premier produit</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($produits_vedette as $produit): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?php echo htmlspecialchars($produit['image_url'] ?: 'https://via.placeholder.com/400x300/28a745/ffffff?text=Produit+Bio'); ?>"
                                     class="card-img-top"
                                     alt="<?php echo htmlspecialchars($produit['nom']); ?>"
                                     onerror="this.src='https://via.placeholder.com/400x300/28a745/ffffff?text=Produit+Bio'">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-success">
                                        <?php echo htmlspecialchars($produit['nom']); ?>
                                    </h5>
                                    <p class="card-text flex-grow-1">
                                        <?php echo htmlspecialchars($produit['description']); ?>
                                    </p>
                                    <p class="text-success fw-bold mt-auto">
                                        <?php echo number_format($produit['prix'], 2); ?> DH
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="produits.php" class="btn btn-outline-success">Voir tous les produits →</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-success text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 BioFarm - Produits Bio de Qualité</p>
            <p>🌱 Cultivé avec amour pour votre santé</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
