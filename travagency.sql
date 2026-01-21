-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 11:59 AM
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
-- Database: `travagency`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `booking_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `user_id`, `number_of_people`, `total_price`, `status`, `booking_date`) VALUES
(1, 1, 2, 2, 700.00, 'confirmed', '2026-01-21 11:49:20'),
(2, 2, 3, 1, 250.00, 'pending', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Alice', 'alice@example.com', 'I want to book a tour to Djerba.', '2026-01-21 11:49:20'),
(2, 'Bob', 'bob@example.com', 'Do you offer custom Sahara tours?', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `slug`, `description`, `image`, `region`, `created_at`, `updated_at`) VALUES
(1, 'Tozeur', 'tozeur', 'Oasis city with desert landscapes.', 'https://images.unsplash.com/photo-tozeur', 'South Tunisia', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(2, 'Djerba', 'djerba', 'Beautiful island with beaches and culture.', 'https://images.unsplash.com/photo-djerba', 'South Tunisia', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(3, 'Tunis', 'tunis', 'Capital city with historic medina.', 'https://images.unsplash.com/photo-tunis', 'North Tunisia', '2026-01-21 11:49:20', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `tour_id`, `destination_id`, `url`, `alt_text`, `created_at`) VALUES
(1, 1, NULL, 'https://images.unsplash.com/photo-sahara-1', 'Sahara Desert', '2026-01-21 11:49:20'),
(2, 2, 2, 'https://images.unsplash.com/photo-djerba-1', 'Djerba Beach', '2026-01-21 11:49:20'),
(3, NULL, 1, 'https://images.unsplash.com/photo-tozeur-1', 'Oasis in Tozeur', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `tour_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'Amazing desert experience!', '2026-01-21 11:49:20'),
(2, 2, 3, 4, 'Loved the beach and culture.', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `canonical` varchar(255) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `page`, `title`, `description`, `canonical`, `og_title`, `og_description`, `og_url`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Vérité Voyages | Travel Tunisia', 'Discover Tunisia with Vérité Voyages', 'https://www.verite-voyages.com/', 'Vérité Voyages', 'Explore Tunisia with our tours', 'https://www.verite-voyages.com/', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(2, 'destinations', 'Destinations | Vérité Voyages', 'Explore our destinations in Tunisia', 'https://www.verite-voyages.com/destinations', 'Destinations | Vérité Voyages', 'Best places to visit in Tunisia', 'https://www.verite-voyages.com/destinations', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(3, 'tours', 'Tours | Vérité Voyages', 'Explore our tours in Tunisia', 'https://www.verite-voyages.com/tours', 'Tours | Vérité Voyages', 'Book the best tours in Tunisia', 'https://www.verite-voyages.com/tours', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(4, 'contact', 'Contact | Vérité Voyages', 'Get in touch with us', 'https://www.verite-voyages.com/contact', 'Contact | Vérité Voyages', 'Send us a message or visit our office', 'https://www.verite-voyages.com/contact', '2026-01-21 11:49:20', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `destination_id`, `name`, `slug`, `description`, `price`, `duration`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sahara Adventure', 'sahara-adventure', 'Camel rides, desert camps, and sunsets.', 350.00, '3 days', 'https://images.unsplash.com/photo-sahara', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(2, 2, 'Djerba Relaxation', 'djerba-relaxation', 'Beaches and Mediterranean vibes.', 250.00, '2 days', 'https://images.unsplash.com/photo-djerba-tour', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(3, 3, 'Tunis Cultural', 'tunis-cultural', 'Medina, markets, historic tours.', 150.00, '1 day', 'https://images.unsplash.com/photo-tunis-tour', '2026-01-21 11:49:20', '2026-01-21 11:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ROLE_ADMIN','ROLE_USER') DEFAULT 'ROLE_USER',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@verite-voyages.com', 'password123', 'ROLE_ADMIN', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(2, 'John Doe', 'john@example.com', 'password123', 'ROLE_USER', '2026-01-21 11:49:20', '2026-01-21 11:49:20'),
(3, 'Jane Smith', 'jane@example.com', 'password123', 'ROLE_USER', '2026-01-21 11:49:20', '2026-01-21 11:49:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page` (`page`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `destination_id` (`destination_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
