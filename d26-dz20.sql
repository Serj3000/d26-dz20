show databases;

-- DROP DATABASE d26test_dz20;
-- CREATE database d26test_dz20;

use d26test_dz20;

-- create table categories (
-- id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
-- name VARCHAR(255),
-- slug VARCHAR(255),
-- created_at DATETIME,
-- updated_at DATETIME
-- );

-- INSERT INTO categories
-- (categorie,created_at,updated_at)
-- VALUE
-- ('Categorie 1','2019-07-30','2019-07-30'),
-- ('Categorie 2','2019-07-30','2019-07-30');

-- create table users (
-- id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
-- name VARCHAR(255),
-- email VARCHAR(255),
-- password VARCHAR(255),
-- remember_token VARCHAR(100),
-- created_at DATETIME,
-- updated_at DATETIME
-- );

select * from categories;
select * from posts;
select * from users;
