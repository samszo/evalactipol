-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Mardi 31 Mars 2009 à 18:30
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
  `circonsc_depute` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_depute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `depute`
-- 

INSERT INTO `depute` (`id_depute`, `nom_depute`, `prenom_depute`, `mail_depute`, `numphone_depute`, `lien_AN_depute`, `num_depart_depute`, `circonsc_depute`) VALUES 
(1, 'Xavier', 'Breton', 'contact@xavier-breton.com,xbreton@assemblee-nationale.fr', '0033140630211,0033474450211', 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/330008.pdf', 1, 1),
(2, 'Charles', 'de La Verpilli&Atilde;&uml;re', 'charlesdelaverpilliere@orange.fr,cdelaverpilliere@assemblee-nationale.fr', '0033140639507,0033474351358', 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/1012.pdf', 1, 2),
(3, '&Atilde;‰tienne', 'Blanc', 'contact@etienne-blanc.org,eblanc@assemblee-nationale.fr', '0033140637533,0033450991745', 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/267075.pdf', 1, 3),
(4, 'Michel', 'Voisin', 'mvoisin@assemblee-nationale.fr', '0033140636755,0033474323303,0033385311818,0033385310970', 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/2936.pdf', 1, 4);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=149 ;

-- 
-- Contenu de la table `geoname`
-- 

INSERT INTO `geoname` (`id_geoname`, `nom_geoname`, `type_geoname`, `num_depart_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname`) VALUES 
(1, 'Ain', 'Departement', 1, '1,2,3,4', 0, 0, 0, ''),
(2, 'Bourg-en-Bresse Est', 'Canton', 1, '1', 0, 0, 0, ''),
(3, ' Bourg-en-Bresse Nord-Centre', 'Canton', 1, '1', 0, 0, 0, ''),
(4, ' Bourg-en-Bresse Sud', 'Canton', 1, '1', 0, 0, 0, ''),
(5, ' Ceyz&Atilde;&copy;riat', 'Canton', 1, '1', 0, 0, 0, ''),
(6, ' Coligny', 'Canton', 1, '1', 0, 0, 0, ''),
(7, ' Montrevel-en-Bresse', 'Canton', 1, '1', 0, 0, 0, ''),
(8, ' P&Atilde;&copy;ronnas', 'Canton', 1, '1', 0, 0, 0, ''),
(9, ' Pont-d''Ain', 'Canton', 1, '1', 0, 0, 0, ''),
(10, ' Saint-Trivier-de-Courtes', 'Canton', 1, '1', 0, 0, 0, ''),
(11, ' Treffort-Cuisiat', 'Canton', 1, '1', 0, 0, 0, ''),
(12, ' Viriat', 'Canton', 1, '1', 0, 0, 0, ''),
(13, 'Amb&Atilde;&copy;rieu-en-Bugey', 'Canton', 1, '2', 0, 0, 0, ''),
(14, ' Izernore', 'Canton', 1, '2', 0, 0, 0, ''),
(15, ' Lagnieu', 'Canton', 1, '2', 0, 0, 0, ''),
(16, ' Meximieux', 'Canton', 1, '2', 0, 0, 0, ''),
(17, ' Montluel', 'Canton', 1, '2', 0, 0, 0, ''),
(18, ' Nantua', 'Canton', 1, '2', 0, 0, 0, ''),
(19, ' Oyonnax Nord', 'Canton', 1, '2', 0, 0, 0, ''),
(20, ' Oyonnax Sud', 'Canton', 1, '2', 0, 0, 0, ''),
(21, ' Poncin', 'Canton', 1, '2', 0, 0, 0, ''),
(22, 'Bellegarde-sur-Valserine', 'Canton', 1, '3', 0, 0, 0, ''),
(23, ' Belley', 'Canton', 1, '3', 0, 0, 0, ''),
(24, ' Br&Atilde;&copy;nod', 'Canton', 1, '3', 0, 0, 0, ''),
(25, ' Champagne-en-Valromey', 'Canton', 1, '3', 0, 0, 0, ''),
(26, ' Collonges', 'Canton', 1, '3', 0, 0, 0, ''),
(27, ' Ferney-Voltaire', 'Canton', 1, '3', 0, 0, 0, ''),
(28, ' Gex', 'Canton', 1, '3', 0, 0, 0, ''),
(29, ' Hauteville-Lompnes', 'Canton', 1, '3', 0, 0, 0, ''),
(30, ' Lhuis', 'Canton', 1, '3', 0, 0, 0, ''),
(31, ' Saint-Rambert-en-Bugey', 'Canton', 1, '3', 0, 0, 0, ''),
(32, ' Seyssel', 'Canton', 1, '3', 0, 0, 0, ''),
(33, ' Virieu-le-Grand', 'Canton', 1, '3', 0, 0, 0, ''),
(34, 'B&Atilde;&cent;g&Atilde;&copy;-le-Ch&Atilde;&cent;tel', 'Canton', 1, '4', 0, 0, 0, ''),
(35, ' Chalamont', 'Canton', 1, '4', 0, 0, 0, ''),
(36, ' Ch&Atilde;&cent;tillon-sur-Chalaronne', 'Canton', 1, '4', 0, 0, 0, ''),
(37, ' Miribel', 'Canton', 1, '4', 0, 0, 0, ''),
(38, ' Pont-de-Vaux', 'Canton', 1, '4', 0, 0, 0, ''),
(39, ' Pont-de-Veyle', 'Canton', 1, '4', 0, 0, 0, ''),
(40, ' Reyrieux', 'Canton', 1, '4', 0, 0, 0, ''),
(41, ' Saint-Trivier-sur-Moignans', 'Canton', 1, '4', 0, 0, 0, ''),
(42, ' Thoissey', 'Canton', 1, '4', 0, 0, 0, ''),
(43, ' Tr&Atilde;&copy;voux', 'Canton', 1, '4', 0, 0, 0, ''),
(44, ' Villars-les-Dombes', 'Canton', 1, '4', 0, 0, 0, ''),
(45, 'Aisne', 'Departement', 2, '1,2,3,4,5', 0, 0, 0, ''),
(46, 'Allier', 'Departement', 3, '1,2,3,4', 0, 0, 0, ''),
(47, 'Alpes-de-Haute-Provence', 'Departement', 4, '1,2', 0, 0, 0, ''),
(48, 'Hautes-Alpes', 'Departement', 5, '1,2', 0, 0, 0, ''),
(49, 'Alpes-Maritimes', 'Departement', 6, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(50, 'Ard&Atilde;&uml;che', 'Departement', 7, '1,2,3', 0, 0, 0, ''),
(51, 'Ardennes', 'Departement', 8, '1,2,3', 0, 0, 0, ''),
(52, 'Ari&Atilde;&uml;ge', 'Departement', 9, '1,2', 0, 0, 0, ''),
(53, 'Aube', 'Departement', 10, '1,2,3', 0, 0, 0, ''),
(54, 'Aude', 'Departement', 11, '1,2,3', 0, 0, 0, ''),
(55, 'Aveyron', 'Departement', 12, '1,2,3', 0, 0, 0, ''),
(56, 'Bouches-du-Rh&Atilde;&acute;ne', 'Departement', 13, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(57, 'Calvados', 'Departement', 14, '1,2,3,4,5,6', 0, 0, 0, ''),
(58, 'Cantal', 'Departement', 15, '1,2', 0, 0, 0, ''),
(59, 'Charente', 'Departement', 16, '1,2,3,4', 0, 0, 0, ''),
(60, 'Charente-Maritime', 'Departement', 17, '1,2,3,4,5', 0, 0, 0, ''),
(61, 'Cher', 'Departement', 18, '1,2,3', 0, 0, 0, ''),
(62, 'Corr&Atilde;&uml;ze', 'Departement', 19, '1,2,3', 0, 0, 0, ''),
(63, 'Corse-du-Sud', 'Departement', 2, '1,2', 0, 0, 0, ''),
(64, 'Haute-Corse', 'Departement', 2, '1,2', 0, 0, 0, ''),
(65, 'C&Atilde;&acute;te-d''Or', 'Departement', 21, '1,2,3,4,5', 0, 0, 0, ''),
(66, 'C&Atilde;&acute;tes-d''Armor', 'Departement', 22, '1,2,3,4,5', 0, 0, 0, ''),
(67, 'Creuse', 'Departement', 23, '1,2', 0, 0, 0, ''),
(68, 'Dordogne', 'Departement', 24, '1,2,3,4', 0, 0, 0, ''),
(69, 'Doubs', 'Departement', 25, '1,2,3,4,5', 0, 0, 0, ''),
(70, 'Dr&Atilde;&acute;me', 'Departement', 26, '1,2,3,4', 0, 0, 0, ''),
(71, 'Eure', 'Departement', 27, '1,2,3,4,5', 0, 0, 0, ''),
(72, 'Eure-et-Loir', 'Departement', 28, '1,2,3,4', 0, 0, 0, ''),
(73, 'Finist&Atilde;&uml;re', 'Departement', 29, '1,2,3,4,5,6,7,8', 0, 0, 0, ''),
(74, 'Gard', 'Departement', 30, '1,2,3,4,5', 0, 0, 0, ''),
(75, 'Haute-Garonne', 'Departement', 31, '1,2,3,4,5,6,7,8', 0, 0, 0, ''),
(76, 'Gers', 'Departement', 32, '1,2', 0, 0, 0, ''),
(77, 'Gironde', 'Departement', 33, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(78, 'H&Atilde;&copy;rault', 'Departement', 34, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(79, 'Ille-et-Vilaine', 'Departement', 35, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(80, 'Indre', 'Departement', 36, '1,2,3', 0, 0, 0, ''),
(81, 'Indre-et-Loire', 'Departement', 37, '1,2,3,4,5', 0, 0, 0, ''),
(82, 'Is&Atilde;&uml;re', 'Departement', 38, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(83, 'Jura', 'Departement', 39, '1,2,3', 0, 0, 0, ''),
(84, 'Landes', 'Departement', 40, '1,2,3', 0, 0, 0, ''),
(85, 'Loir-et-Cher', 'Departement', 41, '1,2,3', 0, 0, 0, ''),
(86, 'Loire', 'Departement', 42, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(87, 'Haute-Loire', 'Departement', 43, '1,2', 0, 0, 0, ''),
(88, 'Loire-Atlantique', 'Departement', 44, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(89, 'Loiret', 'Departement', 45, '1,2,3,4,5', 0, 0, 0, ''),
(90, 'Lot', 'Departement', 46, '1,2', 0, 0, 0, ''),
(91, 'Lot-et-Garonne', 'Departement', 47, '1,2,3', 0, 0, 0, ''),
(92, 'Loz&Atilde;&uml;re', 'Departement', 48, '1,2', 0, 0, 0, ''),
(93, 'Maine-et-Loire', 'Departement', 49, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(94, 'Manche', 'Departement', 50, '1,2,3,4,5', 0, 0, 0, ''),
(95, 'Marne', 'Departement', 51, '1,2,3,4,5,6', 0, 0, 0, ''),
(96, 'Haute-Marne', 'Departement', 52, '1,2', 0, 0, 0, ''),
(97, 'Mayenne', 'Departement', 53, '1,2,3', 0, 0, 0, ''),
(98, 'Meurthe-et-Moselle', 'Departement', 54, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(99, 'Meuse', 'Departement', 55, '1,2', 0, 0, 0, ''),
(100, 'Morbihan', 'Departement', 56, '1,2,3,4,5,6', 0, 0, 0, ''),
(101, 'Moselle', 'Departement', 57, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(102, 'Ni&Atilde;&uml;vre', 'Departement', 58, '1,2,3', 0, 0, 0, ''),
(103, 'Nord', 'Departement', 59, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(104, 'Oise', 'Departement', 60, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(105, 'Orne', 'Departement', 61, '1,2,3', 0, 0, 0, ''),
(106, 'Pas-de-Calais', 'Departement', 62, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(107, 'Puy-de-D&Atilde;&acute;me', 'Departement', 63, '1,2,3,4,5,6', 0, 0, 0, ''),
(108, 'Pyr&Atilde;&copy;n&Atilde;&copy;es-Atlantiques', 'Departement', 64, '1,2,3,4,5,6', 0, 0, 0, ''),
(109, 'Hautes-Pyr&Atilde;&copy;n&Atilde;&copy;es', 'Departement', 65, '1,2,3', 0, 0, 0, ''),
(110, 'Pyr&Atilde;&copy;n&Atilde;&copy;es-Orientales', 'Departement', 66, '1,2,3,4', 0, 0, 0, ''),
(111, 'Bas-Rhin', 'Departement', 67, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(112, 'Haut-Rhin', 'Departement', 68, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(113, 'Rh&Atilde;&acute;ne', 'Departement', 69, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(114, 'Haute-Sa&Atilde;&acute;ne', 'Departement', 70, '1,2,3', 0, 0, 0, ''),
(115, 'Sa&Atilde;&acute;ne-et-Loire', 'Departement', 71, '1,2,3,4,5,6', 0, 0, 0, ''),
(116, 'Sarthe', 'Departement', 72, '1,2,3,4,5', 0, 0, 0, ''),
(117, 'Savoie', 'Departement', 73, '1,2,3', 0, 0, 0, ''),
(118, 'Haute-Savoie', 'Departement', 74, '1,2,3,4,5', 0, 0, 0, ''),
(119, 'Paris', 'Departement', 75, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(120, 'Seine-Maritime', 'Departement', 76, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(121, 'Seine-et-Marne', 'Departement', 77, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(122, 'Yvelines', 'Departement', 78, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(123, 'Deux-S&Atilde;&uml;vres', 'Departement', 79, '1,2,3,4', 0, 0, 0, ''),
(124, 'Somme', 'Departement', 80, '1,2,3,4,5,6', 0, 0, 0, ''),
(125, 'Tarn', 'Departement', 81, '1,2,3,4', 0, 0, 0, ''),
(126, 'Tarn-et-Garonne', 'Departement', 82, '1,2', 0, 0, 0, ''),
(127, 'Var', 'Departement', 83, '1,2,3,4,5,6,7', 0, 0, 0, ''),
(128, 'Vaucluse', 'Departement', 84, '1,2,3,4', 0, 0, 0, ''),
(129, 'Vend&Atilde;&copy;e', 'Departement', 85, '1,2,3,4,5', 0, 0, 0, ''),
(130, 'Vienne', 'Departement', 86, '1,2,3,4', 0, 0, 0, ''),
(131, 'Haute-Vienne', 'Departement', 87, '1,2,3,4', 0, 0, 0, ''),
(132, 'Vosges', 'Departement', 88, '1,2,3,4', 0, 0, 0, ''),
(133, 'Yonne', 'Departement', 89, '1,2,3', 0, 0, 0, ''),
(134, 'Territoire-de-Belfort', 'Departement', 90, '1,2', 0, 0, 0, ''),
(135, 'Essonne', 'Departement', 91, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(136, 'Hauts-de-Seine', 'Departement', 92, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(137, 'Seine-Saint-Denis', 'Departement', 93, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(138, 'Val-de-Marne', 'Departement', 94, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(139, 'Val-d''Oise', 'Departement', 95, '1,2,3,4,5,6,7,8,9', 0, 0, 0, ''),
(140, 'Guadeloupe', 'Departement', 971, '1,2,3,4', 0, 0, 0, ''),
(141, 'Martinique', 'Departement', 972, '1,2,3,4', 0, 0, 0, ''),
(142, 'Guyane', 'Departement', 973, '1,2', 0, 0, 0, ''),
(143, 'R&Atilde;&copy;union', 'Departement', 974, '1,2,3,4,5', 0, 0, 0, ''),
(144, 'Saint-Pierre-et-Miquelon', 'Departement', 975, '1', 0, 0, 0, ''),
(145, 'Mayotte', 'Departement', 976, '1', 0, 0, 0, ''),
(146, 'Wallis-et-Futuna', 'Departement', 986, '1', 0, 0, 0, ''),
(147, 'Polyn&Atilde;&copy;sie', 'Departement', 987, '1,2', 0, 0, 0, ''),
(148, 'Nouvelle-Cal&Atilde;&copy;donie', 'Departement', 988, '1,2', 0, 0, 0, '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Contenu de la table `urls`
-- 

INSERT INTO `urls` (`id_URL`, `valeur_URL`, `code_extract_URL`) VALUES 
(1, 'http://www.assemblee-nationale.fr/13/tribun/fiches_id/330008.asp', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(2, 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/330008.pdf', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(3, 'http://www.assemblee-nationale.fr/13/tribun/fiches_id/1012.asp', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(4, 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/1012.pdf', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(5, 'http://www.assemblee-nationale.fr/13/tribun/fiches_id/267075.asp', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(6, 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/267075.pdf', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(7, 'http://www.assemblee-nationale.fr/13/tribun/fiches_id/2936.asp', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')'),
(8, 'http://www.assemblee-nationale.fr/13/tribun/tnom/2007/2936.pdf', 'find(''li a[title^=http://www.assemblee-nationale.fr]'')');
