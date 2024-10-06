-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 01 oct. 2024 à 23:01
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_stages_sodecoton`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`admin_id`, `email`, `mot_de_passe`) VALUES
(3, 'stevekaragama573@gmail.com', '$2y$10$AiMHu6U2tfjo.RnTuqp7qej/ZVCG3uFHASCkzIrJlw7huzQR4B1p.');

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) DEFAULT NULL,
  `offre_id` int(11) DEFAULT NULL,
  `date_soumission` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('EnAttente','Accepter','Rejeter') DEFAULT 'EnAttente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `etudiant_id`, `offre_id`, `date_soumission`, `statut`) VALUES
(1, 2, 6, '2024-09-20 14:20:11', 'Accepter'),
(2, 2, 3, '2024-09-20 15:29:33', 'Rejeter'),
(5, 4, 9, '2024-09-20 18:19:30', 'Accepter'),
(6, 2, 9, '2024-09-20 18:21:04', 'Accepter'),
(7, 2, 7, '2024-09-20 18:33:55', 'Accepter'),
(10, 2, 3, '2024-09-27 11:16:29', 'Accepter'),
(11, 10, 3, '2024-09-27 11:58:06', 'EnAttente'),
(12, 11, 3, '2024-10-01 10:42:48', 'EnAttente');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `etudiant_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `niveau_etude` varchar(100) DEFAULT NULL,
  `filiere` varchar(100) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `lettre_motivation` varchar(255) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `ecole` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`etudiant_id`, `nom`, `prenom`, `email`, `mot_de_passe`, `niveau_etude`, `filiere`, `cv`, `lettre_motivation`, `date_creation`, `ecole`) VALUES
(2, 'KARA', 'STEVE', 'karasteve@gmail.com', '$2y$10$YAF.n0k/2wn/VX4nG6jXm.E4sEsQtpiSmbUBCuxE2XMhWp8XMHj4K', 'II', 'Génie logiciel', 'uploads/cv_66f6b25324c9b_d.pdf', 'uploads/lettre_66f6b2533bf4d_compte_rendu_Diane.pdf', '2024-09-18 14:19:31', 'IUT'),
(3, 'KEBBO', 'DIANE', 'kebbodiane@gmail.com', '$2y$10$YfEjNW1o2zHQFgK95SIr7umDe1GTQklQrbTqGTrFIA4bScbeA84hu', 'II', 'Marketing', NULL, NULL, '2024-09-19 11:37:36', 'IUC'),
(4, 'KEBBO WABALE', 'DIANE LEILA', 'kebbodiane27@gmail.com', '$2y$10$TSsv/FZzZSviYTFkdVinX.KV06zpPj4PvlmeoWdRu8p6dWJ12Lipa', 'Master II', 'Marketing', NULL, NULL, '2024-09-20 16:47:08', 'IUG'),
(5, 'TCHADE', 'HANS', 'hanstchade458@gmail.cm', '$2y$10$PHfdZM4K/RSYhptzAXJWae6hoEmJrq5SnLIA75REj45EmPNGrVaUm', 'licence1', 'GEOGRAPHIE', NULL, NULL, '2024-09-22 03:52:18', 'IAI'),
(9, 'jean', 'jack', 'jack@gmail.com', '$2y$10$I.URXDxz6Em8YMqc1t0Vi.RzJvPEywMDC8F4A2w4YYxGonDO4JTue', 'II', 'Inforamtique', NULL, NULL, '2024-09-27 10:36:27', 'IAI'),
(10, 'jean', 'jack', 'jean@gmail.com', '$2y$10$gU55kliR52gkUX.bczRgZu3Awci1uLpMEU.cti8JOdEXSQBrWOoPC', 'II', 'GEOGRAPHIE', 'uploads/cv_66f68f80c022f_f.pdf', 'uploads/lettre_66f69254de7d7_premiere_de_couverture.pdf', '2024-09-27 10:44:48', 'IUT'),
(11, 'TCHEUNJIO', 'VANOLD', 'tcheunjiovanold@gmail.com', '$2y$10$ziRChcdbXpLs6.9cJW4VXuDcoHbcxCqs4Fqnh84UVLA0YX1pXwXly', 'II', 'Génie logiciel', 'uploads/cv_66fbd24f45532_clas.pdf', NULL, '2024-10-01 10:41:36', 'IAI');

-- --------------------------------------------------------

--
-- Structure de la table `offresstage`
--

CREATE TABLE `offresstage` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `date_publication` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `offresstage`
--

INSERT INTO `offresstage` (`id`, `titre`, `description`, `date_debut`, `date_fin`, `responsable_id`, `date_publication`) VALUES
(3, 'Stage en Développement Web', 'Ce stage implique la conception et le développement d\'applications web. Les stagiaires travailleront avec des technologies comme HTML, CSS, JavaScript et des frameworks comme React ou Angular pour créer des interfaces utilisateur interactives.', '2024-09-29', '2024-09-29', 2, '2024-10-05 22:00:00'),
(6, 'Stage en Marketing Digital', 'Les stagiaires participeront à des campagnes de marketing en ligne, y compris la gestion des réseaux sociaux, l\'optimisation des moteurs de recherche (SEO), et la création de contenu. Ils apprendront à analyser les données pour évaluer l\'efficacité des campagnes.', '2024-10-05', '2024-10-26', 2, '2024-09-19 15:53:09'),
(7, 'Stage en Gestion de Projet', ' Ce stage permet aux étudiants d\'assister à la planification, l\'exécution et le suivi de projets. Ils apprendront à utiliser des outils de gestion de projet comme Trello ou Asana, et à travailler en étroite collaboration avec les équipes pour respecter les délais.\n', '2024-10-05', '2024-10-06', 2, '2024-09-20 07:46:53'),
(8, 'Stage en Ressources Humaines', 'Les stagiaires aideront à la gestion du personnel, au recrutement et à l\'intégration de nouveaux employés. Ils participeront également à des projets liés à la formation et au développement des employés.', '2024-10-06', '2024-10-06', 2, '2024-09-20 07:49:15'),
(9, 'Stage en Analyse de Données', 'Ce stage impliquera la collecte, l\'analyse et l\'interprétation de données pour aider à la prise de décisions stratégiques. Les stagiaires utiliseront des outils comme Excel, R ou Python pour analyser des ensembles de données.', '2024-09-29', '2024-11-29', 2, '2024-09-20 18:18:27'),
(10, 'Stage en Design Graphique', 'Les stagiaires travailleront à la création de supports visuels pour des projets de communication. Ils utiliseront des logiciels comme Adobe Photoshop et Illustrator pour concevoir des affiches, des brochures et du contenu pour les réseaux sociaux.', '2024-09-25', '2024-10-06', 2, '2024-09-22 03:58:08'),
(11, 'Stage en Informatique de Gestion', 'Ce stage permettra aux étudiants de comprendre comment les systèmes informatiques sont utilisés pour gérer les opérations commerciales. Ils auront l\'occasion de participer à des projets d\'implémentation de logiciels de gestion.', '2024-10-02', '2024-09-29', 2, '2024-09-30 06:40:49'),
(13, 'Stage en Informatique de Gestion', 'Ce stage permettra aux étudiants de comprendre comment les systèmes informatiques sont utilisés pour gérer les opérations commerciales. Ils auront l\'occasion de participer à des projets d\'implémentation de logiciels de gestion.', '2024-11-01', '2024-11-15', 2, '2024-10-01 20:58:27');

-- --------------------------------------------------------

--
-- Structure de la table `responsablesstage`
--

CREATE TABLE `responsablesstage` (
  `responsable_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `responsablesstage`
--

INSERT INTO `responsablesstage` (`responsable_id`, `nom`, `prenom`, `email`, `mot_de_passe`, `departement`, `date_creation`) VALUES
(2, 'Yaya', 'Oumarou', 'yayaoumarou@gmail.com', '$2y$10$2PMkDxn6MmASFMFoIW8ewuW/3Oddz0RxVFhlsPJmofq5mo0cWQjri', NULL, '2024-09-19 14:22:04'),
(3, 'TCHADE', 'GABY', 'tchadegaby@gmail.com', '$2y$10$07IveYinayqQuDyJz53qEeQoviVgboA2Mafwn6v8a5Oib5Hure6iK', NULL, '2024-09-22 03:57:46'),
(4, 'kara', 'melo', 'melo@gmail.com', '$2y$10$9nrauSi68WquAvUWpCxoKuISzZGfaMBTddqBFDAEgB7UJAOo3QbtK', NULL, '2024-09-30 06:43:23');

-- --------------------------------------------------------

--
-- Structure de la table `sollicitationstuteur`
--

CREATE TABLE `sollicitationstuteur` (
  `id` int(11) NOT NULL,
  `tuteur_id` int(11) DEFAULT NULL,
  `etudiant_id` int(11) DEFAULT NULL,
  `date_solicitation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sollicitationstuteur`
--

INSERT INTO `sollicitationstuteur` (`id`, `tuteur_id`, `etudiant_id`, `date_solicitation`) VALUES
(1, 3, 3, '2024-09-24 18:09:57');

-- --------------------------------------------------------

--
-- Structure de la table `tuteurs`
--

CREATE TABLE `tuteurs` (
  `tuteur_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `entreprise` varchar(100) DEFAULT NULL,
  `poste` varchar(100) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tuteurs`
--

INSERT INTO `tuteurs` (`tuteur_id`, `nom`, `prenom`, `email`, `mot_de_passe`, `entreprise`, `poste`, `date_creation`) VALUES
(3, 'KEBBO', 'DIANE', 'kebbo@gmail.com', '$2y$10$J9.QuCQ41AEDOrqDwL3Tw.LGlzwTLNZi02zv8lJyYm6JDhK2n1O.W', 'SODECOTON', 'COMMERCIAL', '2024-09-20 09:48:54'),
(4, 'Karagama', 'Steve', 'steve@gmail.com', '$2y$10$ZEaTi3CFX7gh2nKbcnh56eUCuTwqBCl2mzLZd2xhXRxYASXajBFX6', 'SODECOTON', 'Chef bureau test et deploiement', '2024-09-30 06:42:48');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `offre_id` (`offre_id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`etudiant_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `offresstage`
--
ALTER TABLE `offresstage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Index pour la table `responsablesstage`
--
ALTER TABLE `responsablesstage`
  ADD PRIMARY KEY (`responsable_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `sollicitationstuteur`
--
ALTER TABLE `sollicitationstuteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tuteur_id` (`tuteur_id`),
  ADD KEY `etudiant_id` (`etudiant_id`);

--
-- Index pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  ADD PRIMARY KEY (`tuteur_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `candidatures`
--
ALTER TABLE `candidatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `etudiant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `offresstage`
--
ALTER TABLE `offresstage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `responsablesstage`
--
ALTER TABLE `responsablesstage`
  MODIFY `responsable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sollicitationstuteur`
--
ALTER TABLE `sollicitationstuteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  MODIFY `tuteur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`etudiant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidatures_ibfk_2` FOREIGN KEY (`offre_id`) REFERENCES `offresstage` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `offresstage`
--
ALTER TABLE `offresstage`
  ADD CONSTRAINT `offresstage_ibfk_1` FOREIGN KEY (`responsable_id`) REFERENCES `responsablesstage` (`responsable_id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `sollicitationstuteur`
--
ALTER TABLE `sollicitationstuteur`
  ADD CONSTRAINT `sollicitationstuteur_ibfk_1` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`tuteur_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sollicitationstuteur_ibfk_2` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`etudiant_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
