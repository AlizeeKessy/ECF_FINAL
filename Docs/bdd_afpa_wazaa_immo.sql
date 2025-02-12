-- drop database if exists afpa_wazaa_immo ;--
-- create database afpa_wazaa_immo charset utf8mb4;--

use afpa_wazaa_immo;


-- Structure de la table `waz_types_utilisateurs`
CREATE TABLE waz_types_utilisateurs(
   type_utilisateur_id INT,
   type_utilisateur_libelle VARCHAR(20) NOT NULL,
   PRIMARY KEY(type_utilisateur_id)
);

-- Déchargement des données de la table `waz_types_utilisateurs`
INSERT INTO `waz_types_utilisateurs` (`type_utilisateur_id`, `type_utilisateur_libelle`) VALUES
(1, 'Admin');
COMMIT;

-- Structure de la table `waz_options`
CREATE TABLE waz_options(
   option_id INT,
   option_libelle VARCHAR(250) NOT NULL,
   PRIMARY KEY(option_id)
);


-- Structure de la table `waz_type_offre`
CREATE TABLE waz_type_offre(
   type_offre_id INT,
   type_offre_libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(type_offre_id)
);

-- Déchargement des données de la table `waz_type_offre`
INSERT INTO `waz_type_offre` (`type_offre_id`, `type_offre_libelle`) VALUES
(1, 'Location'),
(2, 'Achat'),
(3, 'Viager');
COMMIT;



-- Structure de la table `waz_utilisateurs`
CREATE TABLE waz_utilisateurs(
   utilisateur_id INT,
   utilisateur_pseudo VARCHAR(50) NOT NULL,
   utilisateur_email VARCHAR(50) NOT NULL,
   utilisateur_mdp VARCHAR(255) NOT NULL,
   type_utilisateur_id INT NOT NULL,
   PRIMARY KEY(utilisateur_id),
   FOREIGN KEY(type_utilisateur_id) REFERENCES waz_types_utilisateurs(type_utilisateur_id)
);



-- Structure de la table `waz_type_bien`
CREATE TABLE waz_type_bien(
   type_bien_id INT,
   type_bien_libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(type_bien_id)
);




-- Structure de la table `waz_annonces`
CREATE TABLE waz_annonces(
   ann_id INT,
   ann_offre CHAR(1) NOT NULL,
   ann_type VARCHAR(50) NOT NULL,
   ann_piece INT NOT NULL,
   ann_ref VARCHAR(10) NOT NULL,
   ann_titre VARCHAR(250) NOT NULL,
   ann_description VARCHAR(500) NOT NULL,
   ann_surf_hab INT NOT NULL,
   ann_suf_total INT NOT NULL,
   ann_vue INT NOT NULL,
   ann_diag_energie CHAR(1) NOT NULL,
   ann_prix_bien INT (11) NOT NULL,
   ann_date_ajout DATE NOT NULL,
   ann_date_modif DATE NOT NULL,
   type_offre_id INT NOT NULL,
   type_bien_id INT NOT NULL,
   utilisateur_id INT NOT NULL,
   PRIMARY KEY(ann_id),
   UNIQUE(ann_vue),
   FOREIGN KEY(type_offre_id) REFERENCES waz_type_offre(type_offre_id),
   FOREIGN KEY(type_bien_id) REFERENCES waz_type_bien(type_bien_id),
   FOREIGN KEY(utilisateur_id) REFERENCES waz_utilisateurs(utilisateur_id)
);


-- Structure de la table `waz_photos`
CREATE TABLE waz_photos(
   photo_id INT,
   photo_type_bien VARCHAR(50) NOT NULL,
   photo_description VARCHAR(250) NOT NULL,
   ann_id INT NOT NULL,
   PRIMARY KEY(photo_id),
   FOREIGN KEY(ann_id) REFERENCES waz_annonces(ann_id)
);


-- Structure de la table `avoir`
CREATE TABLE avoir(
   ann_id INT,
   option_id INT,
   PRIMARY KEY(ann_id, option_id),
   FOREIGN KEY(ann_id) REFERENCES waz_annonces(ann_id),
   FOREIGN KEY(option_id) REFERENCES waz_options(option_id)
);
