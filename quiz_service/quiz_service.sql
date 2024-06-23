-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 23, 2024 at 08:10 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_service`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `text`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tak', 1, '2024-06-23 15:50:31', '2024-06-23 15:50:31'),
(2, 1, 'Nie', 0, '2024-06-23 15:50:31', '2024-06-23 15:50:31'),
(3, 2, '2', 0, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(4, 2, '4', 1, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(5, 2, '5', 0, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(6, 3, '9', 0, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(7, 3, '6', 0, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(8, 3, '11', 1, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(9, 4, '413 462', 0, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(10, 4, '0', 1, '2024-06-23 17:50:29', '2024-06-23 17:50:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Science', '2024-06-23 15:13:52', '2024-06-23 15:13:52'),
(2, 'History', '2024-06-23 15:13:52', '2024-06-23 15:13:52'),
(3, 'Mathematics', '2024-06-23 15:13:52', '2024-06-23 15:13:52'),
(4, 'Programming', '2024-06-23 15:13:52', '2024-06-23 15:13:52'),
(5, 'Sport', '2024-06-23 15:13:52', '2024-06-23 15:13:52');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_type` enum('single','multiple','text','gap_fill') NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_type`, `text`, `image`, `created_at`, `updated_at`) VALUES
(1, 3, 'single', 'Czy lubisz Arke Gdynie?', NULL, '2024-06-23 15:50:31', '2024-06-23 15:50:31'),
(2, 4, 'single', '2+2', NULL, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(3, 4, 'single', '3*3+2', NULL, '2024-06-23 17:50:29', '2024-06-23 17:50:29'),
(4, 4, 'single', '1120+412342*0', NULL, '2024-06-23 17:50:29', '2024-06-23 17:50:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `category_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(3, 5, 'Sport Test 1.', 'Football quiz.', '2024-06-23 15:50:31', '2024-06-23 15:50:31'),
(4, 3, 'Quick Maths', '', '2024-06-23 17:50:29', '2024-06-23 17:50:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'test@gmail.com', '$2y$10$.YZm60POYMTwwSGzLwlvE.Sf/l4gC.fDjGEsKMYoluQjwCiC4ctT2', NULL, '2024-06-23 14:05:13', '2024-06-23 14:05:13');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `quiz_id`, `question_id`, `answer_id`, `is_correct`, `created_at`) VALUES
(21, 1, 3, 1, 1, 0, '2024-06-23 17:44:23'),
(22, 1, 3, 1, 1, 0, '2024-06-23 17:45:34'),
(23, 1, 4, 2, 4, 0, '2024-06-23 17:51:25'),
(24, 1, 4, 3, 6, 0, '2024-06-23 17:51:25'),
(25, 1, 4, 4, 9, 0, '2024-06-23 17:51:25'),
(31, 1, 4, 2, 3, 0, '2024-06-23 17:58:24'),
(32, 1, 4, 3, 6, 0, '2024-06-23 17:58:24'),
(33, 1, 4, 4, 10, 0, '2024-06-23 17:58:24'),
(34, 1, 3, 1, 1, 0, '2024-06-23 18:01:23'),
(35, 1, 3, 1, 2, 0, '2024-06-23 18:01:27'),
(36, 1, 3, 1, 1, 0, '2024-06-23 18:01:31'),
(37, 1, 3, 1, 2, 0, '2024-06-23 18:01:39'),
(38, 1, 4, 2, 4, 0, '2024-06-23 18:01:47'),
(39, 1, 4, 3, 8, 0, '2024-06-23 18:01:47'),
(40, 1, 4, 4, 10, 0, '2024-06-23 18:01:47'),
(41, 1, 3, 1, 1, 0, '2024-06-23 18:02:36'),
(42, 1, 4, 2, 5, 0, '2024-06-23 18:02:43'),
(43, 1, 4, 3, 7, 0, '2024-06-23 18:02:43'),
(44, 1, 4, 4, 10, 0, '2024-06-23 18:02:43'),
(45, 1, 3, 1, 1, 0, '2024-06-23 18:03:18'),
(46, 1, 3, 1, 1, 0, '2024-06-23 18:05:06'),
(47, 1, 3, 1, 2, 0, '2024-06-23 18:05:11'),
(48, 1, 3, 1, 1, 0, '2024-06-23 18:05:34'),
(49, 1, 3, 1, 1, 0, '2024-06-23 18:07:09'),
(50, 1, 3, 1, 2, 0, '2024-06-23 18:07:50'),
(51, 1, 4, 2, 4, 0, '2024-06-23 18:08:47'),
(52, 1, 4, 3, 8, 0, '2024-06-23 18:08:47'),
(53, 1, 4, 4, 9, 0, '2024-06-23 18:08:47'),
(54, 1, 3, 1, 1, 0, '2024-06-23 18:08:51');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indeksy dla tabeli `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_4` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
