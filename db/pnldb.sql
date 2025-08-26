-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 13, 2025 alle 20:10
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

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`data_prenotazione`, `durata_prenotazione`, `C_quantità`, `Prodotto_id`, `U_cf`) VALUES
(NULL, NULL, 2, 'Cm3', 'MRMAE23491');

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
(24, 'MRMAE23491', 'C3', 'AAAAAAAAAAA', 5, '2025-08-13 18:09:59');

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
  `N_Iscritti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`Prodotto_id`, `Corso_Nome`, `Corso_Operatore_Nome`, `Corso_Operatore_Cognome`, `Corso_Data`, `N_Iscritti`) VALUES
('C3', 'Corso di Mix&Master', 'Giancarlo', 'Piro', '21/09/2025', 1),
('Cm3', 'Soundtrack Crafting', 'Ginevra', 'Morselli', '2025-02-14', 1);

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
('ORD6819e36880689', 'MRMAE23491', '2025-05-06 00:00:00', 'In elaborazione'),
('ORD6819e44472e03', 'MRMAE23491', '2025-05-06 12:28:20', 'Annullato'),
('ORD681a2e29c1fe6', 'MRMAE23491', '2025-05-06 17:43:37', 'Annullato'),
('ORD681a2e8b81394', 'MRMAE23491', '2025-05-06 17:45:15', 'In elaborazione'),
('ORD681a3121a29bf', 'MRMAE23491', '2025-05-06 17:56:17', 'In elaborazione'),
('ORD681a315269bc6', 'MRMAE23491', '2025-05-06 17:57:06', 'In elaborazione'),
('ORD681a31758f749', 'MRMAE23491', '2025-05-06 17:57:41', 'In elaborazione');

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
(13, 'ORD681a31758f749', 'S2', 1, 56.00, NULL, NULL);

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
('C3', 0, 850.00, 'https://www.artandmusicstudios.com/wp-content/uploads/2019/12/Mix-Master.png', 'Lezione collettiva da 3 ore sull\'arte del Mix&master'),
('Cm3', 0, 150.00, 'https://www.cinematographe.it/wp-content/uploads/2015/01/Film-Music.jpg', 'Come comporre colonne sonore per il cinema. Rapporto tra emozione, immagine e suono.'),
('S1', 0, 65.00, 'https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg', 'Questa sala offre un ambiente accogliente e versatile, perfetto per band e musicisti. Dotata di una batteria acustica di qualità e amplificatori per chitarre, è ideale per registrazioni dal vivo.'),
('S2', 0, 56.00, 'https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg', 'Una sala spaziosa e moderna pensata per band e musicisti. Offre uno spazio ideale per sessioni di registrazione di gruppo, con un mix tra comfort e funzionalità tecnica.test'),
('SV1', 0, 22.00, 'https://static.wixstatic.com/media/11062b_2996c6170ffb4b1d929439162f981ce3~mv2.jpg', 'Una volta acquistato il numero di Mix che desideri, ci metteremo in contatto con te per realizzare il tuo progetto. MIIIIIIIIIXXXX');

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
('Lucarini', 'SV1', 'Mix', 'Pietro GAY');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `ordine_prodotto`
--
ALTER TABLE `ordine_prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
