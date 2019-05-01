-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: nr84dudlpkazpylz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306
-- Generation Time: Mar 13, 2019 at 04:10 AM
-- Server version: 5.7.24
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--
CREATE DATABASE IF NOT EXISTS `wktjmhfmeq80m9nj` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wktjmhfmeq80m9nj`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `photo_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `username`, `photo_id`, `comment`) VALUES
(2, 74, 'sarune', 26, 'i like sea!'),
(3, 79, 'sarune', 25, 'you so cute!');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `photo` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL,
  `com` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`photo_id`, `user_id`, `username`, `photo`, `date`, `likes`, `com`) VALUES
(16, 77, 'animals', 'uploads/77/1550235044.png', '2019-02-15 13:50:44', 0, 0),
(17, 76, 'places', 'uploads/76/1550235806.png', '2019-02-15 14:03:26', 0, 0),
(18, 76, 'places', 'uploads/76/1550235914.png', '2019-02-15 14:05:14', 0, 0),
(19, 77, 'animals', 'uploads/77/1550235952.png', '2019-02-15 14:05:52', 0, 0),
(20, 77, 'animals', 'uploads/77/1550235969.png', '2019-02-15 14:06:09', 0, 0),
(21, 75, 'people', 'uploads/75/1550236073.png', '2019-02-15 14:07:53', 1, 0),
(22, 75, 'people', 'uploads/75/1550236098.png', '2019-02-15 14:08:18', 1, 0),
(23, 76, 'places', 'uploads/76/1550236168.png', '2019-02-15 14:09:28', 3, 0),
(24, 76, 'places', 'uploads/76/1550236184.png', '2019-02-15 14:09:44', 4, 0),
(25, 77, 'animals', 'uploads/77/1550236448.png', '2019-02-15 14:14:08', 4, 1),
(26, 77, 'animals', 'uploads/77/1550236463.png', '2019-02-15 14:14:23', 5, 1),
(29, 75, 'people', 'uploads/75/1550237064.png', '2019-02-15 14:24:24', 5, 0),
(30, 75, 'people', 'uploads/75/1550237077.png', '2019-02-15 14:24:37', 5, 0),
(31, 75, 'people', 'uploads/75/1550237879.png', '2019-02-15 14:37:59', 5, 0),
(39, 77, 'animals', 'uploads/77/1552473535.png', '2019-03-13 11:38:55', 3, 0),
(40, 77, 'animals', 'uploads/77/1552473550.png', '2019-03-13 11:39:10', 3, 0),
(41, 75, 'people', 'uploads/75/1552473610.png', '2019-03-13 11:40:10', 2, 0),
(42, 75, 'people', 'uploads/75/1552473629.png', '2019-03-13 11:40:29', 2, 0),
(43, 76, 'places', 'uploads/76/1552473681.png', '2019-03-13 11:41:21', 1, 0),
(44, 76, 'places', 'uploads/76/1552473693.png', '2019-03-13 11:41:33', 1, 0),
(45, 77, 'animals', 'uploads/77/1552473766.png', '2019-03-13 11:42:46', 1, 0),
(46, 76, 'places', 'uploads/76/1552473802.png', '2019-03-13 11:43:22', 1, 0),
(47, 76, 'places', 'uploads/76/1552473879.png', '2019-03-13 11:44:39', 1, 0),
(48, 75, 'people', 'uploads/75/1552473915.png', '2019-03-13 11:45:15', 1, 0),
(49, 75, 'people', 'uploads/75/1552473933.png', '2019-03-13 11:45:33', 1, 0),
(50, 77, 'animals', 'uploads/77/1552473983.png', '2019-03-13 11:46:23', 1, 0),
(51, 75, 'people', 'uploads/75/1552474015.png', '2019-03-13 11:46:55', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `photo_id`) VALUES
(1, 74, 29),
(2, 74, 30),
(3, 74, 26),
(4, 74, 25),
(5, 74, 24),
(6, 81, 31),
(7, 81, 26),
(8, 81, 23),
(9, 81, 24),
(10, 79, 31),
(11, 79, 30),
(12, 79, 25),
(13, 79, 26),
(15, 79, 24),
(16, 79, 23),
(17, 79, 22),
(18, 79, 29),
(19, 79, 21),
(20, 77, 39),
(21, 77, 40),
(22, 77, 31),
(23, 77, 29),
(25, 77, 25),
(26, 77, 24),
(27, 77, 26),
(28, 77, 23),
(29, 75, 42),
(30, 75, 41),
(31, 75, 40),
(32, 75, 39),
(33, 75, 31),
(34, 75, 30),
(35, 75, 29),
(36, 75, 26),
(37, 75, 25),
(38, 76, 44),
(39, 76, 43),
(40, 76, 42),
(41, 76, 41),
(42, 76, 40),
(43, 76, 39),
(44, 76, 31),
(45, 76, 30),
(46, 76, 29),
(47, 77, 30),
(48, 75, 48),
(49, 75, 49),
(50, 75, 46),
(51, 75, 45),
(52, 75, 47),
(53, 75, 51),
(54, 75, 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `token` text NOT NULL,
  `activation_code` varchar(250) NOT NULL,
  `status` enum('not verified','verified') NOT NULL,
  `notification` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `token`, `activation_code`, `status`, `notification`) VALUES
(75, 'people@student.42.fr', 'people', '$2y$10$BZRxcB5FeY2Yi13Jv4S3reQG2zh/qMLK8w.vii5Oxlu4765QknSCe', '3b5dca501ee1e6d8cd7b905f4e1bf723', 'c06d06da9666a219db15cf575aff2824', 'verified', 'yes'),
(76, 'places@student.42.fr', 'places', '$2y$10$bu9fgYZ7NBa78tV3PBE8y.elitDpR2DIURB7jToTOU1JV91.JMhjO', '1c9ac0159c94d8d0cbedc973445af2da', '9b8619251a19057cff70779273e95aa6', 'verified', 'yes'),
(77, 'animals@student.42.fr', 'animals', '$2y$10$KrIW8GISBFW41COh2TIWDO1kzd7y6IxktNdwTxIwA7e97QwhhzO6e', '3dc4876f3f08201c7c76cb71fa1da439', '352407221afb776e3143e8a1a0577885', 'verified', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
