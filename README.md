# BioFarm

Application web de gestion de produits biologiques, développée dans le cadre de notre projet de fin de module en PHP à l'ENSA Oujda (ITIRC 4, 2025-2026).

---

## L'idée

On a eu cette idée en pensant aux producteurs locaux qui gèrent encore leurs stocks à la main. On voulait faire quelque chose de concret, pas juste une app basique pour avoir une note. BioFarm permet de consulter un catalogue de produits bio, d'en ajouter via un formulaire, et de voir les dernières nouveautés sur la page d'accueil.

Rien de compliqué, mais tout est fonctionnel et sécurisé.

---

## L'équipe

- Asmae Ziani  
- Imad Eddine Elayachi  
- Mohammed Derkaoui  
- Saad Zayou  

Encadrant : M. Mohammed Ouadoud

---

## Ce qu'on a utilisé

- PHP 8 natif, pas de framework
- MySQL avec phpMyAdmin
- PDO pour les requêtes (préparées, pour éviter les injections SQL)
- Bootstrap 5.3 pour l'interface
- WAMP en local
- Git et GitHub pour le versioning

---

## Lancer le projet en local

Cloner le repo dans le dossier www de WAMP, créer une base de données qui s'appelle `biofarm_db`, puis créer la table :

```sql
CREATE TABLE produits (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255),
  prix DECIMAL(10,2),
  quantite INT,
  stock INT,
  unite VARCHAR(50),
  categorie VARCHAR(50),
  image_url VARCHAR(255),
  description TEXT,
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

Ensuite modifier `config/database.php` avec vos infos de connexion. Ce fichier est dans le .gitignore donc il ne sera pas pushé.

Ouvrir `http://localhost/biofarm` dans le navigateur, ça marche.

---

## Ce que fait l'app

- La page d'accueil affiche les 3 produits ajoutés en dernier
- Le catalogue liste tout, trié par ordre alphabétique
- Le formulaire d'ajout vérifie les données côté serveur avant d'insérer quoi que ce soit en base
- Si on laisse le champ image vide, une image par défaut s'affiche automatiquement
- Les cartes ont une petite animation au chargement, c'est fait en JS vanilla avec une boucle for et setTimeout

---

## Sécurité

On a utilisé des requêtes préparées PDO donc pas d'injection SQL possible. Les sorties HTML passent par htmlspecialchars() pour le XSS. Et le fichier de config avec le mot de passe est dans le .gitignore, on a failli oublier ça au début.

---

## Ce qu'on aurait voulu ajouter

- Une page de connexion admin
- La modification et suppression de produits (on a fait que l'ajout)
- Un vrai upload d'image au lieu de saisir le chemin manuellement
- Des filtres par catégorie ou par prix

---

## Structure des fichiers

```
biofarm/
├── config/database.php
├── css/style.css
├── images/
├── index.php
├── produits.php
├── ajouter.php
├── script.js
├── biofarm_db.sql       ← ici
├── .gitignore
└── .htaccess
```

---

Juin 2026 — ENSA Oujda
