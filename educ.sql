-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 12 Septembre 2014 à 12:51
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `educ`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Maternelle'),
(2, 'Primaire'),
(3, 'Collège'),
(4, 'Lycée');

-- --------------------------------------------------------

--
-- Structure de la table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `cities`
--

INSERT INTO `cities` (`id`, `nom`) VALUES
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
-- Structure de la table `classrooms`
--

CREATE TABLE IF NOT EXISTS `classrooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `actif` varchar(3) NOT NULL DEFAULT 'oui',
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `scolarite` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `classrooms`
--

INSERT INTO `classrooms` (`id`, `category_id`, `actif`, `nom`, `description`, `scolarite`, `created_at`, `updated_at`) VALUES
(15, 4, 'oui', '11e annee', '', '300000', '2014-09-02 13:39:52', '2014-09-02 13:39:52');

-- --------------------------------------------------------

--
-- Structure de la table `classroom_periode`
--

CREATE TABLE IF NOT EXISTS `classroom_periode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  `scolarite` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `classroom_periode`
--

INSERT INTO `classroom_periode` (`id`, `classroom_id`, `periode_id`, `scolarite`) VALUES
(15, 12, 12, '70000'),
(16, 12, 13, ''),
(17, 13, 12, ''),
(18, 13, 13, ''),
(19, 14, 12, '100000'),
(20, 14, 13, ''),
(24, 15, 15, '');

-- --------------------------------------------------------

--
-- Structure de la table `classroom_student`
--

CREATE TABLE IF NOT EXISTS `classroom_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `periode_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `classroom_student`
--

INSERT INTO `classroom_student` (`id`, `classroom_id`, `student_id`, `periode_id`) VALUES
(16, 15, 18, 15),
(15, 15, 17, 15);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'avartar2.png',
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `adresse`, `tel`, `email`, `photo`, `etat`, `created_at`, `updated_at`) VALUES
(17, 'Soumaré', 'Fode Idrissa', 'Camayenne', '00224664396534', 'fisoumare@gmail.com', '17_0a42bcc6b91f1cc1398c4b4fc1537ca02ff5311b caa4ab9abb351c023d5f0cc7ad61b3cc60e0ca9e 00224664396534_uomkuuWNC6uQSvabwJWs.jpg', 1, '2014-04-05 17:05:31', '2014-04-05 16:05:31'),
(18, 'Soumaré', 'Maury', 'Camayenne', '00224664291706', 'delmohaq@gmail.com', '18_0a42bcc6b91f1cc1398c4b4fc1537ca02ff5311b 4b633c2f6eccd3ebb438a0a1a123daa4ee4ab037 00224664291706_dY7DbYlr1uKbGknIqg0W.jpg', 0, '2014-04-05 16:46:12', '2014-04-13 16:37:33');

-- --------------------------------------------------------

--
-- Structure de la table `clotures`
--

CREATE TABLE IF NOT EXISTS `clotures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_cloture` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `clotures`
--

INSERT INTO `clotures` (`id`, `date_cloture`, `created_at`, `updated_at`) VALUES
(1, '2014-04-10', '2014-04-12 18:37:42', '2014-04-12 18:37:42');

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `scolarite` varchar(255) NOT NULL,
  `montant_inscription` int(11) NOT NULL,
  `montant_reinscription` int(11) NOT NULL,
  `devise` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`id`, `nom`, `adresse`, `tel`, `email`, `scolarite`, `montant_inscription`, `montant_reinscription`, `devise`, `photo`) VALUES
(1, 'Afrique Elite', 'Ratoma', '664 00 00 00', 'educ@gmail.com', '300000', 20000, 15000, 'GNF', 'bf81d4cef0d20a0f36191f6ceb593889cb6b525a_87A5QuCeo0gPq9pqeDbn.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(41) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

--
-- Contenu de la table `countries`
--

INSERT INTO `countries` (`id`, `nom`) VALUES
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
-- Structure de la table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `montant` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `periode_id`, `montant`, `created_at`, `updated_at`) VALUES
(3, 17, 15, '600000', '2014-09-08 20:18:35', '2014-09-08 20:19:52'),
(4, 18, 15, '50000', '2014-09-11 08:19:22', '2014-09-11 08:19:22');

-- --------------------------------------------------------

--
-- Structure de la table `periodes`
--

CREATE TABLE IF NOT EXISTS `periodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` varchar(3) DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `interval` varchar(20) NOT NULL,
  `debut` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `debut_payement` varchar(255) NOT NULL,
  `scolarite` varchar(255) NOT NULL,
  `montant_inscription` int(11) NOT NULL,
  `montant_reinscription` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `periodes`
--

INSERT INTO `periodes` (`id`, `actif`, `nom`, `interval`, `debut`, `debut_payement`, `scolarite`, `montant_inscription`, `montant_reinscription`, `created_at`, `updated_at`) VALUES
(15, 'oui', '', '2014 - 2015', '01/08/2014', '08', '100000', 20000, 15000, '2014-09-02 13:39:28', '2014-09-11 08:18:56');

-- --------------------------------------------------------

--
-- Structure de la table `periode_student`
--

CREATE TABLE IF NOT EXISTS `periode_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `classroom_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 si l''élève est ancien ou 1 si il est nouveau',
  `scolarite` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `periode_student`
--

INSERT INTO `periode_student` (`id`, `periode_id`, `student_id`, `classroom_id`, `category_id`, `new`, `scolarite`, `created_at`, `updated_at`) VALUES
(19, 15, 18, 15, 4, 1, '50000', '0000-00-00 00:00:00', '2014-09-10 19:28:45'),
(18, 15, 17, 15, 4, 1, '', '0000-00-00 00:00:00', '2014-09-10 11:16:24');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(500) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `seuil_alert_stock` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg',
  `expiration` date DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `ref`, `nom`, `prix`, `stock`, `seuil_alert_stock`, `photo`, `expiration`, `etat`, `created_at`, `updated_at`) VALUES
(1, '5', 'Biscreem', 3000, 400, 200, '1_biscreem_iNu8xTs56E6wYUeslrFi.jpg', '0000-00-00', 1, '2014-04-12 17:03:46', '2014-04-19 07:42:29'),
(2, '4', 'Patte dentifrice', 35000, 395, 100, '2_patteDentifrice_fRaeMRDu6PUrLbQHlPTG.jpg', '2014-06-20', 1, '2014-04-13 08:02:28', '2014-04-19 08:34:47'),
(3, 'qsgg', 'zgzrgrz', 0, 0, 0, 'default.jpg', NULL, 0, '2014-04-04 22:04:21', '2014-04-19 07:39:43'),
(4, 'fdfaedf', 'aefef', 0, 0, 0, 'default.jpg', NULL, 0, '2014-04-04 08:15:08', '2014-04-19 07:40:19'),
(5, 'dvfv', 'vadsvzfv', 0, 0, 0, 'default.jpg', NULL, 0, '2014-04-04 08:16:28', '2014-04-19 07:40:09'),
(6, '454656', 'zrgrzg', 0, 0, 0, '6_zrgrzg_xxc2MxScRTR1rgEjh30m.jpg', NULL, 0, '2014-04-04 22:07:00', '2014-04-19 07:39:50'),
(7, 'zfaqgazfgzrg', 'zrgzrag', 0, 0, 0, 'default.jpg', NULL, 0, '2014-04-04 08:19:17', '2014-04-19 07:40:14'),
(9, 'tgsg', 'sfgsfg', 45666, 40, 50, 'default.jpg', NULL, 0, '2014-04-04 17:44:27', '2014-04-19 07:40:33'),
(10, 'tgsg', 'sfgsfg', 45666, 40, 50, 'default.jpg', NULL, 0, '2014-04-04 17:44:27', '2014-04-19 07:40:39'),
(11, 'qsgg', 'zgzrgrz', 0, 0, 0, 'default.jpg', NULL, 0, '2014-04-04 08:11:42', '2014-04-19 07:40:23'),
(12, 'qgqdg', 'Coca', 8000, 450, 100, 'default.jpg', '0000-00-00', 0, '2014-04-04 19:48:13', '2014-04-19 07:40:05'),
(13, 'qgqdg', 'Coca', 8000, 450, 100, 'default.jpg', NULL, 0, '2014-04-04 18:51:49', '2014-04-19 07:39:59'),
(14, '6', 'Spaguetti', 10000, 50, 20, '14_spaguetti_xvBbgY44zfRtqJCjIcj3.jpg', '0000-00-00', 1, '2014-04-05 08:01:55', '2014-04-19 07:42:43'),
(15, '3', 'Sachet Eau Coyah', 500, 3850, 1000, 'default.jpg', '0000-00-00', 1, '2014-04-13 08:12:16', '2014-04-19 07:49:47'),
(16, '2', 'Yaourt', 8000, 500, 100, 'default.jpg', '2014-06-21', 1, '2014-04-19 07:33:01', '2014-04-19 08:22:40'),
(17, '1', 'Coca cola', 8000, 450, 100, 'default.jpg', '0000-00-00', 1, '2014-04-19 07:35:51', '2014-04-19 07:44:00');

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
  `country_id` int(11) NOT NULL,
  `city_naissance_id` int(11) DEFAULT NULL,
  `autre_ville_naissance` varchar(255) NOT NULL,
  `quartier_naissance` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `prenom_pere` varchar(255) NOT NULL,
  `nom_mere` varchar(255) NOT NULL,
  `prenom_mere` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'etudiant.jpg',
  `scolarite` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `students`
--

INSERT INTO `students` (`id`, `matricule`, `sexe`, `nom`, `prenom`, `date_naissance`, `country_id`, `city_naissance_id`, `autre_ville_naissance`, `quartier_naissance`, `city_id`, `quartier`, `prenom_pere`, `nom_mere`, `prenom_mere`, `tel`, `email`, `photo`, `scolarite`, `created_at`, `updated_at`) VALUES
(17, '', 'f', 'SOUMARE', 'Fodé Idrissa', '04/09/2014', 79, 4, '', 'Camayenne', 4, 'Camayenne', 'Samba Oumar', 'Conté', 'Adama', '', '', '17_6e8d2a2c5711d584d51c90dfc3bd747b58abe101_5VwxGVCTeZ0zn6zPlRTZ.png', '', '2014-09-02 13:40:59', '2014-09-10 11:16:24'),
(18, '', 'm', 'Mara', 'Casimir', '26/09/2014', 79, 4, '', 'Camayenne', 4, 'Camayenne', 'Samba Oumar', 'Conté', 'Adama', '', '', 'etudiant.jpg', '', '2014-09-10 12:57:19', '2014-09-10 12:57:19');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'avartarB.jpg',
  `identifiant` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `etat` int(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `type`, `photo`, `identifiant`, `mdp`, `nom`, `prenom`, `etat`, `created_at`, `updated_at`) VALUES
(79, 'Administrateur', 'avartarB.jpg', 'afrique-elite', 'a4d01e32110e9b2bcd0fcb2b55ffe42b8566f70a', 'admin', 'admin', 1, NULL, '2014-08-31 23:27:20'),
(82, 'Gérant', 'avartarB.jpg', 'jbender', 'a3ca6d1bf24f340bf85c4860da5b273ed97bcaef', 'SOUMARE', 'Fodé Idrissa', 0, '2014-08-31 23:25:04', '2014-08-31 23:26:23'),
(83, 'Gérant', 'avartarB.jpg', 'thiam', 'e2a5c6cfa40378015670a6199fb841556401b477', 'THIAM', 'Ibrahima', 1, '2014-09-01 12:46:13', '2014-09-01 12:46:13');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE IF NOT EXISTS `ventes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `remise` int(11) NOT NULL,
  `etat` int(1) NOT NULL DEFAULT '1',
  `created_at` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`id`, `user_id`, `produit_id`, `client_id`, `quantite`, `prix`, `remise`, `etat`, `created_at`, `updated_at`) VALUES
(1, 79, 1, 0, 4, '3000', 0, 1, '2014-04-09 21:31:17', '2014-04-09 19:31:17'),
(2, 79, 1, 0, 6, '3000', 0, 1, '2014-04-09 21:32:00', '2014-04-09 19:32:00'),
(3, 79, 2, 0, 7, '35000', 0, 1, '2014-04-09 21:32:39', '2014-04-09 19:32:39'),
(4, 79, 2, 0, 5, '3500', 10, 1, '2014-04-09 21:33:31', '2014-04-09 19:33:31'),
(5, 79, 2, 0, 2, '28000', 20, 1, '2014-03-09 21:34:09', '2014-04-13 11:30:20'),
(6, 79, 2, 0, 5, '35000', 0, 1, '2014-04-13 09:02:29', '2014-04-13 07:02:29'),
(8, 79, 2, 0, 4, '37000', 0, 1, '2014-04-13 08:59:16', '2014-04-13 06:59:16'),
(9, 79, 2, 0, 4, '35000', 0, 1, '2014-04-10 18:30:40', '2014-04-10 16:30:40'),
(10, 79, 2, 0, 10, '35500', 0, 1, '2014-03-13 08:56:51', '2014-04-13 10:35:48'),
(11, 79, 2, 0, 5, '35000', 0, 1, '2014-04-10 18:30:40', '2014-04-10 16:30:40'),
(12, 79, 1, 17, 2, '3000', 0, 1, '2014-04-10 18:35:08', '2014-04-10 16:35:08'),
(13, 79, 1, 0, 2, '3000', 0, 1, '2014-04-10 18:40:52', '2014-03-10 17:40:52'),
(14, 79, 2, 17, 15, '35000', 0, 1, '2014-04-10 18:45:50', '2014-04-10 16:45:50'),
(15, 79, 2, 18, 14, '24500', 30, 1, '2014-04-10 18:47:46', '2014-04-10 16:47:46'),
(16, 79, 2, 0, 23, '35000', 0, 1, '2014-04-10 18:53:34', '2014-04-10 16:53:34'),
(17, 79, 1, 0, 84, '2850', 5, 1, '2014-04-10 18:53:34', '2014-04-10 16:53:34'),
(18, 79, 2, 0, 54, '35000', 0, 1, '2014-04-10 18:53:58', '2014-04-10 16:53:58'),
(21, 79, 15, 0, 50, '450', 10, 1, '2014-04-13 21:16:01', '2014-04-13 20:16:01'),
(23, 79, 2, 0, 5, '35000', 0, 1, '2014-04-13 21:17:00', '2014-04-13 20:19:01'),
(28, 79, 15, 0, 70, '500', 0, 1, '2014-04-19 07:48:23', '2014-04-19 07:48:51'),
(29, 79, 15, 0, 50, '400', 20, 1, '2014-04-19 07:49:47', '2014-04-19 07:49:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
