# GUIDE D'UTILISATION DE L'APPLICATION (GESTION DES JOURNAUX)

Ce document explique toutes les étapes nécessaires pour faire fonctionner cette application web.

## 1. Prérequis
Pour faire fonctionner le projet, vous avez besoin de :
*   **XAMPP** : Pour faire fonctionner le serveur Apache (pour PHP).
*   **PostgreSQL (pgAdmin)** ou **MySQL (phpMyAdmin)** : Pour stocker les données (Base de données). *Note : Le projet semble configuré pour MySQL dans db.php.*

## 2. Préparation de la Base de Données (MySQL)
1.  Ouvrez **phpMyAdmin** (généralement `localhost/phpmyadmin`).
2.  Créez une nouvelle base de données :
    *   Nom : `gestion_journaux` (tel que défini dans `db.php`).
3.  Une fois dans `gestion_journaux` :
    *   Allez dans l'onglet **SQL**.
    *   Copiez tout le contenu du fichier **[schema.sql](file:///d:/projet%20DTS/schema.sql)**.
    *   Cliquez sur le bouton "Exécuter" pour créer toutes les tables.

## 3. Préparation du Projet dans XAMPP
1.  Placez le dossier de votre projet dans le répertoire `C:\xampp\htdocs\` (exemple : `C:\xampp\htdocs\projet_dts\`).
2.  Ouvrez le **XAMPP Control Panel** et démarrez (Start) **Apache** et **MySQL**.

## 4. Connexion PHP et Base de Données
Ouvrez le fichier **[db.php](file:///d:/projet%20DTS/db.php)** et vérifiez les éléments suivants :
*   `$dbname = 'gestion_journaux'` : Vérifiez s'il correspond au nom créé dans phpMyAdmin.
*   `$user = 'root'` : Votre login phpMyAdmin.
*   `$password = ''` : Votre mot de passe phpMyAdmin (laissez vide si vous n'en avez pas).

## 5. Utilisation de l'Application
Ouvrez votre navigateur (Chrome, Firefox, etc.) et tapez : `localhost/nom_de_votre_dossier/index.php`.

### A. L'Administrateur
*   **Login** : `cidst92`
*   **Mot de passe** : `na19jo2004`
*   **Actions possibles** :
    *   Voir tous les utilisateurs.
    *   Bloquer ou supprimer des utilisateurs.
    *   Suivre les opérations effectuées par chaque utilisateur.
    *   Voir toutes les tentatives de connexion.

### B. L'Utilisateur
1.  **Inscription** : Cliquez sur "S'inscrire" sur la page de connexion.
2.  **Connexion** : Utilisez votre CIN et le mot de passe que vous avez créé.
3.  **Enregistrement d'un Journal** :
    *   Remplissez le formulaire : Partie, Éditeur, etc.
    *   La date et l'heure de réception sont automatiques.
4.  **Liste des Journaux** : L'historique de tous les journaux enregistrés est visible en bas de page.

## 6. Déploiement sur GitHub et Railway (Hébergement En Ligne)

Le projet est configuré pour fonctionner à la fois en **local (XAMPP)** et **en ligne (Railway)** sans changer le code.

### A. GitHub
1.  Créez un compte sur [github.com](https://github.com).
2.  Créez un nouveau dépôt (**New Repository**) nommé `gestion-journaux`.
3.  Initialisez git dans votre dossier local et envoyez le code :
    ```bash
    git init
    git add .
    git commit -m "Déploiement initial"
    git branch -M main
    git remote add origin https://github.com/VOTRE_NOM/gestion-journaux.git
    git push -u origin main
    ```

### B. Railway
1.  Connectez-vous sur [railway.app](https://railway.app) avec votre compte GitHub.
2.  **Créer la Base de Données** :
    *   `New Project` -> `Provision MySQL`.
    *   Une fois créée, allez dans l'onglet **Variables** de la base de données pour voir les identifiants.
3.  **Importer les Tables** :
    *   Utilisez un outil comme **HeidiSQL** ou le terminal pour importer votre `schema.sql` dans la base de données Railway en utilisant l'URL de connexion fournie par Railway.
4.  **Déployer l'Application PHP** :
    *   `New Project` -> `Deploy from GitHub repo` -> Sélectionnez `gestion-journaux`.
5.  **Lier l'Application et la Base de Données** :
    *   Railway devrait automatiquement lier les variables (`MYSQLHOST`, `MYSQLPASSWORD`, etc.) si les deux services sont dans le même projet. Sinon, copiez-les manuellement dans l'onglet **Variables** de votre service PHP.
6.  **Accès En Ligne** :
    *   Dans l'onglet **Settings** du service PHP sur Railway, cliquez sur `Generate Domain` pour avoir votre adresse `https://...railway.app`.

---
*Note : Le fichier `db.php` détecte automatiquement s'il est sur Railway et utilise les bonnes variables.*
