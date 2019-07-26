CREATE TABLE machines
(
    name varchar(20),
    os varchar(20),
    status varchar(20),
    type varchar(20),
    comment varchar(100),
    port int
);

INSERT INTO machines VALUES 
    (
        'Machine1', 
        'Windows', 
        'Off', 
        'VM', 
        'Ceci est la machine 1', 
        1755
    );

DELETE FROM machines where name = 'Machine2';