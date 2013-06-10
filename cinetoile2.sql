-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 21 Décembre 2012 à 14:39
-- Version du serveur: 5.5.28
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `cinetoile`
--

-- --------------------------------------------------------

--
-- Structure de la table `Diffusion`
--

CREATE TABLE IF NOT EXISTS `Diffusion` (
  `date_diffusion` datetime NOT NULL,
  `id_film` int(11) NOT NULL,
  `cycle` varchar(48) DEFAULT NULL,
  `commentaire` varchar(256) DEFAULT NULL,
  `affiche` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`date_diffusion`),
  KEY `id_film` (`id_film`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Diffusion`
--

INSERT INTO `Diffusion` (`date_diffusion`, `id_film`, `cycle`, `commentaire`, `affiche`) VALUES
('2012-11-11 11:30:00', 92, 'FranÃ§ais', 'Youpi !!', '/Images/Affiches/persepolis.jpg'),
('2015-05-04 05:07:00', 91, 'Tata', '', '/Images/Affiches/fargo.jpg'),
('2017-06-04 03:05:00', 93, 'Couleur', 'C''est certain, il faut venir, ce sera trop bien !', '/Images/Affiches/bartonfink.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Film`
--

CREATE TABLE IF NOT EXISTS `Film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `realisateur` varchar(64) NOT NULL,
  `annee` year(4) DEFAULT NULL,
  `pays` varchar(32) DEFAULT NULL,
  `acteurs` varchar(128) DEFAULT NULL,
  `genre` varchar(64) DEFAULT NULL,
  `support` enum('VHS','DVD') DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `synopsis` text,
  `affiche` varchar(64) DEFAULT NULL,
  `bande_annonce` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Contenu de la table `Film`
--

INSERT INTO `Film` (`id`, `titre`, `realisateur`, `annee`, `pays`, `acteurs`, `genre`, `support`, `duree`, `synopsis`, `affiche`, `bande_annonce`) VALUES
(91, 'FF', 'FF', 1933, '', '', '', '', '00:00:00', '', '/Images/Affiches/13_TZAMETI.jpg', ''),
(92, 'frefe', 'ferfref', 1935, '', '', '', '', '00:00:00', '', '/Images/Affiches/13_TZAMETI.jpg', ''),
(93, 'Fargo', 'Tarantino', 1938, '', '', '', '', '00:00:00', 'En plein hiver, Jerry Lundegaard, un vendeur de voitures d''occasion Ã  Minneapolis, a besoin d''un prÃªt de Wade Gustafson, son riche beau-pÃ¨re. EndettÃ© jusqu''au cou, il fait appel Ã  Carl Showalter et Gaear Grimsrud, deux malfrats, pour qu''ils enlÃ¨vent son Ã©pouse Jean. Il pourra ainsi partager avec les ravisseurs la ranÃ§on que Wade paiera pour la libÃ©ration de sa fille. Mais les choses ne vont pas se dÃ©rouler comme prÃ©vu.', '/Images/Affiches/FARGO.jpg', '<div id=''blogvision'' style=''width:420px; height:335px''><object width=''100%'' height=''100%''><param name=''movie'' value=''http://www.allocine.fr/blogvision/19389092''></param><param name=''allowFullScreen'' value=''true''></param><param name=''allowScriptAccess'' value=''always''></param><embed src=''http://www.allocine.fr/blogvision/19389092'' type=''application/x-shockwave-flash'' width=''100%'' height=''100%'' allowFullScreen=''true'' allowScriptAccess=''always''/></object><a href="http://www.allocine.fr/videos_allocineshow_home?callocineshow=18739529" target="_blank">Faux Raccord</a></div>');

-- --------------------------------------------------------

--
-- Structure de la table `Membre`
--

CREATE TABLE IF NOT EXISTS `Membre` (
  `login` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `droits` enum('0','1','2') NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `ecole` enum('Autre','Ense3','Ensimag','GI','Pagora','Phelma') DEFAULT NULL,
  `annee` enum('Autre','1','2','3') DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Membre`
--

INSERT INTO `Membre` (`login`, `password`, `droits`, `prenom`, `nom`, `email`, `telephone`, `ecole`, `annee`) VALUES
('Cin&eacute;toile', '*235DBD77707D2B6306DFE73F08CD0B90B5751D9F', '2', 'Cin&eacute;toile', NULL, 'cinetoile.grenoble@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `VoteFilm`
--

CREATE TABLE IF NOT EXISTS `VoteFilm` (
  `id_film` int(11) NOT NULL,
  `nombre_votes` int(11) NOT NULL,
  PRIMARY KEY (`id_film`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Nombre de votes pour chaque film';

-- --------------------------------------------------------

--
-- Structure de la table `VoteMembre`
--

CREATE TABLE IF NOT EXISTS `VoteMembre` (
  `login` varchar(32) NOT NULL,
  `id_film` int(11) NOT NULL,
  `date_vote` datetime NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `id_film` (`id_film`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Le vote d''un membre';

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Diffusion`
--
ALTER TABLE `Diffusion`
  ADD CONSTRAINT `Diffusion_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `Film` (`id`);

--
-- Contraintes pour la table `VoteFilm`
--
ALTER TABLE `VoteFilm`
  ADD CONSTRAINT `VoteFilm_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `Film` (`id`);

--
-- Contraintes pour la table `VoteMembre`
--
ALTER TABLE `VoteMembre`
  ADD CONSTRAINT `VoteMembre_ibfk_1` FOREIGN KEY (`login`) REFERENCES `Membre` (`login`),
  ADD CONSTRAINT `VoteMembre_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `Film` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
