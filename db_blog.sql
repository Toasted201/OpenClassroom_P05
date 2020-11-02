-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2020 at 03:06 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `dateCreate` date NOT NULL,
  `statut` enum('attente','valide','refus','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `postId`, `userId`, `content`, `dateCreate`, `statut`) VALUES
(1, 1, 9, 'Test Comment #1.0', '2020-10-01', 'refus'),
(2, 1, 9, 'Test Comment #1.1', '2020-10-20', 'refus'),
(3, 1, 9, 'Test Comment #1.2', '2020-10-20', 'refus'),
(4, 1, 9, 'Test Comment #1.3', '2020-10-20', 'refus'),
(5, 1, 9, 'Test Comment #1.5', '2020-10-20', 'refus'),
(6, 1, 9, 'Test Comment #1.4', '2020-10-20', 'valide'),
(7, 1, 9, 'Test Comment #1.6', '2020-10-20', 'refus'),
(8, 1, 9, 'Test Comment #1.7', '2020-10-20', 'valide'),
(9, 1, 9, 'Test Comment #1.8', '2020-10-20', 'refus'),
(10, 1, 9, 'Test Comment #1.9', '2020-10-20', 'valide'),
(11, 2, 9, '<script>alert(\'test\')</script>', '2020-10-22', 'refus'),
(12, 4, 9, 'Test Comment #4.1', '2020-10-26', 'valide'),
(13, 9, 9, 'Bienvenue dans le monde du dév^^', '2020-06-03', 'valide'),
(14, 11, 10, 'Approuvé', '2020-10-26', 'valide'),
(15, 11, 9, 'Approuvé', '2020-10-26', 'refus'),
(16, 9, 10, 'Prête à commencer', '2020-06-03', 'valide'),
(17, 9, 10, 'Prête à commencer', '2020-10-27', 'refus'),
(18, 10, 10, 'C\'est parti', '2020-10-27', 'attente'),
(19, 9, 10, 'Un nouveau test de commentaire', '2020-10-29', 'refus'),
(20, 12, 10, 'Un nouveau test de commentaire', '2020-10-29', 'attente'),
(21, 12, 10, 'Un nouveau test de commentaire', '2020-10-29', 'attente'),
(22, 16, 9, 'Félicitations', '2020-08-12', 'valide'),
(23, 17, 12, 'le PHP, c\'est fun^^', '2020-09-05', 'valide'),
(24, 10, 10, 'Un test de commentaire sur le post #1', '2020-11-02', 'attente');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `chapo` text NOT NULL,
  `content` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `dateCreate` date NOT NULL,
  `dateChange` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `userId`, `chapo`, `content`, `title`, `publish`, `dateCreate`, `dateChange`) VALUES
(1, 9, 'Test CHAPO #1', 'Test CONTENU #1', 'Test TITLE #1', 0, '2020-10-01', '2020-10-26'),
(2, 9, 'Test CHAPO #2 ', 'Test CONTENT #2 & modif', 'Test TITLE #2  ', 0, '2020-10-01', '2020-10-29'),
(3, 9, 'Test CHAPO #3', 'Test CONTENT #3', 'Test TITLE #3', 0, '2020-10-21', '2020-10-26'),
(4, 9, 'Test CHAPO #4', 'Test CONTENT #4', 'Test TITLE #4', 0, '2020-10-21', '2020-10-26'),
(5, 9, 'Test CHAPO #5', 'Test CONTENT #5', 'Test TITLE #5', 0, '2020-10-21', NULL),
(6, 9, 'Test CHAPO #6', 'Test CONTENT #6', 'Test TITLE #6', 0, '2020-10-21', NULL),
(7, 9, 'Test CHAPO #7', 'Test CONTENT #7', 'Test TITLE #7', 0, '2020-10-22', NULL),
(8, 9, 'Test CHAPO #8', 'Test CHAPO #8', 'Test TITLE #8', 0, '2020-10-23', NULL),
(9, 10, 'Devenir développeur et constituer un portfolio en réalisant des applications avec PHP', 'Grâce à la spécialisation PHP / Symfony, je vais aborder tous les sujets centraux me permettant de développer une application de manière professionnelle et robuste. Depuis l’affichage de données provenant de la base de données, la traduction de contenu, construire une API REST…\r\n\r\nJe vais aborder l\'ensemble des sujets nécessaires à de bonnes bases pour entrer sereinement dans le monde du développement web professionnel (l\'affichage de données provenant de la base de données, la traduction de contenu, construire une API REST…).\r\n\r\nJe vais suivre cette formation en ligne pour obtenir le diplôme “Développeur d’application”* enregistré au RNCP, de niveau II reconnu par l’État (équivalent au niveau Bac+3/4). \r\n\r\nCe diplôme est délivré par OpenClassrooms.', 'Formation Développeur d\'application - PHP / Symfony', 1, '2020-06-03', NULL),
(10, 10, 'J\'embarque sur un grand parcours d\'apprentissage.', 'L’objectif de ce premier projet est de me donner toutes les clés pour réussir mon parcours, puis mon insertion professionnelle ! \r\n\r\nAinsi, je vais mettre en place mon planning de formation, et me familiariser avec les projets que j\'aurais à réaliser pendant mon parcours. Ce projet me permettra également de préparer ma première séance de mentorat où je me présenterai à votre mentor ! \r\n', 'Projet 1 - Définir sa stratégie d\'apprentissage', 1, '2020-06-04', NULL),
(11, 10, 'B.R.A.V.O, vous avez réussi votre première soutenance de projet !', 'Vous pouvez être très fière, c’est une première étape de franchie !', 'Projet 1 Validé', 1, '2020-06-22', NULL),
(12, 10, 'Votre nouveau client, une agence immobilière de montagne, a besoin d\'un site web pour présenter les chalets qu\'elle vend. Vous allez utiliser Wordpress pour créer son site !', 'Compétences évaluées : \r\n\r\n- Adapter un thème Wordpress pour respecter les exigences du client\r\n- Rédiger une documentation à l\'intention d\'utilisateurs non spécialistes\r\n- Sélectionner un thème Wordpress adapté aux besoins du client', 'Projet 2 - Intégrez un thème WordPress pour un client', 1, '2020-06-23', NULL),
(13, 10, 'En tant que développeur, on vous demande souvent de lister les fonctionnalités dont a besoin le client et de proposer une solution technique adaptée.\r\nVous devez donc sélectionner la solution qui vous semble la plus à même de répondre à son besoin.', 'Jennifer Edwards est l\'organisatrice du festival des Films de Plein Air. Elle ambitionne de sélectionner et de projeter des films d\'auteur en plein air du 5 au 8 août au parc Monceau à Paris.\r\n\r\nSon association vient juste d\'être créée et elle dispose d\'un budget limité. Elle a besoin de communiquer en ligne sur son festival, d\'annoncer les films projetés et de recueillir les réservations.\r\n\r\nEn tant que développeur, on vous demande de lister les fonctionnalités dont a besoin la cliente et de proposer une solution technique adaptée. Vous devez donc sélectionner la solution qui vous semble la plus à même de répondre à son besoin : quels outils utiliser, éventuellement un CMS, etc.\r\n\r\nVous devrez ensuite réaliser une première maquette de ce site correspondant à ses attentes, en utilisant uniquement HTML et CSS.', 'Projet 3 - Analysez les besoins de votre client pour son festival de films', 1, '2020-06-27', NULL),
(14, 10, 'Vos efforts ont porté leurs fruits ! Vous avez acquis toutes les compétences de ce projet.', 'Très bonne présentation : claire, structurée et fluide.\r\n\r\nBon travail, bonne implication dans la mission.', 'Projet 3 Validé !', 1, '2020-07-10', NULL),
(15, 10, 'Utilisez vos connaissances en UML et MySQL pour imaginer et concevoir l\'architecture de la base de donnée d\'une application de restauration', 'Vous venez d\'être recruté par la toute jeune startup ExpressFood. \r\n\r\nElle ambitionne de livrer des plats de qualité à domicile en moins de 20 minutes grâce à un réseau de livreurs à vélo.', 'Projet 4 - Concevez la solution technique de restauration en ligne', 1, '2020-07-11', NULL),
(16, 10, 'Félicitations !\r\nVos efforts ont porté leurs fruits ! Vous avez acquis toutes les compétences de ce projet.', 'Points forts :\r\n\r\nRespect scrupuleux du cahier des charges\r\n\r\nAxes d\'amélioration :\r\n\r\nMieux préparer pour diminuer le nombre d\'hésitations', 'Projet 4 Validé', 1, '2020-08-11', NULL),
(17, 10, 'Développez votre première application web avec PHP et MySQL, et offrez-vous une visibilité intéressante sur le web.', 'Ça y est, vous avez sauté le pas ! Le monde du développement web avec PHP est à portée de main et vous avez besoin de visibilité pour pouvoir convaincre vos futurs employeurs/clients en un seul regard. \r\n\r\nVous êtes développeur PHP, il est donc temps de montrer vos talents au travers d’un blog à vos couleurs.', 'Projet 5 - Créez votre premier blog en PHP', 1, '2020-08-12', '2020-11-02'),
(18, 10, 'Vos efforts ont porté leurs fruits ! Vous avez acquis toutes les compétences de ce projet.', 'Points forts :\r\n\r\nDocumentation bien conçue;\r\nChoix du thème bien justifié;\r\nMise en place template de base pour ajouter des chalets en vente/location\r\n\r\nAxes d\'amélioration :\r\n\r\nAjouter une formulaire de réservation;', 'Projet 2 Validé !', 1, '2020-06-26', NULL),
(19, 11, 'le chapô d\'un test de post', 'le contenu d\'un test de post', 'Le titre d\'un test de post', 0, '2020-11-02', '2020-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `dateCreate` date DEFAULT NULL,
  `dateLastConnexion` date DEFAULT NULL,
  `userRole` enum('admin','moderateur','visiteur','') NOT NULL,
  `dateBF` date DEFAULT NULL,
  `nbAttaques` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `pass`, `dateCreate`, `dateLastConnexion`, `userRole`, `dateBF`, `nbAttaques`) VALUES
(9, 'Jane', 'Doe', 'janedoe@helixsi.com', '$2y$10$YrEfHT2QRAFXbdu5wN/ZoeYLZ0OH9ANxhcK57kAv/PrIE/SvPr7XC', '2020-10-27', NULL, 'visiteur', '2020-10-27', 1),
(10, 'Julie', 'Xaxa', 'julie@helixsi.com', '$2y$10$1fCTlRKZWeKd5xxaPBlG4e1rXFqWH.hU/wj1BdbJKQCkCWFmYqPZa', '2020-10-27', NULL, 'admin', '2020-10-29', 1),
(11, 'John', 'Doe', 'johndoe@helixsi.com', '$2y$10$Oac7/LLg2F3c4klvqAfc5e8tH4hH1slB/SfhX3t48/fXQs2qUOdSC', '2020-10-27', NULL, 'visiteur', NULL, 0),
(12, 'Bob', 'Doe', 'bobdoe@helixsi.com', '$2y$10$0qOauv2bWLAFuN5hEC1dFuqWcFRgKqLtqCOp4o9zr9r5AaO9LxH6S', '2020-10-27', NULL, 'visiteur', NULL, 0),
(13, 'Dan', 'Doe', 'dandoe@helixsi.com', '$2y$10$CU7nClOVTNHNFd50LFpAUOt5rt6RS8Qz2zR5NEER7B2mLhRku2R1K', '2020-11-02', NULL, 'visiteur', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
