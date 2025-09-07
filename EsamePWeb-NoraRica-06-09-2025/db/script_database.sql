CREATE DATABASE pnldb;
USE pnldb;

CREATE TABLE UTENTE (

    U_cf VARCHAR(16) PRIMARY KEY,
    U_mail VARCHAR(50) NOT NULL UNIQUE,
    U_password VARCHAR(255) NOT NULL,
    U_nome VARCHAR (32) NOT NULL,
    U_cognome VARCHAR (32) NOT NULL,
    U_tipo VARCHAR(32) NOT NULL,
    U_data_di_nascita DATE NOT NULL,
    U_telefono VARCHAR(32),
    U_stato VARCHAR(16)

);

CREATE TABLE PRODOTTO(

    Prodotto_id VARCHAR(255) PRIMARY KEY,
    Prodotto_prezzo DECIMAL (7, 2) NOT NULL,
    Prodotto_immagine VARCHAR(255), 
    Prodotto_descrizione VARCHAR (1000),
    hot TINYINT(1) NOT NULL

);

CREATE TABLE SALA (

    Sala_Tipo VARCHAR (32),
    Sala_Nome VARCHAR (32),
    Sala_capienza INT(20),
    Prodotto_id VARCHAR(255) PRIMARY KEY,
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id)

);

CREATE TABLE SERVIZIO (

    Servizio_Tipo VARCHAR(32),
    Servizio_Operatore_Nome VARCHAR(32),
    Servizio_Operatore_Cognome VARCHAR(32),
    Prodotto_id VARCHAR(255) PRIMARY KEY,
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id)

);

CREATE TABLE CORSI (

    Corsi_Nome VARCHAR(32),
    Corso_Operatore_Nome VARCHAR(32),
    Corso_Operatore_Cognome VARCHAR(32),
    Corso_Data VARCHAR(32),
    Prodotto_id VARCHAR(255) PRIMARY KEY,
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id)

);

CREATE TABLE MODIFICA (

    Prodotto_id VARCHAR(255),
    U_cf VARCHAR(16),
    Tipo_modifica VARCHAR (128),
    Data_di_modifica DATE NOT NULL,
    PRIMARY KEY (Prodotto_id, U_cf),
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id),
    FOREIGN KEY (U_cf) REFERENCES UTENTE(U_cf)

);

CREATE TABLE CARRELLO (

    C_quantità INT (100),
    Prodotto_id VARCHAR(255),
    U_cf VARCHAR(16),
    PRIMARY KEY (Prodotto_id, U_cf),
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id),
    FOREIGN KEY (U_cf) REFERENCES UTENTE(U_cf)

);

CREATE TABLE ORDINE (

    Ordine_id VARCHAR (255) PRIMARY KEY,
    Data_ordine DATE NOT NULL,
    cf_cliente VARCHAR (16) NOT NULL,
    FOREIGN KEY (cf_cliente) REFERENCES UTENTE(U_cf)
);

CREATE TABLE CONTIENE (

    Ordine_id VARCHAR(255),
    Prodotto_id VARCHAR(255),
    Quantità_di_prodotto INT(100),
    PRIMARY KEY (Ordine_id, Prodotto_id),
    FOREIGN KEY (Ordine_id) REFERENCES ORDINE(Ordine_id),
    FOREIGN KEY (Prodotto_id) REFERENCES PRODOTTO(Prodotto_id)

);
