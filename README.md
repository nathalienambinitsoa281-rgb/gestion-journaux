# GESTION DE JOURNAUX CIDST TSIMBAZAZA

Système de gestion et d'archivage des journaux (Gazetimpanjakana) pour le CIDST à Tsimbazaza.

## 🚀 DEPLOIEMENT (CLICK & GO !)

### MÉTHODE 1 : UN CLICK SUR RAILWAY (Le plus simple !)

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template)

Si vous cliquez sur le bouton ci-dessus, suivez ces étapes :

1.  **Connectez votre GitHub** : Autorisez Railway à accéder à votre GitHub.
2.  **Choisissez votre dépôt** : Sélectionnez le dépôt GitHub contenant ce code.
3.  **Ajoutez MySQL** : Cliquez sur **Add Service** → Choisissez **MySQL**.
4.  **Attendez la fin du déploiement** : Cela prendra 1-2 minutes.
5.  **Importez la base de données** :
    - Ouvrez le service MySQL sur Railway.
    - Cliquez sur **Connect** → **Connect with phpMyAdmin**.
    - Dans phpMyAdmin, cliquez sur l'onglet **Importer**.
    - Choisissez le fichier `schema.sql` de votre ordinateur et cliquez sur **Exécuter**.
6.  **C'est fini !** : Ouvrez le lien donné par Railway pour accéder à votre plateforme !

---

### MÉTHODE 2 : ÉTAPE PAR ÉTAPE (Si vous préférez faire le push vous-même)

#### Étape 1 : Préparez GitHub
1.  Allez sur [GitHub](https://github.com) et créez un **New Repository**.
2.  Ouvrez un terminal dans le dossier `projet DTS` et exécutez ces commandes (une par une) :
    ```bash
    git init
    git add .
    git commit -m "Premier commit"
    git remote add origin VOTRE_LIEN_GITHUB_ICI
    git push -u origin main
    ```

#### Étape 2 : Déployez sur Railway
1.  Ouvrez [Railway.app](https://railway.app) et connectez-vous avec votre compte GitHub.
2.  Cliquez sur **New Project** → Choisissez **Deploy from GitHub repo**.
3.  Sélectionnez le dépôt que vous venez de créer.
4.  Cliquez sur **Add Service** → Choisissez **MySQL**.
5.  Attendez que le déploiement soit terminé (vous verrez un check vert).

#### Étape 3 : Initialisez la base de données
1.  Dans votre projet Railway, cliquez sur le service **MySQL**.
2.  Cliquez sur l'onglet **Connect**.
3.  Cliquez sur **Connect with phpMyAdmin**.
4.  Dans phpMyAdmin :
    - Cliquez sur le nom de votre base de données (ça ressemble à `railway`).
    - Cliquez sur l'onglet **Importer** en haut.
    - Cliquez sur **Choisir un fichier** → Sélectionnez `schema.sql` depuis votre ordinateur.
    - Cliquez sur **Exécuter** en bas à droite.

#### Étape 4 : Profitez !
Cliquez sur le lien généré par Railway (en haut à gauche, ça ressemble à `votre-projet.up.railway.app`) et votre plateforme est prête !

---

## Fonctionnalités
- **Dashboard Admin**: Gestion des utilisateurs et surveillance des opérations.
- **Enregistrement**: Ajout de journaux avec fichiers PDF.
- **Recherche**: Filtres par numéro, partie, éditeur et date.
- **Statistiques**: Visualisation des données enregistrées.
- **Sécurité**: Hashage des mots de passe et logs d'activité.

## Identifiants Admin par défaut
- **Login**: `cidst tsimbazaza`
- **Mot de passe**: `acquisition92`

## Technologies
- PHP 8.x
- MySQL
- CSS3 (Custom Properties, Glassmorphism)
- JavaScript (Vanilla)
