# Gestion de Devis et Factures

Une application de gestion de devis et factures en PHP, permettant de créer des clients, de générer des devis et factures, et de les exporter en PDF.

## Fonctionnalités

- Ajouter des clients
- Créer des devis et des factures
- Voir la liste des factures et devis
- Afficher les statistiques sur le tableau de bord
- Exporter les factures en PDF

## Technologies

- PHP
- MySQL
- Tailwind CSS (via CDN)
- Dompdf pour la génération de PDF

## Prérequis

- PHP 7.4 ou supérieur
- Serveur MySQL
- Composer pour installer les dépendances PHP

## Installation

1. Clonez le dépôt :

   ```bash
   git clone https://github.com/DARTFRA/facture-devis.git
   cd facture-devis
   ```

2. Installez les dépendances :

   ```bash
   composer install
   ```

3. Configurez la base de données :

   - Créez une base de données MySQL, par exemple `gestion_factures`.
   - Importez le fichier SQL fourni dans la base de données (voir ci-dessous).

4. Configurez la connexion à la base de données dans `data/config.php` :

   ```php
   <?php
   $host = 'localhost';
   $db   = 'gestion_factures';
   $user = 'votre_utilisateur';
   $pass = 'votre_mot_de_passe';
   $charset = 'utf8mb4';

   $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
   $options = [
       PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES   => false,
   ];

   try {
       $pdo = new PDO($dsn, $user, $pass, $options);
   } catch (\PDOException $e) {
       throw new \PDOException($e->getMessage(), (int)$e->getCode());
   }
   ```

5. Lancez l'application sur votre serveur local (ex. : [http://localhost/gestion-devis-factures](http://localhost/gestion-devis-factures)).

## Schéma SQL

Voici le schéma SQL pour les tables `clients`, `factures`, et `articles`.

```sql
CREATE DATABASE gestion_factures;
USE gestion_factures;

-- Table des clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    adresse VARCHAR(255),
    telephone VARCHAR(20)
);

-- Table des factures
CREATE TABLE factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_facture DATE NOT NULL,
    montant_total DECIMAL(10,2),
    type ENUM('devis', 'facture') NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Table des articles des factures
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facture_id INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) AS (quantite * prix_unitaire) STORED,
    FOREIGN KEY (facture_id) REFERENCES factures(id) ON DELETE CASCADE
);
```

## Données d'exemple

Pour tester l'application, vous pouvez insérer les données d'exemple suivantes dans la base de données.

```sql
-- Insertion de clients
INSERT INTO clients (nom, email, adresse, telephone) VALUES
('Jean Dupont', 'jean.dupont@example.com', '123 Rue de Paris, Paris', '0102030405'),
('Marie Martin', 'marie.martin@example.com', '456 Avenue de Lyon, Lyon', '0607080910');

-- Insertion de factures
INSERT INTO factures (client_id, date_facture, montant_total, type) VALUES
(1, '2024-11-10', 150.00, 'facture'),
(2, '2024-11-11', 75.00, 'devis');

-- Insertion d'articles
INSERT INTO articles (facture_id, description, quantite, prix_unitaire) VALUES
(1, 'Service de consultation', 1, 100.00),
(1, 'Maintenance technique', 1, 50.00),
(2, 'Installation de logiciel', 1, 75.00);
```

## Utilisation

1. Accédez au tableau de bord pour voir les statistiques globales.
2. Cliquez sur "Ajouter un Client" pour créer un nouveau client.
3. Cliquez sur "Ajouter une Facture / Devis" pour générer une facture ou un devis.
4. Consultez la liste des factures et devis et téléchargez-les en PDF si nécessaire.

## Crédits

Projet réalisé en PHP avec Tailwind CSS et Dompdf.

## Licence

Ce projet est sous licence MIT.