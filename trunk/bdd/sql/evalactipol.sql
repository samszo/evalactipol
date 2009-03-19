-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Jeudi 19 Mars 2009 à 14:38
-- Version du serveur: 5.0.27
-- Version de PHP: 5.2.0
-- 
-- Base de données: `evalactipol`
-- 
DROP DATABASE `evalactipol`;
CREATE DATABASE `evalactipol` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `evalactipol`;

-- --------------------------------------------------------

-- 
-- Structure de la table `depute-geo`
-- 

CREATE TABLE `depute-geo` (
  `id_depute` varchar(255) NOT NULL,
  `id_geoname` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`,`id_geoname`),
  KEY `id_geoname` (`id_geoname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `depute-geo`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `depute-mc`
-- 

CREATE TABLE `depute-mc` (
  `id_depute` int(10) unsigned NOT NULL,
  `id_motclef` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`,`id_motclef`),
  KEY `id_motclef` (`id_motclef`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `depute-mc`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `depute-rubr`
-- 

CREATE TABLE `depute-rubr` (
  `id_depute` int(10) unsigned NOT NULL,
  `id_rubrique` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`,`id_rubrique`),
  KEY `id_rubrique` (`id_rubrique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `depute-rubr`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `depute-url`
-- 

CREATE TABLE `depute-url` (
  `id_depute` int(10) unsigned NOT NULL,
  `id_URL` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`,`id_URL`),
  KEY `id_URL` (`id_URL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `depute-url`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `depute`
-- 

CREATE TABLE `depute` (
  `id_depute` int(10) unsigned NOT NULL auto_increment,
  `nom_depute` varchar(255) NOT NULL,
  `prenom_depute` varchar(255) NOT NULL,
  `mail_depute` varchar(255) NOT NULL,
  `numphone_depute` varchar(255) NOT NULL,
  `lien_AN_depute` varchar(255) NOT NULL,
  `num_depart_depute` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `depute`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `geo-url`
-- 

CREATE TABLE `geo-url` (
  `id_geoname` int(10) unsigned NOT NULL,
  `id_URL` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_geoname`,`id_URL`),
  KEY `id_URL` (`id_URL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `geo-url`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `geoname`
-- 

CREATE TABLE `geoname` (
  `id_geoname` int(10) unsigned NOT NULL auto_increment,
  `nom_geoname` varchar(255) NOT NULL,
  `type_geoname` varchar(255) NOT NULL,
  `num_depart_geoname` int(10) unsigned NOT NULL,
  `circonscriptions_geoname` varchar(255) NOT NULL,
  `lat_geoname` decimal(10,0) unsigned NOT NULL,
  `lng_geoname` decimal(10,0) unsigned NOT NULL,
  `alt_geoname` decimal(10,0) unsigned NOT NULL,
  `kml_geoname` text NOT NULL,
  PRIMARY KEY  (`id_geoname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `geoname`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mot-clef`
-- 

CREATE TABLE `mot-clef` (
  `id_motclef` int(10) unsigned NOT NULL auto_increment,
  `valeur_motclef` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_motclef`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `mot-clef`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `quest-mc`
-- 

CREATE TABLE `quest-mc` (
  `id_question` int(10) unsigned NOT NULL,
  `id_motclef` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_question`,`id_motclef`),
  KEY `id_motclef` (`id_motclef`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `quest-mc`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `quest-rubr`
-- 

CREATE TABLE `quest-rubr` (
  `id_question` int(10) unsigned NOT NULL,
  `id_rubrique` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_question`,`id_rubrique`),
  KEY `id_rubrique` (`id_rubrique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `quest-rubr`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `questions`
-- 

CREATE TABLE `questions` (
  `id_question` int(10) unsigned NOT NULL auto_increment,
  `num_question` int(10) unsigned NOT NULL,
  `date_publication` date NOT NULL,
  `date_reponse` date NOT NULL,
  `num_legislature` int(10) unsigned NOT NULL,
  `id_depute` int(10) unsigned NOT NULL,
  `id_URL` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_question`),
  KEY `id_URL` (`id_URL`),
  KEY `id_depute` (`id_depute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `questions`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `rubrique`
-- 

CREATE TABLE `rubrique` (
  `id_rubrique` int(10) unsigned NOT NULL auto_increment,
  `valeur_rubrique` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_rubrique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `rubrique`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `urls`
-- 

CREATE TABLE `urls` (
  `id_URL` int(10) unsigned NOT NULL auto_increment,
  `valeur_URL` text NOT NULL,
  `code_extract_URL` text NOT NULL,
  PRIMARY KEY  (`id_URL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `urls`
-- 

