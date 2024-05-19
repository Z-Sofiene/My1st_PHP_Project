DROP TABLE IF EXISTS Admin ;
DROP TABLE IF EXISTS Conge;
DROP TABLE IF EXISTS Personnel;
CREATE TABLE IF NOT EXISTS Personnel (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50),
            prenom VARCHAR(50),
            login VARCHAR(50),
            password VARCHAR(255),
            solde_conge INT
        );
CREATE TABLE IF NOT EXISTS Conge (
            id INT AUTO_INCREMENT PRIMARY KEY,
            personnel_id INT,
            debut_conge DATE,
            fin_conge DATE,
            validConge BOOLEAN,
            FOREIGN KEY (personnel_id) REFERENCES Personnel(id) ON DELETE CASCADE
        );
CREATE TABLE IF NOT EXISTS Admin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50),
            prenom VARCHAR(50),
            login VARCHAR(50),
            password VARCHAR(255)
        );