CREATE DATABASE IF NOT EXISTS lista_sarcini;

USE lista_sarcini;

CREATE TABLE IF NOT EXISTS sarcini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titlu VARCHAR(255) NOT NULL,         
    descriere TEXT NOT NULL,             
    deadline DATE NOT NULL,              
    completata TINYINT(1) DEFAULT 0     
);

CREATE TABLE IF NOT EXISTS utilizatori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);


---------------------user si parola------------------
INSERT INTO utilizatori (username, password, role) 
VALUES ('Admin', PASSWORD('proiectfloreasebastian'), 'admin');
