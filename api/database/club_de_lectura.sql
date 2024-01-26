-- Create the database
CREATE DATABASE club_de_lectura_db;
USE club_de_lectura_db;

-- Create the Users table
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name_user VARCHAR(50),
    email_user VARCHAR(100),
    password_user VARCHAR(255)
);

-- Create the Books table
CREATE TABLE books (
    id_book INT AUTO_INCREMENT PRIMARY KEY,
    title_book VARCHAR(100),
    id_author_book INT,
    year_publication_book INT,
    genre_book VARCHAR(50)
);

ALTER TABLE books ADD CONSTRAINT fk_author_book FOREIGN KEY (id_author_book) REFERENCES authors(id_author);

-- Create the Authors table
CREATE TABLE authors (
    id_author INT AUTO_INCREMENT PRIMARY KEY,
    name_author VARCHAR(100),
    bio_author TEXT,
    link_author VARCHAR(255)
);

-- Create the Comments table
CREATE TABLE comments (
    id_comment INT AUTO_INCREMENT PRIMARY KEY,
    id_book_comment INT,
    id_user_comment INT,
    content_comment TEXT,
    date_publication_comment TIMESTAMP
);

ALTER TABLE comments ADD CONSTRAINT fk_book_comment FOREIGN KEY (id_book_comment) REFERENCES books(id_book);
ALTER TABLE comments ADD CONSTRAINT fk_user_comment FOREIGN KEY (id_user_comment) REFERENCES users(id_user);
-- ALTER TABLE comments
-- ADD COLUMN  date_publication_comment TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Create the Ratings table
CREATE TABLE ratings (
    id_rating INT AUTO_INCREMENT PRIMARY KEY,
    id_book_rating INT,
    id_user_rating INT,
    score_rating INT
);
ALTER TABLE ratings ADD CONSTRAINT fk_book_rating FOREIGN KEY (id_book_rating) REFERENCES books(id_book);
ALTER TABLE ratings ADD CONSTRAINT fk_user_rating FOREIGN KEY (id_user_rating) REFERENCES users(id_user);


-- Create the Friendship table
CREATE TABLE private (
    id_private INT AUTO_INCREMENT PRIMARY KEY,
    id_sender_user_private INT,
    id_receiver_user_private INT,
    message_private VARCHAR(255),
    read_private BOOLEAN,
    CONSTRAINT fk_sender_user_private FOREIGN KEY (id_sender_user_private) REFERENCES users(id_user),
    CONSTRAINT fk_receiver_user_private FOREIGN KEY (id_receiver_user_private) REFERENCES users(id_user)
);
