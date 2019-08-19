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

CREATE TABLE virtualmachines
(
    comment varchar(100),
    mac varchar(50),
    memory int,
    name varchar(20),
    status varchar(20),
    uuid varchar (100),
    vcpu int,
    vmid varchar (20) PRIMARY KEY,
    vmtype varchar (20),
    date_insert timestamp CURRENT_TIMESTAMP,
    date_update timestamp ON UPDATE CURRENT_TIMESTAMP 
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

