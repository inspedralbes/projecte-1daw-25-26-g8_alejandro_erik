

CREATE TABLE DEPARTAMENT (
    id_departament INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);



CREATE TABLE TECNIC (
    id_tecnic INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)


);


CREATE TABLE INCIDENCIA (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    id_departament INT NOT NULL,
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
   
    pagina VARCHAR(100) NOT NULL,
    data_acces DATETIME DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE INCIDENCIA
ADD CONSTRAINT chk_estat
CHECK (estat IN ('oberta', 'en_proces', 'tancada'));

ALTER TABLE INCIDENCIA
ADD CONSTRAINT chk_prioritat
CHECK (prioritat IN ('alta', 'mitjana', 'baixa'));