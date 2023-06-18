-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Cze 2023, 14:43
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `logindb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects`
--

CREATE TABLE `projects` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `todolist`
--

CREATE TABLE `todolist` (
                            `id` int(11) NOT NULL,
                            `user_id` int(11) NOT NULL,
                            `tasks` varchar(255) DEFAULT NULL,
                            `priority` enum('niski','średni','wysoki') NOT NULL DEFAULT 'średni',
                            `completed` tinyint(1) NOT NULL DEFAULT 0,
                            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                            `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
                            `due_date` date DEFAULT NULL,
                            `notes` text DEFAULT NULL,
                            `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `name` varchar(128) NOT NULL,
                        `email` varchar(255) NOT NULL,
                        `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password_hash`) VALUES
                                                                (1, 'a', 'a@a.pl', '$2y$10$IODMMwU6XWamqS3jXA6N4.tZp3ZP1njYOuv3jDf0rAz/qP1uBgkYe'),
                                                                (4, 'a', 'a2@a.pl', '$2y$10$egUNhZSS6Ad8NQGkEKzoyOFesly5G7qemE3eNlOpjy1kyv5imkuc.'),
                                                                (5, 'a', 'a3@a.pl', '$2y$10$tGMpWWI0rPXIvC8Oxebgw.Hc5AGYzaNafR6i2rjZp5iSNeKvrpfu.'),
                                                                (6, 'Maks', 'maks@maks.pl', '$2y$10$YHFn/yrEzI0FYVlbghVdCu846gC8OK4DYNV9yf7XdRSoCWwuxqP/i');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `projects`
--
ALTER TABLE `projects`
    ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `todolist`
--
ALTER TABLE `todolist`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `projects`
--
ALTER TABLE `projects`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `todolist`
--
ALTER TABLE `todolist`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `todolist`
--
ALTER TABLE `todolist`
    ADD CONSTRAINT `todolist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `todolist_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
