-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 26 Mars 2014 à 18:59
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `ecoges`
--

-- --------------------------------------------------------

--
-- Structure de la table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `cities`
--

INSERT INTO `cities` (`id`, `city`) VALUES
(1, 'Bandar Beyla'),
(2, 'Boffa'),
(3, 'Boké'),
(4, 'Conakry'),
(5, 'Coyah'),
(6, 'Dabola'),
(7, 'Dalaba'),
(8, 'Dinguiraye'),
(9, 'Dubreka'),
(10, 'Faranah'),
(11, 'Forecariah'),
(12, 'Fria'),
(13, 'Gaoual'),
(14, 'Gueckedou'),
(15, 'Kamsar'),
(16, 'Kankan'),
(17, 'Kérouané'),
(18, 'Kindia'),
(19, 'Kissidougou'),
(20, 'Koubia'),
(21, 'Kouroussa'),
(22, 'Labé'),
(23, 'Lélouma'),
(24, 'Lola'),
(25, 'Macenta'),
(26, 'Mali'),
(27, 'Mamou'),
(28, 'Mandiana'),
(29, 'N''Zérékoré'),
(30, 'Ourouss'),
(31, 'Siguiri'),
(32, 'Telimele'),
(33, 'Tougue'),
(34, 'Yomou'),
(35, 'Youkounkoun');

-- --------------------------------------------------------

--
-- Structure de la table `cities_schools`
--

CREATE TABLE IF NOT EXISTS `cities_schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `cities_schools`
--

INSERT INTO `cities_schools` (`id`, `city_id`, `school_id`) VALUES
(3, 4, 12);

-- --------------------------------------------------------

--
-- Structure de la table `cities_students`
--

CREATE TABLE IF NOT EXISTS `cities_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `cities_students`
--

INSERT INTO `cities_students` (`id`, `city_id`, `student_id`) VALUES
(2, 4, 82),
(3, 4, 83),
(4, 4, 84),
(5, 4, 85),
(6, 4, 86),
(7, 4, 87);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms`
--

CREATE TABLE IF NOT EXISTS `classrooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `niveau` int(2) NOT NULL,
  `alias` varchar(1) NOT NULL,
  `description` text NOT NULL,
  `afficher_matiere` int(1) NOT NULL DEFAULT '0',
  `afficher_enseignant` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Contenu de la table `classrooms`
--

INSERT INTO `classrooms` (`id`, `actif`, `niveau`, `alias`, `description`, `afficher_matiere`, `afficher_enseignant`) VALUES
(1, 'non', 4, '', '', 1, 0),
(2, 'non', 3, '', '', 0, 0),
(3, 'non', 2, '', '', 0, 0),
(4, 'non', 1, '', '', 0, 0),
(5, 'non', 1, '', '', 0, 0),
(6, 'oui', 2, '', '', 0, 0),
(7, 'oui', 1, '', '', 0, 0),
(8, 'oui', 3, '', '', 0, 0),
(9, 'oui', 4, '', '', 0, 0),
(10, 'oui', 1, '', '', 0, 0),
(11, 'oui', 2, '', '', 0, 0),
(12, 'oui', 3, '', '', 0, 0),
(13, 'non', 1, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_departements`
--

CREATE TABLE IF NOT EXISTS `classrooms_departements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `departement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Contenu de la table `classrooms_departements`
--

INSERT INTO `classrooms_departements` (`id`, `classroom_id`, `departement_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 3),
(6, 6, 4),
(7, 7, 4),
(8, 8, 4),
(9, 9, 4),
(10, 10, 6),
(11, 11, 6),
(12, 12, 6),
(13, 13, 3),
(14, 14, 7),
(15, 15, 7),
(16, 16, 7),
(17, 17, 7),
(18, 18, 8),
(19, 19, 8),
(20, 20, 8),
(21, 21, 8),
(22, 22, 9),
(23, 23, 9),
(24, 24, 9),
(25, 25, 9),
(26, 26, 10),
(27, 27, 10),
(28, 28, 10),
(29, 29, 10),
(30, 30, 11),
(31, 31, 11),
(32, 32, 11),
(33, 33, 11),
(34, 34, 12),
(35, 35, 12),
(36, 36, 12),
(37, 37, 12),
(38, 38, 13),
(39, 39, 13),
(40, 40, 13),
(41, 41, 13),
(42, 42, 14),
(43, 43, 14),
(44, 44, 14),
(45, 45, 14),
(46, 46, 15),
(47, 47, 15),
(48, 48, 15),
(49, 49, 15),
(50, 50, 16),
(51, 51, 16),
(52, 52, 16),
(53, 53, 16),
(54, 54, 17),
(55, 55, 17),
(56, 56, 17),
(57, 57, 17),
(58, 58, 18),
(59, 59, 18),
(60, 60, 18),
(61, 61, 18),
(62, 62, 19),
(63, 63, 19),
(64, 64, 19),
(65, 65, 19),
(66, 66, 20),
(67, 67, 20),
(68, 68, 20),
(69, 69, 20),
(70, 70, 21),
(71, 71, 21),
(72, 72, 21),
(73, 73, 21),
(74, 74, 22),
(75, 75, 22),
(76, 76, 22),
(77, 77, 22),
(78, 78, 23),
(79, 79, 23),
(80, 80, 23),
(81, 81, 23),
(82, 82, 24),
(83, 83, 24),
(84, 84, 24),
(85, 85, 24),
(86, 86, 25),
(87, 87, 25),
(88, 88, 25),
(89, 89, 25),
(90, 90, 26),
(91, 91, 26),
(92, 92, 26),
(93, 93, 26);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_evaluations`
--

CREATE TABLE IF NOT EXISTS `classrooms_evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `classrooms_evaluations`
--

INSERT INTO `classrooms_evaluations` (`id`, `classroom_id`, `evaluation_id`) VALUES
(15, 9, 18),
(14, 1, 17),
(13, 1, 16),
(12, 1, 15),
(11, 1, 14),
(16, 1, 19),
(17, 1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_matieres`
--

CREATE TABLE IF NOT EXISTS `classrooms_matieres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `matiere_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Contenu de la table `classrooms_matieres`
--

INSERT INTO `classrooms_matieres` (`id`, `classroom_id`, `matiere_id`) VALUES
(63, 1, 3),
(62, 1, 13),
(61, 1, 12),
(60, 12, 13),
(59, 2, 6),
(58, 5, 7),
(57, 5, 2),
(56, 5, 14),
(55, 5, 13),
(54, 6, 13),
(53, 7, 13),
(52, 9, 13),
(51, 8, 13),
(50, 2, 13),
(49, 2, 5),
(48, 2, 4),
(47, 2, 2),
(46, 2, 1),
(45, 10, 13),
(44, 10, 15),
(43, 10, 14),
(42, 10, 5),
(41, 1, 5),
(40, 1, 4),
(65, 1, 15),
(38, 1, 22),
(37, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_periodes`
--

CREATE TABLE IF NOT EXISTS `classrooms_periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Contenu de la table `classrooms_periodes`
--

INSERT INTO `classrooms_periodes` (`id`, `classroom_id`, `periode_id`) VALUES
(1, 1, 6),
(2, 2, 6),
(3, 3, 6),
(4, 4, 6),
(5, 5, 6),
(6, 6, 6),
(7, 7, 6),
(8, 8, 6),
(9, 9, 6),
(10, 10, 6),
(11, 11, 6),
(12, 12, 6),
(13, 13, 6),
(14, 14, 6),
(15, 15, 6),
(16, 16, 6),
(17, 17, 6),
(18, 18, 6),
(19, 19, 6),
(20, 20, 6),
(21, 21, 6),
(22, 22, 6),
(23, 23, 6),
(24, 24, 6),
(25, 25, 6),
(26, 26, 6),
(27, 27, 6),
(28, 28, 6),
(29, 29, 6),
(30, 30, 6),
(31, 31, 6),
(32, 32, 6),
(33, 33, 6),
(34, 34, 6),
(35, 35, 6),
(36, 36, 6),
(37, 37, 6),
(38, 38, 6),
(39, 39, 6),
(40, 40, 6),
(41, 41, 6),
(42, 42, 6),
(43, 43, 6),
(44, 44, 6),
(45, 45, 6),
(46, 46, 6),
(47, 47, 6),
(48, 48, 6),
(49, 49, 6),
(50, 50, 6),
(51, 51, 6),
(52, 52, 6),
(53, 53, 6),
(54, 54, 6),
(55, 55, 6),
(56, 56, 6),
(57, 57, 6),
(58, 58, 6),
(59, 59, 6),
(60, 60, 6),
(61, 61, 6),
(62, 62, 6),
(63, 63, 6),
(64, 64, 6),
(65, 65, 6),
(66, 66, 6),
(67, 67, 6),
(68, 68, 6),
(69, 69, 6),
(70, 70, 6),
(71, 71, 6),
(72, 72, 6),
(73, 73, 6),
(74, 74, 6),
(75, 75, 6),
(76, 76, 6),
(77, 77, 6),
(78, 78, 6),
(79, 79, 6),
(80, 80, 6),
(81, 81, 6),
(82, 82, 6),
(83, 83, 6),
(84, 84, 6),
(85, 85, 6),
(86, 86, 6),
(87, 87, 6),
(88, 88, 6),
(89, 89, 6),
(90, 90, 6),
(91, 91, 6),
(92, 92, 6),
(93, 93, 6);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_students`
--

CREATE TABLE IF NOT EXISTS `classrooms_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `classrooms_students`
--

INSERT INTO `classrooms_students` (`id`, `classroom_id`, `student_id`) VALUES
(1, 1, 82),
(2, 1, 83),
(3, 1, 84),
(4, 1, 85),
(5, 1, 86),
(6, 7, 87);

-- --------------------------------------------------------

--
-- Structure de la table `classrooms_teachers`
--

CREATE TABLE IF NOT EXISTS `classrooms_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Contenu de la table `classrooms_teachers`
--

INSERT INTO `classrooms_teachers` (`id`, `classroom_id`, `teacher_id`) VALUES
(11, 1, 80),
(13, 1, 83),
(14, 10, 83),
(15, 10, 85),
(16, 10, 86),
(17, 10, 89),
(24, 2, 89),
(23, 2, 83),
(22, 2, 80),
(25, 8, 89),
(26, 9, 89),
(27, 7, 89),
(28, 6, 89),
(29, 5, 89),
(30, 5, 85),
(31, 5, 82),
(32, 5, 87),
(33, 12, 89),
(34, 1, 90),
(36, 1, 92),
(37, 1, 86);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(41) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

--
-- Contenu de la table `countries`
--

INSERT INTO `countries` (`id`, `country`) VALUES
(1, 'Afghanistan'),
(2, 'Afrique du Sud'),
(3, 'Albanie'),
(4, 'Algérie'),
(5, 'Allemagne'),
(6, 'Andorre'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctique'),
(10, 'Antigua-et-Barbuda'),
(11, 'Antilles néerlandaises'),
(12, 'Arabie saoudite'),
(13, 'Argentine'),
(14, 'Arménie'),
(15, 'Aruba'),
(16, 'Australie'),
(17, 'Autriche'),
(18, 'Azerbaïdjan'),
(19, 'Bénin'),
(20, 'Bahamas'),
(21, 'Bahreïn'),
(22, 'Bangladesh'),
(23, 'Barbade'),
(24, 'Belau'),
(25, 'Belgique'),
(26, 'Belize'),
(27, 'Bermudes'),
(28, 'Bhoutan'),
(29, 'Biélorussie'),
(30, 'Birmanie'),
(31, 'Bolivie'),
(32, 'Bosnie-Herzégovine'),
(33, 'Botswana'),
(34, 'Brésil'),
(35, 'Brunei'),
(36, 'Bulgarie'),
(37, 'Burkina Faso'),
(38, 'Burundi'),
(39, 'Côte d''Ivoire'),
(40, 'Cambodge'),
(41, 'Cameroun'),
(42, 'Canada'),
(43, 'Cap-Vert'),
(44, 'Chili'),
(45, 'Chine'),
(46, 'Chypre'),
(47, 'Colombie'),
(48, 'Comores'),
(49, 'Congo'),
(50, 'Corée du Nord'),
(51, 'Corée du Sud'),
(52, 'Costa Rica'),
(53, 'Croatie'),
(54, 'Cuba'),
(55, 'Danemark'),
(56, 'Djibouti'),
(57, 'Dominique'),
(58, 'Égypte'),
(59, 'Émirats arabes unis'),
(60, 'Équateur'),
(61, 'Érythrée'),
(62, 'Espagne'),
(63, 'Estonie'),
(64, 'États-Unis'),
(65, 'Éthiopie'),
(66, 'Finlande'),
(67, 'France'),
(68, 'Géorgie'),
(69, 'Gabon'),
(70, 'Gambie'),
(71, 'Ghana'),
(72, 'Gibraltar'),
(73, 'Grèce'),
(74, 'Grenade'),
(75, 'Groenland'),
(76, 'Guadeloupe'),
(77, 'Guam'),
(78, 'Guatemala'),
(79, 'Guinea'),
(80, 'Guinée équatoriale'),
(81, 'Guinée-Bissao'),
(82, 'Guyana'),
(83, 'Guyane française'),
(84, 'Haïti'),
(85, 'Honduras'),
(86, 'Hong Kong'),
(87, 'Hongrie'),
(88, 'Ile Bouvet'),
(89, 'Ile Christmas'),
(90, 'Ile Norfolk'),
(91, 'Iles Cayman'),
(92, 'Iles Cook'),
(93, 'Iles Féroé'),
(94, 'Iles Falkland'),
(95, 'Iles Fidji'),
(96, 'Iles Géorgie du Sud et Sandwich du Sud'),
(97, 'Iles Heard et McDonald'),
(98, 'Iles Marshall'),
(99, 'Iles Pitcairn'),
(100, 'Iles Salomon'),
(101, 'Iles Svalbard et Jan Mayen'),
(102, 'Iles Turks-et-Caicos'),
(103, 'Iles Vierges américaines'),
(104, 'Iles Vierges britanniques'),
(105, 'Iles des Cocos (Keeling)'),
(106, 'Iles mineures éloignées des États-Unis'),
(107, 'Inde'),
(108, 'Indonésie'),
(109, 'Iran'),
(110, 'Iraq'),
(111, 'Irlande'),
(112, 'Islande'),
(113, 'Israël'),
(114, 'Italie'),
(115, 'Jamaïque'),
(116, 'Japon'),
(117, 'Jordanie'),
(118, 'Kazakhstan'),
(119, 'Kenya'),
(120, 'Kirghizistan'),
(121, 'Kiribati'),
(122, 'Koweït'),
(123, 'Laos'),
(124, 'Lesotho'),
(125, 'Lettonie'),
(126, 'Liban'),
(127, 'Liberia'),
(128, 'Libye'),
(129, 'Liechtenstein'),
(130, 'Lituanie'),
(131, 'Luxembourg'),
(132, 'Macao'),
(133, 'Madagascar'),
(134, 'Malaisie'),
(135, 'Malawi'),
(136, 'Maldives'),
(137, 'Mali'),
(138, 'Malte'),
(139, 'Mariannes du Nord'),
(140, 'Maroc'),
(141, 'Martinique'),
(142, 'Maurice'),
(143, 'Mauritanie'),
(144, 'Mayotte'),
(145, 'Mexique'),
(146, 'Micronésie'),
(147, 'Moldavie'),
(148, 'Monaco'),
(149, 'Mongolie'),
(150, 'Montserrat'),
(151, 'Mozambique'),
(152, 'Népal'),
(153, 'Namibie'),
(154, 'Nauru'),
(155, 'Nicaragua'),
(156, 'Niger'),
(157, 'Nigeria'),
(158, 'Nioué'),
(159, 'Norvège'),
(160, 'Nouvelle-Calédonie'),
(161, 'Nouvelle-Zélande'),
(162, 'Oman'),
(163, 'Ouganda'),
(164, 'Ouzbékistan'),
(165, 'Pérou'),
(166, 'Pakistan'),
(167, 'Panama'),
(168, 'Papouasie-Nouvelle-Guinée'),
(169, 'Paraguay'),
(170, 'Pays-Bas'),
(171, 'Philippines'),
(172, 'Pologne'),
(173, 'Polynésie française'),
(174, 'Porto Rico'),
(175, 'Portugal'),
(176, 'Qatar'),
(177, 'République centrafricaine'),
(178, 'République démocratique du Congo'),
(179, 'République dominicaine'),
(180, 'République tchèque'),
(181, 'Réunion'),
(182, 'Roumanie'),
(183, 'Royaume-Uni'),
(184, 'Russie'),
(185, 'Rwanda'),
(186, 'Sénégal'),
(187, 'Sahara occidental'),
(188, 'Saint-Christophe-et-Niévès'),
(189, 'Saint-Marin'),
(190, 'Saint-Pierre-et-Miquelon'),
(191, 'Saint-Siège'),
(192, 'Saint-Vincent-et-les-Grenadines'),
(193, 'Sainte-Hélène'),
(194, 'Sainte-Lucie'),
(195, 'Salvador'),
(196, 'Samoa'),
(197, 'Samoa américaines'),
(198, 'Sao Tomé-et-Principe'),
(199, 'Seychelles'),
(200, 'Sierra Leone'),
(201, 'Singapour'),
(202, 'Slovénie'),
(203, 'Slovaquie'),
(204, 'Somalie'),
(205, 'Soudan'),
(206, 'Sri Lanka'),
(207, 'Suède'),
(208, 'Suisse'),
(209, 'Suriname'),
(210, 'Swaziland'),
(211, 'Syrie'),
(212, 'Taïwan'),
(213, 'Tadjikistan'),
(214, 'Tanzanie'),
(215, 'Tchad'),
(216, 'Terres australes françaises'),
(217, 'Territoire britannique de l''Océan Indien'),
(218, 'Thaïlande'),
(219, 'Timor Oriental'),
(220, 'Togo'),
(221, 'Tokélaou'),
(222, 'Tonga'),
(223, 'Trinité-et-Tobago'),
(224, 'Tunisie'),
(225, 'Turkménistan'),
(226, 'Turquie'),
(227, 'Tuvalu'),
(228, 'Ukraine'),
(229, 'Uruguay'),
(230, 'Vanuatu'),
(231, 'Venezuela	'),
(232, 'Viêt Nam	'),
(233, 'Wallis-et-Futuna	'),
(234, 'Yémen	'),
(235, 'Yougoslavie	'),
(236, 'Zambie	'),
(237, 'Zimbabwe	'),
(238, 'ex-République yougoslave de Macédoine	');

-- --------------------------------------------------------

--
-- Structure de la table `countries_schools`
--

CREATE TABLE IF NOT EXISTS `countries_schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `countries_schools`
--

INSERT INTO `countries_schools` (`id`, `country_id`, `school_id`) VALUES
(4, 45, 12);

-- --------------------------------------------------------

--
-- Structure de la table `countries_students`
--

CREATE TABLE IF NOT EXISTS `countries_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `countries_students`
--

INSERT INTO `countries_students` (`id`, `country_id`, `student_id`) VALUES
(1, 79, 82),
(2, 79, 83),
(3, 79, 84),
(4, 79, 85),
(5, 79, 86),
(7, 79, 87);

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE IF NOT EXISTS `departements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `departements`
--

INSERT INTO `departements` (`id`, `actif`, `nom`, `description`) VALUES
(1, 'non', 'Mathematique', 'Magna, ut parturient! Odio lundium! Etiam tortor quis diam porta. Vut aenean, lectus lectus rhoncus cum dignissim scelerisque. Proin phasellus, sed! Lectus, lacus arcu placerat! Sociis enim parturient dis ultrices sit proin adipiscing turpis? Eros auctor eros scelerisque magnis ac a integer et a odio nascetur aenean a lacus, proin ac purus lorem dis? Pellentesque elit. Urna placerat lorem elementum, a pellentesque aenean, a nisi porttitor, non diam amet dictumst! Odio proin augue ridiculus nec elementum, et proin? Est elementum lorem nec nunc porttitor diam enim elementum, turpis ridiculus nunc? Turpis auctor sagittis dictumst lorem proin? Diam turpis, magnis scelerisque. Lectus porttitor, mus integer, mattis sagittis scelerisque massa eros purus pulvinar! Platea tempor magna, tortor, tincidunt vel mid sed nunc.'),
(2, 'non', 'Bio-Chimie', 'Aliquam massa massa et, massa purus, porta et nec sit adipiscing nec elementum. In, placerat porttitor cras magna, montes turpis. Enim tortor, magna. Sociis turpis phasellus elementum mid. Dictumst hac dictumst pulvinar magnis, ac! Cursus scelerisque etiam nec, egestas ultricies? Et phasellus magna, dolor egestas? Elementum lorem auctor, quis dis augue a! Cum dapibus? Dis proin, a montes in enim! Nascetur turpis duis pulvinar, ac et! Ridiculus natoque nascetur dignissim, nec velit, ut dictumst enim aliquet placerat nunc tincidunt turpis? Ac et augue placerat, ut pulvinar scelerisque! Porttitor, lorem a lectus, elementum porttitor montes diam nascetur! Mag'),
(3, 'non', 'Physique', 'Risus amet sagittis. Odio auctor diam, aliquam proin sit, rhoncus elementum sed, nec a! Habitasse et, porta in quis ac, lundium in turpis sed phasellus in parturient adipiscing, rhoncus lorem, montes elementum, ultricies augue, tristique lacus. Ac hac placerat! Porttitor nascetur nec et pellentesque! Urna cursus ridiculus, etiam vut ut et augue aliquet eu adipiscing eros? Elementum et tincidunt dignissim! Nec rhoncus, dis dapibus a cursus turpis magna! Integer turpis, risus hac ut ac duis, eros tincidunt et cras turpis tincidunt elementum arcu integer! Proin lectus, augue urna, augue in amet porttitor! Duis. Vut cras lectus a habitasse et odio, etiam! In elit, massa diam, enim elementum scelerisque. Platea magna sit mus, tincidunt porttitor nisi placerat eros lacus, pulvinar porttitor.'),
(4, 'oui', 'Peinture', 'Scelerisque dolor lorem duis sociis magna nisi ultrices augue, aliquam adipiscing velit nisi integer magna urna lectus cras ac, elementum sed penatibus purus. Risus, natoque, ac! Nec, dignissim elementum cursus a montes risus amet placerat phasellus turpis porttitor amet porttitor natoque, eros etiam pulvinar eu etiam enim auctor scelerisque tortor pulvinar, magna elit enim et integer, augue ut non porttitor platea, nunc sociis! Porta, dignissim est, adipiscing, lundium ultrices, in montes, augue odio mus odio, cum platea pulvinar a? Montes aliquam cras pellentesque non dictumst porta, porta phasellus proin mus tristique rhoncus? Porta elit, porttitor? Nec ac hac aliquam porta turpis amet, ac. Eu, ut aliquam habitasse nunc nec duis, in massa non ridiculus sociis turpis adipiscing tortor ac.'),
(5, 'non', 'hnfnf', 'dhndfhnfnfnfn'),
(6, 'oui', 'MIAGE', ''),
(7, 'non', '	sed sit et, integer. ', '	quam habitant auctor integer sem at nam massa himenaeos, netus vel dapibus nibh malesuada leo fusce tortor, sociosqu semper facilisis semper class tempus faucibus. tristique duis eros cubilia quisque habitasse aliquam, fringilla orci non vel laoreet dolor enim, justo facilisis neque accumsan in. ad venenatis hac per dictumst, nulla ligula. '),
(8, 'non', '	magna aliquam ut, curabitur. ', '	potenti ut rutrum odio condimentum donec suscipit molestie est etiam, sit rutrum dui nostra sem aliquet conubia nullam. sollicitudin rhoncus venenatis vivamus rhoncus netus risus tortor non, mauris turpis eget integer nibh dolor commodo, venenatis ut molestie semper adipiscing amet cras. class donec sapien malesuada auctor sapien, arcu inceptos aenean. '),
(9, 'non', '	magna sollicitudin eleifend, porta. ', '	scelerisque ac class conubia condimentum mauris facilisis conubia quis scelerisque lacinia tempus, nullam felis fusce ac potenti netus ornare semper molestie iaculis fermentum, ornare curabitur tincidunt imperdiet scelerisque imperdiet euismod scelerisque torquent curae. rhoncus sollicitudin tortor placerat aptent hac nec, posuere suscipit sed tortor neque, urna hendrerit vehicula duis litora. '),
(10, 'non', '	tincidunt tortor sociosqu, semper. ', '	pellentesque semper class tempus faucibus tristique duis eros cubilia quisque habitasse, aliquam fringilla orci non vel laoreet dolor enim justo facilisis, neque accumsan in ad venenatis hac per dictumst nulla. ligula donec mollis massa porttitor ullamcorper risus eu, platea fringilla habitasse suscipit pellentesque donec, est habitant vehicula tempor ultrices placerat. '),
(11, 'non', '	eget conubia nullam, sollicitudin. ', '	nulla venenatis vivamus rhoncus netus risus tortor non mauris, turpis eget integer nibh dolor commodo venenatis, ut molestie semper adipiscing amet cras class. donec sapien malesuada auctor sapien arcu inceptos aenean consequat metus, litora mattis vivamus feugiat arcu adipiscing mauris primis ante, ullamcorper ad nisi lobortis arcu per orci malesuada. '),
(12, 'non', '	pretium odio fringilla, class. ', '	mi metus ipsum lorem luctus pharetra dictum, vehicula tempus in venenatis gravida ut gravida, proin orci quis sed platea. mi quisque hendrerit semper hendrerit facilisis ante, sapien faucibus ligula commodo vestibulum rutrum pretium, varius sem aliquet himenaeos dolor. cursus nunc habitasse aliquam ut curabitur ipsum, luctus ut rutrum odio condimentum. '),
(13, 'non', '	nullam sit ornare, orci. ', '	dictumst nullam adipiscing pulvinar libero aliquam vestibulum platea cursus pellentesque, leo dui lectus curabitur euismod ad erat curae. non elit ultrices placerat netus metus feugiat non conubia fusce porttitor sociosqu, diam commodo metus in himenaeos vitae aptent consequat luctus purus, eleifend enim sollicitudin eleifend porta malesuada ac class conubia condimentum. '),
(14, 'non', '	sed eu lobortis, curae. ', '	lacinia vivamus amet nulla torquent nibh, eu diam aliquam pretium, donec aliquam tempus lacus. tempus feugiat lectus cras non velit mollis sit et, integer egestas habitant auctor integer sem at, nam massa himenaeos netus vel dapibus nibh. malesuada leo fusce tortor sociosqu, semper facilisis semper class tempus, faucibus tristique duis. '),
(15, 'non', '	dictum platea mi, quisque. ', '	adipiscing semper hendrerit facilisis ante sapien faucibus ligula commodo, vestibulum rutrum pretium varius sem aliquet himenaeos dolor cursus, nunc habitasse aliquam ut curabitur ipsum luctus. ut rutrum odio condimentum donec suscipit molestie, est etiam sit rutrum dui nostra sem, aliquet conubia nullam sollicitudin rhoncus. venenatis vivamus rhoncus netus, risus tortor. '),
(16, 'non', '	nullam elit ultrices, placerat. ', '	cras euismod ultrices conubia fusce porttitor sociosqu diam commodo metus in himenaeos vitae aptent, consequat luctus purus eleifend enim sollicitudin eleifend porta malesuada ac class. conubia condimentum mauris facilisis conubia quis scelerisque lacinia tempus, nullam felis fusce ac potenti netus ornare semper molestie, iaculis fermentum ornare curabitur tincidunt imperdiet scelerisque. '),
(17, 'non', '	platea ligula donec, mollis. ', '	proin porttitor ullamcorper risus eu platea fringilla habitasse suscipit pellentesque, donec est habitant vehicula tempor ultrices placerat sociosqu ultrices consectetur, ullamcorper tincidunt quisque tellus ante nostra euismod nec. suspendisse sem curabitur elit malesuada lacus viverra sagittis sit ornare orci augue, nullam adipiscing pulvinar libero aliquam vestibulum platea cursus pellentesque leo. '),
(18, 'non', '	habitant nostra litora, mattis. ', '	aenean at arcu adipiscing mauris primis ante ullamcorper, ad nisi lobortis arcu per orci malesuada blandit, metus tortor urna turpis consectetur porttitor. egestas sed eleifend eget tincidunt pharetra varius tincidunt morbi malesuada, elementum mi torquent mollis eu lobortis curae purus amet vivamus, amet nulla torquent nibh eu diam aliquam pretium. '),
(19, 'non', '	ornare nec auctor, felis. ', '	elit ornare habitasse nec elit felis inceptos tellus inceptos cubilia quis mattis faucibus sem, non odio fringilla class aliquam metus ipsum lorem luctus pharetra dictum vehicula. tempus in venenatis gravida ut gravida proin orci quis, sed platea mi quisque hendrerit semper hendrerit facilisis, ante sapien faucibus ligula commodo vestibulum rutrum. '),
(20, 'non', '	quam ultrices consectetur, ullamcorper. ', '	vestibulum quisque tellus ante nostra euismod nec suspendisse sem curabitur elit, malesuada lacus viverra sagittis sit ornare orci augue nullam adipiscing, pulvinar libero aliquam vestibulum platea cursus pellentesque leo dui. lectus curabitur euismod ad erat curae non elit, ultrices placerat netus metus feugiat non, conubia fusce porttitor sociosqu diam commodo. '),
(21, 'non', '	consectetur metus tortor, urna. ', '	tempus consectetur porttitor egestas sed eleifend eget tincidunt pharetra varius tincidunt morbi, malesuada elementum mi torquent mollis eu lobortis curae purus amet, vivamus amet nulla torquent nibh eu diam aliquam pretium donec. aliquam tempus lacus tempus feugiat lectus cras, non velit mollis sit et integer, egestas habitant auctor integer sem. '),
(22, 'oui', '	rhoncus suscipit molestie, est. ', '	integer sit rutrum dui nostra sem aliquet conubia nullam sollicitudin rhoncus, venenatis vivamus rhoncus netus risus tortor non mauris turpis. eget integer nibh dolor commodo venenatis ut molestie semper adipiscing amet, cras class donec sapien malesuada auctor sapien arcu inceptos aenean, consequat metus litora mattis vivamus feugiat arcu adipiscing mauris. '),
(23, 'oui', '	a facilisis conubia, quis. ', '	eget lacinia tempus nullam felis fusce ac potenti, netus ornare semper molestie iaculis fermentum ornare, curabitur tincidunt imperdiet scelerisque imperdiet euismod. scelerisque torquent curae rhoncus sollicitudin tortor placerat aptent, hac nec posuere suscipit sed tortor neque, urna hendrerit vehicula duis litora tristique. congue nec auctor felis libero, ornare habitasse nec. '),
(24, 'oui', '	lacinia cubilia quisque, habitasse. ', '	cubilia fringilla orci non vel laoreet dolor enim, justo facilisis neque accumsan in ad venenatis hac, per dictumst nulla ligula donec mollis. massa porttitor ullamcorper risus eu platea fringilla habitasse suscipit pellentesque, donec est habitant vehicula tempor ultrices placerat sociosqu ultrices consectetur, ullamcorper tincidunt quisque tellus ante nostra euismod nec. '),
(25, 'oui', '	imperdiet turpis eget, integer. ', '	nostra dolor commodo venenatis ut molestie semper adipiscing amet cras class, donec sapien malesuada auctor sapien arcu inceptos aenean. consequat metus litora mattis vivamus feugiat arcu adipiscing mauris, primis ante ullamcorper ad nisi lobortis arcu per, orci malesuada blandit metus tortor urna turpis. consectetur porttitor egestas sed eleifend, eget tincidunt. '),
(26, 'oui', '	eleifend euismod scelerisque, torquent. ', '	faucibus rhoncus sollicitudin tortor placerat aptent, hac nec posuere suscipit sed tortor, neque urna hendrerit vehicula. duis litora tristique congue nec auctor felis, libero ornare habitasse nec elit, felis inceptos tellus inceptos cubilia. quis mattis faucibus sem non odio fringilla class aliquam metus, ipsum lorem luctus pharetra dictum vehicula tempus. ');

-- --------------------------------------------------------

--
-- Structure de la table `departements_facultes`
--

CREATE TABLE IF NOT EXISTS `departements_facultes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement_id` int(11) DEFAULT NULL,
  `faculte_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `departements_facultes`
--

INSERT INTO `departements_facultes` (`id`, `departement_id`, `faculte_id`) VALUES
(1, 1, 6),
(2, 2, 6),
(3, 3, 6),
(4, 4, 7),
(5, 5, 6),
(6, 6, 8),
(7, 7, 11),
(8, 8, 11),
(9, 9, 11),
(10, 10, 11),
(11, 11, 11),
(12, 12, 12),
(13, 13, 12),
(14, 14, 12),
(15, 15, 12),
(16, 16, 12),
(17, 17, 13),
(18, 18, 13),
(19, 19, 13),
(20, 20, 13),
(21, 21, 13),
(22, 22, 14),
(23, 23, 14),
(24, 24, 14),
(25, 25, 14),
(26, 26, 14);

-- --------------------------------------------------------

--
-- Structure de la table `departements_periodes`
--

CREATE TABLE IF NOT EXISTS `departements_periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departement_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `departements_periodes`
--

INSERT INTO `departements_periodes` (`id`, `departement_id`, `periode_id`) VALUES
(1, 1, 6),
(2, 2, 6),
(3, 3, 6),
(4, 4, 6),
(5, 5, 6),
(6, 6, 6),
(7, 7, 6),
(8, 8, 6),
(9, 9, 6),
(10, 10, 6),
(11, 11, 6),
(12, 12, 6),
(13, 13, 6),
(14, 14, 6),
(15, 15, 6),
(16, 16, 6),
(17, 17, 6),
(18, 18, 6),
(19, 19, 6),
(20, 20, 6),
(21, 21, 6),
(22, 22, 6),
(23, 23, 6),
(24, 24, 6),
(25, 25, 6),
(26, 26, 6);

-- --------------------------------------------------------

--
-- Structure de la table `enseignements`
--

CREATE TABLE IF NOT EXISTS `enseignements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `enseignant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Contenu de la table `enseignements`
--

INSERT INTO `enseignements` (`id`, `classe_id`, `matiere_id`, `enseignant_id`) VALUES
(33, 10, 14, 85),
(32, 10, 5, 83),
(31, 1, 5, 83),
(30, 1, 4, 83),
(28, 1, 1, 80),
(34, 10, 15, 86),
(35, 10, 13, 89),
(44, 8, 13, 89),
(41, 2, 1, 80),
(42, 2, 5, 83),
(43, 2, 13, 89),
(45, 9, 13, 89),
(46, 7, 13, 89),
(47, 6, 13, 89),
(48, 5, 13, 89),
(49, 5, 14, 85),
(50, 5, 2, 82),
(51, 5, 7, 87),
(52, 12, 13, 89),
(53, 1, 12, 90),
(55, 1, 13, 92),
(56, 1, 15, 86);

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE IF NOT EXISTS `evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_evaluation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `evaluations`
--

INSERT INTO `evaluations` (`id`, `nom`, `description`, `date_evaluation`) VALUES
(14, 'Devoir de surveillé', '', '07/07/2013'),
(15, 'Devoir de surveillé', '', '07/07/2013'),
(16, 'Devoir de surveillé', '', '07/07/2013'),
(17, 'Devoir de surveillé', '', '07/07/2013'),
(18, 'Devoir de surveillé', '', '23/07/2013'),
(19, 'Devoir de surveillé', '', '27/07/2013'),
(20, 'Rattrapage', 'sdtsdthsgdhdshthdghdfgh', '14/08/2013');

-- --------------------------------------------------------

--
-- Structure de la table `evaluations_matieres`
--

CREATE TABLE IF NOT EXISTS `evaluations_matieres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `evaluations_matieres`
--

INSERT INTO `evaluations_matieres` (`id`, `evaluation_id`, `matiere_id`) VALUES
(14, 18, 13),
(13, 17, 2),
(12, 16, 1),
(11, 15, 4),
(10, 14, 5),
(15, 19, 12),
(16, 20, 5);

-- --------------------------------------------------------

--
-- Structure de la table `evaluations_notes`
--

CREATE TABLE IF NOT EXISTS `evaluations_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `evaluations_notes`
--

INSERT INTO `evaluations_notes` (`id`, `evaluation_id`, `note_id`) VALUES
(10, 17, 10),
(9, 17, 9),
(8, 17, 8),
(7, 17, 7),
(6, 17, 6),
(11, 16, 11),
(12, 16, 12),
(13, 16, 13),
(14, 14, 14),
(15, 14, 15),
(16, 14, 16),
(17, 14, 17),
(18, 14, 18);

-- --------------------------------------------------------

--
-- Structure de la table `evaluations_teachers`
--

CREATE TABLE IF NOT EXISTS `evaluations_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `evaluations_teachers`
--

INSERT INTO `evaluations_teachers` (`id`, `evaluation_id`, `teacher_id`) VALUES
(3, 14, 83),
(4, 15, 83),
(5, 16, 80),
(6, 17, 82),
(7, 18, 89),
(8, 19, 90),
(9, 20, 83);

-- --------------------------------------------------------

--
-- Structure de la table `examens`
--

CREATE TABLE IF NOT EXISTS `examens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `date_debut` varchar(255) NOT NULL,
  `date_fin` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `facultes`
--

CREATE TABLE IF NOT EXISTS `facultes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `facultes`
--

INSERT INTO `facultes` (`id`, `actif`, `nom`, `description`) VALUES
(6, 'oui', 'Sciences', 'Magna, ut parturient! Odio lundium! Etiam tortor quis diam porta. Vut aenean, lectus lectus rhoncus cum dignissim scelerisque. Proin phasellus, sed! Lectus, lacus arcu placerat! Sociis enim parturient dis ultrices sit proin adipiscing turpis? Eros auctor eros scelerisque magnis ac a integer et a odio nascetur aenean a lacus, proin ac purus lorem dis? Pellentesque elit. Urna placerat lorem elementum, a pellentesque aenean, a nisi porttitor, non diam amet dictumst! Odio proin augue ridiculus nec elementum, et proin? Est elementum lorem nec nunc porttitor diam enim elementum, turpis ridiculus nunc? Turpis auctor sagittis dictumst lorem proin? Diam turpis, magnis scelerisque. Lectus porttitor, mus integer, mattis sagittis scelerisque massa eros purus pulvinar! Platea tempor magna, tortor, tincidunt vel mid sed nunc.'),
(5, 'oui', 'Médecine', 'Magna, ut parturient! Odio lundium! Etiam tortor quis diam porta. Vut aenean, lectus lectus rhoncus cum dignissim scelerisque. Proin phasellus, sed! Lectus, lacus arcu placerat! Sociis enim parturient dis ultrices sit proin adipiscing turpis? Eros auctor eros scelerisque magnis ac a integer et a odio nascetur aenean a lacus, proin ac purus lorem dis? Pellentesque elit. Urna placerat lorem elementum, a pellentesque aenean, a nisi porttitor, non diam amet dictumst! Odio proin augue ridiculus nec elementum, et proin? Est elementum lorem nec nunc porttitor diam enim elementum, turpis ridiculus nunc? Turpis auctor sagittis dictumst lorem proin? Diam turpis, magnis scelerisque. Lectus porttitor, mus integer, mattis sagittis scelerisque massa eros purus pulvinar! Platea tempor magna, tortor, tincidunt vel mid sed nunc.'),
(7, 'oui', 'Beaux arts', 'Scelerisque dolor lorem duis sociis magna nisi ultrices augue, aliquam adipiscing velit nisi integer magna urna lectus cras ac, elementum sed penatibus purus. Risus, natoque, ac! Nec, dignissim elementum cursus a montes risus amet placerat phasellus turpis porttitor amet porttitor natoque, eros etiam pulvinar eu etiam enim auctor scelerisque tortor pulvinar, magna elit enim et integer, augue ut non porttitor platea, nunc sociis! Porta, dignissim est, adipiscing, lundium ultrices, in montes, augue odio mus odio, cum platea pulvinar a? Montes aliquam cras pellentesque non dictumst porta, porta phasellus proin mus tristique rhoncus? Porta elit, porttitor? Nec ac hac aliquam porta turpis amet, ac. Eu, ut aliquam habitasse nunc nec duis, in massa non ridiculus sociis turpis adipiscing tortor ac.'),
(8, 'non', 'Informatique', ''),
(9, 'non', 'Test', ''),
(10, 'oui', 'Droit', ''),
(11, 'non', '	malesuada ullamcorper ad, nisi. ', '	pulvinar arcu per orci malesuada blandit metus tortor urna turpis consectetur, porttitor egestas sed eleifend eget tincidunt pharetra varius tincidunt, morbi malesuada elementum mi torquent mollis eu lobortis curae. purus amet vivamus amet nulla torquent nibh eu, diam aliquam pretium donec aliquam tempus lacus, tempus feugiat lectus cras non velit. '),
(12, 'non', '	molestie potenti netus, ornare. ', '	fusce molestie iaculis fermentum ornare curabitur tincidunt imperdiet scelerisque, imperdiet euismod scelerisque torquent curae rhoncus sollicitudin, tortor placerat aptent hac nec posuere suscipit. sed tortor neque urna hendrerit vehicula duis litora tristique congue, nec auctor felis libero ornare habitasse nec elit felis, inceptos tellus inceptos cubilia quis mattis faucibus sem. '),
(13, 'non', '	tempor ac mollis, sit. ', '	rhoncus integer egestas habitant auctor integer sem at nam massa himenaeos, netus vel dapibus nibh malesuada leo fusce tortor. sociosqu semper facilisis semper class tempus, faucibus tristique duis eros cubilia, quisque habitasse aliquam fringilla. orci non vel laoreet dolor enim, justo facilisis neque accumsan in ad, venenatis hac per dictumst. '),
(14, 'non', '	pretium odio fringilla, class. ', '	mi metus ipsum lorem luctus pharetra dictum, vehicula tempus in venenatis gravida ut gravida, proin orci quis sed platea. mi quisque hendrerit semper hendrerit facilisis ante, sapien faucibus ligula commodo vestibulum rutrum pretium, varius sem aliquet himenaeos dolor. cursus nunc habitasse aliquam ut curabitur ipsum, luctus ut rutrum odio condimentum. '),
(16, 'non', 'Faculte des medecine', 'Magna, ut parturient! Odio lundium! Etiam tortor quis diam porta. Vut aenean, lectus lectus rhoncus cum dignissim scelerisque. Proin phasellus, sed! Lectus, lacus arcu placerat! Sociis enim parturient dis ultrices sit proin adipiscing turpis? Eros auctor eros scelerisque magnis ac a integer et a odio nascetur aenean a lacus, proin ac purus lorem dis? Pellentesque elit. Urna placerat lorem elementum, a pellentesque aenean, a nisi porttitor, non diam amet dictumst! Odio proin augue ridiculus nec elementum, et proin? Est elementum lorem nec nunc porttitor diam enim elementum, turpis ridiculus nunc? Turpis auctor sagittis dictumst lorem proin? Diam turpis, magnis scelerisque. Lectus porttitor, mus integer, mattis sagittis scelerisque massa eros purus pulvinar! Platea tempor magna, tortor, tincidunt vel mid sed nunc.'),
(17, 'non', 'Faculte des medecine', 'Magna, ut parturient! Odio lundium! Etiam tortor quis diam porta. Vut aenean, lectus lectus rhoncus cum dignissim scelerisque. Proin phasellus, sed! Lectus, lacus arcu placerat! Sociis enim parturient dis ultrices sit proin adipiscing turpis? Eros auctor eros scelerisque magnis ac a integer et a odio nascetur aenean a lacus, proin ac purus lorem dis? Pellentesque elit. Urna placerat lorem elementum, a pellentesque aenean, a nisi porttitor, non diam amet dictumst! Odio proin augue ridiculus nec elementum, et proin? Est elementum lorem nec nunc porttitor diam enim elementum, turpis ridiculus nunc? Turpis auctor sagittis dictumst lorem proin? Diam turpis, magnis scelerisque. Lectus porttitor, mus integer, mattis sagittis scelerisque massa eros purus pulvinar! Platea tempor magna, tortor, tincidunt vel mid sed nunc.');

-- --------------------------------------------------------

--
-- Structure de la table `facultes_periodes`
--

CREATE TABLE IF NOT EXISTS `facultes_periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculte_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `facultes_periodes`
--

INSERT INTO `facultes_periodes` (`id`, `faculte_id`, `periode_id`) VALUES
(2, 5, 6),
(3, 6, 6),
(4, 7, 6),
(5, 8, 6),
(6, 9, 6),
(7, 10, 6),
(8, 11, 6),
(9, 12, 6),
(10, 13, 6),
(11, 14, 6),
(12, 16, 6),
(13, 17, 6);

-- --------------------------------------------------------

--
-- Structure de la table `facultes_schools`
--

CREATE TABLE IF NOT EXISTS `facultes_schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculte_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `facultes_schools`
--

INSERT INTO `facultes_schools` (`id`, `faculte_id`, `school_id`) VALUES
(6, 6, 12),
(5, 5, 12),
(7, 7, 13),
(8, 8, 12),
(9, 9, 12),
(10, 10, 12);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `matieres`
--

INSERT INTO `matieres` (`id`, `actif`, `nom`, `description`) VALUES
(1, 'oui', 'Analyse numerique et fonctionnelle', ''),
(2, 'oui', 'Physique nucléaire', ''),
(3, 'oui', 'Thermodynamique', ''),
(4, 'oui', 'Recherche opérationnelle', ''),
(5, 'oui', 'Algèbre', ''),
(6, 'oui', 'Géométrie analytique', ''),
(7, 'oui', 'Bio-Chimie', ''),
(8, 'oui', 'Programmation lineaire', ''),
(9, 'oui', 'Programmation lineaire', ''),
(10, 'oui', 'Programmation lineaire', ''),
(11, 'oui', 'Programmation lineaire', ''),
(12, 'oui', 'Topologie', ''),
(13, 'oui', 'Anglais', 'Cours d''anglais de base'),
(14, 'oui', 'Reseaux et Systemes d''information', ''),
(15, 'oui', 'Algorithme', ''),
(16, 'oui', 'Comtabilite Gestion', ''),
(17, 'oui', 'Analyse complexe', ''),
(18, 'oui', 'Analyse fonctionnelle', ''),
(19, 'oui', 'Analyse fonctionnelle', ''),
(20, 'oui', 'Analyse fonctionnelle', ''),
(21, 'oui', 'Analyse fonctionnelle', ''),
(22, 'oui', 'Analyse fonctionnelle', '');

-- --------------------------------------------------------

--
-- Structure de la table `matieres_periodes`
--

CREATE TABLE IF NOT EXISTS `matieres_periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matiere_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `matieres_periodes`
--

INSERT INTO `matieres_periodes` (`id`, `matiere_id`, `periode_id`) VALUES
(1, 1, 6),
(2, 2, 6),
(3, 3, 6),
(4, 4, 6),
(5, 5, 6),
(6, 6, 6),
(7, 7, 6),
(8, 8, 6),
(9, 9, 6),
(10, 10, 6),
(11, 11, 6),
(12, 12, 6),
(13, 13, 6),
(14, 14, 6),
(15, 15, 6),
(16, 16, 6),
(17, 17, 6),
(18, 18, 6),
(19, 19, 6),
(20, 20, 6),
(21, 21, 6),
(22, 22, 6);

-- --------------------------------------------------------

--
-- Structure de la table `matieres_teachers`
--

CREATE TABLE IF NOT EXISTS `matieres_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matiere_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `matieres_teachers`
--

INSERT INTO `matieres_teachers` (`id`, `matiere_id`, `teacher_id`) VALUES
(5, 1, 80),
(4, 22, 80),
(6, 1, 81),
(7, 2, 82),
(8, 4, 83),
(9, 5, 83),
(10, 13, 89),
(11, 15, 86),
(12, 14, 85),
(13, 7, 87),
(14, 12, 90),
(15, 12, 91),
(16, 13, 92);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `notes`
--

INSERT INTO `notes` (`id`, `valeur`) VALUES
(10, 17),
(9, 14),
(8, 16),
(7, 14),
(6, 20),
(11, 16),
(12, 12),
(13, 16),
(14, 12),
(15, 14),
(16, 14),
(17, 3),
(18, 13);

-- --------------------------------------------------------

--
-- Structure de la table `notes_students`
--

CREATE TABLE IF NOT EXISTS `notes_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `notes_students`
--

INSERT INTO `notes_students` (`id`, `note_id`, `student_id`) VALUES
(10, 10, 85),
(9, 9, 83),
(8, 8, 84),
(7, 7, 86),
(6, 6, 82),
(11, 11, 82),
(12, 12, 86),
(13, 13, 84),
(14, 14, 82),
(15, 15, 83),
(16, 16, 84),
(17, 17, 85),
(18, 18, 86);

-- --------------------------------------------------------

--
-- Structure de la table `option_affichage_listes`
--

CREATE TABLE IF NOT EXISTS `option_affichage_listes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entite` varchar(255) NOT NULL,
  `option_affichage_liste` varchar(255) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Définit l''affichage des entités (faculté,département,classes' AUTO_INCREMENT=5 ;

--
-- Contenu de la table `option_affichage_listes`
--

INSERT INTO `option_affichage_listes` (`id`, `entite`, `option_affichage_liste`) VALUES
(1, 'faculte', 'active'),
(2, 'departement', 'active'),
(3, 'classe', 'active'),
(4, 'matiere', 'active');

-- --------------------------------------------------------

--
-- Structure de la table `periodes`
--

CREATE TABLE IF NOT EXISTS `periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `debut` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fin` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `periodes`
--

INSERT INTO `periodes` (`id`, `actif`, `nom`, `debut`, `fin`) VALUES
(5, NULL, '06/02/2013 06/04/2013', '06/02/2013', '06/04/2013'),
(6, 'oui', 'Session du 06/02/2013 au 06/04/2013', '06/02/2013', '06/04/2013'),
(14, NULL, 'Session du 06/03/2013 au 06/17/2013', '06/03/2013', '06/17/2013'),
(15, NULL, 'Session du 06/02/2013 au 06/21/2013', '06/02/2013', '06/21/2013'),
(16, NULL, 'Une session de l''UNC', '06/02/2013', '06/29/2013'),
(17, NULL, 'xxxxxxxxx', '06/03/2013', '06/05/2013');

-- --------------------------------------------------------

--
-- Structure de la table `periodes_schools`
--

CREATE TABLE IF NOT EXISTS `periodes_schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `periodes_schools`
--

INSERT INTO `periodes_schools` (`id`, `periode_id`, `school_id`) VALUES
(1, 2, 12),
(2, 3, 12),
(3, 4, 12),
(4, 5, 12),
(5, 6, 12),
(6, 14, 12),
(7, 15, 12),
(8, 16, 12),
(9, 17, 13);

-- --------------------------------------------------------

--
-- Structure de la table `periodes_students`
--

CREATE TABLE IF NOT EXISTS `periodes_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `periodes_teachers`
--

CREATE TABLE IF NOT EXISTS `periodes_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'non',
  `nom` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `adresse_web` varchar(255) NOT NULL,
  `adresse_email` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `schools`
--

INSERT INTO `schools` (`id`, `actif`, `nom`, `ville`, `quartier`, `adresse_web`, `adresse_email`, `tel`, `created`, `updated`) VALUES
(12, 'oui', 'Koffi Annan', 'Oklahoma', 'Kaporo', 'koffiannan.com', 'fisoumare@gmail.com', 664894576, '2013-06-18 13:43:17', '2013-06-18 13:43:17'),
(13, 'non', 'UNC', 'Oklahoma', 'Kaporo', 'koffiannan.com', 'fisoumare@gmail.com', 664894576, '2013-06-18 13:43:17', '2013-06-18 13:43:17');

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` varchar(255) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` varchar(10) NOT NULL,
  `pays_naissance` varchar(255) NOT NULL,
  `ville_naissance` varchar(255) NOT NULL,
  `quartier_naissance` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `prenom_pere` varchar(255) NOT NULL,
  `nom_mere` varchar(255) NOT NULL,
  `prenom_mere` varchar(255) NOT NULL,
  `tel` int(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'etudiant.jpg',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Contenu de la table `students`
--

INSERT INTO `students` (`id`, `matricule`, `sexe`, `nom`, `prenom`, `date_naissance`, `pays_naissance`, `ville_naissance`, `quartier_naissance`, `ville`, `quartier`, `prenom_pere`, `nom_mere`, `prenom_mere`, `tel`, `email`, `photo`, `created`, `updated`) VALUES
(82, '', 'h', 'SOUMARE', 'Fodé Idrissa', '11/19/1984', 'Guinea', '', 'Abattoir', 'Dalaba', 'Bloc des professeurs', 'Samba Oumar', 'Conte', 'Adama', 0, '', '2fb32b6fd2c3835fd0917e961228db48.jpg', '2013-06-20 10:16:24', '2013-07-05 15:39:59'),
(83, '12345', 'h', 'SOUMARE', 'Daouda', '11/19/1984', 'Guinea', '', 'Abattoir', 'Djakarta', 'Bloc des professeurs', 'Samba Oumar', 'Conte', 'Adama', 0, '', 'a4fbd2692614b31bca10116d7a8bf96f.png', '2013-06-20 10:17:10', '2013-07-05 14:43:31'),
(84, '12345', 'h', 'SOUMARE', 'Maury', '11/19/1984', 'Guinea', '', 'Abattoir', 'Azkaban', 'Bloc des professeurs', 'Samba Oumar', 'Conte', 'Adama', 0, '', '7e1056b867551b2b9b43bc089a6a3e8a.png', '2013-06-20 10:17:49', '2013-07-05 14:43:54'),
(85, '12345', 'f', 'SOUMARE', 'Aboubacar Sidiki', '11/19/1984', 'Guinea', '', 'Abattoir', 'Conakry', 'Bloc des professeurs', 'Samba Oumar', 'Conte', 'Adama', 0, '', 'etudiant.jpg', '2013-06-20 10:18:10', '2013-07-05 14:44:36'),
(86, '12345', 'h', 'KEITA', 'Moussa Inter', '11/19/1984', 'Guinea', '', 'Abattoir', 'Conakry', 'Bloc des professeurs', 'Samba Oumar', 'Conte', 'Adama', 0, '', 'etudiant.jpg', '2013-06-20 10:18:29', '2013-07-05 14:44:49'),
(87, '', 'h', 'DIALLO', 'Alpha Amadou', '19/03/1985', 'Guinea', '', 'Landreyah', 'Conakry', 'Dixinn', 'Pathe', 'DIALLO', 'Marly', 0, '', 'c1f2ab486e322561650c4ef5fd50d941.png', '2013-07-05 14:58:39', '2013-07-15 09:48:36');

-- --------------------------------------------------------

--
-- Structure de la table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `sexe` varchar(10) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'enseignant.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Contenu de la table `teachers`
--

INSERT INTO `teachers` (`id`, `actif`, `sexe`, `nom`, `prenom`, `ville`, `quartier`, `tel`, `email`, `photo`) VALUES
(80, 'oui', 'M.', 'TOURE', 'Kandia', 'Conakry', 'Matam', 0, 'fisoumare@gmail.com', '370d941ebbb82ce91504cda0c8839f5c.png'),
(81, 'oui', 'M.', 'Nemangou', 'Philipe Anatole', 'Conakry', 'Matam', 0, 'fisoumare@gmail.com', 'avartarB.jpg'),
(82, 'oui', 'Mme', 'SOW', 'Binta', 'Conakry', 'Kipe', 0, '', '04272b7f15d31dff1c3bf57e57d3d2ab.png'),
(83, 'oui', 'M.', 'SOUMARE', 'Fodé Idrissa', 'Conakry', 'Camayenne', 64396534, '', 'enseignant.jpg'),
(84, 'oui', 'M.', 'CONDE', 'Lansana', 'Oklahoma', 'Sangoyah', 0, '', 'enseignant.jpg'),
(85, 'oui', 'M.', 'BANGOURA', 'Olivier', 'Oklahoma', 'Kaloum', 0, '', 'enseignant.jpg'),
(86, 'oui', 'M.', 'DIALLO', 'Dalaba', 'Oklahoma', 'Coza', 0, '', 'enseignant.jpg'),
(87, 'oui', 'M.', 'SOW', 'Boubacar', 'Oklahoma', 'Coza', 0, '', 'enseignant.jpg'),
(88, 'oui', 'M.', 'BANGOURA', 'Rodolphe', 'Oklahoma', 'Kaporo', 0, '', 'enseignant.jpg'),
(89, 'oui', 'M.', 'SOUMARE', 'Maury', 'Oklahoma', 'Camayenne', 0, '', 'enseignant.jpg'),
(90, 'oui', 'M.', 'MARA', 'Casimir', 'Conakry', 'Camayenne', 0, '', 'enseignant.jpg'),
(91, 'oui', 'M.', 'DIANE', 'Daouda', 'Conakry', 'Camayenne', 0, '', 'enseignant.jpg'),
(92, 'oui', 'M.', 'DIENG', 'Naye', 'Conakry', 'Camayenne', 0, '', 'enseignant.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'Particulier',
  `fonction` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'photo.jpg',
  `sexe` varchar(10) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `type`, `fonction`, `photo`, `sexe`, `identifiant`, `mdp`, `nom`, `prenom`, `email`) VALUES
(79, 'Particulier', '', 'photo.jpg', '', 'fisoumare', 'a7eea0a0a5aa33e914efdb01e3f04f080aab5a6a', 'SOUMARE', 'Fodé Idrissa', 'fisoumare@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
