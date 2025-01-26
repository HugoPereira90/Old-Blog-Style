-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 20 Juin 2023 à 16:46
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE `actualite` (
  `type` varchar(256) NOT NULL,
  `texte` varchar(256) NOT NULL,
  `photo` varchar(256) DEFAULT NULL,
  `jeu` varchar(256) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `actualite`
--

INSERT INTO `actualite` (`type`, `texte`, `photo`, `jeu`, `date`) VALUES
('JV', 'Patch 13.11', NULL, 'League of Legends', '2023-06-08'),
('JS', 'Developpez votre ville Romaine tout en repoussant les attaques barbares venus de Germanie.', 'Uploads/Discordia.png', 'Nouveaute : Discordia', '2023-06-09');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `ID` int(10) UNSIGNED NOT NULL,
  `logname` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `mail` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `login`
--

INSERT INTO `login` (`ID`, `logname`, `password`, `mail`) VALUES
(2, 'hugo', '81dc9bdb52d04dc20036dbd8313ed055', 'hugopereira2002@hotmail.fr'),
(3, 'test', 'e9510081ac30ffa83f10b68cde1cac07', 'test'),
(4, 'Arnaud', 'd79c8788088c2193f0244d8f1f36d2db', 'arnaud@gmail.fr'),
(5, 'Pluto', 'a8eaf88e26451020bf62ab0bc441ec13', 'pluto@mickey.fr'),
(6, 'Pheonix', 'f379eaf3c831b04de153469d1bec345e', 'pheonix@feu.fr');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `ID_post` int(10) UNSIGNED NOT NULL,
  `date_lastedit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `content` varchar(8000) COLLATE utf8_bin NOT NULL,
  `image_url` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `owner_login` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`ID_post`, `date_lastedit`, `title`, `content`, `image_url`, `owner_login`) VALUES
(2, '2023-04-26 15:12:40', 'GÃ©nÃ©ral', 'bonjour,\r\n\r\nC\'est mon premier msg', NULL, 2),
(3, '2023-04-27 18:37:57', 'GÃ©nÃ©ral', 'j\'aime les jeux', 'Uploads/_042723183757.jpg', 3),
(4, '2023-04-27 09:24:59', 'GÃ©nÃ©ral', 'League of Legend est le meilleur jeu vidÃ©o en termes d\'esport', 'Uploads/_042723092459.jpg', 2),
(5, '2023-04-26 15:14:57', 'Jeux de rÃ´le', 'Quelqu\'un connais des jeux de rÃ´le sympa ?', NULL, 4),
(6, '2023-04-26 15:17:01', 'Jeux de sociÃ©tÃ©', 'Mickey a encore gagnÃ©', 'Uploads/_042623151701.jpg', 5),
(7, '2023-04-26 15:18:00', 'GÃ©nÃ©ral', 'Je me suis baladÃ© avec Dingo', NULL, 5),
(8, '2023-04-26 15:20:25', 'Jeux VidÃ©o', 'voici mon plus grand rival', 'Uploads/_042623152025.jfif', 6),
(9, '2023-04-27 09:12:18', 'Jeux de rÃ´le', 'Le nouveau film &quot;donjon et dragon&quot; est trop bien', NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `recommandation`
--

CREATE TABLE `recommandation` (
  `type` varchar(256) NOT NULL,
  `texte` varchar(256) NOT NULL,
  `photo` varchar(256) DEFAULT NULL,
  `jeu` varchar(256) NOT NULL,
  `note` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `recommandation`
--

INSERT INTO `recommandation` (`type`, `texte`, `photo`, `jeu`, `note`) VALUES
('JV', 'bon jeu', NULL, 'League of Legends', '8.0'),
('JR', 'amusant', NULL, 'Dune', '7.5');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `LINK` (`owner_login`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `ID_post` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Test` FOREIGN KEY (`owner_login`) REFERENCES `login` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
