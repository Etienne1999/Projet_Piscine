-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 19 avr. 2020 à 16:37
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
-- Base de données :  `ebay-ece`
--
CREATE DATABASE IF NOT EXISTS `ebay-ece` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ebay-ece`;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ligne_1` varchar(255) NOT NULL,
  `Ligne_2` varchar(255) DEFAULT NULL,
  `Ville` varchar(255) NOT NULL,
  `Code_Postal` varchar(255) NOT NULL,
  `Pays` varchar(255) NOT NULL,
  `Telephone` varchar(255) NOT NULL,
  `ID_User` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_User` (`ID_User`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`ID`, `Ligne_1`, `Ligne_2`, `Ville`, `Code_Postal`, `Pays`, `Telephone`, `ID_User`) VALUES
(1, '15 rue guillaume apollinaire', NULL, 'Saint Denis', '93200', 'France ', '01 02 03 04 05', 1),
(2, '37 Quai de grenelle', 'zeae', 'Paris', '75015', 'France', '01 03 02 04 05', 1),
(4, '37 Quai de grenelle', NULL, 'Paris', '75015', 'France', '01 03 02 05 01', 1),
(5, '37 Quai de grenelle', NULL, 'Paris', '75015', 'France', '01 03 02 05 01', 1),
(6, '12, rue du test', NULL, 'Paris', '75000', 'France', '01 05 02 03 04', 3),
(7, '7 passage du manÃ¨ge', NULL, 'Montrouge', '92120', 'France', '0786049768', 2),
(8, '56 avenue de la rÃ©publique', NULL, 'Paris', '75013', 'France', '0156846795', 6),
(9, '12 avenue Verdier', NULL, 'Bagneux', '92220', 'France', '0645889733', 7),
(10, '53 avenue coquelicot', NULL, 'Marseille', '13005', 'France', '0756289146', 8),
(11, '2 impasse Victor Hugo ', NULL, 'Clermont-Ferrand', '63000', 'France', '0625489731', 9),
(12, '43 rue de messe', NULL, 'Paris', '75020', 'France', '0654895463', 10),
(13, '356 Hessel Falls', NULL, 'Bangor', 'L5024', 'Pays de Galle', '96365254621', 11);

-- --------------------------------------------------------

--
-- Structure de la table `carte_bancaire`
--

DROP TABLE IF EXISTS `carte_bancaire`;
CREATE TABLE IF NOT EXISTS `carte_bancaire` (
  `Numero_Carte` varchar(255) NOT NULL,
  `Nom_Proprietaire` varchar(255) NOT NULL,
  `Date_exp` date NOT NULL,
  `CVV` int(11) NOT NULL,
  `Plafond` int(11) DEFAULT NULL COMMENT 'Si null alors pas de plafond',
  `ID_User` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Adresse_Facturation` int(11) DEFAULT NULL,
  PRIMARY KEY (`Numero_Carte`),
  KEY `Adresse_Facturation` (`Adresse_Facturation`),
  KEY `carte_bancaire_ibfk_2` (`Type`),
  KEY `carte_bancaire_ibfk_3` (`ID_User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `carte_bancaire`
--

INSERT INTO `carte_bancaire` (`Numero_Carte`, `Nom_Proprietaire`, `Date_exp`, `CVV`, `Plafond`, `ID_User`, `Type`, `Adresse_Facturation`) VALUES
('1000700000000015', 'GESLIN', '2023-08-01', 143, 6000, 2, 1, 7),
('1234123412341234', 'DIAS DA SILVA', '2020-01-01', 213, NULL, 1, 2, 2),
('1235465645315686', 'Dupont', '2023-07-01', 235, 800, 6, 1, 8),
('1568742658951324', 'Clarck', '2021-12-01', 756, 400, 9, 1, 11),
('3546458756754326', 'Dufour', '2021-04-01', 235, 1500, 7, 2, 9),
('5235465123654512', 'Fourrier', '2020-08-01', 120, 1200, 10, 3, 12),
('5312645826321474', 'Abraham', '2023-10-01', 314, 4000, 11, 2, 13),
('5784231225286954', 'GaillÃ©', '2025-02-01', 316, 7800, 8, 2, 10),
('7987514573582530', 'DIAS DA SILVA', '2022-01-01', 841, NULL, 1, 3, 1),
('9172321441098454', 'DIAS DA SILVA', '2021-03-01', 231, 500, 1, 2, 2),
('9874563214589875', 'kozlow', '2027-02-01', 564, 10000, 3, 2, 6),
('9900940620967860', 'DIAS DA SILVA', '2020-04-01', 111, NULL, 1, 1, 1);

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

--
-- Déchargement des données de la table `cheque_cadeau`
--

INSERT INTO `cheque_cadeau` (`Numero_Carte`, `Montant`) VALUES
('3135593021726809', 15),
('3520193552834272', 20),
('3639105189200888', 75),
('4759295557240639', 2500),
('5863924884650402', 20),
('6034574292407434', 1),
('7228364643893480', 15),
('8844954369134026', 25),
('9753923560804818', 150);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Acheteur` int(11) NOT NULL,
  `Adresse_Livraison` int(11) DEFAULT NULL,
  `Montant_total` double NOT NULL,
  `Date_Commande` datetime NOT NULL DEFAULT current_timestamp(),
  `Date_Livraison` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `commande_ibfk_1` (`Acheteur`),
  KEY `commande_ibfk_2` (`Adresse_Livraison`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande_detail`
--

DROP TABLE IF EXISTS `commande_detail`;
CREATE TABLE IF NOT EXISTS `commande_detail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Commande` int(11) NOT NULL,
  `Objet` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `commande_detail_ibfk_2` (`Objet`),
  KEY `Commande` (`Commande`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `coupon_reduc`
--

DROP TABLE IF EXISTS `coupon_reduc`;
CREATE TABLE IF NOT EXISTS `coupon_reduc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Montant` int(11) NOT NULL,
  `Type` tinyint(1) NOT NULL COMMENT '1 = %, 0 = €',
  `Code` varchar(255) NOT NULL,
  `Date_exp` datetime DEFAULT NULL,
  `Utilisations` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `coupon_reduc`
--

INSERT INTO `coupon_reduc` (`ID`, `Montant`, `Type`, `Code`, `Date_exp`, `Utilisations`) VALUES
(1, 15, 1, 'SEGADO420', '2020-04-19 23:55:05', NULL),
(2, 5, 0, 'PAQUES2020', NULL, -1),
(3, 20, 0, 'PREMIEREFOIS', NULL, 1),
(4, 40, 1, 'TEST', '1998-06-18 15:05:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

DROP TABLE IF EXISTS `enchere`;
CREATE TABLE IF NOT EXISTS `enchere` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Objet` int(11) NOT NULL,
  `Acheteur` int(11) NOT NULL,
  `Prix` double NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `enchere_ibfk_1` (`Acheteur`),
  KEY `Objet` (`Objet`)
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
  KEY `img_produit_ibfk_1` (`Produit`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `img_produit`
--

INSERT INTO `img_produit` (`ID`, `Produit`, `URL`) VALUES
(12, 1, './img/0Anneau.jpeg'),
(13, 14, './img/0Bol_de_Fruit_Leon_sporah.jpg'),
(14, 15, './img/0bouilloire_1940.jpg'),
(15, 13, './img/0Chandelier.jpg'),
(16, 29, './img/0Corbeille_de_bureau.jpg'),
(17, 21, './img/0Ensemble_de_Coupe.jpg'),
(18, 16, './img/0Lampe_a_suspens.jpg'),
(19, 20, './img/0Maquette_.jpg'),
(20, 3, './img/0Mona Lisa.jpg\r\n'),
(21, 2, './img/0Pieces.jpg'),
(22, 18, './img/0Saladier_archanien.jpg'),
(23, 17, './img/0Tire_Bouchon.jpg'),
(24, 19, './img/0Trancheur_a_Pain.jpg');

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
  KEY `offre_achat_ibfk_1` (`Acheteur`),
  KEY `offre_achat_ibfk_2` (`Produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Video` varchar(255) DEFAULT NULL,
  `Prix_min` double DEFAULT 0 COMMENT 'prix mini offre d''achat',
  `Prix_Achat` double DEFAULT 0,
  `Prix_Enchere` double DEFAULT 0,
  `Date_fin_enchere` datetime DEFAULT NULL,
  `Vendu` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'true = vendu; false = en vente',
  `Vendeur` int(11) NOT NULL,
  `Categorie` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `produit_ibfk_2` (`Vendeur`),
  KEY `produit_ibfk_1` (`Categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`ID`, `Nom`, `Description`, `Video`, `Prix_min`, `Prix_Achat`, `Prix_Enchere`, `Date_fin_enchere`, `Vendu`, `Vendeur`, `Categorie`) VALUES
(1, 'Anneau Anti-stress de Laurent Vouton', 'Anneau anti-stress homme en acier Heavenly Way', NULL, NULL, 500, NULL, NULL, 0, 1, 3),
(2, 'Pieces d\'or romain', 'Ce lot de pieces romaines a été retrouve cet été en Bretagne. Elles datent de l\'epoque de Cesar', NULL, NULL, 2000, 1500, '2020-04-16 13:37:00', 1, 2, 1),
(3, 'Mona Lisa', 'Une copie d\'œuvre d\'exception realise par notre cher et bien aime leonard de vinci ', NULL, NULL, NULL, 1000, '2020-04-19 23:55:00', 0, 3, 2),
(13, 'Chandelier du XVIII siecle ', 'Chandelier retrouve chez ma grand-mere, je le met en vente pour des interesses', NULL, NULL, 1200, NULL, NULL, 0, 2, 1),
(14, 'Bol de fruit design par Leon Sporah', 'Leon est un ami proche, il souhaite proposer aux amateurs de ce site ce bien particulier de sa collection', NULL, 50, 350, NULL, NULL, 0, 2, 2),
(15, 'Bouilloire de la seconde guerre mondiale', 'Heritage de père en fils, nous avons decide de nous en separe suite a notre demenagement', NULL, NULL, 35, NULL, NULL, 0, 3, 1),
(16, 'Lampe a suspens', 'Fidele au tradition des années 80, cette lampe vous fait revivre votre jeunesse.', NULL, 0, 0, 1500, '2020-04-25 15:02:00', 0, 6, 3),
(17, 'Tire Bouchon de l\'époque de Napoleon', 'Ce tire-bouchon a du bouchon ! Du vecu ! Vous pouvez donner du vivant a vos soiree a l\'aide ce fabuleux outil', NULL, 20, 150, 0, NULL, 0, 6, 2),
(18, 'Saladier Archanien', 'Ce saladier a du passe. Cree en 1850, vos salades auront un gout nouveau…\r\n', NULL, 0, NULL, 150, '2020-04-20 12:20:00', 0, 6, 2),
(19, 'Trancheur a pain des annees 50', 'Trancheur retrouvé dans ma maison de campagne - avis au amateur', NULL, 20, 50, 0, NULL, 0, 6, 2),
(20, 'Maquette cheval de troie', 'Maquette produite dans les annees 50 par des artisants photubiques\r\n', NULL, 0, 100, 0, NULL, 0, 6, 1),
(21, 'Ensemble de coupe de champagne', 'Cette ensemble datant des annees 40 provenant d\'allemagne de l\'ouest.\r\n', NULL, 0, 100, 0, NULL, 0, 6, 1),
(29, 'Corbeille de bureau', 'Venant des bureaux de l\'elysee, cette corbeille a surement vu des papiers les plus important que l Etat a connu', NULL, 0, 100, 0, NULL, 0, 2, 2);

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
  `Adresse` int(11) DEFAULT NULL COMMENT 'Adresse principale',
  `Carte_Paiement` varchar(255) DEFAULT NULL COMMENT 'Moyen de paiement par defaut',
  `Role` int(11) DEFAULT NULL,
  `Avatar` varchar(255) NOT NULL DEFAULT 'img/profil/avatar.jpg',
  `Banniere` varchar(255) NOT NULL DEFAULT 'img/profil/banniere.jpg',
  PRIMARY KEY (`ID`),
  KEY `Role` (`Role`),
  KEY `utilisateur_ibfk_1` (`Adresse`),
  KEY `Carte_Paiement` (`Carte_Paiement`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `Nom`, `Prenom`, `Pseudo`, `Password`, `Email`, `Adresse`, `Carte_Paiement`, `Role`, `Avatar`, `Banniere`) VALUES
(1, 'DIAS DA SILVA', 'Daniel', 'Magic-System', 'azerty', 'daniel.dias-da-silva@edu.ece.fr', 4, '9172321441098454', 1, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(2, 'GESLIN', 'Etienne', 'Xoxonoxir', 'qwerty', 'etienne.geslin@edu.ece.fr', 7, '1000700000000015', 1, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(3, 'KOZLOW', 'Constantin', 'saladetomate', 'azertyuiop', 'constantin.kozlow@edu.ece.fr', 6, '9874563214589875', 1, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(6, 'DUPONT', 'JEAN', '123soleil', 'tomate', 'piscine.ece.2020@gmail.com', 8, '1235465645315686', 3, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(7, 'Dufour', 'Thomas', 'lapatatedu12', 'patate', 'patate@gmail.com', 9, '3546458756754326', 3, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(8, 'Gailler', 'Julie', 'Julielabesta', 'julie34', 'julei@gmail.com', 10, '5784231225286954', 3, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(9, 'Clarck', 'Marie', 'xXMarieXx', 'marie12', 'mariegameuse@hotmail.fr', 11, '1568742658951324', 3, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(10, 'Fourrier', 'Justine', 'jujulamissdu75', 'JUJU', 'jujulamissdu75@sfr.fr', 12, '5235465123654512', 3, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg'),
(11, 'Abraham', 'Florent', 'abflo', 'floflo', 'flo.ab@hotmail.fr', 13, '5312645826321474', 2, 'img/profil/avatar.jpg', 'img/profil/banniere.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `carte_bancaire`
--
ALTER TABLE `carte_bancaire`
  ADD CONSTRAINT `carte_bancaire_ibfk_1` FOREIGN KEY (`Adresse_Facturation`) REFERENCES `adresse` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `carte_bancaire_ibfk_2` FOREIGN KEY (`Type`) REFERENCES `type_carte` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carte_bancaire_ibfk_3` FOREIGN KEY (`ID_User`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`Adresse_Livraison`) REFERENCES `adresse` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD CONSTRAINT `commande_detail_ibfk_2` FOREIGN KEY (`Objet`) REFERENCES `produit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_detail_ibfk_3` FOREIGN KEY (`Commande`) REFERENCES `commande` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `enchere_ibfk_1` FOREIGN KEY (`Objet`) REFERENCES `produit` (`ID`),
  ADD CONSTRAINT `enchere_ibfk_2` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`);

--
-- Contraintes pour la table `img_produit`
--
ALTER TABLE `img_produit`
  ADD CONSTRAINT `img_produit_ibfk_1` FOREIGN KEY (`Produit`) REFERENCES `produit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `offre_achat`
--
ALTER TABLE `offre_achat`
  ADD CONSTRAINT `offre_achat_ibfk_1` FOREIGN KEY (`Acheteur`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offre_achat_ibfk_2` FOREIGN KEY (`Produit`) REFERENCES `produit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`Categorie`) REFERENCES `categorie` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`Vendeur`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`Adresse`) REFERENCES `adresse` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `role` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_3` FOREIGN KEY (`Carte_Paiement`) REFERENCES `carte_bancaire` (`Numero_Carte`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
