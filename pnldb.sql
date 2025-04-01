-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 20, 2024 alle 17:57
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
  `C_quantità` int(11) DEFAULT NULL,
  `Prodotto_id` varchar(255) NOT NULL,
  `U_cf` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `N_Lez` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`Prodotto_id`, `Corso_Nome`, `Corso_Operatore_Nome`, `Corso_Operatore_Cognome`, `Corso_Data`, `N_Lez`) VALUES
('C1', 'Corso di Canto (15 lezioni)', 'Claudio', 'Forte', '', 15),
('C2', 'Corso di Canto (30 lezioni)', 'Claudio', 'Forte', '', 30),
('C3', 'Corso di Mix&Master (15 lezioni)', 'Giancarlo', 'Piro', '', 15),
('C4', 'Corso di Mix&Master (30 lezioni)', 'Giancarlo', 'Piro', '', 30),
('Cm1', 'Beat Makinggggg', 'Giorgio', 'Parodi', '', 1),
('Cm2', 'Recording Vocals', 'Arianna', 'Vandelli', '2025-01-14', 1),
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
  `Data_ordine` date NOT NULL,
  `cf_cliente` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('C1', 1, 600.00, 'https://file.cure-naturali.it/site/image/hotspot_article_first/24008.jpg', '15 lezioni da un\'ora personalizzate e mirate ai tuoi obbiettivi nel canto.'),
('C2', 0, 900.00, 'https://file.cure-naturali.it/site/image/hotspot_article_first/24008.jpg', '30 lezioni da un\'ora personalizzate e mirate ai tuoi obbiettivi nel canto'),
('C3', 0, 850.00, 'https://www.artandmusicstudios.com/wp-content/uploads/2019/12/Mix-Master.png', '15 lezioni personalizzate da un\'ora sull\'arte del Mix&master'),
('C4', 0, 1360.00, 'https://www.artandmusicstudios.com/wp-content/uploads/2019/12/Mix-Master.png', '30 lezioni personalizzare da un\'ora e sull\'arte del Mix&master'),
('Cm1', 0, 150.00, 'https://audient.com/wp-content/uploads/2021/07/image1.jpg', 'Le basi del beat making per i generi hip-hop, trap e EDM.'),
('Cm2', 0, 150.00, 'https://media.istockphoto.com/id/635926346/it/foto/apparecchiature-di-registrazione-in-studio.jpg?s=612x612&w=0&k=20&c=DeBtSR6d2i3djlJOLgG-PqzGpikFNm4PD9tlzDJo1MY=', 'Diverse tecniche per la registrazione delle voci in studio.'),
('Cm3', 0, 150.00, 'https://www.cinematographe.it/wp-content/uploads/2015/01/Film-Music.jpg', 'Come comporre colonne sonore per il cinema. Rapporto tra emozione, immagine e suono.'),
('S1', 0, 65.00, 'https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg', 'Questa sala offre un ambiente accogliente e versatile, perfetto per band e musicisti. Dotata di una batteria acustica di qualità e amplificatori per chitarre, è ideale per registrazioni dal vivo.'),
('S2', 0, 55.00, 'https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg', 'Una sala spaziosa e moderna pensata per band e musicisti. Offre uno spazio ideale per sessioni di registrazione di gruppo, con un mix tra comfort e funzionalità tecnica.test'),
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
('36bcfuianq8', 'io@gmail.com', '1234', 'io', 'mitico', 'cliente', '0052-04-04', '456785679', 'attivo'),
('3y98241jhhjsja', 'igor.miti@gmail.com', '1234', 'igor', 'miti', 'cliente', '0057-04-12', '4567890', 'attivo'),
('53278hdsh', 'prop@gmail.com', 'mio', 'proprietario1', 'P1', 'proprietario', '0782-05-04', '3456788', 'attivo'),
('dgdwjkd787289', 'admin2@gmail.com', 'root', 'admin2', 'A2', 'admin', '0723-06-30', '567890878', 'attivo'),
('e5678nsjj', 'norarica@gmail.com', '12345', 'nora', 'rica', 'cliente', '0008-07-25', '5467890', 'attivo'),
('sddfhjkjk', 'admin@gmail.com', 'root', 'admin1', 'A1', 'admin', '0095-04-23', '3886945278', 'attivo'),
('wfkjnjnoicf', 'm.rossi@gmail.com', '123', 'Mario', 'Rossi', 'cliente', '0045-03-12', '3456789', 'attesa');

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
  ADD KEY `fk_ordine_cliente` (`cf_cliente`);

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
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`U_cf`) REFERENCES `utente` (`U_cf`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_ordine_cliente` FOREIGN KEY (`cf_cliente`) REFERENCES `utente` (`U_cf`);

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
