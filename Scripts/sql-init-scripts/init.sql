-- init.sql

USE saeldap;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(20),
    prenom VARCHAR(20),
    username VARCHAR(20) UNIQUE,
    mail VARCHAR(50) UNIQUE
);
