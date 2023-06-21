-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2021 at 03:28 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `question_answer`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--
use Question_answer;

CREATE TABLE `block` (
  `user_id` int(11) NOT NULL,
  `blocked_user` int(11) NOT NULL,
  `block_date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `request_date` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`sender_id`, `receiver_id`, `request_date`, `status`, `seen`) VALUES
(4, 1, 1611561103, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(128) NOT NULL,
  `description` text,
  `picture` varchar(128) DEFAULT NULL,
  `cover_photo` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_admin`
--

CREATE TABLE `group_admin` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE `group_member` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `request_date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text,
  `seen` varchar(5) NOT NULL DEFAULT 'no',
  `attachment` varchar(128) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `action` tinyint(4) NOT NULL,
  `notif_date` bigint(20) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_text` text,
  `post_date` bigint(20) NOT NULL,
  `privacy` tinyint(4) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `post_text`, `post_date`, `privacy`, `location_id`, `group_id`) VALUES
(1, 1, 'Ù…Ù† Ù…ÛŒØ®ÙˆØ§Ù‡Ù… Ø§ÙˆÙ„ÛŒÙ† Ù¾Ø³Øª ÙØ³Ø¨Ú© Ø§Ù… Ø±Ø§ Ø¨Ú¯Ø°Ø§Ø±Ù….', 1611560855, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_date` bigint(20) NOT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`comment_id`, `user_id`, `post_id`, `comment_date`, `comment_text`) VALUES
(1, 1, 1, 1611560894, 'Ù‚Ø´Ù†Ú¯'),
(2, 4, 1, 1611561165, 'wow'),
(3, 4, 1, 1611561177, 'qashang'),
(9, 1, 1, 1615401144, 'wo....'),
(10, 1, 1, 1615646589, 'dgvsgvbs');

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_picture`
--

CREATE TABLE `post_picture` (
  `picture_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `picture` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_picture`
--

INSERT INTO `post_picture` (`picture_id`, `post_id`, `picture`) VALUES
(1, 1, 'images/post/1611560855woman-programming.png');

-- --------------------------------------------------------

--
-- Table structure for table `post_share`
--

CREATE TABLE `post_share` (
  `share_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `share_date` bigint(20) NOT NULL,
  `share_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `cover_photo` varchar(128) DEFAULT NULL,
  `picture` varchar(128) DEFAULT NULL,
  `job_title` varchar(64) DEFAULT NULL,
  `job_organization` varchar(64) DEFAULT NULL,
  `hire_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `status_text` text,
  `marital_status` varchar(32) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `province` varchar(64) DEFAULT NULL,
  `district` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `cover_photo`, `picture`, `job_title`, `job_organization`, `hire_date`, `end_date`, `status_text`, `marital_status`, `country`, `province`, `district`) VALUES
(1, 'images/cover/1611560779woman-programming.png', 'images/profile/161156077957503942_2309215629403141_5607941590115942400_n.jpg', 'Student', 'KPU', 2018, 0, '', '0', 'Afghanistan', 'Kabul', 'Kabul'),
(4, 'images/cover/1611561090burritos-wraps-with-beef-vegetables-black-background-beef-burrito-mexican-food_2829-6727.jpg', 'images/profile/1611561090MYXJ_20200323203332757_save.jpg', 'Student', 'KPU', 2018, 0, '', '0', 'Afghanistan', 'Kabul', 'Kabul');

-- --------------------------------------------------------

--
-- Table structure for table `profile_education`
--

CREATE TABLE `profile_education` (
  `education_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `degree` varchar(32) DEFAULT NULL,
  `organization` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `gender`, `dob`, `email`, `phone`, `password`) VALUES
(1, 'Farzana', 'Dawlatshahi', '1', '1996-05-05', 'farzana.dolatshahi@gmail.com', NULL, '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257'),
(2, 'Faraidon', 'Dawlatshahi', '0', '2008-01-01', 'faraidon.asadi@gmail.com', NULL, ''),
(4, 'Farzan', 'Shahi', '1', '1997-01-08', NULL, '0798631667', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`user_id`,`blocked_user`),
  ADD KEY `blockeduser_block_fk` (`blocked_user`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`sender_id`,`receiver_id`),
  ADD KEY `user_receiver_friend_fk` (`receiver_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_admin`
--
ALTER TABLE `group_admin`
  ADD PRIMARY KEY (`group_id`,`user_id`),
  ADD KEY `user_group_admin_fk` (`user_id`);

--
-- Indexes for table `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `group_group_member_fk` (`group_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_sender_message_fk` (`sender_id`),
  ADD KEY `user_receiver_message_fk` (`receiver_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_notification_fk` (`user_id`),
  ADD KEY `post_notification_fk` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_post_fk` (`user_id`),
  ADD KEY `location_post_fk` (`location_id`),
  ADD KEY `group_post_fk` (`group_id`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_post_comment_fk` (`user_id`),
  ADD KEY `post_post_comment_fk` (`post_id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_post_like_fk` (`post_id`);

--
-- Indexes for table `post_picture`
--
ALTER TABLE `post_picture`
  ADD PRIMARY KEY (`picture_id`),
  ADD KEY `post_post_picture_fk` (`post_id`);

--
-- Indexes for table `post_share`
--
ALTER TABLE `post_share`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `user_post_share_fk` (`user_id`),
  ADD KEY `post_post_share_fk` (`post_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `profile_education`
--
ALTER TABLE `profile_education`
  ADD PRIMARY KEY (`education_id`),
  ADD KEY `user_profile_education_fk` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `post_picture`
--
ALTER TABLE `post_picture`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post_share`
--
ALTER TABLE `post_share`
  MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profile_education`
--
ALTER TABLE `profile_education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `blockeduser_block_fk` FOREIGN KEY (`blocked_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_block_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `user_receiver_friend_fk` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sender_friend_fk` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_admin`
--
ALTER TABLE `group_admin`
  ADD CONSTRAINT `group_group_admin_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_admin_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_group_member_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_member_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `user_receiver_message_fk` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sender_message_fk` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `post_notification_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_notification_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `group_post_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `location_post_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `post_post_comment_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_comment_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_post_like_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_picture`
--
ALTER TABLE `post_picture`
  ADD CONSTRAINT `post_post_picture_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_share`
--
ALTER TABLE `post_share`
  ADD CONSTRAINT `post_post_share_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_share_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `user_profile_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_education`
--
ALTER TABLE `profile_education`
  ADD CONSTRAINT `user_profile_education_fk` FOREIGN KEY (`user_id`) REFERENCES `profile` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
