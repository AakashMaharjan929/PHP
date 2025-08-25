-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 03:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gharbhada`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminearnings`
--

CREATE TABLE `adminearnings` (
  `Total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminearnings`
--

INSERT INTO `adminearnings` (`Total`) VALUES
(750);

-- --------------------------------------------------------

--
-- Table structure for table `booktourrequests`
--

CREATE TABLE `booktourrequests` (
  `bookTour_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `TourDate` date DEFAULT NULL,
  `CallPrice` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `tenantName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boostedposts`
--

CREATE TABLE `boostedposts` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `transaction_screenshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boostedposts`
--

INSERT INTO `boostedposts` (`id`, `post_id`, `post_name`, `transaction_screenshot`, `created_at`) VALUES
(6, '31', '2BHK aparment', '../BoostPosts/6-146x300.webp', '2025-02-19 02:44:09'),
(7, '15', 'Room for rent at old Baneshwor', '../BoostPosts/', '2025-02-19 09:26:18'),
(8, '17', 'Flat on rent - Bagdol', '../BoostPosts/6-146x300.webp', '2025-02-19 09:26:24'),
(9, '14', '2BHK flat Available for Rent', '../BoostPosts/6-146x300.webp', '2025-02-19 09:26:31'),
(10, '14', '2BHK flat Available for Rent', '../BoostPosts/6-146x300.webp', '2025-02-19 09:26:59'),
(11, '15', 'Room for rent at old Baneshwor', '../BoostPosts/6-146x300.webp', '2025-02-19 09:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `boostpost`
--

CREATE TABLE `boostpost` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_section` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boostpost`
--

INSERT INTO `boostpost` (`id`, `post_id`, `post_name`, `post_section`, `created_at`) VALUES
(3, '14', '2BHK flat Available for Rent', 'featured', '2024-08-20 09:32:19'),
(4, '15', 'Room for rent at old Baneshwor', 'featured', '2024-08-20 09:32:30'),
(5, '16', '2 bhk flat on rent at sanepa', 'featured', '2024-08-20 09:32:51'),
(7, '18', 'sunny 3bk 1st floor 26000', 'bestdeals', '2024-08-20 09:33:21'),
(9, '20', 'Flat on Rent', 'bestdeals', '2024-08-20 09:33:55'),
(12, '19', '3 bhk flat on rent at jhamshikhel', 'featured', '2024-08-20 09:42:30'),
(14, '17', 'Flat on rent - Bagdol', 'bestdeals', '2024-08-20 11:27:43'),
(19, '31', '2BHK aparment', 'bestdeals', '2025-02-19 02:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` enum('residential','commercial') NOT NULL,
  `floor` varchar(40) DEFAULT NULL,
  `entrance` varchar(255) NOT NULL,
  `for_whom` enum('family','single') NOT NULL,
  `road_size` int(11) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `living_rooms` int(11) NOT NULL,
  `restrooms` int(11) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `name`, `phone_number`, `title`, `rent`, `location`, `type`, `floor`, `entrance`, `for_whom`, `road_size`, `bedrooms`, `living_rooms`, `restrooms`, `image1`, `image2`, `image3`, `description`, `created_at`, `updated_at`, `status`) VALUES
(14, 10, 'Ram Laxman', '9712348237', '2BHK flat Available for Rent', 25000.00, 'Baluwatar', 'residential', 'Ground floor', 'Main', 'family', 14, 2, 1, 1, '../PostImages/1+1.webp', '../PostImages/1+2.webp', '../PostImages/1+3.webp', 'Discover serenity and convenience in this charming room for rent nestled in the vibrant city of Kathmandu, Nepal. Perfectly situated near the bustling district of Thamel, this room offers a tranquil retreat amidst the city\'s lively atmosphere. The furnished bedroom features a comfortable bed, ample storage space with a wardrobe, and a study desk ideal for work or study sessions.', '2024-08-19 03:50:12', '2024-08-20 09:32:19', 1),
(15, 10, 'Ram Laxman', '9712348237', 'Room for rent at old Baneshwor', 22000.00, 'Baneshwor', 'residential', 'Ground floor', 'Seperated', 'family', 20, 1, 1, 1, '../PostImages/2+1.webp', '../PostImages/2+2.webp', '../PostImages/2+3.webp', 'You\'ll have access to a modern, shared bathroom equipped with hot water facilities. Enjoy the convenience of a shared kitchen where you can prepare meals with ease. High-speed internet, electricity, and water utilities are all included in the rent, ensuring a hassle-free living experience.', '2024-08-19 03:54:31', '2024-08-20 09:32:30', 1),
(16, 10, 'Ram Laxman', '9712348237', '2 bhk flat on rent at sanepa', 35000.00, 'Sanepa', 'residential', 'Ground floor', 'Main', 'family', 10, 2, 1, 1, '../PostImages/3+1.webp', '../PostImages/3+2.webp', '../PostImages/3+3.webp', 'With 24/7 security and CCTV surveillance, safety is prioritized. Take advantage of the rooftop terrace offering breathtaking views, perfect for relaxation or social gatherings. Whether you\'re a student or a professional, this room provides the ideal blend of comfort and accessibility in Kathmandu.', '2024-08-19 03:57:50', '2024-08-20 09:32:51', 1),
(17, 10, 'Ram Laxman', '9712348237', 'Flat on rent - Bagdol', 25000.00, 'Bagdol', 'residential', 'Ground floor', 'Seperated', 'family', 14, 1, 1, 1, '../PostImages/4+1.webp', '../PostImages/4+2.webp', '../PostImages/4+3.webp', 'Discover serenity and convenience in this charming room for rent nestled in the vibrant city of Kathmandu, Nepal. Perfectly situated near the bustling district of Thamel, this room offers a tranquil retreat amidst the city\'s lively atmosphere. The furnished bedroom features a comfortable bed, ample storage space with a wardrobe, and a study desk ideal for work or study sessions. ', '2024-08-19 04:00:59', '2024-08-20 11:27:43', 2),
(18, 10, 'Ram Laxman', '9712348237', 'sunny 3bk 1st floor 26000', 26000.00, 'Manjushri Marg', 'residential', 'First floor', 'Seperated', 'family', 20, 1, 1, 1, '../PostImages/5+1.webp', '../PostImages/5+2.webp', '../PostImages/5+3.webp', 'You\'ll have access to a modern, shared bathroom equipped with hot water facilities. Enjoy the convenience of a shared kitchen where you can prepare meals with ease. High-speed internet, electricity, and water utilities are all included in the rent, ensuring a hassle-free living experience.', '2024-08-19 04:05:03', '2024-08-20 09:33:21', 2),
(19, 11, 'Radha Krishna', '9723149793', '3 bhk flat on rent at jhamshikhel', 30000.00, 'Jhamshikhel', 'residential', 'First floor', 'Main', 'single', 14, 3, 1, 1, '../PostImages/6+1.webp', '../PostImages/6+2.webp', '../PostImages/6+3.webp', 'You\'ll have access to a modern, shared bathroom equipped with hot water facilities. Enjoy the convenience of a shared kitchen where you can prepare meals with ease. High-speed internet, electricity, and water utilities are all included in the rent, ensuring a hassle-free living experience. ', '2024-08-19 04:10:40', '2024-08-20 09:42:30', 1),
(20, 11, 'Radha Krishna', '9723149793', 'Flat on Rent', 20000.00, ' Suryabinayak', 'residential', 'First floor', 'Main', 'family', 14, 1, 1, 1, '../PostImages/7+1.webp', '../PostImages/7+2.webp', '../PostImages/7+3.webp', 'With 24/7 security and CCTV surveillance, safety is prioritized. Take advantage of the rooftop terrace offering breathtaking views, perfect for relaxation or social gatherings. Whether you\'re a student or a professional, this room provides the ideal blend of comfort and accessibility in Kathmandu.', '2024-08-19 04:14:21', '2024-08-20 09:33:55', 2),
(31, 16, 'test', '9822336422', '2BHK aparment', 15000.00, 'Baluwatar', 'residential', '2', 'Main', 'family', 20, 2, 1, 1, '../PostImages/photo1.webp', '../PostImages/photo2.webp', '../PostImages/photo3.webp', 'Located in the peaceful yet well-connected area of Baluwatar, this rental room offers a comfortable and convenient living space ideal for students or professionals. The room is well-lit and spacious, providing a cozy atmosphere with essential amenities. Depending on preference, it can be furnished with a bed, wardrobe, and table or left unfurnished for personal customization. An attached or shared bathroom ensures convenience, while a reliable water supply and electricity backup (if available) add to the comfort. The neighborhood is safe and within walking distance of grocery stores, restaurants, and public transport, making daily life easy and hassle-free. Perfect for those seeking a quiet yet accessible place to call home, this room offers a great balance of privacy and convenience in the heart of Kathmandu.', '2025-02-19 02:43:52', '2025-02-19 02:44:36', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `status`) VALUES
(1, '', '', '', '$2y$10$UI5OyA7XyGyqoNfYNm9onOZphtFTgiMbPrqbnqSO03HKpYHBxuW0e', '2024-08-18 12:18:10', 1),
(10, 'Ram Laxman', 'ramlaxman@gmail.com', '9712348237', '$2y$10$fjlDe3TQUIzgn115r2ASqeTCFm/8tRdNuNlvr0bhPdZm3rr7zddJq', '2024-08-18 12:46:04', 1),
(11, 'Radha Krishna', 'radhakrishna@gmail.com', '9723149793', '$2y$10$hh8OQgP8stwziBJOImwfeuDZYNVUu6I/zG1QphaQqn63jrA5amHKy', '2024-08-19 04:07:40', 1),
(12, 'admin', 'admin@gmail.com', '9712342314', '$2y$10$6sJJoC9Rh0iy4Hq0HLqHzObeUtIX0oJ4hv3j1r8m1ZjWAhxJHQU6i', '2024-08-20 07:07:09', 1),
(15, 'Manu Adhikari', 'manuadhikari@gmail.com', '9842224447', '$2y$10$8fSluRXo0vAvvIav1OWSiOT0SVv8hDGR33k3omBKiEpoC/G3ChyfW', '2025-02-18 14:49:31', 1),
(16, 'test', 'test@gmail.com', '9822336422', '$2y$10$uq.NiJubdiDMhyAy15qcpOxjcv3uIZEM2gRy4vJfeSQjxkm65kQ/.', '2025-02-19 02:29:03', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booktourrequests`
--
ALTER TABLE `booktourrequests`
  ADD PRIMARY KEY (`bookTour_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `boostedposts`
--
ALTER TABLE `boostedposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boostpost`
--
ALTER TABLE `boostpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booktourrequests`
--
ALTER TABLE `booktourrequests`
  MODIFY `bookTour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `boostedposts`
--
ALTER TABLE `boostedposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `boostpost`
--
ALTER TABLE `boostpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booktourrequests`
--
ALTER TABLE `booktourrequests`
  ADD CONSTRAINT `booktourrequests_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `booktourrequests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
