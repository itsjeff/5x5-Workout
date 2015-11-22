-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2015 at 10:44 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `5x5`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE IF NOT EXISTS `exercises` (
`exercise_id` bigint(20) NOT NULL,
  `exercise_name` varchar(200) NOT NULL,
  `exercise_description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`exercise_id`, `exercise_name`, `exercise_description`) VALUES
(1, 'Sqauts', ''),
(2, 'Benchpress', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed aliquam orci. Donec at nunc porttitor, semper sem sed, ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vulputate malesuada dignissim.</p>  				<p>Donec venenatis orci in turpis fringilla placerat. Mauris sit amet ligula laoreet, elementum magna in, sollicitudin libero. Vivamus ultrices, dui sollicitudin accumsan placerat, eros nibh fermentum est, vel pharetra metus quam vel nisi. Aenean a urna in lectus ornare gravida.</p>'),
(3, 'Bent Over Rows', ''),
(4, 'Deadlift', ''),
(5, 'Barbell Curls', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed aliquam orci. Donec at nunc porttitor, semper sem sed, ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vulputate malesuada dignissim.</p>  				<p>Donec venenatis orci in turpis fringilla placerat. Mauris sit amet ligula laoreet, elementum magna in, sollicitudin libero. Vivamus ultrices, dui sollicitudin accumsan placerat, eros nibh fermentum est, vel pharetra metus quam vel nisi. Aenean a urna in lectus ornare gravida.</p>'),
(6, 'Barbell Shrugs', '<p> Barbell shrugs ... Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed aliquam orci. Donec at nunc porttitor, semper sem sed, ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vulputate malesuada dignissim.</p>  				<p>Donec venenatis orci in turpis fringilla placerat. Mauris sit amet ligula laoreet, elementum magna in, sollicitudin libero. Vivamus ultrices, dui sollicitudin accumsan placerat, eros nibh fermentum est, vel pharetra metus quam vel nisi. Aenean a urna in lectus ornare gravida.</p>'),
(7, 'Cable Crunches', ''),
(8, 'Hyperextensions', ''),
(9, 'Triceps Extensions', ''),
(10, 'Over Head Press', ''),
(11, 'Close Grip Benchpress', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` bigint(20) NOT NULL,
  `fullName` varchar(250) CHARACTER SET utf16 NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_workout`
--

CREATE TABLE IF NOT EXISTS `user_workout` (
`user_workout_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `workout_plan_id` bigint(20) NOT NULL,
  `sets_reps` varchar(250) NOT NULL,
  `set_weight` decimal(4,2) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workout_plans`
--

CREATE TABLE IF NOT EXISTS `workout_plans` (
`plan_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `start_sets_reps` varchar(250) NOT NULL,
  `start_weight` float(4,2) NOT NULL DEFAULT '50.00',
  `category_id` varchar(250) NOT NULL,
  `order_no` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workout_plans`
--

INSERT INTO `workout_plans` (`plan_id`, `exercise_id`, `start_sets_reps`, `start_weight`, `category_id`, `order_no`) VALUES
(1, 1, '5, 5, 5, 5, 5', 50.00, '1', 1),
(2, 2, '5, 5, 5, 5, 5', 50.00, '1', 2),
(3, 3, '5, 5, 5, 5, 5', 50.00, '1', 3),
(4, 6, '8, 8, 8', 50.00, '1', 4),
(5, 9, '8, 8, 8', 50.00, '1', 5),
(6, 5, '8, 8, 8', 50.00, '1', 6),
(7, 8, '10, 10', 50.00, '1', 7),
(8, 7, '10, 10, 10', 50.00, '1', 8),
(9, 1, '5, 5, 5, 5, 5', 50.00, '2', 1),
(10, 10, '5, 5, 5, 5, 5', 50.00, '2', 2),
(11, 4, '5', 50.00, '2', 3),
(12, 3, '5, 5, 5, 5, 5', 50.00, '2', 4),
(13, 11, '8, 8, 8', 50.00, '2', 5),
(14, 5, '8, 8, 8', 50.00, '2', 6),
(15, 7, '10, 10, 10', 50.00, '2', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
 ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_workout`
--
ALTER TABLE `user_workout`
 ADD PRIMARY KEY (`user_workout_id`);

--
-- Indexes for table `workout_plans`
--
ALTER TABLE `workout_plans`
 ADD PRIMARY KEY (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
MODIFY `exercise_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_workout`
--
ALTER TABLE `user_workout`
MODIFY `user_workout_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workout_plans`
--
ALTER TABLE `workout_plans`
MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
