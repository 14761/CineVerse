-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 23, 2026 at 10:41 AM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MovieReviewDB`
--
CREATE DATABASE IF NOT EXISTS `MovieReviewDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `MovieReviewDB`;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

DROP TABLE IF EXISTS `favourites`;
CREATE TABLE IF NOT EXISTS `favourites` (
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`movie_id`),
  KEY `movie_id` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`user_id`, `movie_id`) VALUES
(11, 83533),
(8, 687163),
(11, 687163),
(9, 875828),
(8, 1054867),
(8, 1159559),
(8, 1265609),
(9, 1265609),
(8, 1368166),
(11, 1368166);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `overview` text,
  `poster_path` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `overview`, `poster_path`, `release_date`) VALUES
(83533, 'Avatar: Fire and Ash', 'In the wake of the devastating war against the RDA and the loss of their eldest son, Jake Sully and Neytiri face a new threat on Pandora: the Ash People, a violent and power-hungry Na\'vi tribe led by the ruthless Varang. Jake\'s family must fight for their survival and the future of Pandora in a conflict that pushes them to their emotional and physical limits.', '/bRBeSHfGHwkEpImlhxPmOcUsaeg.jpg', '2025-12-17'),
(687163, 'Project Hail Mary', 'Science teacher Ryland Grace wakes up on a spaceship light years from home with no recollection of who he is or how he got there. As his memory returns, he begins to uncover his mission: solve the riddle of the mysterious substance causing the sun to die out. He must call on his scientific knowledge and unorthodox ideas to save everything on Earth from extinction… but an unexpected friendship means he may not have to do it alone.', '/yihdXomYb5kTeSivtFndMy5iDmf.jpg', '2026-03-15'),
(875828, 'Peaky Blinders: The Immortal Man', 'After his estranged son gets embroiled in a Nazi plot, self-exiled gangster Tommy Shelby must return to Birmingham to save his family — and his nation.', '/gRMalasZEzsZi4w2VFuYusfSfqf.jpg', '2026-03-05'),
(1054867, 'One Battle After Another', 'Washed-up revolutionary Bob exists in a state of stoned paranoia, surviving off-grid with his spirited, self-reliant daughter, Willa. When his evil nemesis resurfaces after 16 years and she goes missing, the former radical scrambles to find her, father and daughter both battling the consequences of his past.', '/lbBWwxBht4JFP5PsuJ5onpMqugW.jpg', '2025-09-23'),
(1159559, 'Scream 7', 'When a new Ghostface killer emerges in the quiet town where Sidney Prescott has built a new life, her darkest fears are realized as her daughter becomes the next target. Determined to protect her family, Sidney must face the horrors of her past to put an end to the bloodshed once and for all.', '/jjyuk0edLiW8vOSnlfwWCCLpbh5.jpg', '2026-02-25'),
(1265609, 'War Machine', 'On one last grueling mission during Army Ranger training, a combat engineer must lead his unit in a fight against a giant otherworldly killing machine.', '/tlPgDzwIE7VYYIIAGCTUOnN4wI1.jpg', '2026-02-12'),
(1368166, 'The Housemaid', 'Trying to escape her past, Millie Calloway accepts a job as a live-in housemaid for the wealthy Nina and Andrew Winchester. But what begins as a dream job quickly unravels into something far more dangerous—a sexy, seductive game of secrets, scandal, and power.', '/cWsBscZzwu5brg9YjNkGewRUvJX.jpg', '2025-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`user_id`,`movie_id`),
  KEY `movie_id` (`movie_id`)
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`user_id`, `movie_id`, `rating`, `comment`) VALUES
(8, 687163, 9.0, 'The film is basically what you\'d expect, but it\'s so incisive and cleverly conceived that it keeps surprising you.'),
(8, 1159559, 7.0, 'test'),
(11, 83533, 9.0, 'Just love it. It worth every moment'),
(11, 1368166, 7.0, 'It surprises you every moment, the characters are incredibly well played');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(8, 'Phelippe Duarte', 'pheambrosio@gmail.com', '$2y$10$xc.iO4KYdhJre3YYT00STuDFu8CP.08UWgf4MsrXNfmUgKukBIhZG', '2026-03-20 00:10:12'),
(9, 'Manu', 'manu@example.com', '$2y$10$Uc0Qt46UbHXiUQiHlgSkuuXTZlb84vbwSmesB9NJ9ZFchgONXeQO6', '2026-03-23 01:28:02'),
(10, 'John Seed', 'john@example.com', '$2y$10$KWhkhH2XS5geYXqCJakQ/OM/mKuBIOa9yxB.W2MaON/xuCEHCw3D.', '2026-03-23 04:50:13'),
(11, 'Mary', 'mary@email.com', '$2y$10$kX3yWZQDw1pNwGd6bwPp9u4b1Qi0wmi6VA/h8PEwHH63JRUdIOiW.', '2026-03-23 04:51:29');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
