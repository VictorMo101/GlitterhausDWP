DROP DATABASE IF EXISTS GlimmerHausDB;
CREATE DATABASE GlimmerHausDB CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE GlimmerHausDB;

CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    passwordHash VARCHAR(255) NOT NULL,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE ageRatings (
    ageRatingId INT AUTO_INCREMENT PRIMARY KEY,
    rating VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO ageRatings (rating)
VALUES
('G'),
('PG'),
('PG-13'),
('R'),
('NC-17');

CREATE TABLE genres (
    genreId INT AUTO_INCREMENT PRIMARY KEY,
    genreName VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO genres (genreName)
VALUES
('Action'),
('Adventure'),
('Animation'),
('Comedy'),
('Crime'),
('Documentary'),
('Drama'),
('Fantasy'),
('Horror'),
('Mystery'),
('Romance'),
('Science Fiction'),
('Thriller'),
('Western');

CREATE TABLE movies (
    movieId INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    durationMinutes INT NOT NULL,
    ageRatingId INT,
    posterUrl VARCHAR(2048),
    isActive BOOLEAN NOT NULL DEFAULT TRUE,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ageRatingId) REFERENCES ageRatings(ageRatingId) ON DELETE RESTRICT
);

CREATE TABLE movieGenres (
    movieId INT NOT NULL,
    genreId INT NOT NULL,
    PRIMARY KEY (movieId, genreId),
    FOREIGN KEY (movieId) REFERENCES movies(movieId) ON DELETE CASCADE,
    FOREIGN KEY (genreId) REFERENCES genres(genreId) ON DELETE RESTRICT
);

CREATE TABLE auditoriumTypes (
    auditoriumTypeId INT AUTO_INCREMENT PRIMARY KEY,
    auditoriumTypeName VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO auditoriumTypes (auditoriumTypeName)
VALUES
('small'),
('medium'),
('large');

CREATE TABLE auditoriums (
    auditoriumId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    auditoriumTypeId INT NOT NULL,
    FOREIGN KEY (auditoriumTypeId) REFERENCES auditoriumTypes(auditoriumTypeId) ON DELETE RESTRICT
);

INSERT INTO auditoriums (name, auditoriumTypeId)
VALUES
('Small 1', 1),
('Small 2', 1),
('Medium 1', 2),
('Medium 2', 2),
('Large 1', 3),
('Large 2', 3);

CREATE TABLE seats (
    seatId INT AUTO_INCREMENT PRIMARY KEY,
    auditoriumId INT NOT NULL,
    rowLabel VARCHAR(5) NOT NULL,
    seatNumber INT NOT NULL,
    UNIQUE (auditoriumId, rowLabel, seatNumber),
    UNIQUE (seatId, auditoriumId),
    FOREIGN KEY (auditoriumId) REFERENCES auditoriums(auditoriumId) ON DELETE RESTRICT
);

CREATE TABLE screenings (
    screeningId INT AUTO_INCREMENT PRIMARY KEY,
    movieId INT NOT NULL,
    auditoriumId INT NOT NULL,
    startsAt DATETIME NOT NULL,
    endsAt DATETIME NOT NULL,
    ticketPrice DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (movieId) REFERENCES movies(movieId) ON DELETE RESTRICT,
    FOREIGN KEY (auditoriumId) REFERENCES auditoriums(auditoriumId) ON DELETE RESTRICT,
    UNIQUE (auditoriumId, startsAt),
    UNIQUE (screeningId, auditoriumId)
);

CREATE TABLE bookings (
    bookingId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    screeningId INT NOT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    totalPrice DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE RESTRICT,
    FOREIGN KEY (screeningId) REFERENCES screenings(screeningId) ON DELETE RESTRICT,
    UNIQUE (bookingId, screeningId)
);

CREATE TABLE bookingSeats (
    bookingSeatId INT AUTO_INCREMENT PRIMARY KEY,
    bookingId INT NOT NULL,
    screeningId INT NOT NULL,
    seatId INT NOT NULL,
    auditoriumId INT NOT NULL,
    priceAtBooking DECIMAL(8,2) NOT NULL,
    UNIQUE (screeningId, seatId),
    FOREIGN KEY (bookingId, screeningId) REFERENCES bookings(bookingId, screeningId) ON DELETE RESTRICT,
    FOREIGN KEY (screeningId, auditoriumId) REFERENCES screenings(screeningId, auditoriumId) ON DELETE RESTRICT,
    FOREIGN KEY (seatId, auditoriumId) REFERENCES seats(seatId, auditoriumId) ON DELETE RESTRICT
);