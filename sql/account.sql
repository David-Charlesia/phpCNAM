CREATE DATABASE IF NOT EXISTS accountPHPCNAM CHARACTER SET utf8;

USE accountPHPCNAM;

CREATE TABLE IF NOT EXISTS accountPHPCNAM(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    pwd VARCHAR(100) NOT NULL,
    privilege INT(6) NOT NULL
);

INSERT INTO accountPHPCNAM (pseudo,email,pwd,privilege)VALUES(
    'admin',
    'admin@superuser.com',
    'admin',
    1
);