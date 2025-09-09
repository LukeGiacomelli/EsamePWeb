-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 09, 2025 alle 15:23
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pnldb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `data_prenotazione` datetime DEFAULT NULL,
  `durata_prenotazione` int(11) DEFAULT NULL,
  `C_quantità` int(11) DEFAULT NULL,
  `Prodotto_id` varchar(255) NOT NULL,
  `U_cf` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `id` int(11) NOT NULL,
  `utente_id` varchar(16) NOT NULL,
  `prodotto_id` varchar(255) NOT NULL,
  `messaggio` text NOT NULL,
  `punteggio` tinyint(3) UNSIGNED NOT NULL CHECK (`punteggio` between 0 and 5),
  `data_commento` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`id`, `utente_id`, `prodotto_id`, `messaggio`, `punteggio`, `data_commento`) VALUES
(4, 'MRMAE23491', 'Cm3', 'cazzooo', 2, '2025-04-23 20:51:19'),
(13, 'MRMAE23491', 'Cm3', 'lo vedii!?', 1, '2025-04-23 21:08:32'),
(22, 'MRMAE23491', 'C3', 'awdawdwd', 3, '2025-04-23 21:38:43'),
(23, 'MRMAE23491', 'C3', 'cazzzo che hit', 5, '2025-04-23 21:38:56'),
(24, 'MRMAE23491', 'C3', 'AAAAAAAAAAA', 5, '2025-08-13 18:09:59'),
(25, 'MRMAE23491', 'C3', 'cazzooo', 4, '2025-09-03 09:30:58'),
(26, 'MRMAE23491', 'C3', 'w', 4, '2025-09-03 09:31:11'),
(27, 'MRMAE23491', 'C3', 'w', 0, '2025-09-03 09:32:22'),
(28, 'MRMAE23491', 'C3', 'ciao', 1, '2025-09-06 08:53:32'),
(29, 'MRMAE23491', 'C3', 'ciao', 1, '2025-09-06 08:53:54'),
(31, 'MRMAE23491', 'C3', 'ciao', 1, '2025-09-06 08:59:25'),
(32, 'MRMAE23491', 'C3', 'ciao', 0, '2025-09-06 09:09:46'),
(33, 'MRMAE23491', 'S1', 'bella sala', 0, '2025-09-06 09:11:12'),
(34, 'MRMAE23491', 'C3', 'ciao', 0, '2025-09-06 09:13:08'),
(35, 'MRMAE23491', 'Cm3', 'no', 0, '2025-09-06 09:13:20'),
(36, 'MRMAE23491', 'S2', 'ciao', 0, '2025-09-06 09:13:33'),
(37, 'MRMAE23491', 'S2', 'cccc', 0, '2025-09-06 09:14:20'),
(38, 'MRMAE23491', 'S2', 'd', 0, '2025-09-06 09:14:58'),
(39, 'MRMAE23491', 'S2', '', 0, '2025-09-06 09:15:09'),
(40, 'MRMAE23491', 'S1', 'hjhhhhhhhhhh', 4, '2025-09-06 09:16:39'),
(41, 'MRMAE23491', 'Cm3', 'wwww', 0, '2025-09-06 09:20:44'),
(42, 'MRMAE23491', 'S1', 'ww', 0, '2025-09-06 09:21:05'),
(43, 'MRMAE23491', 'S1', 'wdwd', 0, '2025-09-06 09:21:30'),
(44, 'MRMAE23491', 'S1', 'cccc', 0, '2025-09-06 09:21:51'),
(45, 'MRMAE23491', 'S2', 'aaa', 0, '2025-09-06 09:22:17'),
(46, 'MRMAE23491', 'S1', 'www', 4, '2025-09-06 09:22:34'),
(47, 'MRMAE23491', 'C3', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 2, '2025-09-06 09:23:45'),
(48, 'MRMAE23491', 'SV1', 'ddddddddddddd', 5, '2025-09-06 09:24:00'),
(49, 'MRMAE23491', 'SV1', '07/09', 5, '2025-09-07 10:08:08');

-- --------------------------------------------------------

--
-- Struttura della tabella `contiene`
--

CREATE TABLE `contiene` (
  `Ordine_id` varchar(255) NOT NULL,
  `Prodotto_id` varchar(255) NOT NULL,
  `Quantità_di_prodotto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `corso`
--

CREATE TABLE `corso` (
  `Prodotto_id` varchar(255) NOT NULL,
  `Corso_Nome` varchar(32) DEFAULT NULL,
  `Corso_Operatore_Nome` varchar(32) DEFAULT NULL,
  `Corso_Operatore_Cognome` varchar(32) DEFAULT NULL,
  `Corso_Data` varchar(32) DEFAULT NULL,
  `N_Iscritti` int(11) NOT NULL,
  `Max_Iscritti` int(4) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`Prodotto_id`, `Corso_Nome`, `Corso_Operatore_Nome`, `Corso_Operatore_Cognome`, `Corso_Data`, `N_Iscritti`, `Max_Iscritti`) VALUES
('C3', 'Corso di Mix&Master', 'Giancarlo', 'Piro', '2025-09-21', 2, 5),
('Cm3', 'Soundtrack Crafting', 'Ginevra', 'Morselli', '2025-02-14', 3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `modifica`
--

CREATE TABLE `modifica` (
  `Prodotto_id` varchar(255) NOT NULL,
  `U_cf` varchar(16) NOT NULL,
  `Tipo_modifica` varchar(128) DEFAULT NULL,
  `Data_di_modifica` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `Ordine_id` varchar(255) NOT NULL,
  `cf_cliente` varchar(255) DEFAULT NULL,
  `Data_ordine` datetime DEFAULT NULL,
  `stato` varchar(50) DEFAULT 'in elaborazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`Ordine_id`, `cf_cliente`, `Data_ordine`, `stato`) VALUES
('ORD6819daba85829', 'MRMAE23491', '2025-05-06 00:00:00', 'Annullato'),
('ORD6819dce3e496d', 'MRMAE23491', '2025-05-06 00:00:00', 'Annullato'),
('ORD6819e36880689', 'MRMAE23491', '2025-05-06 00:00:00', 'Confermato'),
('ORD6819e44472e03', 'MRMAE23491', '2025-05-06 12:28:20', 'Annullato'),
('ORD681a2e29c1fe6', 'MRMAE23491', '2025-05-06 17:43:37', 'Annullato'),
('ORD681a2e8b81394', 'MRMAE23491', '2025-05-06 17:45:15', 'Rifiutato'),
('ORD681a3121a29bf', 'MRMAE23491', '2025-05-06 17:56:17', 'Confermato'),
('ORD681a315269bc6', 'MRMAE23491', '2025-05-06 17:57:06', 'Annullato'),
('ORD681a31758f749', 'MRMAE23491', '2025-05-06 17:57:41', 'Annullato'),
('ORD68ad7ad44e8fe', 'MRMAE23491', '2025-08-26 11:13:56', 'Annullato'),
('ORD68af0a0768c79', 'MRMAE23491', '2025-08-27 15:37:11', 'Annullato'),
('ORD68b55c314c080', 'MRMAE23491', '2025-09-01 10:41:21', 'In elaborazione'),
('ORD68b55d9b42805', 'MRMAE23491', '2025-09-01 10:47:23', 'In elaborazione'),
('ORD68b560396aa3c', 'MRMAE23491', '2025-09-01 10:58:33', 'In elaborazione'),
('ORD68b560842b75b', 'MRMAE23491', '2025-09-01 10:59:48', 'In elaborazione'),
('ORD68b563261e93e', 'MRMAE23491', '2025-09-01 11:11:02', 'In elaborazione'),
('ORD68b578ae82a34', 'MRMAE23491', '2025-09-01 12:42:54', 'In elaborazione'),
('ORD68b953cdd51d0', 'MRMAE23491', '2025-09-04 10:54:37', 'In elaborazione'),
('ORD68b953e94818b', 'MRMAE23491', '2025-09-04 10:55:05', 'In elaborazione'),
('ORD68baa5c15e14b', 'MRMAE23491', '2025-09-05 10:56:33', 'Annullato'),
('ORD68baa5f61ba7a', 'MRMAE23491', '2025-09-05 10:57:26', 'In elaborazione'),
('ORD68baa609b4d00', 'MRMAE23491', '2025-09-05 10:57:45', 'In elaborazione'),
('ORD68baa7b6246c1', 'MRMAE23491', '2025-09-05 11:04:54', 'In elaborazione'),
('ORD68baa833b2af0', 'MRMAE23491', '2025-09-05 11:06:59', 'In elaborazione'),
('ORD68baa871206d2', 'MRMAE23491', '2025-09-05 11:08:01', 'In elaborazione'),
('ORD68baaaa4c3641', 'MRMAE23491', '2025-09-05 11:17:24', 'In elaborazione'),
('ORD68baaceec5356', 'MRMAE23491', '2025-09-05 11:27:10', 'In elaborazione'),
('ORD68baad4905e31', 'MRMAE23491', '2025-09-05 11:28:41', 'In elaborazione'),
('ORD68bab202cc35c', 'MRMAE23491', '2025-09-05 11:48:50', 'In elaborazione'),
('ORD68bab46990480', 'MRMAE23491', '2025-09-05 11:59:05', 'In elaborazione'),
('ORD68bab619cff2c', 'MRMAE23491', '2025-09-05 12:06:17', 'In elaborazione'),
('ORD68bea064ccd7e', 'MRMAE23491', '2025-09-08 11:22:44', 'Confermato'),
('ORD68bea560b28f5', 'MRMAE23491', '2025-09-08 11:44:00', 'Confermato'),
('ORD68bea6ba09c67', 'MRMAE23491', '2025-09-08 11:49:46', 'In elaborazione'),
('ORD68bea7c9a2092', 'MRMAE23491', '2025-09-08 11:54:17', 'In elaborazione'),
('ORD68bea83538125', 'MRMAE23491', '2025-09-08 11:56:05', 'In elaborazione'),
('ORD68bea85dcd658', 'MRMAE23491', '2025-09-08 11:56:45', 'In elaborazione'),
('ORD68bea87c7ced7', 'MRMAE23491', '2025-09-08 11:57:16', 'In elaborazione'),
('ORD68bea895f25ce', 'MRMAE23491', '2025-09-08 11:57:41', 'In elaborazione'),
('ORD68bea8b7cc1ac', 'MRMAE23491', '2025-09-08 11:58:15', 'In elaborazione'),
('ORD68bea8c207d30', 'MRMAE23491', '2025-09-08 11:58:26', 'In elaborazione'),
('ORD68bea8cccba4d', 'MRMAE23491', '2025-09-08 11:58:36', 'In elaborazione'),
('ORD68beb035c433e', 'MRMAE23491', '2025-09-08 12:30:13', 'Confermato'),
('ORD68bee4bbea909', 'MRMAE23491', '2025-09-08 16:14:19', 'Confermato'),
('ORD68bee5cd4ae23', 'MRMAE23491', '2025-09-08 16:18:53', 'Confermato'),
('ORD68c026b523cb9', 'MRMAE23491', '2025-09-09 15:08:05', 'Confermato');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine_prodotto`
--

CREATE TABLE `ordine_prodotto` (
  `id` int(11) NOT NULL,
  `ordine_id` varchar(255) DEFAULT NULL,
  `prodotto_id` varchar(255) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  `prezzo_unitario` decimal(10,2) DEFAULT NULL,
  `data_prenotazione` datetime DEFAULT NULL,
  `durata_prenotazione` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine_prodotto`
--

INSERT INTO `ordine_prodotto` (`id`, `ordine_id`, `prodotto_id`, `quantita`, `prezzo_unitario`, `data_prenotazione`, `durata_prenotazione`) VALUES
(1, 'ORD6819daba85829', 'C3', 2, 850.00, NULL, NULL),
(2, 'ORD6819daba85829', 'Cm3', 1, 150.00, NULL, NULL),
(3, 'ORD6819daba85829', 'S1', 1, 65.00, NULL, NULL),
(4, 'ORD6819daba85829', 'S2', 1, 56.00, NULL, NULL),
(5, 'ORD6819dce3e496d', 'SV1', 9, 22.00, NULL, NULL),
(6, 'ORD6819e36880689', 'C3', 3, 850.00, NULL, NULL),
(7, 'ORD6819e44472e03', 'Cm3', 2, 150.00, NULL, NULL),
(8, 'ORD6819e44472e03', 'S1', 1, 65.00, NULL, NULL),
(9, 'ORD6819e44472e03', 'S2', 2, 56.00, NULL, NULL),
(10, 'ORD681a2e8b81394', 'S2', 2, 56.00, '2025-05-07 22:02:00', 2),
(11, 'ORD681a3121a29bf', 'S2', 1, 56.00, NULL, NULL),
(12, 'ORD681a315269bc6', 'S1', 1, 65.00, NULL, NULL),
(13, 'ORD681a31758f749', 'S2', 1, 56.00, NULL, NULL),
(14, 'ORD68ad7ad44e8fe', 'Cm3', 2, 150.00, NULL, NULL),
(15, 'ORD68ad7ad44e8fe', 'S1', 1, 65.00, '2025-08-29 11:00:00', 2),
(16, 'ORD68af0a0768c79', 'Cm3', 1, 150.00, NULL, NULL),
(17, 'ORD68af0a0768c79', 'S1', 1, 65.00, NULL, NULL),
(18, 'ORD68b55c314c080', 'S1', 1, 65.00, NULL, NULL),
(19, 'ORD68b55d9b42805', 'Cm3', 1, 150.00, NULL, NULL),
(20, 'ORD68b560396aa3c', 'Cm3', 1, 150.00, NULL, NULL),
(21, 'ORD68b560842b75b', 'Cm3', 1, 150.00, NULL, NULL),
(22, 'ORD68b563261e93e', 'Cm3', 1, 150.00, NULL, NULL),
(23, 'ORD68b578ae82a34', 'C3', 1, 850.00, NULL, NULL),
(24, 'ORD68b578ae82a34', 'S1', 1, 65.00, '2025-09-02 10:00:00', 2),
(25, 'ORD68b953cdd51d0', 'Cm3', 1, 150.00, NULL, NULL),
(26, 'ORD68b953cdd51d0', 'S2', 1, 56.00, NULL, NULL),
(27, 'ORD68b953cdd51d0', 'SV1', 1, 22.00, NULL, NULL),
(28, 'ORD68b953e94818b', 'S1', 1, 65.00, NULL, NULL),
(29, 'ORD68baa7b6246c1', 'C3', 1, 850.00, NULL, NULL),
(30, 'ORD68baa7b6246c1', 'SV1', 1, 22.00, NULL, NULL),
(31, 'ORD68baa833b2af0', 'S1', 1, 65.00, '2025-09-05 10:00:00', 3),
(32, 'ORD68baa871206d2', 'S1', 1, 65.00, '2025-09-13 10:00:00', 4),
(33, 'ORD68baa871206d2', 'S2', 1, 56.00, '2025-09-06 12:00:00', 6),
(35, 'ORD68baad4905e31', 'S1', 1, 325.00, '2025-09-12 14:00:00', 5),
(36, 'ORD68bab202cc35c', 'Cm3', 1, 150.00, NULL, NULL),
(37, 'ORD68bab202cc35c', 'S2', 1, 112.00, '2025-09-05 10:00:00', 2),
(38, 'ORD68bab46990480', 'C3', 3, 2550.00, NULL, NULL),
(39, 'ORD68bab46990480', 'S1', 1, 130.00, '2025-09-06 10:00:00', 2),
(40, 'ORD68bab46990480', 'S2', 1, 224.00, '2025-09-13 18:00:00', 4),
(41, 'ORD68bab619cff2c', 'S2', 1, 672.00, '2025-09-26 16:00:00', 12),
(42, 'ORD68bea064ccd7e', 'Cm3', 1, 150.00, NULL, NULL),
(43, 'ORD68bea064ccd7e', 'S1', 1, 65.00, '2025-09-13 12:00:00', 1),
(44, 'ORD68bea560b28f5', 'Cm3', 1, 150.00, NULL, NULL),
(45, 'ORD68bea6ba09c67', 'S1111111', 1, 1.00, '2025-09-19 12:00:00', 1),
(46, 'ORD68bea7c9a2092', 'S1111111', 1, 1.00, '2025-09-19 12:00:00', 1),
(47, 'ORD68bea83538125', 'S1111111', 1, 1.00, '2025-09-27 14:00:00', 1),
(48, 'ORD68bea85dcd658', 'SV1', 1, 22.00, NULL, NULL),
(49, 'ORD68bea87c7ced7', 'SV1', 1, 22.00, NULL, NULL),
(50, 'ORD68bea895f25ce', 'SV1', 1, 22.00, NULL, NULL),
(51, 'ORD68bea8b7cc1ac', 'SV1', 1, 22.00, NULL, NULL),
(52, 'ORD68bea8c207d30', 'SV1', 1, 22.00, NULL, NULL),
(53, 'ORD68bea8cccba4d', 'SV1', 1, 22.00, NULL, NULL),
(54, 'ORD68beb035c433e', 'S1', 1, 65.00, '2025-09-13 10:00:00', 1),
(55, 'ORD68bee4bbea909', 'S1', 1, 130.00, '2025-09-11 08:00:00', 2),
(56, 'ORD68bee5cd4ae23', 'S1', 1, 65.00, '2025-09-11 08:00:00', 1),
(57, 'ORD68c026b523cb9', 'S1', 1, 260.00, '2025-09-12 12:00:00', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id_prenotazioni` int(10) UNSIGNED NOT NULL,
  `prodotto_id` varchar(255) NOT NULL,
  `utente_cf` varchar(64) NOT NULL,
  `start_date` datetime NOT NULL,
  `durata` int(4) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`id_prenotazioni`, `prodotto_id`, `utente_cf`, `start_date`, `durata`, `note`) VALUES
(1, 'S1', 'MRMAE23491', '2025-09-10 10:00:00', 3, NULL),
(2, 'S1', 'MRMAE23491', '2025-09-11 08:00:00', 1, 'Ordine ORD68bee5cd4ae23'),
(3, 'S1', 'MRMAE23491', '2025-09-12 12:00:00', 4, 'Ordine ORD68c026b523cb9');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `Prodotto_id` varchar(255) NOT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT 0,
  `Prodotto_prezzo` decimal(7,2) NOT NULL,
  `Prodotto_immagine` varchar(255) DEFAULT NULL,
  `Prodotto_descrizione` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`Prodotto_id`, `hot`, `Prodotto_prezzo`, `Prodotto_immagine`, `Prodotto_descrizione`) VALUES
('C3', 1, 850.00, 'https://www.artandmusicstudios.com/wp-content/uploads/2019/12/Mix-Master.png', 'Lezione collettiva da 3 ore sull\'arte del Mix&master'),
('Cm3', 0, 150.00, 'https://www.cinematographe.it/wp-content/uploads/2015/01/Film-Music.jpg', 'Come comporre colonne sonore per il cinema. Rapporto tra emozione, immagine e suono.'),
('S1', 0, 65.00, 'https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg', 'Questa sala offre un ambiente accogliente e versatile, perfetto per band e musicisti. Dotata di una batteria acustica di qualità e amplificatori per chitarre, è ideale per registrazioni dal vivo.'),
('S1111111', 0, 1.00, 'https://www.audioitalia.net/wp-content/uploads/2024/09/Studio-di-registrazione.jpg', 'sala temp'),
('S2', 0, 56.00, 'https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg', 'Una sala spaziosa e moderna pensata per band e musicisti. Offre uno spazio ideale per sessioni di registrazione di gruppo, con un mix tra comfort e funzionalità tecnica.test'),
('SV1', 0, 22.00, 'https://static.wixstatic.com/media/11062b_2996c6170ffb4b1d929439162f981ce3~mv2.jpg', 'Una volta ciaooooooooneeeeeeeeee');

-- --------------------------------------------------------

--
-- Struttura della tabella `sala`
--

CREATE TABLE `sala` (
  `Sala_capienza` int(11) DEFAULT NULL,
  `Prodotto_id` varchar(255) NOT NULL,
  `Sala_Tipo` varchar(32) DEFAULT NULL,
  `Sala_Nome` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sala`
--

INSERT INTO `sala` (`Sala_capienza`, `Prodotto_id`, `Sala_Tipo`, `Sala_Nome`) VALUES
(5, 'S1', 'Sala registrazione', 'Lumen'),
(2, 'S1111111', 'Sala prove', 'Sala temp'),
(100, 'S2', 'Sala registrazione', 'Arcadia');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizio`
--

CREATE TABLE `servizio` (
  `Servizio_Operatore_Cognome` varchar(32) DEFAULT NULL,
  `Prodotto_id` varchar(255) NOT NULL,
  `Servizio_Tipo` varchar(32) DEFAULT NULL,
  `Servizio_Operatore_Nome` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` (`Servizio_Operatore_Cognome`, `Prodotto_id`, `Servizio_Tipo`, `Servizio_Operatore_Nome`) VALUES
('Lucarini', 'SV1', 'Mix', 'Pietro');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `U_cf` varchar(16) NOT NULL,
  `U_mail` varchar(50) NOT NULL,
  `U_password` varchar(255) NOT NULL,
  `U_nome` varchar(32) NOT NULL,
  `U_cognome` varchar(32) NOT NULL,
  `U_tipo` varchar(32) NOT NULL,
  `U_data_di_nascita` date NOT NULL,
  `U_telefono` varchar(32) DEFAULT NULL,
  `U_stato` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`U_cf`, `U_mail`, `U_password`, `U_nome`, `U_cognome`, `U_tipo`, `U_data_di_nascita`, `U_telefono`, `U_stato`) VALUES
('AAAAAAAAA', 'admin@gmail.com', '123', 'admin', 'admin', 'admin', '1990-03-02', '33333333', 'attivo'),
('MRMAE23491', 'marco@unimi.it', '123', 'Marco', 'Mesiti', 'cliente', '1984-02-16', '3212245765', 'attivo'),
('SSSSSSSSS', 'sara@unimi.it', '123', 'Sara', 'Saretti', 'proprietario', '1999-01-02', '3985574432', 'attivo');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`Prodotto_id`,`U_cf`),
  ADD KEY `U_cf` (`U_cf`);

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utente_id` (`utente_id`),
  ADD KEY `prodotto_id` (`prodotto_id`);

--
-- Indici per le tabelle `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`Ordine_id`,`Prodotto_id`),
  ADD KEY `Prodotto_id` (`Prodotto_id`);

--
-- Indici per le tabelle `corso`
--
ALTER TABLE `corso`
  ADD PRIMARY KEY (`Prodotto_id`);

--
-- Indici per le tabelle `modifica`
--
ALTER TABLE `modifica`
  ADD PRIMARY KEY (`Prodotto_id`,`U_cf`),
  ADD KEY `U_cf` (`U_cf`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`Ordine_id`),
  ADD KEY `cf_cliente` (`cf_cliente`);

--
-- Indici per le tabelle `ordine_prodotto`
--
ALTER TABLE `ordine_prodotto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordine_id` (`ordine_id`),
  ADD KEY `prodotto_id` (`prodotto_id`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazioni`),
  ADD KEY `prodotti_fk` (`prodotto_id`),
  ADD KEY `utente_fk` (`utente_cf`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`Prodotto_id`);

--
-- Indici per le tabelle `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`Prodotto_id`);

--
-- Indici per le tabelle `servizio`
--
ALTER TABLE `servizio`
  ADD PRIMARY KEY (`Prodotto_id`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`U_cf`),
  ADD UNIQUE KEY `U_mail` (`U_mail`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commenti`
--
ALTER TABLE `commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT per la tabella `ordine_prodotto`
--
ALTER TABLE `ordine_prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazioni` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`U_cf`) REFERENCES `utente` (`U_cf`) ON DELETE CASCADE;

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utente` (`U_cf`) ON DELETE CASCADE,
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`Ordine_id`) REFERENCES `ordine` (`Ordine_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`);

--
-- Limiti per la tabella `corso`
--
ALTER TABLE `corso`
  ADD CONSTRAINT `corso_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `modifica`
--
ALTER TABLE `modifica`
  ADD CONSTRAINT `modifica_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`),
  ADD CONSTRAINT `modifica_ibfk_2` FOREIGN KEY (`U_cf`) REFERENCES `utente` (`U_cf`);

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`cf_cliente`) REFERENCES `utente` (`U_cf`);

--
-- Limiti per la tabella `ordine_prodotto`
--
ALTER TABLE `ordine_prodotto`
  ADD CONSTRAINT `ordine_prodotto_ibfk_1` FOREIGN KEY (`ordine_id`) REFERENCES `ordine` (`Ordine_id`),
  ADD CONSTRAINT `ordine_prodotto_ibfk_2` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`);

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prodotti_fk` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`),
  ADD CONSTRAINT `utente_fk` FOREIGN KEY (`utente_cf`) REFERENCES `utente` (`U_cf`);

--
-- Limiti per la tabella `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `sala_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `servizio`
--
ALTER TABLE `servizio`
  ADD CONSTRAINT `servizio_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
