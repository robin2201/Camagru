-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 11 Décembre 2016 à 14:45
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camagru`
--
CREATE DATABASE IF NOT EXISTS `camagru` ;
-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL,
  `pict_name` varchar(255) DEFAULT NULL,
  `comment_user` varchar(255) DEFAULT NULL,
  `comment` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comment`
--


-- --------------------------------------------------------

--
-- Structure de la table `likePic`
--

CREATE TABLE IF NOT EXISTS `likePic` (
  `like_id` INT(11) NOT NULL,
  `pict_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `likePic`
--

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `picture_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `picture_path` longtext NOT NULL,
  `picture_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pictures`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_token`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`) VALUES
(2, 'lol', 'rberthie@student.42.fr', '$2y$10$kqo0TwUx3vCHP1e4mqGAA.oOodHJlmWqRhnUuIDYZWsOHAlwrgoa.', 'cQiAc8avpiyWL1UaAqxKv017ZXVz38qLRobG9O1aTaaudGbWx5XrQnUllBleFfB2MBiPxwfq4aCklu4vOinPveJ1OzS5RtOGuQud01kos3WdYgINHoY20giZuA9M6GLvnd4VrEeFOT9q8D0nWbCotzCiaisJhgR6x0rdkLz1NVaPpmvxQ9t6ki4T3nzT4NvFPJqfs1jtvyQaezpXbu6ooxgqVLyqkCuZKVpLxOotKCRPYFPry39QycNqZM', NULL, '2016-11-22 11:08:38', NULL, NULL),
(3, 'rberthie', 'robin.berthier.rb@gmail.com', '$2y$10$TCOmR9s2G3pzTlC/.OEQ2.Es.9qWcNvGbrL7YHJZKMehF4vqj/Awq', 'fjimEGSU6PrZeRvrRsZLtBKqphbYFzNcW13hSt38O6UvxkFRuDPinWDySxIqqbosfqbQlQZ8KSzTdVmBndNSPkooihQZO1knMv6uGz6D2yWJkDHmw7OUd4WhTGuTCeWTaYdIBFbOWyakrEvBZ6Zzmed5o828ZcyYtZdJ7YHRMUcBq9fzZ9Zfcg9JLypiQieIPmMds7VXOdZ1bAtHf5J0KIbcCb6IVnteyZtmTBZIu4LcqOBf5kyTvCI3V8', NULL, '2016-11-28 15:55:47', NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`picture_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `LikePic`
--
ALTER TABLE `LikePic`
  ADD PRIMARY KEY (`like_id`);
--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT pour la table `LikePip`
--
ALTER TABLE `LikePic`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
