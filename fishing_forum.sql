-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 02, 2024 at 08:14 PM
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
-- Database: `fishing_forum`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `thread_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 2, 'Dzięki za informacje! Sprawdzę te miejsca następnym razem, gdy będę w Polsce.', '2024-06-02 17:26:26'),
(2, 1, 3, 'Również byłem w niektórych z tych miejsc. Są naprawdę świetne!', '2024-06-02 17:26:26'),
(3, 2, 1, 'Uwielbiam używać wirówek do połowu w wodach słodkich. Działają naprawdę dobrze.', '2024-06-02 17:26:26'),
(4, 2, 3, 'Moim wyborem są woblery. Zawsze się sprawdzają.', '2024-06-02 17:26:26'),
(5, 3, 1, 'Świetne porady! Szkoda, że nie znałem ich na początku.', '2024-06-02 17:26:26'),
(6, 3, 2, 'Bardzo pomocne dla początkujących. Dzięki za podzielenie się!', '2024-06-02 17:26:26'),
(7, 1, 4, 'siemano debile', '2024-06-02 17:59:14'),
(8, 6, 4, 'adasdasasdasas', '2024-06-02 17:59:19'),
(9, 6, 4, 'dasda', '2024-06-02 18:02:31'),
(10, 6, 4, 'fhgdfgjf', '2024-06-02 18:05:02'),
(11, 6, 4, 'hfghffg', '2024-06-02 18:06:02');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `user_id`, `title`, `content`, `category`, `created_at`) VALUES
(1, 1, 'Najlepsze miejsca na ryby w Polsce', 'Ostatnio byłem na rybach w Polsce i znalazłem niesamowite miejsca. Pozwólcie, że się nimi podzielę.', 'woda słodka', '2024-06-02 17:26:26'),
(2, 2, 'Ulubione przynęty do wody słodkiej', 'Jakie są Wasze ulubione przynęty do połowu w wodach słodkich?', 'woda słodka', '2024-06-02 17:26:26'),
(3, 3, 'Porady dla początkujących wędkarzy', 'Dopiero zaczynasz wędkarstwo? Oto kilka porad, które pomogą Ci rozpocząć.', 'sprzęt', '2024-06-02 17:26:26'),
(4, 4, 'siema elo', 'fnsadfiotgbaikgbnsdfiklgsdfhsdhsdghsdhdxfg', 'saltwater', '2024-06-02 17:48:49'),
(5, 4, 'bbsfdghbfgb', 'bfghbfbgfbsfghsgfh', 'freshwater', '2024-06-02 17:51:00'),
(6, 4, 'dasdasdasa', 'dasdasdasas', 'freshwater', '2024-06-02 17:57:54');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'jan_kowalski', 'jan@example.com', '$2y$10$eXj/9he2FA1Ggk/LtFhH0e/whnWJpObT5HgSk9v07eQIo4CpG.6Fy', '2024-06-02 17:26:26'),
(2, 'anna_nowak', 'anna@example.com', '$2y$10$E3PCsLS5ud.c6hxOaKQXlOeFNc/fJfr/u30mI4UUtRtS6MyaNOXqW', '2024-06-02 17:26:26'),
(3, 'piotr_zielinski', 'piotr@example.com', '$2y$10$ClPrKEFbTGKE4WvAG.Qb.uuY8HLS5KgXsvKJUKiRjKfFZ4UPA/SeK', '2024-06-02 17:26:26'),
(4, 'kacper', 'kacper@mail.com', '$2y$10$B.RF1P6nD1ddpfBx9lRW8OJaJlf1a.BErYj6Wnrij942BpWHw81kq', '2024-06-02 17:30:50');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
