/* Création de tables */
CREATE TABLE machines
(
    name varchar(20),
    os varchar(20),
    status varchar(20),
    type varchar(20),
    comment varchar(100),
    port int
);
/* insertion dans une table */
INSERT INTO machines VALUES 
    (
        'Machine1', 
        'Windows', 
        'Off', 
        'VM', 
        'Ceci est la machine 1', 
        1755
    );
/* suppréssion d'un champs */
DELETE FROM machines where name = 'Machine2';