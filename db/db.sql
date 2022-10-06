
create database IF NOT EXISTS vcs;

use vcs;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS ip;

CREATE TABLE users(
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(255),
    PRIMARY KEY (id)
);
CREATE TABLE ip(
    id int NOT NULL AUTO_INCREMENT,
    ip varchar(15) NOT NULL,
    username varchar(255),
    PRIMARY KEY (id)
);
