-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 06 juin 2026 à 19:32
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biofarm_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `date_creation`) VALUES
(1, 'Fruits', 'Fruits biologiques frais de saison', '2026-05-31 13:05:52'),
(2, 'Légumes', 'Légumes biologiques cultivés sans pesticides', '2026-05-31 13:05:52'),
(3, 'Céréales', 'Céréales et graines biologiques', '2026-05-31 13:05:52'),
(4, 'Herbes', 'Herbes aromatiques et médicinales biologiques', '2026-05-31 13:05:52');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `prix` decimal(10,2) NOT NULL,
  `categorie` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int DEFAULT '0',
  `unite` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'kg',
  `quantite` int DEFAULT '0',
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_categorie` (`categorie`),
  KEY `idx_prix` (`prix`),
  KEY `idx_stock` (`stock`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `categorie`, `stock`, `unite`, `quantite`, `image_url`, `date_creation`, `date_modification`) VALUES
(1, 'Tomates Bio', 'Tomates biologiques fraîches du jardin, cultivées sans pesticides', 15.50, 'Légumes', 25, 'kg', 25, 'images/tomate.png', '2026-05-31 13:05:52', '2026-05-31 15:28:45'),
(2, 'Pommes Bio', 'Pommes biologiques croquantes et sucrées, variété locale', 22.00, 'Fruits', 30, 'kg', 30, 'images/pomme.png', '2026-05-31 13:05:52', '2026-05-31 15:28:45'),
(3, 'Carottes Bio', 'Carottes biologiques orange vif, riches en vitamines', 12.00, 'Légumes', 40, 'kg', 40, 'images/carottes.png', '2026-05-31 13:05:52', '2026-05-31 15:46:06'),
(4, 'Oranges Bio', 'Oranges biologiques juteuses, parfaites pour les jus', 18.50, 'Fruits', 20, 'kg', 20, 'images/orange.png', '2026-05-31 13:05:52', '2026-05-31 15:28:45'),
(5, 'Courgettes Bio', 'Courgettes biologiques tendres, idéales pour les gratins', 14.00, 'Légumes', 15, 'kg', 15, 'images/courgettes.png', '2026-05-31 13:05:52', '2026-05-31 15:28:46'),
(6, 'Bananes Bio', 'Bananes biologiques mûres à point, source de potassium', 25.00, 'Fruits', 35, 'kg', 35, 'images/banane.png', '2026-05-31 13:05:52', '2026-05-31 15:28:46'),
(7, 'Épinards Bio', 'Épinards biologiques frais, riches en fer et vitamines', 16.50, 'Légumes', 20, 'kg', 20, 'images/épinards.png', '2026-05-31 13:05:52', '2026-05-31 15:46:06'),
(8, 'Fraises Bio', 'Fraises biologiques sucrées de saison, cultivées localement', 35.00, 'Fruits', 12, 'kg', 12, 'images/fraises.png', '2026-05-31 13:05:52', '2026-05-31 15:28:46'),
(10, 'Menthe Bio', 'Menthe fraîche bio, idéale pour les infusions et le thé marocain', 8.00, NULL, 50, 'botte', 50, 'images/default.png', '2026-05-31 16:10:49', '2026-05-31 16:10:49');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_produits`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_produits`;
CREATE TABLE IF NOT EXISTS `vue_produits` (
`id` int
,`nom` varchar(100)
,`description` text
,`prix_formate` varchar(51)
,`prix` decimal(10,2)
,`categorie` varchar(50)
,`stock` int
,`quantite` int
,`image_url` varchar(255)
,`date_creation_fr` varchar(21)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_produits`
--
DROP TABLE IF EXISTS `vue_produits`;

DROP VIEW IF EXISTS `vue_produits`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_produits`  AS SELECT `produits`.`id` AS `id`, `produits`.`nom` AS `nom`, `produits`.`description` AS `description`, concat(format(`produits`.`prix`,2),' DH') AS `prix_formate`, `produits`.`prix` AS `prix`, `produits`.`categorie` AS `categorie`, `produits`.`stock` AS `stock`, `produits`.`quantite` AS `quantite`, `produits`.`image_url` AS `image_url`, date_format(`produits`.`date_creation`,'%d/%m/%Y %H:%i') AS `date_creation_fr` FROM `produits` ORDER BY `produits`.`nom` ASC ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
