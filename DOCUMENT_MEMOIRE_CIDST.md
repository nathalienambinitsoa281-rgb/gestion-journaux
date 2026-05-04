# DOCUMENTATION TECHNIQUE POUR MÉMOIRE DE FIN D'ÉTUDES

**Thème :** La création d’un site web de gestion de journaux au sein du Centre d’Information et de Documentation Scientifique et Technique (CIDST).

---

## 1. STRUCTURE DE LA BASE DE DONNÉES (LES 3 TABLES PRINCIPALES)

Voici les trois tables fondamentales du système :

### A. Table `journal`
Cette table stocke toutes les informations relatives aux journaux officiels (Gazetimpanjakana).
- **id_journal** (INT, PK) : Identifiant unique.
- **matricule** (INT) : Numéro officiel du journal.
- **partie** (VARCHAR) : La section ou partie du journal.
- **editeur** (VARCHAR) : L'institution ou l'éditeur.
- **date_edition** (DATE) : Date de publication.
- **fichier_pdf** (VARCHAR) : Lien vers le fichier numérique.

### B. Table `utilisateur`
Cette table gère les comptes des agents ou utilisateurs autorisés.
- **id_utilisateur** (INT, PK) : Identifiant unique.
- **nom** (VARCHAR) : Nom de l'utilisateur.
- **matricule** (VARCHAR) : Login de connexion.
- **mot_de_passe** (VARCHAR) : Mot de passe sécurisé (haché).
- **est_bloque** (BOOLEAN) : Statut du compte.

### C. Table `periodique`
Cette table assure le suivi des réceptions et fait le lien entre les utilisateurs et les journaux.
- **id_periodicite** (INT, PK) : Identifiant du suivi.
- **date_reception** (TIMESTAMP) : Date et heure de l'enregistrement.
- **id_utilisateur** (FK) : Référence vers l'utilisateur ayant fait l'enregistrement.
- **id_journal** (FK) : Référence vers le journal concerné.

---

## 2. MODÈLE CONCEPTUEL DE TRAITEMENT (MCT)

Le MCT décrit les événements et les opérations du système.

**Événement 1 : Arrivée d'un nouveau journal**
- **Action :** Vérification des informations.
- **Résultat :** Journal valide OU Journal non conforme.

**Événement 2 : Demande d'enregistrement**
- **Condition :** L'utilisateur doit être connecté.
- **Opération :** Saisie des données dans le formulaire.
- **Résultat :** Mise à jour de la base de données.

**Événement 3 : Recherche par un utilisateur public**
- **Opération :** Saisie d'un mot-clé (Matricule/Editeur).
- **Résultat :** Affichage des résultats en temps réel (AJAX).

---

## 3. MODÈLE ORGANISATIONNEL DE TRAITEMENT (MOT)

Le MOT définit qui fait quoi, où et quand.

| Poste de travail | Événement / Opération | Nature | Délai |
| :--- | :--- | :--- | :--- |
| **Administrateur** | Authentification au système | Interactif | Immédiat |
| **Administrateur** | Enregistrement d'un nouveau journal | Manuel/Web | Quotidien |
| **Système (Serveur)** | Archivage numérique et calcul stats | Automatique | Temps réel |
| **Public / Visiteur** | Consultation des archives via le site | Interactif | Permanent |

---

## 4. MODÈLE LOGIQUE DES DONNÉES (MLD)

Le MLD traduit les relations en termes de clés.
- **UTILISATEUR** (<u>id_utilisateur</u>, nom, prenom, matricule, mot_de_passe, est_bloque)
- **JOURNAL** (<u>id_journal</u>, matricule, partie, editeur, lieu_edition, date_edition, fichier_pdf, prix)
- **PERIODIQUE** (<u>id_periodicite</u>, date_reception, *id_utilisateur*, *id_journal*)
- **ADMIN_LOGICIEL** (<u>id_admin</u>, login, nom, mot_de_passe)

---

## 5. MODÈLE PHYSIQUE DES DONNÉES (MPD)

C'est l'implémentation SQL concrète (MySQL).

```sql
CREATE TABLE journal (
  id_journal INT PRIMARY KEY AUTO_INCREMENT,
  matricule INT NOT NULL,
  partie VARCHAR(50),
  editeur VARCHAR(255) NOT NULL,
  date_edition DATE,
  fichier_pdf VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE utilisateur (
  id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100),
  prenom VARCHAR(100),
  adresse VARCHAR(255),
  contact VARCHAR(50),
  matricule VARCHAR(50) UNIQUE,
  fonction VARCHAR(100),
  mot_de_passe VARCHAR(255),
  est_bloque TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE periodique (
  id_periodicite INT PRIMARY KEY AUTO_INCREMENT,
  date_reception TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  id_utilisateur INT,
  id_journal INT,
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
  FOREIGN KEY (id_journal) REFERENCES journal(id_journal)
) ENGINE=InnoDB;
```

---
*Document préparé pour la rédaction du mémoire CIDST - 2026*
