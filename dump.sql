-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2015 at 10:40 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

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
  `exercise_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `exercise_name` varchar(200) NOT NULL,
  `exercise_description` text NOT NULL,
  PRIMARY KEY (`exercise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
(11, 'Close Grip Benchpress', ''),
(12, 'Pull-ups', ''),
(13, 'Chin-ups', ''),
(14, 'Dips', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(250) CHARACTER SET utf16 NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `email`, `password`, `created_at`) VALUES
(1, 'Jeff', 'mesh_f@hotmail.com', '$2y$10$6/5LHmEKvHVHSegC7dbBKe1CvFG4ZWjMA5AQn/4z2UUcfEvhYSy1i', '2015-11-26 06:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE IF NOT EXISTS `users_profile` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `display_pic` varchar(250) NOT NULL,
  `selected_workout_id` bigint(10) NOT NULL DEFAULT '1',
  `user_id` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `display_pic`, `selected_workout_id`, `user_id`) VALUES
(1, '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_workout`
--

CREATE TABLE IF NOT EXISTS `user_workout` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(10) NOT NULL,
  `workout_cycle_id` bigint(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_workout_excercises`
--

CREATE TABLE IF NOT EXISTS `user_workout_excercises` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sets_reps` varchar(250) NOT NULL,
  `set_weight` decimal(4,2) NOT NULL,
  `user_workout_id` bigint(20) NOT NULL,
  `workout_plan_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE IF NOT EXISTS `workout` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `workout`
--

INSERT INTO `workout` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '5x5', '', '2015-12-13 04:25:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `workout_cycles`
--

CREATE TABLE IF NOT EXISTS `workout_cycles` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `workout_id` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `workout_cycles`
--

INSERT INTO `workout_cycles` (`id`, `name`, `description`, `workout_id`) VALUES
(1, 'Workout A', '', 1),
(2, 'Workout B', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `workout_plans`
--

CREATE TABLE IF NOT EXISTS `workout_plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `exercise_id` int(11) NOT NULL,
  `start_sets_reps` varchar(250) NOT NULL,
  `start_weight` float(4,2) NOT NULL DEFAULT '50.00',
  `workout_cycle_id` bigint(10) NOT NULL,
  `order_no` int(11) NOT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `workout_plans`
--

INSERT INTO `workout_plans` (`plan_id`, `exercise_id`, `start_sets_reps`, `start_weight`, `workout_cycle_id`, `order_no`) VALUES
(1, 1, '5, 5, 5, 5, 5', 50.00, 1, 1),
(2, 2, '5, 5, 5, 5, 5', 50.00, 1, 2),
(3, 3, '5, 5, 5, 5, 5', 50.00, 1, 3),
(4, 6, '8, 8, 8', 50.00, 1, 4),
(5, 9, '8, 8, 8', 50.00, 1, 5),
(6, 5, '8, 8, 8', 50.00, 1, 6),
(7, 8, '10, 10', 50.00, 1, 7),
(8, 7, '10, 10, 10', 50.00, 1, 8),
(9, 1, '5, 5, 5, 5, 5', 50.00, 2, 1),
(10, 10, '5, 5, 5, 5, 5', 50.00, 2, 2),
(11, 4, '5', 50.00, 2, 3),
(12, 3, '5, 5, 5, 5, 5', 50.00, 2, 4),
(13, 11, '8, 8, 8', 50.00, 2, 5),
(14, 5, '8, 8, 8', 50.00, 2, 6),
(15, 7, '10, 10, 10', 50.00, 2, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
