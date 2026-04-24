# GESTION JOURNAUX - Système d'Archivage Numérique

Projet de gestion et d'archivage des journaux officiels pour le Ministère de l'Intérieur.

## Fonctionnalités
- **Dashboard Admin**: Gestion des utilisateurs et surveillance des opérations.
- **Enregistrement**: Ajout de journaux avec fichiers PDF.
- **Recherche**: Filtres par numéro, partie, éditeur et date.
- **Statistiques**: Visualisation des données enregistrées.
- **Sécurité**: Hashage des mots de passe et logs d'activité.

## Déploiement sur Railway

1. **GitHub**: Créez un nouveau dépôt sur GitHub et poussez ce code.
2. **Base de données**: Sur Railway, ajoutez un service **MySQL**.
3. **Variables d'environnement**: Railway injectera automatiquement les variables `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, et `MYSQLPASSWORD`.
4. **Initialisation DB**: Importez le fichier `schema.sql` dans votre base de données Railway.
5. **Déploiement**: Connectez votre dépôt GitHub à Railway.

## Technologies
- PHP 8.x
- MySQL
- CSS3 (Custom Properties, Glassmorphism)
- JavaScript (Vanilla)
