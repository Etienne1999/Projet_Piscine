-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 14 avr. 2020 à 11:46
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ebay-ece (piscine)`
--
CREATE DATABASE IF NOT EXISTS `ebay-ece (piscine)` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ebay-ece (piscine)`;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ligne_1` varchar(255) NOT NULL,
  `Ligne_2` varchar(255) NOT NULL,
  `Ville` varchar(255) NOT NULL,
  `Code_Postal` varchar(255) NOT NULL,
  `Pays` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `carte_bancaire`
--

DROP TABLE IF EXISTS `carte_bancaire`;
CREATE TABLE IF NOT EXISTS `carte_bancaire` (
  `Numero_Carte` varchar(255) NOT NULL,
  `Nom_Propietaire` varchar(255) NOT NULL,
  `Date_exp` date NOT NULL,
  `ID_User` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Adresse_Facturation` int(11) NOT NULL,
  PRIMARY KEY (`Numero_Carte`),
  KEY `Adresse_Facturation` (`Adresse_Facturation`),
  KEY `Type` (`Type`),
  KEY `ID_User` (`ID_User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID`, `Nom`, `Description`) VALUES
(1, 'Ferraille ou Trésor', 'Objets de collection, Trésor de famille, etc...'),
(2, 'Bon pour le Musée', 'Oeuvres d\'arts, Sculture, etc...'),
(3, 'Accessoire VIP', 'Bijoux, Accessoire haut de gammes, etc...');

-- --------------------------------------------------------

--
-- Structure de la table `cheque_cadeau`
--

DROP TABLE IF EXISTS `cheque_cadeau`;
CREATE TABLE IF NOT EXISTS `cheque_cadeau` (
  `Numero_Carte` varchar(255) NOT NULL,
  `Montant` double NOT NULL,
  PRIMARY KEY (`Numero_Carte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Acheteur` int(11) NOT NULL,
  `Adresse_Livraison` int(11) NOT NULL,
  `Montant_total` double NOT NULL,
  `Date_Commande` datetime NOT NULL DEFAULT current_timestamp(),
  `Date_Livraison` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Acheteur` (`Acheteur`),
  KEY `Adresse_Livraison` (`Adresse_Livraison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_detail`
--

DROP TABLE IF EXISTS `commande_detail`;
CREATE TABLE IF NOT EXISTS `commande_detail` (
  `ID` int(11) NOT NULL,
  `Objet` int(11) NOT NULL,
  `Quantité` int(11) NOT NULL,
  `Montant` double NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Objet` (`Objet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `coupon_reduc`
--

DROP TABLE IF EXISTS `coupon_reduc`;
CREATE TABLE IF NOT EXISTS `coupon_reduc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Montant` int(11) NOT NULL,
  `Type` tinyint(1) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Date_exp` datetime DEFAULT NULL,
  `Utilisations` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

DROP TABLE IF EXISTS `enchere`;
CREATE TABLE IF NOT EXISTS `enchere` (
  `Objet` int(11) NOT NULL,
  `Acheteur` int(11) NOT NULL,
  `Prix` double NOT NULL,
  PRIMARY KEY (`Objet`,`Acheteur`),
  KEY `Acheteur` (`Acheteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `img_produit`
--

DROP TABLE IF EXISTS `img_produit`;
CREATE TABLE IF NOT EXISTS `img_produit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Produit` int(11) NOT NULL,
  `URL` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Produit` (`Produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `offre_achat`
--

DROP TABLE IF EXISTS `offre_achat`;
CREATE TABLE IF NOT EXISTS `offre_achat` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Produit` int(11) NOT NULL,
  `Acheteur` int(11) NOT NULL,
  `Offre` double NOT NULL,
  `Contre_Offre` double NOT NULL,
  `Statut` int(11) NOT NULL,
  `Tentative` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Acheteur` (`Acheteur`),
  KEY `Produit` (`Produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Video` varchar(255) NOT NULL,
  `Prix_Achat` double NOT NULL,
  `Prix_Enchere` double NOT NULL,
  `Date_fin_enchere` datetime NOT NULL,
  `Vendeur` int(11) NOT NULL,
  `Categorie` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Categorie` (`Categorie`),
  KEY `Vendeur` (`Vendeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Achat` tinyint(1) NOT NULL,
  `Vente` tinyint(1) NOT NULL,
  `Gestion_User` tinyint(1) NOT NULL COMMENT 'Gestion role des autres utilisateurs',
  `Cheque_Cadeau` tinyint(1) NOT NULL COMMENT 'Creation et suppression de cheque cadeau',
  `Code_reduc` tinyint(1) NOT NULL COMMENT 'Creation et suppr de code de reduction',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`ID`, `Nom`, `Achat`, `Vente`, `Gestion_User`, `Cheque_Cadeau`, `Code_reduc`) VALUES
(1, 'Admin', 1, 1, 1, 1, 1),
(2, 'Membre', 1, 0, 0, 0, 0),
(3, 'Vendeur', 1, 1, 0, 0, 0),
(4, 'SuperVendeur', 1, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_carte`
--

DROP TABLE IF EXISTS `type_carte`;
CREATE TABLE IF NOT EXISTS `type_carte` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_carte`
--

INSERT INTO `type_carte` (`ID`, `Nom`) VALUES
(1, 'Visa'),
(2, 'Mastercard'),
(3, 'American Express');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Pseudo` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Adresse` int(11) DEFAULT NULL,
  `Role` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Adresse` (`Adresse`),
  KEY `Role` (`Role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `carte_bancaire`
--
ALTER TABLE `carte_bancaire`
  ADD CONSTRAINT `carte_bancaire_ibfk_1` FOREIGN KEY (`Adresse_Facturation`) REFERENCES `adresse` (`ID`),
  ADD CONSTRAINT `carte_bancaire_ibfk_2` FOREIGN KEY (`Type`) REFERENCES `type_carte` (`ID`),
  ADD CONSTRAINT `carte_bancaire_ibfk_3` FOREIGN KEY (`ID_User`) REFERENCES `utilisateur` (`ID`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`Adresse_Livraison`) REFERENCES `adresse` (`ID`);

--
-- Contraintes pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD CONSTRAINT `commande_detail_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `commande` (`ID`),
  ADD CONSTRAINT `commande_detail_ibfk_2` FOREIGN KEY (`Objet`) REFERENCES `produit` (`ID`);

--
-- Contraintes pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`),
  ADD CONSTRAINT `enchere_ibfk_2` FOREIGN KEY (`Objet`) REFERENCES `produit` (`ID`);

--
-- Contraintes pour la table `img_produit`
--
ALTER TABLE `img_produit`
  ADD CONSTRAINT `img_produit_ibfk_1` FOREIGN KEY (`Produit`) REFERENCES `produit` (`ID`);

--
-- Contraintes pour la table `offre_achat`
--
ALTER TABLE `offre_achat`
  ADD CONSTRAINT `offre_achat_ibfk_1` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`),
  ADD CONSTRAINT `offre_achat_ibfk_2` FOREIGN KEY (`Produit`) REFERENCES `produit` (`ID`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`Categorie`) REFERENCES `categorie` (`ID`),
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`Vendeur`) REFERENCES `utilisateur` (`ID`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`Adresse`) REFERENCES `adresse` (`ID`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `role` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
