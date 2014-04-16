CREATE USER 'Cinetoile'@'localhost' IDENTIFIED BY 'tarantino';


CREATE DATABASE IF NOT EXISTS cinetoile;
USE cinetoile;


-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Dim 07 Juillet 2013 à 21:24
-- Version du serveur: 5.5.31
-- Version de PHP: 5.3.10-1ubuntu3.6

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
  `nb_presents` int(11) DEFAULT NULL,
  PRIMARY KEY (`date_diffusion`),
  KEY `id_film` (`id_film`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Film`
--

CREATE TABLE IF NOT EXISTS `Film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `realisateur` varchar(64) NOT NULL,
  `annee` year(4) DEFAULT NULL,
  `pays` varchar(64) DEFAULT NULL,
  `acteurs` varchar(128) DEFAULT NULL,
  `genre` varchar(64) DEFAULT NULL,
  `support` enum('VHS','DVD') DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `synopsis` text,
  `affiche` varchar(64) DEFAULT NULL,
  `bande_annonce` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Membre`
--

CREATE TABLE IF NOT EXISTS `Membre` (
  `login` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `droits` enum('0','1','2','3') NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `ecole` enum('Autre','Ense3','Ensimag','GI','Pagora','Phelma') DEFAULT NULL,
  `annee` enum('Autre','1','2','3') DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- password à changer
INSERT INTO Membre (login,password,droits,prenom,nom,email,telephone,ecole,annee)
VALUES ('Cin&eacute;toile',PASSWORD('siteweb'),'3','Cin&eacute;toile',NULL,'cinetoile.grenoble@gmail.com',NULL,NULL,NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Diffusion`
--
ALTER TABLE `Diffusion`
  ADD CONSTRAINT `Diffusion_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `Film` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


GRANT ALL
ON cinetoile.*
TO 'Cinetoile' IDENTIFIED BY 'tarantino'
WITH GRANT OPTION;
