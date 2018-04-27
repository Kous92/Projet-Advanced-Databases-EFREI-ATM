-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 11 avr. 2018 à 09:07
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  efrei_bank
--
CREATE DATABASE IF NOT EXISTS efrei_bank DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE efrei_bank;

-- --------------------------------------------------------

--
-- Structure de la table CarteBancaire
--

CREATE TABLE CarteBancaire (
  cardID int(11) UNSIGNED NOT NULL,
  clientID_fk int(11) UNSIGNED NOT NULL,
  codeSecret varchar(255) NOT NULL,
  typeCarte varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table CarteBancaire
--

INSERT INTO CarteBancaire (cardID, clientID_fk, codeSecret, typeCarte) VALUES
(1, 1, '914420a9b210195dea7e8a1fdc5234fb1f413c04dba3b5eaabed9df6adb47f51', 'MasterCard'),
(2, 2, '1ab561c91e15d9ef75f15da2d53bba16162fb6999c5469b6609f02883dacd727', 'MasterCard'),
(3, 3, 'addd02a4c2a1aa6c5817b989c8040e106fd8f63809322cd1738d24e1f79e55bc', 'MasterCard'),
(4, 4, '6d1f43ea9ede98de665322245aa9836775e25e6fd741a9b6f22f4c1128cf4fad', 'Visa');

-- --------------------------------------------------------

--
-- Structure de la table Clients
--

CREATE TABLE Clients (
  clientID int(11) UNSIGNED NOT NULL,
  nomClient varchar(100) NOT NULL,
  prenomClient varchar(100) NOT NULL,
  dateNaissance date NOT NULL,
  numeroTelephone varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table Clients
--

INSERT INTO Clients (clientID, nomClient, prenomClient, dateNaissance, numeroTelephone) VALUES
(1, 'BEN MAMAR', 'Koussaïla', '1996-02-28', '0601020304'),
(2, 'ABDULHALIM', 'Ahmed', '1992-03-28', '0602030405'),
(3, 'EL KARRAT', 'Ibrahim', '1996-02-22', '0603040506'),
(4, 'SUHAS', 'Alexandre', '1994-11-23', '0604050607');

-- --------------------------------------------------------

--
-- Structure de la table CompteCourant
--

CREATE TABLE CompteCourant (
  compteID int(11) UNSIGNED NOT NULL,
  clientID int(11) NOT NULL,
  solde float(12,2) NOT NULL,
  dateCreation date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table CompteCourant
--

INSERT INTO CompteCourant (compteID, clientID, solde, dateCreation) VALUES
(1, 1, 2854.75, '2018-04-11'),
(2, 2, 7431.58, '2018-04-11'),
(3, 3, 2236.22, '2018-04-11'),
(4, 4, 14797.19, '2018-04-11');

-- --------------------------------------------------------

--
-- Structure de la table Operations
--

CREATE TABLE Operations (
  operationID int(11) UNSIGNED NOT NULL,
  compteID int(11) UNSIGNED NOT NULL,
  montant float(12,2) NOT NULL,
  typeOperation varchar(30) NOT NULL,
  dateOperation date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table Operations
--

INSERT INTO Operations (operationID, compteID, montant, typeOperation, dateOperation) VALUES
(1, 1, 250.00, 'Dépôt espèces', '2018-11-04'),
(2, 1, 19.99, 'CB', '2018-11-04'),
(3, 1, 60.00, 'Retrait', '2018-11-04'),
(4, 1, 350.00, 'Crédit virement', '2018-11-04'),
(5, 2, 1290.00, 'Paiement chèque', '2018-11-04'),
(6, 2, 34.99, 'CB', '2018-11-04'),
(7, 2, 80.00, 'Retrait', '2018-11-04'),
(8, 2, 120.00, 'Paiement virement', '2018-11-04'),
(9, 3, 3000.00, 'Encaissement chèque', '2018-11-04'),
(10, 3, 340.00, 'Paiement chèque', '2018-11-04'),
(11, 3, 499.99, 'CB', '2018-11-04'),
(12, 3, 200.00, 'Retrait', '2018-11-04'),
(13, 4, 1500.00, 'Encaissement chèque', '2018-11-04'),
(14, 4, 3750.00, 'Crédit virement', '2018-11-04'),
(15, 4, 1799.99, 'CB', '2018-11-04'),
(16, 4, 500.00, 'Retrait', '2018-11-04'),
(17, 1, 10.00, 'Retrait', '2018-04-25'),
(18, 1, 100.00, 'Retrait', '2018-04-25'),
(19, 1, 20.00, 'Retrait', '2018-04-25'),
(20, 1, 50.00, 'Retrait', '2018-04-25'),
(21, 1, 10.00, 'Retrait', '2018-04-25'),
(22, 1, 100.00, 'Retrait', '2018-04-25'),
(23, 1, 20.00, 'Retrait', '2018-04-25'),
(24, 3, 50.00, 'Retrait', '2018-04-25'),
(25, 4, 100.00, 'Retrait', '2018-04-25'),
(26, 1, 20.00, 'Retrait', '2018-04-26'),
(27, 1, 10.00, 'Retrait', '2018-04-26'),
(28, 4, 30.00, 'Retrait', '2018-04-26'),
(29, 4, 60.00, 'Retrait', '2018-04-26'),
(30, 4, 750.00, 'Retrait', '2018-04-26'),
(31, 1, 1200.00, 'Dépôt espèces', '2018-04-26'),
(32, 1, 1200.00, 'Dépôt espèces', '2018-04-26'),
(33, 2, 400.00, 'Dépôt espèces', '2018-04-27'),
(34, 2, 10.00, 'Retrait', '2018-04-27'),
(35, 2, 50.00, 'Retrait', '2018-04-27'),
(36, 2, 700.00, 'Retrait', '2018-04-27'),
(37, 2, 2400.00, 'Dépôt espèces', '2018-04-27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table CarteBancaire
--
ALTER TABLE CarteBancaire
  ADD PRIMARY KEY (cardID),
  ADD KEY clientID (clientID_fk);

--
-- Index pour la table Clients
--
ALTER TABLE Clients
  ADD PRIMARY KEY (clientID),
  ADD KEY clientID (clientID);

--
-- Index pour la table CompteCourant
--
ALTER TABLE CompteCourant
  ADD PRIMARY KEY (compteID),
  ADD KEY clientID (clientID);

--
-- Index pour la table Operations
--
ALTER TABLE Operations
  ADD PRIMARY KEY (operationID),
  ADD KEY compteID (compteID);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table CarteBancaire
--
ALTER TABLE CarteBancaire
  MODIFY cardID int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table Clients
--
ALTER TABLE Clients
  MODIFY clientID int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table CompteCourant
--
ALTER TABLE CompteCourant
  MODIFY compteID int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table Operations
--
ALTER TABLE Operations
  MODIFY operationID int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table CarteBancaire
--
ALTER TABLE CarteBancaire
  ADD CONSTRAINT cartebancaire_ibfk_1 FOREIGN KEY (clientID_fk) REFERENCES Clients (clientID);

--
-- Contraintes pour la table CompteCourant
--
ALTER TABLE CompteCourant
  ADD CONSTRAINT comptecourant_ibfk_1 FOREIGN KEY (compteID) REFERENCES Clients (clientID);

--
-- Contraintes pour la table Operations
--
ALTER TABLE Operations
  ADD CONSTRAINT operations_ibfk_1 FOREIGN KEY (compteID) REFERENCES Clients (clientID);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
