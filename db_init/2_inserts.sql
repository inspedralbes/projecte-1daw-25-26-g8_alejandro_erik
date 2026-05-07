INSERT INTO DEPARTAMENT (nom) VALUES
('Català'),
('Matemàtiques'),
('Informàtica'),
('Física'),
('Administració');

INSERT INTO TECNIC (nom) VALUES
('Ermengol Serra'),
('Joan Pujol'),
('Laia Vidal'),
('Marc Torrent'),
('Núria Costa');
INSERT INTO INCIDENCIA 
(id_departament, id_tecnic, descripcio, estat, prioritat, data_finalitzacio) 
VALUES
-- tancada
(1, 1, 'L’ordinador de l’aula no arrenca', 'tancada', 'alta', '2026-05-01 09:30:00'),

-- en procés
(2, 2, 'El programa de càlcul dona error constant', 'en_proces', 'mitjana', NULL),

-- oberta
(1, 1, 'Projector sense imatge a classe', 'oberta', 'alta', NULL),

-- tancada
(2, 2, 'Impressora de departament no respon', 'tancada', 'baixa', '2026-05-02 11:00:00'),

-- oberta sense assignar tècnic
(1, NULL, 'Internet molt lent a l’aula', 'oberta', 'alta', NULL);INSERT INTO ACTUACIO (id_incidencia, id_tecnic, descripcio, temps_dedicat) VALUES
(1, 1, 'Diagnòstic de la font d’alimentació', 30),
(1, 1, 'Substitució del cable d’alimentació', 40),
(1, 1, 'Prova final del sistema', 20);
INSERT INTO ACTUACIO (id_incidencia, id_tecnic, descripcio, temps_dedicat) VALUES
(2, 2, 'Revisió del software de matemàtiques', 25),
(2, 2, 'Reinstal·lació del programa', 35),
(2, 2, 'Proves amb dades reals', 30);

INSERT INTO ACTUACIO (id_incidencia, id_tecnic, descripcio, temps_dedicat) VALUES
(3, 1, 'Revisió del projector', 20),
(3, 1, 'Canvi de cable HDMI', 15),
(3, 1, 'Test de projecció', 10);