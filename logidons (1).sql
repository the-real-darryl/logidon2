-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 27 Septembre 2018 à 17:46
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `logidons`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`ID`, `NOM`, `DESCRIPTION`) VALUES
(1, 'ameublement', 'touy ce qui conserne les meubles de la maison,les meubles de bureau,...'),
(2, 'monnaie', 'tout ce qui conserne les cheques, les virments banquaires, les virements par cartes,...'),
(3, 'electroniques', 'tout ce qui consernes les appareils electroniques: TV, les postes redio,les ordinateurs, les routeurs, les switchs, ...'),
(4, 'electromenagers', 'tout ce qui conserne le frigidaires, lave-vaisselles, lave-linges, ...');

-- --------------------------------------------------------

--
-- Structure de la table `compagnie`
--

CREATE TABLE `compagnie` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) CHARACTER SET utf8 NOT NULL,
  `DATE_CREATION` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compagnie`
--

INSERT INTO `compagnie` (`ID`, `NOM`, `DATE_CREATION`) VALUES
(1, 'walmart', '2018-09-17'),
(2, 'maurice', '2018-09-24');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilitebenevole`
--

CREATE TABLE `disponibilitebenevole` (
  `idDisponibilite` int(11) NOT NULL,
  `fkBenevole` int(11) NOT NULL,
  `date` date NOT NULL,
  `debut` time NOT NULL DEFAULT '08:00:00',
  `fin` time NOT NULL DEFAULT '16:00:00',
  `accepter` tinyint(1) DEFAULT '0',
  `note` varchar(200) DEFAULT NULL,
  `traiter` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `disponibilitebenevole`
--

INSERT INTO `disponibilitebenevole` (`idDisponibilite`, `fkBenevole`, `date`, `debut`, `fin`, `accepter`, `note`, `traiter`) VALUES
(1, 43, '2018-09-24', '08:00:00', '16:00:00', 0, NULL, 0),
(2, 43, '2018-01-01', '00:00:00', '01:00:00', 1, NULL, 1),
(3, 43, '2018-01-01', '00:00:00', '00:01:00', NULL, NULL, 0),
(4, 43, '2020-02-01', '02:00:00', '05:02:00', NULL, NULL, 0),
(5, 43, '2018-01-01', '00:00:00', '02:01:00', NULL, NULL, 0),
(6, 43, '2018-01-01', '01:01:00', '02:02:00', NULL, NULL, 0),
(7, 43, '2018-02-01', '00:00:00', '00:00:00', 1, NULL, 1),
(8, 43, '2018-02-01', '00:00:00', '00:00:00', NULL, NULL, 0),
(9, 43, '2018-02-01', '00:00:00', '00:00:00', NULL, NULL, 0),
(10, 43, '2018-01-01', '01:01:00', '01:22:00', NULL, NULL, 0),
(11, 43, '2018-01-01', '01:01:00', '02:00:00', NULL, NULL, 0),
(12, 43, '2018-01-01', '00:00:00', '00:49:00', NULL, NULL, 0),
(13, 43, '2019-02-01', '01:02:00', '01:02:00', NULL, NULL, 0),
(14, 43, '2019-02-01', '00:00:00', '06:05:00', NULL, NULL, 0),
(15, 43, '2018-01-01', '00:00:00', '01:01:00', NULL, NULL, 0),
(16, 43, '2018-01-01', '00:00:00', '00:00:00', NULL, NULL, 0),
(17, 43, '2018-01-01', '00:00:00', '02:01:00', NULL, NULL, 0),
(18, 43, '2022-04-05', '04:03:00', '03:02:00', NULL, NULL, 0),
(19, 43, '2020-03-05', '02:01:00', '01:02:00', NULL, NULL, 0),
(20, 5, '2018-09-25', '08:04:00', '12:17:00', NULL, NULL, 0),
(21, 43, '2019-01-01', '01:01:00', '01:06:00', NULL, NULL, 0),
(22, 43, '2018-01-01', '00:00:00', '00:01:00', NULL, NULL, 0),
(23, 43, '2018-01-01', '00:00:00', '01:01:00', NULL, NULL, 0),
(24, 43, '2026-04-01', '00:00:00', '05:00:00', NULL, NULL, 0),
(25, 43, '2018-01-01', '00:00:00', '08:00:00', NULL, NULL, 0),
(26, 43, '2018-01-01', '01:01:00', '01:01:00', NULL, NULL, 0),
(27, 43, '2019-02-03', '00:01:00', '00:04:00', NULL, NULL, 0),
(28, 43, '2018-01-01', '00:00:00', '02:01:00', NULL, NULL, 0),
(29, 43, '2018-09-28', '10:00:00', '12:00:00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `don`
--

CREATE TABLE `don` (
  `ID` int(11) NOT NULL,
  `MEMBRE_ID` int(11) NOT NULL,
  `ID_COMPAGNIE` int(11) DEFAULT NULL,
  `EMPLOYE_ID` int(11) NOT NULL,
  `CATEGORIE_ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `QUANTITE` int(4) NOT NULL,
  `MODE_LIVRAISON` varchar(255) NOT NULL,
  `MONTANT` float NOT NULL DEFAULT '0',
  `DATE_PROMESSE` date DEFAULT NULL,
  `DATE_PROMISE` date DEFAULT NULL,
  `DATE_ANNULATION` date DEFAULT NULL,
  `DATE_ACCEPTATION` date DEFAULT NULL,
  `DATE_RECU` date DEFAULT NULL,
  `DATE_REFUS` date DEFAULT NULL,
  `PHOTO` varchar(255) DEFAULT 'aucune photo fournie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `don`
--

INSERT INTO `don` (`ID`, `MEMBRE_ID`, `ID_COMPAGNIE`, `EMPLOYE_ID`, `CATEGORIE_ID`, `NOM`, `DESCRIPTION`, `QUANTITE`, `MODE_LIVRAISON`, `MONTANT`, `DATE_PROMESSE`, `DATE_PROMISE`, `DATE_ANNULATION`, `DATE_ACCEPTATION`, `DATE_RECU`, `DATE_REFUS`, `PHOTO`) VALUES
(27, 70, 2, 3, 1, 'lauraine', 'le chat bleu', 1, '1', 10, '2018-09-21', '2018-09-27', NULL, NULL, NULL, NULL, '34c481d101.jpg'),
(28, 70, 2, 4, 2, 'lauraine', 'le chat bleu', 1, '1', 2, '2018-09-21', '2018-09-28', NULL, NULL, NULL, NULL, 'd13b40536c.jpg'),
(29, 77, NULL, 5, 1, 'lauraine', 'le chat bleu', 1, '1', 672562, '2018-09-24', '2018-09-07', NULL, '2018-09-24', NULL, NULL, 'e2a91901b0.jpg'),
(30, 77, NULL, 5, 1, 'lauraine', 'le chat bleu', 1, '1', 672562, '2018-09-24', '2018-09-07', NULL, NULL, NULL, '2018-09-24', 'e2a91901b0.jpg'),
(31, 77, NULL, 5, 1, 'lauraine', 'le chat bleu', 1, '1', 672562, '2018-09-24', '2018-10-01', NULL, NULL, NULL, NULL, 'e2a91901b0.jpg'),
(32, 77, NULL, 5, 1, 'lauraine', 'le chat bleu', 1, '1', 672562, '2018-09-24', '2018-10-02', NULL, NULL, NULL, NULL, 'e2a91901b0.jpg'),
(33, 77, NULL, 5, 1, 'lauraine', 'le chat bleu', 1, '1', 672562, '2018-09-24', '2018-10-03', NULL, NULL, NULL, NULL, 'e2a91901b0.jpg'),
(34, 43, NULL, 43, 1, 'lauraine', 'le chat bleu', 1, '1', 450, '2018-09-27', '2017-02-01', '2018-09-27', NULL, NULL, NULL, '681e24d158.jpg'),
(35, 43, NULL, 46, 1, 'lauraine', 'le chat bleu', 1, '1', 8000, '2018-09-27', '2018-01-01', '2018-09-27', NULL, NULL, NULL, '9671416c28.jpg'),
(36, 43, NULL, 2, 1, 'lauraine', 'le chat bleu', 1, '1', 900000, '2018-09-27', '2018-01-01', '2018-09-27', NULL, NULL, '2018-09-27', '89ba274bfb.jpg'),
(37, 43, NULL, 3, 1, 'lauraine', 'le chat bleu', 1, '1', 60, '2018-09-27', '2018-01-01', '2018-09-27', NULL, NULL, NULL, 'ddaa7994a7.jpg'),
(38, 43, NULL, 4, 2, 'hamac', 'le chat bleu et vert', 12, '1', 65, '2018-09-27', '2024-05-05', '2018-09-27', NULL, NULL, NULL, '71fe4a0403.png'),
(39, 43, NULL, 5, 2, 'chaise', 'lasksnlasckn', 6, 'je vais deposer au centre', 345, '2018-09-27', '2018-01-01', NULL, NULL, NULL, NULL, '4343b7b473.png');

-- --------------------------------------------------------

--
-- Structure de la table `horrairebenevole`
--

CREATE TABLE `horrairebenevole` (
  `idLigneHorraire` int(11) NOT NULL,
  `date` date NOT NULL,
  `debut` time NOT NULL DEFAULT '08:00:00',
  `fin` time NOT NULL DEFAULT '16:00:00',
  `fkBenevole` int(11) NOT NULL,
  `fkEmploye` int(11) NOT NULL,
  `note` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `COURRIEL` varchar(255) NOT NULL,
  `ADRESSE` varchar(255) NOT NULL,
  `VILLE` varchar(255) NOT NULL,
  `CODE_POSTALE` varchar(255) NOT NULL,
  `PROVINCE` varchar(255) NOT NULL,
  `TELEPHONE` varchar(255) NOT NULL,
  `MOT_DE_PASSE` varchar(255) DEFAULT NULL,
  `ACTIF` tinyint(1) DEFAULT '1',
  `GROUP_ID` int(8) DEFAULT NULL,
  `DATE_CREATION` date DEFAULT NULL,
  `NUM_JETON` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`ID`, `NOM`, `COURRIEL`, `ADRESSE`, `VILLE`, `CODE_POSTALE`, `PROVINCE`, `TELEPHONE`, `MOT_DE_PASSE`, `ACTIF`, `GROUP_ID`, `DATE_CREATION`, `NUM_JETON`) VALUES
(1, 'admin', 'admin@admin.ca', 'rosemont', 'montreal', 's5g 9r3', 'quebec', '1234567890', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, '2018-09-01', 0),
(2, 'tahar', 'tahar@gmail.ca', 'rosemont', 'montreal', 'd4v 9m4', 'quebec', '1234567890', 'f70de0e2d1f353c8ae55bdf55d5bee7b1f80565e', 1, 3, '2018-09-01', 0),
(3, 'manesh', 'manesh@gmail.ca', 'rosemont', 'montreal', 'd4b 9h7', 'quebec', '123', '2acc69720f65306113b56d3db5045006b00ea378', 1, 3, '2018-09-01', 0),
(4, 'guy', 'guy@gmail.ca', 'rosemont', 'montreal', 's4c 9f3', 'quebec', '123', 'b5cd271b521acc9a180d5ff625e8f9a71c235729', 1, 3, '2018-09-01', 0),
(5, 'nikoleta', 'nikoleta@gmail.ca', 'rosemonte', 'montreal', 'c1f 5g9', 'quebec', '123123159', 'a96837d3aacd82830892e461141e20c3f45063c0', 1, 4, '2018-09-01', 1),
(6, 'daryl', 'daryl@gmail.ca', 'rosemont', 'montreal', 'd4c 9g3', 'quebec', '123', 'd5ac5af5bdb426cefff1c69fc9b96b82ec2d8c0e', 1, 3, '2018-09-01', 0),
(7, 'georges', 'georges@gmail.ca', 'rosemont', 'montreal', 's4d y6u', 'quebec', '1234567890', '', 1, 5, '2018-09-01', 0),
(13, 'Ivana', 'ivana@gmail.ca', 'rosemont', 'montreal', 'a4d 9f3', 'quebec', '514214', NULL, 1, 5, '2018-09-08', 0),
(15, 'lucie', 'lucie@gmail.ca', 'rosemont', 'montreal', 'a5f 9g3', 'quebec', '464153', NULL, 1, 5, '2018-09-03', 0),
(39, 'gordon', 'gordon@gmail.ca', 'rosemont', 'montreal', 'a4d 9r3', 'quebec', '9341345456', NULL, 1, 5, '2018-09-07', 0),
(40, 'jhon', 'jhon@gmail.ca', 'rosemont', 'montreal', 's5v 9f1', 'quebec', '41345456', NULL, 1, 5, '2018-09-02', 0),
(41, 'lee', 'lee@gmail.ca', 'rosemont', 'montreal', 'a4d 9v7', 'quebec', '7465513', NULL, 1, 5, '2018-09-07', 0),
(42, 'hong', 'hong@gmail.ca', 'rosemont', 'montreal', 'a4c 9e1', 'quebec', '7465513', NULL, 1, 5, '2018-09-01', 0),
(43, 'Teodora', 'tedi@gmail.com', 'rosemont', 'montreal', 's4f 9v7', 'quebec', '8453168219', '5e779c488063cba1675770dd066f908a8aa6100e', 1, 4, '2018-09-12', 0),
(44, 'Maria', 'maria@gmail.ca', 'rosemont', 'montreal', 'a4d 9r1', 'quebec', '436413', NULL, 1, 5, '2018-09-08', 0),
(46, 'marie', 'marie@gmail.ca', 'rosemont', 'montreal', 's4c 9b2', 'quebec', '5142224545', 'f0fd596f396d8fc32d5e4fe4c73c61fa2ac55c70', 1, 4, '2018-09-11', 0),
(47, 'fadi', 'fadi@gmail.ca', 'rosemont', 'montreal', 'a4c 9r3', 'quebec', '1234567890', NULL, 1, 5, '2018-09-08', 0),
(48, 'sonia', 'sonia@gmail.ca', 'rosemont', 'montreal', 'a1a1a1', 'Quebec', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(49, 'albert', 'albert@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '123', NULL, 1, 5, '2018-09-19', 0),
(50, 'alberto', 'alberto@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'quebec', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(51, 'zak', 'zak@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(52, 'ed', 'ed@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(53, 'eric', 'eric@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(54, 'samir', 'samir@gmail.ca', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(55, 'sami', 'sami@gmail.com', 'rosemont', 'montreal', 'a1a1a1', 'Alberta', '1234567890', NULL, 1, 5, '2018-09-19', 0),
(70, 'jhon', 'jhon@walmart.ca', 'll1ll1', 'll', 'll', 'Alberta', '111', NULL, 1, 5, '2018-09-21', 0),
(76, 'darryl', 'd@d.com', 'daytacu', 'hsbkshb', 'H7P2K1', 'QC', '5147019401', 'Darryl1', 1, 1, '2018-09-07', 0),
(77, 'darryl', 'emam@h.com', 'wsewcdcd', 'dsc c ac', 'j6z1z7', 'Saskatchewan', '450-976-0099', NULL, 1, 5, '2018-09-24', 0),
(78, 'les echalottes', 'dea@gmai.com', '6400 16e Avenue', 'Montreal', 'H1X2S9', 'QuÃ©bec', '5147019401', NULL, 1, 5, '2018-09-24', 0);

-- --------------------------------------------------------

--
-- Structure de la table `typemembre`
--

CREATE TABLE `typemembre` (
  `GROUP_ID` int(8) NOT NULL,
  `GROUP_NAME` varchar(255) NOT NULL,
  `GROUP_DESC` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `typemembre`
--

INSERT INTO `typemembre` (`GROUP_ID`, `GROUP_NAME`, `GROUP_DESC`) VALUES
(1, 'administrateur', 'seulement le ou les administrateurs'),
(2, 'superviseur', 'les superviseurs'),
(3, 'employes permanents', 'regroupe tous les employes qui sont permanents.'),
(4, 'volentaires', 'regroupe tous les employes qui se sont engages comme volentaires et sont actives.'),
(5, 'donateur', 'regroupe les donateurs');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `compagnie`
--
ALTER TABLE `compagnie`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `disponibilitebenevole`
--
ALTER TABLE `disponibilitebenevole`
  ADD PRIMARY KEY (`idDisponibilite`),
  ADD KEY `FKBENEVOLE` (`fkBenevole`);

--
-- Index pour la table `don`
--
ALTER TABLE `don`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MEMBRE_ID` (`MEMBRE_ID`),
  ADD KEY `EMPLOYE_ID` (`EMPLOYE_ID`);

--
-- Index pour la table `horrairebenevole`
--
ALTER TABLE `horrairebenevole`
  ADD PRIMARY KEY (`idLigneHorraire`),
  ADD KEY `FKBENEVOLE` (`fkBenevole`),
  ADD KEY `FKEMPLOYE` (`fkEmploye`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GROUP_ID` (`GROUP_ID`);

--
-- Index pour la table `typemembre`
--
ALTER TABLE `typemembre`
  ADD PRIMARY KEY (`GROUP_ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `compagnie`
--
ALTER TABLE `compagnie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `disponibilitebenevole`
--
ALTER TABLE `disponibilitebenevole`
  MODIFY `idDisponibilite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `don`
--
ALTER TABLE `don`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT pour la table `horrairebenevole`
--
ALTER TABLE `horrairebenevole`
  MODIFY `idLigneHorraire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT pour la table `typemembre`
--
ALTER TABLE `typemembre`
  MODIFY `GROUP_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `disponibilitebenevole`
--
ALTER TABLE `disponibilitebenevole`
  ADD CONSTRAINT `disponibilitebenevole_ibfk_1` FOREIGN KEY (`fkBenevole`) REFERENCES `membre` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `horrairebenevole`
--
ALTER TABLE `horrairebenevole`
  ADD CONSTRAINT `horrairebenevole_ibfk_1` FOREIGN KEY (`fkBenevole`) REFERENCES `membre` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `horrairebenevole_ibfk_2` FOREIGN KEY (`fkEmploye`) REFERENCES `membre` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
  ADD CONSTRAINT `membre_ibfk_1` FOREIGN KEY (`GROUP_ID`) REFERENCES `typemembre` (`GROUP_ID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
