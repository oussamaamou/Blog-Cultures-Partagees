-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `ID` int NOT NULL,
  `ID_auteur` int NOT NULL,
  `ID_categorie` int NOT NULL,
  `Titre` varchar(30) NOT NULL,
  `Contenu` text NOT NULL,
  `Image` mediumblob,
  `Statut` enum('Accepté','Encours','Refusé') NOT NULL,
  `Date_publication` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID`, `ID_auteur`, `ID_categorie`, `Titre`, `Contenu`, `Image`, `Statut`, `Date_publication`) VALUES
(1, 12, 4, 'Et proident expedit', 'Quia aut repudiandae Et proident expedit Quia aut repudiandae Et proident expedit Quia aut repudiandae Et proident expedit Quia aut repudiandae Et proident expedit Quia aut repudiandae Et proident expedit Quia aut repudiandae', NULL, 'Accepté', '2025-01-03 00:00:00'),
(4, 12, 4, 'Non blanditiis repre', ' In et fugiat nisi eo Non blanditiis repre In et fugiat nisi eo Non blanditiis repreIn et fugiat nisi eo Non blanditiis repre In et fugiat nisi eo Non blanditiis repre In et fugiat nisi eo Non blanditiis repre', NULL, 'Accepté', '2025-01-03 00:00:00'),
(5, 12, 4, 'Ipsum dolores quas i', 'Ipsum dolores quas i Ipsum dolores quas i Ipsum dolores quas iIpsum dolores quas i Ipsum dolores quas i Ipsum dolores quas i Ipsum dolores quas i Ipsum dolores quas i Ipsum dolores quas i', NULL, 'Accepté', '2025-01-03 00:00:00'),
(7, 12, 5, 'Minim qui non minim ', 'Consectetur voluptas Minim qui non minim Consectetur voluptas Minim qui non minim Consectetur voluptas Minim qui non minim Consectetur voluptas Minim qui non minim Consectetur voluptas Minim qui non minim ', NULL, 'Accepté', '2025-01-04 00:00:00'),
(8, 12, 5, 'Sit quae qui dolorem', 'Sed magnam ut accusa Sit quae qui dolorem Sit quae qui dolorem Sed magnam ut accusa Sit quae qui dolorem Sit quae qui dolorem Sed magnam ut accusa Sit quae qui dolorem Sit quae qui dolorem Sed magnam ut accusa Sit quae qui dolorem Sit quae qui dolorem', NULL, 'Refusé', '2025-01-05 00:00:00'),
(11, 15, 4, 'Qui molestiae ut in ', 'Ipsum dolores quas i Sint aut a aut dolo Qui molestiae ut in Ipsum dolores quas i Sint aut a aut dolo Qui molestiae ut in Ipsum dolores quas i Sint aut a aut dolo Qui molestiae ut in Ipsum dolores quas i Sint aut a aut dolo Qui molestiae ut in ', NULL, 'Refusé', '2025-01-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `ID` int NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID`, `Nom`, `Description`) VALUES
(4, 'Histoire', 'Parler des sujets historiques qui vous intéressent.'),
(5, 'Sport', 'Parler de votre sport préféré, et supporter votre équipe préféré.');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int NOT NULL,
  `Nom` varchar(25) NOT NULL,
  `Prenom` varchar(25) NOT NULL,
  `Photo` mediumblob,
  `Role` enum('Lecteur','Auteur','Administrateur') NOT NULL,
  `Telephone` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `Nom`, `Prenom`, `Photo`, `Role`, `Telephone`, `Email`, `Mot_de_passe`) VALUES
(11, 'Walid', 'Khaled', NULL, 'Lecteur', '0679672715', 'walid@gmail.com', '$2y$10$yWeYpxdg3pWeK9abv9NrbegMH6M7j3OHHNSDu7h8Xne3LDIYDJdl2'),
(12, 'Houssain', 'Ahmed', 0x70726f66696c655f36373737633166626430663339342e31353234393933362e706e67, 'Auteur', '0654859615', 'houssain@gmail.com', '$2y$10$ptj.UwEHzimW7N/W5VRueO8gLfsmqeltdawYwpA/G5mPGhD.sFMbK'),
(13, 'Oussama', 'Rachad', 0x70726f66696c655f36373761633038633133616662302e34333130373237342e6a706567, 'Administrateur', '0679672715', 'oussama@gmail.com', '$2y$10$s1V2LOOmk0HvYeryJ5f66uciL.ILhQyeAMelSeDSMubocHyVihZQe'),
(14, 'Morad', 'Omar', 0x70726f66696c655f36373738343935326365303665322e33323539313533372e6a7067, 'Lecteur', '0702652515', 'omar@gmail.com', '$2y$10$d6WevXfhyuha9dPdOdDs5OE8/EJpZr1gtEAktDaPxudzY.SG42CdC'),
(15, 'Rayan', 'Kadir', NULL, 'Auteur', '0602742715', 'rayan@gmail.com', '$2y$10$UYDQryQ7K5vPa6sDaR29Eef4E49Ya0Y0HGUdSwtLKd2em9duxqVMC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_auteur` (`ID_auteur`),
  ADD KEY `ID_categorie` (`ID_categorie`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`ID_auteur`) REFERENCES `utilisateur` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`ID_categorie`) REFERENCES `categorie` (`ID`) ON DELETE CASCADE;
COMMIT;

