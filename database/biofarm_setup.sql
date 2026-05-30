-- =====================================================
-- Script de création de la base de données BioFarm
-- Pour XAMPP/phpMyAdmin
-- Devise: Dirham (DH)
-- =====================================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS biofarm_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

-- Utiliser la base de données
USE biofarm_db;

-- =====================================================
-- Table des produits biologiques
-- =====================================================
CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    categorie VARCHAR(50),
    stock INT DEFAULT 0,
    quantite INT DEFAULT 0,
    image_url VARCHAR(255),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- Insertion de données de test (prix en DH)
-- =====================================================
INSERT INTO produits (nom, description, prix, categorie, stock, quantite, image_url) VALUES
('Tomates Bio', 'Tomates biologiques fraîches du jardin, cultivées sans pesticides', 15.50, 'Légumes', 25, 25, 'images/tomates.jpg'),
('Pommes Bio', 'Pommes biologiques croquantes et sucrées, variété locale', 22.00, 'Fruits', 30, 30, 'images/pommes.jpg'),
('Carottes Bio', 'Carottes biologiques orange vif, riches en vitamines', 12.00, 'Légumes', 40, 40, 'images/carottes.jpg'),
('Oranges Bio', 'Oranges biologiques juteuses, parfaites pour les jus', 18.50, 'Fruits', 20, 20, 'images/oranges.jpg'),
('Courgettes Bio', 'Courgettes biologiques tendres, idéales pour les gratins', 14.00, 'Légumes', 15, 15, 'images/courgettes.jpg'),
('Bananes Bio', 'Bananes biologiques mûres à point, source de potassium', 25.00, 'Fruits', 35, 35, 'images/bananes.jpg'),
('Épinards Bio', 'Épinards biologiques frais, riches en fer et vitamines', 16.50, 'Légumes', 20, 20, 'images/epinards.jpg'),
('Fraises Bio', 'Fraises biologiques sucrées de saison, cultivées localement', 35.00, 'Fruits', 12, 12, 'images/fraises.jpg');

-- =====================================================
-- Table des catégories (optionnelle pour extension future)
-- =====================================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion des catégories
INSERT INTO categories (nom, description) VALUES
('Fruits', 'Fruits biologiques frais de saison'),
('Légumes', 'Légumes biologiques cultivés sans pesticides'),
('Céréales', 'Céréales et graines biologiques'),
('Herbes', 'Herbes aromatiques et médicinales biologiques');

-- =====================================================
-- Vue pour affichage des produits avec prix formatés
-- =====================================================
CREATE VIEW vue_produits AS
SELECT 
    id,
    nom,
    description,
    CONCAT(FORMAT(prix, 2), ' DH') AS prix_formate,
    prix,
    categorie,
    stock,
    quantite,
    image_url,
    DATE_FORMAT(date_creation, '%d/%m/%Y %H:%i') AS date_creation_fr
FROM produits
ORDER BY nom;

-- =====================================================
-- Requêtes utiles pour vérification
-- =====================================================

-- Afficher tous les produits
-- SELECT * FROM produits;

-- Afficher les produits avec prix formatés
-- SELECT * FROM vue_produits;

-- Compter les produits par catégorie
-- SELECT categorie, COUNT(*) as nombre_produits 
-- FROM produits 
-- GROUP BY categorie;

-- Afficher les produits en rupture de stock
-- SELECT nom, stock FROM produits WHERE stock <= 5;

-- Calculer la valeur totale du stock
-- SELECT SUM(prix * stock) as valeur_totale_stock FROM produits;

-- =====================================================
-- Index pour optimiser les performances
-- =====================================================
CREATE INDEX idx_categorie ON produits(categorie);
CREATE INDEX idx_prix ON produits(prix);
CREATE INDEX idx_stock ON produits(stock);

-- =====================================================
-- Fin du script
-- =====================================================