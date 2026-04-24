-- Database: `gestion_journaux`
--

CREATE DATABASE IF NOT EXISTS `gestion_journaux` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion_journaux`;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `periodique`;
DROP TABLE IF EXISTS `suivi_operations`;
DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `matricule` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `est_bloque` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_logiciel`
--

DROP TABLE IF EXISTS `admin_logiciel`;
CREATE TABLE `admin_logiciel` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin_logiciel` (`login`, `nom`, `mot_de_passe`) VALUES
('cidst92', 'acquisition', 'na19jo2004');

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `id_journal` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` int(11) NOT NULL,
  `partie` varchar(50) DEFAULT NULL,
  `editeur` varchar(255) NOT NULL,
  `lieu_edition` varchar(255) DEFAULT NULL,
  `date_edition` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `lieu_stockage` varchar(255) DEFAULT NULL,
  `fichier_pdf` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id_journal`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `periodique`
--

CREATE TABLE `periodique` (
  `id_periodicite` int(11) NOT NULL AUTO_INCREMENT,
  `date_reception` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) DEFAULT NULL,
  `id_journal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_periodicite`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_journal` (`id_journal`),
  CONSTRAINT `periodique_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  CONSTRAINT `periodique_ibfk_2` FOREIGN KEY (`id_journal`) REFERENCES `journal` (`id_journal`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suivi_operations`
--

CREATE TABLE `suivi_operations` (
  `id_suivi` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) DEFAULT NULL,
  `operation` varchar(255) NOT NULL,
  `date_operation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_suivi`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `suivi_operations_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tentatives_connexion`
--

DROP TABLE IF EXISTS `tentatives_connexion`;
CREATE TABLE `tentatives_connexion` (
  `id_tentative` int(11) NOT NULL AUTO_INCREMENT,
  `login_tente` varchar(100) DEFAULT NULL,
  `reussi` tinyint(1) DEFAULT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `date_tentative` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tentative`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
