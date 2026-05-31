<?php
/**
 * Page de catalogue des produits
 * Conforme au Chapitre 13 (PDO et boucles PHP)
 */
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY nom ASC");
    $produits = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Erreur de récupération des produits.";
    $produits = array();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - BioFarm</title>
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
                    <li class="nav-item"><a class="nav-link active" href="produits.php">Nos Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="ajouter.php">Ajouter un produit</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-success mb-4 text-center">Notre Catalogue de Produits</h1>
        
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <?php if (empty($produits)) { ?>
            <div class="alert alert-warning text-center">Aucun produit trouvé.</div>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($produits as $produit) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo htmlspecialchars($produit['image_url']); ?>" class="card-img-top" alt="Image produit" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success fw-bold"><?php echo htmlspecialchars($produit['nom']); ?></h5>
                                <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($produit['description']); ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge bg-success fs-6">
                                        <?php echo number_format($produit['prix'], 2); ?> DH
                                    </span>
                                    <span class="badge bg-secondary">
                                        Stock: <?php echo $produit['quantite']; ?> unités
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="text-center mt-4">
            <a href="ajouter.php" class="btn btn-success btn-lg">➕ Ajouter un produit</a>
        </div>
    </div>

    <footer class="bg-success text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1">&copy; 2026 BioFarm - Produits Bio de Qualité</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>