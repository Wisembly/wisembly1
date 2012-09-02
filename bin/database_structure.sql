-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 02 Septembre 2012 à 17:48
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `silexcms`
--

-- --------------------------------------------------------

--
-- Structure de la table `case_category`
--

CREATE TABLE `case_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `icon` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `case_study`
--

CREATE TABLE `case_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `intro` longtext CHARACTER SET utf8 NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_logo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `client_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `key_figures` longtext CHARACTER SET utf8 NOT NULL,
  `short_desc` longtext CHARACTER SET utf8 NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_text` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_author_pic` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_author_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_author_occupation` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_author_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quote_author_company` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `client_category_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Structure de la table `client_category`
--

CREATE TABLE `client_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `family`
--

CREATE TABLE `family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filter_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `icon` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` longtext CHARACTER SET utf8 NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `feature`
--

CREATE TABLE `feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` longtext COLLATE utf8_bin NOT NULL,
  `picture` varchar(255) COLLATE utf8_bin NOT NULL,
  `class` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `filter`
--

CREATE TABLE `filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tagline` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8_bin NOT NULL,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `link` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `job_category`
--

CREATE TABLE `job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `icon` varchar(255) COLLATE utf8_bin NOT NULL,
  `label_class` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `key_argument`
--

CREATE TABLE `key_argument` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` longtext COLLATE utf8_bin NOT NULL,
  `icon` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `press`
--

CREATE TABLE `press` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `logo` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `link` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Structure de la table `quote`
--

CREATE TABLE `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `text` longtext COLLATE utf8_bin NOT NULL,
  `author_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `author_job` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `job` varchar(255) COLLATE utf8_bin NOT NULL,
  `job_category_id` int(11) NOT NULL,
  `main_pic` varchar(255) COLLATE utf8_bin NOT NULL,
  `secondary_pic` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `twitter` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;
