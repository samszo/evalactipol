-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Mercredi 25 F�vrier 2009 � 10:45
-- Version du serveur: 5.0.27
-- Version de PHP: 5.2.0
-- 
-- Base de donn�es: `evalactipol`
-- 
CREATE DATABASE `evalactipol` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `evalactipol`;

-- --------------------------------------------------------

-- 
-- Structure de la table `depute`
-- 

CREATE TABLE `depute` (
  `id_d�put�` int(255) unsigned NOT NULL auto_increment,
  `nom_d�put�` varchar(255) character set utf8 NOT NULL,
  `pr�nom_d�put�` varchar(255) character set utf8 NOT NULL,
  `mail_d�put�` varchar(255) character set utf8 NOT NULL,
  `d�part_d�put�` int(255) unsigned NOT NULL,
  `lien_AN_d�put�` varchar(255) character set utf8 NOT NULL,
  `num_g�oname` int(255) unsigned NOT NULL,
  `id_URL` int(255) unsigned NOT NULL,
  PRIMARY KEY  (`id_d�put�`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=489 ;

-- 
-- Contenu de la table `depute`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `geoname`
-- 

CREATE TABLE `geoname` (
  `num_g�oname` int(255) unsigned NOT NULL auto_increment,
  `nom_g�oname` varchar(255) NOT NULL,
  `num_d�part` int(255) unsigned NOT NULL,
  `id_URL` int(255) unsigned NOT NULL,
  PRIMARY KEY  (`num_g�oname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `geoname`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `mot-clef`
-- 

CREATE TABLE `mot-clef` (
  `id_MC` int(255) unsigned NOT NULL auto_increment,
  `valeur_MC` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`id_MC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `mot-clef`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `questions`
-- 

CREATE TABLE `questions` (
  `id_question` int(255) unsigned NOT NULL auto_increment,
  `num_question` int(255) unsigned NOT NULL,
  `date_publication` date NOT NULL,
  `date_r�ponse` date NOT NULL,
  `id_d�put�` int(255) unsigned NOT NULL,
  `id_URL` int(255) unsigned NOT NULL,
  PRIMARY KEY  (`id_question`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `questions`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `rubrique`
-- 

CREATE TABLE `rubrique` (
  `id_rubrique` int(255) unsigned NOT NULL auto_increment,
  `valeur_rubrique` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`id_rubrique`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `rubrique`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `urls`
-- 

CREATE TABLE `urls` (
  `id_URL` int(255) unsigned NOT NULL auto_increment,
  `valeur_URL` varchar(255) character set utf8 NOT NULL,
  PRIMARY KEY  (`id_URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `urls`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `villes`
-- 

CREATE TABLE `villes` (
  `id_ville` int(255) unsigned NOT NULL auto_increment,
  `nom_ville` varchar(255) character set utf8 NOT NULL,
  `num_g�oname` int(255) unsigned NOT NULL,
  `id_d�put�` int(255) unsigned NOT NULL,
  PRIMARY KEY  (`id_ville`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `villes`
-- 

