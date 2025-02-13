-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 fév. 2025 à 16:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `afpa_wazaa_immo`
--

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

CREATE TABLE `avoir` (
  `ann_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonces`
--

CREATE TABLE `waz_annonces` (
  `ann_id` int(11) NOT NULL,
  `ann_offre` char(1) NOT NULL,
  `ann_type` varchar(50) NOT NULL,
  `ann_piece` int(11) NOT NULL,
  `ann_ref` varchar(10) NOT NULL,
  `ann_titre` varchar(250) NOT NULL,
  `ann_description` varchar(500) NOT NULL,
  `ann_localisation` varchar(100) NOT NULL,
  `ann_surf_hab` int(11) NOT NULL,
  `ann_suf_total` int(11) NOT NULL,
  `ann_vue` int(11) NOT NULL,
  `ann_diag_energie` char(1) NOT NULL,
  `ann_prix_bien` int(11) NOT NULL,
  `ann_date_ajout` date NOT NULL,
  `ann_date_modif` date NOT NULL,
  `type_offre_id` int(11) NOT NULL,
  `type_bien_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `waz_annonces`
--
DELIMITER $$
CREATE TRIGGER `before_insert_waz_annonces` BEFORE INSERT ON `waz_annonces` FOR EACH ROW BEGIN
    DECLARE prefix CHAR(3) DEFAULT 'REF';
    DECLARE num INT;

    -- Compter le nombre d'annonces existantes
    SELECT COUNT(*) INTO num FROM waz_annonces;
    SET num = num + 1;

    -- Générer la référence de l'annonce
    SET NEW.ann_ref = CONCAT(prefix, LPAD(num, 7, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `waz_options`
--

CREATE TABLE `waz_options` (
  `option_id` int(11) NOT NULL,
  `option_libelle` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_options`
--

INSERT INTO `waz_options` (`option_id`, `option_libelle`) VALUES
(1, 'Jardin'),
(2, 'Garage'),
(3, 'Parking'),
(4, 'Piscine'),
(5, 'Combles aménageables'),
(6, 'Cuisine ouverte'),
(7, 'Sans travaux'),
(8, 'Avec travaux'),
(9, 'Cave'),
(10, 'Plain-pied'),
(11, 'Ascenseur'),
(12, 'Terrasse/balcon'),
(13, 'Cheminée');

-- --------------------------------------------------------

--
-- Structure de la table `waz_photos`
--

CREATE TABLE `waz_photos` (
  `photo_id` int(11) NOT NULL,
  `photo_type_bien` varchar(50) NOT NULL,
  `photo_description` varchar(250) NOT NULL,
  `ann_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_types_utilisateurs`
--

CREATE TABLE `waz_types_utilisateurs` (
  `type_utilisateur_id` int(11) NOT NULL,
  `type_utilisateur_libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_types_utilisateurs`
--

INSERT INTO `waz_types_utilisateurs` (`type_utilisateur_id`, `type_utilisateur_libelle`) VALUES
(1, 'Admin'),
(2, 'Commercial');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--

CREATE TABLE `waz_type_bien` (
  `type_bien_id` int(11) NOT NULL,
  `type_bien_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_bien`
--

INSERT INTO `waz_type_bien` (`type_bien_id`, `type_bien_libelle`) VALUES
(1, 'Maison'),
(2, 'Appartement'),
(3, 'Immeuble'),
(4, 'Commerce'),
(5, 'Garage'),
(6, 'Parking'),
(7, 'Terrain'),
(8, 'Lotissement');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--

CREATE TABLE `waz_type_offre` (
  `type_offre_id` int(11) NOT NULL,
  `type_offre_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_offre`
--

INSERT INTO `waz_type_offre` (`type_offre_id`, `type_offre_libelle`) VALUES
(1, 'Location'),
(2, 'Achat'),
(3, 'Viager');

-- --------------------------------------------------------

--
-- Structure de la table `waz_utilisateurs`
--

CREATE TABLE `waz_utilisateurs` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_pseudo` varchar(50) NOT NULL,
  `utilisateur_nom` varchar(50) NOT NULL,
  `utilisateur_prenom` varchar(50) NOT NULL,
  `utilisateur_email` varchar(50) NOT NULL,
  `utilisateur_mdp` varchar(255) NOT NULL,
  `type_utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_utilisateurs`
--

INSERT INTO `waz_utilisateurs` (`utilisateur_id`, `utilisateur_pseudo`, `utilisateur_nom`, `utilisateur_prenom`, `utilisateur_email`, `utilisateur_mdp`, `type_utilisateur_id`) VALUES
(1, 'Jordev', 'GALLO', 'Baidy', 'jordev@gmail.com', '$2y$10$hHiqn33c/x28l2Zz5M/zrORDW62JT6OWz1fPXukWSgkN8c.BK8UCW', 1),
(3, 'Molly_Mohana', 'AKABI NANGA', 'Molly Mohana', 'mollymohana@gmail.com', '$2y$10$NSASKdd8zgYUHvPoz6IRBOdd4swg1MRdvZ7hbInkvf08JTizPJRUi', 2),
(4, 'Phoenix149', 'CARRAUD', 'Anthony', 'phoenix149@gmail.com', '$2y$10$XPPxlu8yHU3ZEFxWmDeeU.IEDXXp0Wp0ssMO/WGLw4GC9AUkFvuFO', 2),
(5, 'Alize_Kessy', 'AKABI NANGA', 'Alizee Kessy', 'alizeekessy@gmail.com', '$2y$10$qLeuITxkdKWYiUJoLAGXfeHtS0L27rGK5Aj9Oyowxi70kBP/C3pyy', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD PRIMARY KEY (`ann_id`,`option_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Index pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD PRIMARY KEY (`ann_id`),
  ADD UNIQUE KEY `ann_vue` (`ann_vue`),
  ADD UNIQUE KEY `ann_vue_2` (`ann_vue`),
  ADD KEY `type_offre_id` (`type_offre_id`),
  ADD KEY `type_bien_id` (`type_bien_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `waz_options`
--
ALTER TABLE `waz_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Index pour la table `waz_photos`
--
ALTER TABLE `waz_photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `ann_id` (`ann_id`);

--
-- Index pour la table `waz_types_utilisateurs`
--
ALTER TABLE `waz_types_utilisateurs`
  ADD PRIMARY KEY (`type_utilisateur_id`);

--
-- Index pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD PRIMARY KEY (`type_bien_id`);

--
-- Index pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  ADD PRIMARY KEY (`type_offre_id`);

--
-- Index pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD KEY `type_utilisateur_id` (`type_utilisateur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  MODIFY `ann_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `waz_photos`
--
ALTER TABLE `waz_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  MODIFY `type_bien_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD CONSTRAINT `avoir_ibfk_1` FOREIGN KEY (`ann_id`) REFERENCES `waz_annonces` (`ann_id`),
  ADD CONSTRAINT `avoir_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `waz_options` (`option_id`);

--
-- Contraintes pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD CONSTRAINT `waz_annonces_ibfk_1` FOREIGN KEY (`type_offre_id`) REFERENCES `waz_type_offre` (`type_offre_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_2` FOREIGN KEY (`type_bien_id`) REFERENCES `waz_type_bien` (`type_bien_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_3` FOREIGN KEY (`utilisateur_id`) REFERENCES `waz_utilisateurs` (`utilisateur_id`);

--
-- Contraintes pour la table `waz_photos`
--
ALTER TABLE `waz_photos`
  ADD CONSTRAINT `waz_photos_ibfk_1` FOREIGN KEY (`ann_id`) REFERENCES `waz_annonces` (`ann_id`);

--
-- Contraintes pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  ADD CONSTRAINT `waz_utilisateurs_ibfk_1` FOREIGN KEY (`type_utilisateur_id`) REFERENCES `waz_types_utilisateurs` (`type_utilisateur_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
