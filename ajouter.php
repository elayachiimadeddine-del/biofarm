<?php
/**
 * Page d'ajout de produits
 * Formulaire pour ajouter un nouveau produit dans la base de données
 */

// Inclusion du fichier de connexion à la base de données
require_once 'config/database.php';

// Variables pour les messages
$success = "";
$error = "";

// Traitement du formulaire quand il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $nom = trim($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $quantite = intval($_POST['quantite']);
    $image = trim($_POST['image']);
    $description = trim($_POST['description']);
    
    // Validation des données
    if (empty($nom) || empty($prix) || empty($quantite) || empty($description)) {
        $error = "Tous les champs sont obligatoires sauf l'image.";
    } elseif ($prix <= 0) {
        $error = "Le prix doit être supérieur à 0.";
    } elseif ($quantite < 0) {
        $error = "La quantité ne peut pas être négative.";
    } else {
        // Si l'image n'est pas fournie, utiliser une image par défaut
        if (empty($image)) {
            $image = 'https://via.placeholder.com/400x300/28a745/ffffff?text=Produit+Bio';
        }
        
        try {
            // Requête d'insertion dans la base de données
            $sql = "INSERT INTO produits (nom, prix, quantite, image_url, description) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prix, $quantite, $image, $description]);
            
            $success = "Produit ajouté avec succès !";
            
            // Réinitialiser les variables pour vider le formulaire
            $nom = $prix = $quantite = $image = $description = "";
            
        } catch(PDOException $e) {
            $error = "Erreur lors de l'ajout du produit: " . $e->getMessage();
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
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bootstrap (identique aux autres pages) -->
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
                        <a class="nav-link text-white" href="produits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="ajouter.php">Ajouter Produit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h2 class="mb-0 text-center">➕ Ajouter un Nouveau Produit Bio</h2>
                    </div>
                    <div class="card-body">
                        
                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Affichage des messages d'erreur -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Formulaire d'ajout de produit -->
                        <form method="POST" action="">
                            <div class="row">
                                <!-- Nom du produit -->
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom du produit *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nom" 
                                           name="nom" 
                                           value="<?php echo isset($nom) ? htmlspecialchars($nom) : ''; ?>"
                                           placeholder="Ex: Tomates cerises bio"
                                           required>
                                </div>

                                <!-- Prix -->
                                <div class="col-md-6 mb-3">
                                    <label for="prix" class="form-label">Prix (DH) *</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="prix" 
                                           name="prix" 
                                           step="0.01" 
                                           min="0.01"
                                           value="<?php echo isset($prix) ? $prix : ''; ?>"
                                           placeholder="Ex: 3.50"
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Quantité -->
                                <div class="col-md-6 mb-3">
                                    <label for="quantite" class="form-label">Quantité en stock *</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="quantite" 
                                           name="quantite" 
                                           min="0"
                                           value="<?php echo isset($quantite) ? $quantite : ''; ?>"
                                           placeholder="Ex: 50"
                                           required>
                                </div>

                                <!-- Image -->
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">URL de l'image</label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="image" 
                                           name="image" 
                                           value="<?php echo isset($image) ? htmlspecialchars($image) : ''; ?>"
                                           placeholder="Ex: images/tomates.jpg">
                                    <div class="form-text">Laissez vide pour utiliser l'image par défaut</div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Décrivez votre produit bio..."
                                          required><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                            </div>

                            <!-- Boutons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="produits.php" class="btn btn-secondary me-md-2">
                                    ← Retour aux produits
                                </a>
                                <button type="submit" class="btn btn-success">
                                    ✅ Ajouter le produit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Conseils pour les débutants -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">💡 Conseils pour ajouter un produit</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li><strong>Nom :</strong> Soyez précis (ex: "Tomates cerises bio" plutôt que "Tomates")</li>
                            <li><strong>Prix :</strong> Indiquez le prix par unité de mesure (kg, pièce, pot, etc.)</li>
                            <li><strong>Image :</strong> Utilisez des URLs d'images ou placez vos images dans le dossier "images/"</li>
                            <li><strong>Description :</strong> Mentionnez l'origine, les bienfaits, la méthode de culture</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-success text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 BioFarm - Produits Bio de Qualité</p>
            <p>🌱 Cultivé avec amour pour votre santé</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript personnalisé -->
    <script src="script.js"></script>
</body>
</html>