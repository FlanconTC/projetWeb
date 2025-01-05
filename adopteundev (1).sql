-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 05 jan. 2025 à 03:53
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adopteundev`
--

-- --------------------------------------------------------

CREATE TABLE `favoris` (
  `id` int(11) NOT NULL,
  `id_favoris` int(11) DEFAULT NULL
);

CREATE TABLE `langage_de_prog` (
  `id` int(11) NOT NULL,
  `langage_de_prog` varchar(255) NOT NULL
);

CREATE TABLE `langage_developpeur` (
 `id` int(11) NOT NULL,
  `id_langage` int(11) DEFAULT NULL
);

--
-- Structure de la table `dev`
--
CREATE TABLE `dev` (
  `id` int(11) NOT NULL,
  `niveau_experience` varchar(255) DEFAULT NULL,
  `salaire_min` int(11) DEFAULT NULL,
  `biographie` longtext DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nb_vues` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL,
  `fiche_de_poste_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fiche_de_poste`
--

CREATE TABLE `fiche_de_poste` (
  `id` int(11) NOT NULL,
  `titre_poste` varchar(255) DEFAULT NULL,
  `technologies_recherchees` varchar(255) DEFAULT NULL,
  `niveau_exp_requis` int(11) DEFAULT NULL,
  `nb_vues` int(11) DEFAULT NULL,
  `salaire_propose` int(11) DEFAULT NULL,
  `description_detaillee` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) NOT NULL,
  `recherche` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matching`
--

CREATE TABLE `matching` (
  `id` int(11) NOT NULL,
  `dev_id` int(11) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `like_from_dev` int(11) DEFAULT NULL,
  `like_from_e` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messagerie`
--

CREATE TABLE `messagerie` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `dev_id` int(11) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `lu_dev` tinyint(1) DEFAULT NULL,
  `lu_e` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `dev_evaluateur_id` int(11) DEFAULT NULL,
  `dev_evalue_id` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `historique_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dev`
--
ALTER TABLE `dev`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D19FA60F76AAB91` (`fiche_de_poste_id`);

--
-- Index pour la table `fiche_de_poste`
--
ALTER TABLE `fiche_de_poste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matching`
--
ALTER TABLE `matching`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DC10F289A421F7B0` (`dev_id`),
  ADD KEY `IDX_DC10F289A4AEAFEA` (`entreprise_id`);

--
-- Index pour la table `langage_de_prog`
--
ALTER TABLE `langage_de_prog`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `langage_developpeur`
  ADD PRIMARY KEY (`id`,`id_langage`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY(`id`, `id_favoris`);

--
-- Index pour la table `messagerie`
--
ALTER TABLE `messagerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_14E8F60CA4AEAFEA` (`entreprise_id`),
  ADD KEY `IDX_14E8F60CA421F7B0` (`dev_id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CFBDFA14D2661763` (`dev_evaluateur_id`),
  ADD KEY `IDX_CFBDFA14A5B10807` (`dev_evalue_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1D1C63B36128735E` (`historique_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `fiche_de_poste`
--
ALTER TABLE `fiche_de_poste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matching`
--
ALTER TABLE `matching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messagerie`
--
ALTER TABLE `messagerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `langage_de_prog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dev`
--
ALTER TABLE `dev`
  ADD CONSTRAINT `FK_1173F105BF396750` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `FK_D19FA60BF396750` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D19FA60F76AAB91` FOREIGN KEY (`fiche_de_poste_id`) REFERENCES `fiche_de_poste` (`id`);

--
-- Contraintes pour la table `matching`
--
ALTER TABLE `matching`
  ADD CONSTRAINT `FK_DC10F289A421F7B0` FOREIGN KEY (`dev_id`) REFERENCES `dev` (`id`),
  ADD CONSTRAINT `FK_DC10F289A4AEAFEA` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `messagerie`
--
ALTER TABLE `messagerie`
  ADD CONSTRAINT `FK_14E8F60CA421F7B0` FOREIGN KEY (`dev_id`) REFERENCES `dev` (`id`),
  ADD CONSTRAINT `FK_14E8F60CA4AEAFEA` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `FK_CFBDFA14A5B10807` FOREIGN KEY (`dev_evalue_id`) REFERENCES `dev` (`id`),
  ADD CONSTRAINT `FK_CFBDFA14D2661763` FOREIGN KEY (`dev_evaluateur_id`) REFERENCES `dev` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B36128735E` FOREIGN KEY (`historique_id`) REFERENCES `historique` (`id`);

ALTER TABLE `favoris`
  ADD FOREIGN KEY (`id`) REFERENCES `dev` (`id`),
  ADD FOREIGN KEY (`id_favoris`) REFERENCES `dev` (`id`);

ALTER TABLE `langage_developpeur`
  ADD FOREIGN KEY (`id`) REFERENCES `dev` (`id`),
  ADD FOREIGN KEY (`id_langage`) REFERENCES `langage_de_prog` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
