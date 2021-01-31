CREATE TABLE users(
    idUser INT PRIMARY KEY AUTO_INCREMENT,
    userName TINYTEXT UNIQUE,
    passwordUser TINYTEXT
);

CREATE TABLE passwords ( 
    `idPassword` INT NOT NULL AUTO_INCREMENT , 
    `idUser` INT NOT NULL , 
    `provider` TINYTEXT NOT NULL , 
    `user` TINYTEXT NOT NULL , 
    `passwordUser` TINYTEXT NOT NULL , 
    PRIMARY KEY (`idPassword`),
    FOREIGN KEY (idUser) REFERENCES users(idUser) ON DELETE CASCADE ON UPDATE CASCADE
);