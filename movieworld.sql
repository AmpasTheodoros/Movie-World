-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2021 at 12:33 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieworld`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(25) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `topic_id`, `title`, `image`, `body`, `published`, `created_at`) VALUES
(35, 12, 1, 'Arrival', '1627638847_1627580867_1627570181_arrival.jpg', '&lt;p&gt;sdsaddsds&lt;/p&gt;&lt;p&gt;dsadsadsad&lt;/p&gt;&lt;p&gt;dsdsadasdsa&lt;/p&gt;&lt;p&gt;sdsadsadsadsad&lt;/p&gt;&lt;p&gt;sadsadsadsa&lt;/p&gt;&lt;p&gt;sdasdsadsada&lt;/p&gt;&lt;p&gt;sadsadsadsad&lt;/p&gt;&lt;p&gt;sdsadasdsadsa&lt;/p&gt;&lt;p&gt;dsadsadsadsad&lt;/p&gt;&lt;p&gt;sadsadsadsad&lt;/p&gt;&lt;p&gt;sadsadasdasdasd&lt;/p&gt;', 1, '2021-07-30 05:22:48'),
(36, 12, 2, 'prestige', '1627635940_prestige.jpg', '&lt;p&gt;prestige&lt;/p&gt;', 1, '2021-07-30 05:24:42'),
(37, 12, 2, 'Insanity', '1627635963_insanity.jpg', '&lt;p&gt;Insanity&lt;/p&gt;', 1, '2021-07-30 05:25:59'),
(38, 13, 1, 'Kati', '1627640346_nysm.jpg', '&lt;p&gt;kati allo&lt;/p&gt;', 1, '2021-07-30 13:19:06'),
(39, 13, 1, 'sddasd', '1627640371_1627576698_1627570181_arrival.jpg', '&lt;p&gt;sdsadasd&lt;/p&gt;', 1, '2021-07-30 13:19:31'),
(40, 13, 1, 'Arrival2', '1627640541_1627570151_arrival.jpg', '&lt;p&gt;DImitris&lt;/p&gt;', 1, '2021-07-30 13:22:21'),
(41, 13, 1, 'Sort Test', '1627768079_nysm.jpg', '&lt;p&gt;sdsadsadsadas&lt;/p&gt;', 1, '2021-08-01 00:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `rating_info`
--

CREATE TABLE `rating_info` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating_action` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating_info`
--

INSERT INTO `rating_info` (`post_id`, `user_id`, `rating_action`) VALUES
(35, 12, 'like'),
(36, 12, 'like'),
(37, 13, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `description`) VALUES
(1, 'sadasd', '<p>sadasd</p>'),
(2, 'Onoma ', '<p>sdsad</p>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `email`, `password`, `created_at`) VALUES
(1, 0, 'Ampas', 'theodoros@mail.com', 'testpass', '2021-07-27 01:27:58'),
(9, 0, '', '', '$2y$10$0iUiZlIFco7KALSmDdTPyepQvjjyqBV0bsoHLqnmclADPh44yOY0.', '2021-07-28 03:02:14'),
(11, 0, 'Theodoros', 'Theodoros@theodoros.com', '$2y$10$ayNvknXFHyVU.h43oEVjleo2Uw4CSaRJsqakZ35ozSEYlcu85xIhK', '2021-07-28 13:03:31'),
(12, 1, 'AmpasTheodoros', 'ampastheodwros@gmail.com', '$2y$10$JJObHmkOe/8EmJDx7FTsBumrHm4h.G4ouGPA6RUIQk9i1Mgo5LGC6', '2021-07-29 14:45:52'),
(13, 0, 'ds', 'ds@ds.com', '$2y$10$c.lsMIjP6nuGS0LBFkepoO2kgkUTKOVDaHi9AY1Q4LycJ6ZQ8XRn.', '2021-07-29 16:08:04'),
(15, 1, 'User', 'User@user.com', '$2y$10$CN9RExiN3ZfT1ubK7bJ8uuI4UB2r9sOygOntDR56mBLWVuW/xcqNS', '2021-07-29 20:49:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD UNIQUE KEY `rpost_id` (`post_id`,`user_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
