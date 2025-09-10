-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 10, 2025 alle 17:21
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS = 0;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pnldb`
--

--
-- Dump dei dati per la tabella `carrello`
--


-- 1. utente
INSERT INTO `utente` (`U_cf`, `U_mail`, `U_password`, `U_nome`, `U_cognome`, `U_tipo`, `U_data_di_nascita`, `U_telefono`, `U_stato`) VALUES
('AAAAAAAAA', 'admin@gmail.com', '123', 'admin', 'admin', 'admin', '1990-03-02', '33333333', 'attivo'),
('MRMAE23491', 'marco@unimi.it', '123', 'Marco', 'Mesiti', 'cliente', '1984-02-16', '3212245765', 'attivo'),
('SSSSSSSSS', 'sara@unimi.it', '123', 'Sara', 'Saretti', 'proprietario', '1999-01-02', '3985574432', 'attivo');

-- 2. prodotto
INSERT INTO `prodotto` (`Prodotto_id`, `hot`, `Prodotto_prezzo`, `Prodotto_immagine`, `Prodotto_descrizione`) VALUES
('C3', 1, 850.00, 'https://www.artandmusicstudios.com/wp-content/uploads/2019/12/Mix-Master.png', 'Lezione collettiva da 3 ore sull\'arte del Mix&master'),
('Cm3', 0, 150.00, 'https://www.cinematographe.it/wp-content/uploads/2015/01/Film-Music.jpg', 'Come comporre colonne sonore per il cinema. Rapporto tra emozione, immagine e suono.'),
('S1', 0, 65.00, 'https://www.musiclabstudio.com/wp-content/uploads/2019/03/costo-sala-prove-1024x768.jpg', 'Questa sala offre un ambiente accogliente e versatile, perfetto per band e musicisti. Dotata di una batteria acustica di qualità e amplificatori per chitarre, è ideale per registrazioni dal vivo.'),
('S1111111', 0, 1.00, 'https://www.audioitalia.net/wp-content/uploads/2024/09/Studio-di-registrazione.jpg', 'sala temp'),
('S2', 0, 56.00, 'https://www.sammusicstudios.it/images/Sala_Vintage_Sala_Prove.jpg', 'Una sala spaziosa e moderna pensata per band e musicisti. Offre uno spazio ideale per sessioni di registrazione di gruppo, con un mix tra comfort e funzionalità tecnica.test'),
('SV1', 0, 22.00, 'https://static.wixstatic.com/media/11062b_2996c6170ffb4b1d929439162f981ce3~mv2.jpg', 'Una volta ciaooooooooneeeeeeeeee');

-- 3. ordine
INSERT INTO `ordine` (`Ordine_id`, `cf_cliente`, `Data_ordine`, `stato`) VALUES
('ORD6819daba85829', 'MRMAE23491', '2025-05-06 00:00:00', 'Annullato'),
('ORD6819dce3e496d', 'MRMAE23491', '2025-05-06 00:00:00', 'Annullato'),
('ORD6819e36880689', 'MRMAE23491', '2025-05-06 00:00:00', 'Confermato');

-- 4. carrello
INSERT INTO `carrello` (`data_prenotazione`, `durata_prenotazione`, `C_quantità`, `Prodotto_id`, `U_cf`) VALUES
(NULL, NULL, 1, 'S1', 'MRMAE23491');

-- 5. commenti
INSERT INTO `commenti` (`id`, `utente_id`, `prodotto_id`, `messaggio`, `punteggio`, `data_commento`) VALUES
(4, 'MRMAE23491', 'Cm3', 'Yeeee', 2, '2025-04-23 20:51:19'),
(13, 'MRMAE23491', 'Cm3', 'Bella sala', 1, '2025-04-23 21:08:32');

-- 6. corso
INSERT INTO `corso` (`Prodotto_id`, `Corso_Nome`, `Corso_Operatore_Nome`, `Corso_Operatore_Cognome`, `Corso_Data`, `N_Iscritti`, `Max_Iscritti`) VALUES
('C3', 'Corso di Mix&Master', 'Giancarlo', 'Piro', '2025-09-21', 2, 5),
('Cm3', 'Soundtrack Crafting', 'Ginevra', 'Morselli', '2025-02-14', 3, 3);

-- 7. modifica
-- (nessun dato nel dump)

-- 8. prenotazioni
INSERT INTO `prenotazioni` (`id_prenotazioni`, `prodotto_id`, `utente_cf`, `start_date`, `durata`, `note`) VALUES
(1, 'S1', 'MRMAE23491', '2025-09-10 10:00:00', 3, NULL);

-- 9. sala
INSERT INTO `sala` (`Sala_capienza`, `Prodotto_id`, `Sala_Tipo`, `Sala_Nome`) VALUES
(5, 'S1', 'Sala registrazione', 'Lumen'),
(2, 'S1111111', 'Sala prove', 'Sala temp'),
(100, 'S2', 'Sala registrazione', 'Arcadia');

-- 10. servizio
INSERT INTO `servizio` (`Servizio_Operatore_Cognome`, `Prodotto_id`, `Servizio_Tipo`, `Servizio_Operatore_Nome`) VALUES
('Lucarini', 'SV1', 'Mix', 'Pietro');

-- 11. ordine_prodotto
INSERT INTO `ordine_prodotto` (`id`, `ordine_id`, `prodotto_id`, `quantita`, `prezzo_unitario`, `data_prenotazione`, `durata_prenotazione`) VALUES
(1, 'ORD6819daba85829', 'C3', 2, 850.00, NULL, NULL),
(2, 'ORD6819daba85829', 'Cm3', 1, 150.00, NULL, NULL),
(3, 'ORD6819daba85829', 'S1', 1, 65.00, NULL, NULL),
(4, 'ORD6819daba85829', 'S2', 1, 56.00, NULL, NULL),
(5, 'ORD6819dce3e496d', 'SV1', 9, 22.00, NULL, NULL),
(6, 'ORD6819e36880689', 'C3', 3, 850.00, NULL, NULL);

-- 12. contiene
-- (nessun dato nel dump)

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;