<?php
/**
 * Page d'accueil BioFarm
 * Conforme au Chapitre 13 (Structure, instructions de sortie et boucles PHP)
 */
require_once 'config/database.php';

// Récupérer les 3 derniers produits ajoutés (Chapitre 13)
try {
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY date_creation DESC LIMIT 3");
    $produits_vedette = $stmt->fetchAll();
} catch(PDOException $e) {
    $produits_vedette = array();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioFarm - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-sm navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">🌱 BioFarm</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produits.php">Nos Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ajouter.php">Ajouter un produit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="bg-light py-5 border-bottom mb-4">
        <div class="container text-center my-4">
            <h1 class="fw-bolder">Bienvenue chez BioFarm</h1>
            <p class="lead mb-0">Des produits bio locaux, cultivés de manière responsable.</p>
            <a href="produits.php" class="btn btn-success mt-3">Découvrir notre catalogue</a>
        </div>
    </header>

    <section class="py-4">
        <div class="container">
            <h2 class="text-success mb-4 text-center">Nos Nouveautés</h2>
            
            <?php if (empty($produits_vedette)) { ?>
                <div class="alert alert-info text-center">Aucun produit disponible pour le moment.</div>
            <?php } else { ?>
                <div class="row">
                    <?php foreach ($produits_vedette as $produit) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                               <img src="<?php echo htmlspecialchars($produit['image_url']); ?>" class="card-img-top" alt="Produit" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-success fw-bold">
                                        <?php echo htmlspecialchars($produit['nom']); ?>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        <?php echo htmlspecialchars($produit['description']); ?>
                                    </p>
                                    <p class="h4 text-success fw-bold mt-auto">
                                        <?php echo number_format($produit['prix'], 2); ?> DH
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="text-center mt-3">
                    <a href="produits.php" class="btn btn-outline-success">Voir tous les produits →</a>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer class="bg-success text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1">&copy; 2026 BioFarm - Produits Bio de Qualité</p>
            <p class="small mb-0">🌱 Cultivé avec amour pour votre santé</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>