-- 1. Tabella utente
CREATE TABLE `utente` (
  `U_cf` varchar(16) NOT NULL,
  `U_mail` varchar(50) NOT NULL,
  `U_password` varchar(255) NOT NULL,
  `U_nome` varchar(32) NOT NULL,
  `U_cognome` varchar(32) NOT NULL,
  `U_tipo` varchar(32) NOT NULL,
  `U_data_di_nascita` date NOT NULL,
  `U_telefono` varchar(32) DEFAULT NULL,
  `U_stato` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`U_cf`),
  UNIQUE KEY `U_mail` (`U_mail`)
);

-- 2. Tabella prodotto
CREATE TABLE `prodotto` (
  `Prodotto_id` varchar(20) NOT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT 0,
  `Prodotto_prezzo` decimal(7,2) NOT NULL,
  `Prodotto_immagine` varchar(255) DEFAULT NULL,
  `Prodotto_descrizione` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`Prodotto_id`)
);

-- 3. Tabella ordine
CREATE TABLE `ordine` (
  `Ordine_id` varchar(16) NOT NULL,
  `cf_cliente` varchar(16) DEFAULT NULL,
  `Data_ordine` datetime DEFAULT NULL,
  `stato` varchar(50) DEFAULT 'in elaborazione',
  PRIMARY KEY (`Ordine_id`),
  KEY `cf_cliente` (`cf_cliente`),
  CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`cf_cliente`) REFERENCES `utente` (`U_cf`)
);

-- 4. Tabella carrello
CREATE TABLE `carrello` (
  `data_prenotazione` datetime DEFAULT NULL,
  `durata_prenotazione` int(11) DEFAULT NULL,
  `C_quantità` int(11) DEFAULT NULL,
  `Prodotto_id` varchar(20) NOT NULL,
  `U_cf` varchar(16) NOT NULL,
  PRIMARY KEY (`Prodotto_id`,`U_cf`),
  KEY `U_cf` (`U_cf`),
  CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE,
  CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`U_cf`) REFERENCES `utente` (`U_cf`) ON DELETE CASCADE
);

-- 5. Tabella commenti
CREATE TABLE `commenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utente_id` varchar(16) NOT NULL,
  `prodotto_id` varchar(20) NOT NULL,
  `messaggio` text NOT NULL,
  `punteggio` tinyint(3) unsigned NOT NULL CHECK (`punteggio` between 0 and 5),
  `data_commento` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `utente_id` (`utente_id`),
  KEY `prodotto_id` (`prodotto_id`),
  CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utente` (`U_cf`) ON DELETE CASCADE,
  CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE
);

-- 6. Tabella contiene
CREATE TABLE `contiene` (
  `Ordine_id` varchar(16) NOT NULL,
  `Prodotto_id` varchar(20) NOT NULL,
  `Quantità_di_prodotto` int(11) DEFAULT NULL,
  PRIMARY KEY (`Ordine_id`,`Prodotto_id`),
  KEY `Prodotto_id` (`Prodotto_id`),
  CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`Ordine_id`) REFERENCES `ordine` (`Ordine_id`) ON DELETE CASCADE,
  CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`)
);

-- 7. Tabella corso
CREATE TABLE `corso` (
  `Prodotto_id` varchar(20) NOT NULL,
  `Corso_Nome` varchar(32) DEFAULT NULL,
  `Corso_Operatore_Nome` varchar(32) DEFAULT NULL,
  `Corso_Operatore_Cognome` varchar(32) DEFAULT NULL,
  `Corso_Data` varchar(32) DEFAULT NULL,
  `N_Iscritti` int(11) NOT NULL,
  `Max_Iscritti` int(4) NOT NULL DEFAULT 5,
  PRIMARY KEY (`Prodotto_id`),
  CONSTRAINT `corso_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE
);

-- 8. Tabella modifica
CREATE TABLE `modifica` (
  `Prodotto_id` varchar(20) NOT NULL,
  `U_cf` varchar(16) NOT NULL,
  `Tipo_modifica` varchar(128) DEFAULT NULL,
  `Data_di_modifica` date NOT NULL,
  PRIMARY KEY (`Prodotto_id`,`U_cf`),
  KEY `U_cf` (`U_cf`),
  CONSTRAINT `modifica_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`),
  CONSTRAINT `modifica_ibfk_2` FOREIGN KEY (`U_cf`) REFERENCES `utente` (`U_cf`)
);

-- 9. Tabella ordine_prodotto
CREATE TABLE `ordine_prodotto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordine_id` varchar(16) DEFAULT NULL,
  `prodotto_id` varchar(20) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  `prezzo_unitario` decimal(10,2) DEFAULT NULL,
  `data_prenotazione` datetime DEFAULT NULL,
  `durata_prenotazione` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordine_id` (`ordine_id`),
  KEY `prodotto_id` (`prodotto_id`),
  CONSTRAINT `ordine_prodotto_ibfk_1` FOREIGN KEY (`ordine_id`) REFERENCES `ordine` (`Ordine_id`),
  CONSTRAINT `ordine_prodotto_ibfk_2` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`)
);

-- 10. Tabella prenotazioni
CREATE TABLE `prenotazioni` (
  `id_prenotazioni` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prodotto_id` varchar(20) NOT NULL,
  `utente_cf` varchar(16) NOT NULL,
  `start_date` datetime NOT NULL,
  `durata` int(4) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_prenotazioni`),
  KEY `prodotti_fk` (`prodotto_id`),
  KEY `utente_fk` (`utente_cf`),
  CONSTRAINT `prodotti_fk` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`),
  CONSTRAINT `utente_fk` FOREIGN KEY (`utente_cf`) REFERENCES `utente` (`U_cf`)
);

-- 11. Tabella sala
CREATE TABLE `sala` (
  `Sala_capienza` int(11) DEFAULT NULL,
  `Prodotto_id` varchar(20) NOT NULL,
  `Sala_Tipo` varchar(32) DEFAULT NULL,
  `Sala_Nome` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Prodotto_id`),
  CONSTRAINT `sala_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE
);

-- 12. Tabella servizio
CREATE TABLE `servizio` (
  `Servizio_Operatore_Cognome` varchar(32) DEFAULT NULL,
  `Prodotto_id` varchar(20) NOT NULL,
  `Servizio_Tipo` varchar(32) DEFAULT NULL,
  `Servizio_Operatore_Nome` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Prodotto_id`),
  CONSTRAINT `servizio_ibfk_1` FOREIGN KEY (`Prodotto_id`) REFERENCES `prodotto` (`Prodotto_id`) ON DELETE CASCADE
);
