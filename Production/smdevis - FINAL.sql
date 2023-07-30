-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 30, 2023 at 01:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smdevis`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230706171906', '2023-07-06 19:19:33', 181);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `part_id` int(11) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'User',
  `login_code` varchar(255) DEFAULT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `nom_soc` varchar(255) NOT NULL,
  `act_entreprise` varchar(255) NOT NULL,
  `mat_fisc` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel_gsm` int(8) NOT NULL,
  `tel_fix` int(8) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `codepostal` int(10) NOT NULL,
  `subscription` varchar(255) NOT NULL,
  `date_part_sub` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`part_id`, `etat`, `role`, `login_code`, `nom`, `prenom`, `nom_soc`, `act_entreprise`, `mat_fisc`, `email`, `tel_gsm`, `tel_fix`, `adresse`, `codepostal`, `subscription`, `date_part_sub`) VALUES
(26, 'Permanent', 'Admin', 'admin', 'Admin', 'Admin', 'Admin', '', '', 'admin@admin.com', 0, 0, '', 0, '', '2023-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE `projets` (
  `ref_proj` int(11) NOT NULL,
  `nom_dem` varchar(255) NOT NULL,
  `prenom_dem` varchar(255) NOT NULL,
  `civilite_dem` varchar(255) NOT NULL,
  `telephone_dem` int(11) NOT NULL,
  `adresse_dem` varchar(255) NOT NULL,
  `ville_dem` varchar(255) NOT NULL,
  `codepostale_dem` int(11) NOT NULL,
  `email_dem` varchar(255) NOT NULL,
  `titreprojet` varchar(255) NOT NULL,
  `situation_proj` varchar(255) NOT NULL,
  `type_bien` varchar(255) NOT NULL,
  `etat_bien` varchar(255) NOT NULL,
  `description_proj` text NOT NULL,
  `objet_dem_proj` varchar(255) NOT NULL,
  `budget_proj` int(11) NOT NULL,
  `delai_realisation` varchar(255) NOT NULL,
  `periode_rappel` varchar(255) NOT NULL,
  `date_dem_proj` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projets`
--

INSERT INTO `projets` (`ref_proj`, `nom_dem`, `prenom_dem`, `civilite_dem`, `telephone_dem`, `adresse_dem`, `ville_dem`, `codepostale_dem`, `email_dem`, `titreprojet`, `situation_proj`, `type_bien`, `etat_bien`, `description_proj`, `objet_dem_proj`, `budget_proj`, `delai_realisation`, `periode_rappel`, `date_dem_proj`) VALUES
(6, 'Mahmoud', 'Mzoughi', 'Monsieur', 29916488, 'Bardo', 'Tunis', 2052, 'mahmoudmzoughi@gmail.com', 'Rénovation de maison', 'proprietaire', 'maison', 'ancien', 'La maison a subi une inondation ces dernières années et a besoin d\'être rénovée', 'je veux rénover ma maison de 20 ans', 10000, '3-6mois', 'matin', '2023-07-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`ref_proj`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `projets`
--
ALTER TABLE `projets`
  MODIFY `ref_proj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
