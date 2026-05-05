CREATE DATABASE IF NOT EXISTS a22alemanrey_Incidencies;
USE a22alemanrey_Incidencies;


DROP TABLE IF EXISTS ACTUACIO;
DROP TABLE IF EXISTS INCIDENCIA;
DROP TABLE IF EXISTS TECNIC;
DROP TABLE IF EXISTS LOG_ACCES;
DROP TABLE IF EXISTS USUARI;
DROP TABLE IF EXISTS DEPARTAMENT;

CREATE TABLE DEPARTAMENT (
    id_departament INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);


CREATE TABLE USUARI (
    id_usuari INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);


CREATE TABLE TECNIC (
    id_tecnic INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT NOT NULL,
    especialitat VARCHAR(100),

    FOREIGN KEY (id_usuari)
        REFERENCES USUARI(id_usuari)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE INCIDENCIA (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    id_departament INT NOT NULL,
    id_usuari INT NOT NULL,
    id_tecnic INT NULL,

    data_creacio DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcio VARCHAR(255) NOT NULL,

    estat VARCHAR(50) DEFAULT 'oberta',
    prioritat VARCHAR(50),

    data_finalitzacio DATETIME NULL,

    FOREIGN KEY (id_departament)
        REFERENCES DEPARTAMENT(id_departament)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    FOREIGN KEY (id_usuari)
        REFERENCES USUARI(id_usuari)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (id_tecnic)
        REFERENCES TECNIC(id_tecnic)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


CREATE TABLE ACTUACIO (
    id_actuacio INT AUTO_INCREMENT PRIMARY KEY,
    id_incidencia INT NOT NULL,
    id_tecnic INT NOT NULL,

    data_actuacio DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcio TEXT NOT NULL,
    temps_dedicat INT NOT NULL,
    visible_usuari BOOLEAN DEFAULT TRUE,

    FOREIGN KEY (id_incidencia)
        REFERENCES INCIDENCIA(id_incidencia)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (id_tecnic)
        REFERENCES TECNIC(id_tecnic)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE LOG_ACCES (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT NOT NULL,
    pagina VARCHAR(100) NOT NULL,
    data_acces DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuari)
        REFERENCES USUARI(id_usuari)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


ALTER TABLE INCIDENCIA
ADD CONSTRAINT chk_estat
CHECK (estat IN ('oberta', 'en_proces', 'tancada'));

ALTER TABLE INCIDENCIA
ADD CONSTRAINT chk_prioritat
CHECK (prioritat IN ('alta', 'mitjana', 'baixa'));