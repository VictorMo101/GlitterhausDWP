<?php

class Movie {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getActiveMovies() {
        $query = "SELECT movieId, title, description, durationMinutes, posterUrl,
                         ageRatings.rating AS ageRating
                  FROM movies
                  LEFT JOIN ageRatings ON ageRatings.ageRatingId = movies.ageRatingId
                  WHERE movies.isActive = 1
                  ORDER BY movies.title";
        $statement = $this->connection->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveMovieById($movieId) {
        $query = "SELECT movieId, title, description, durationMinutes, posterUrl,
                         ageRatings.rating AS ageRating
                  FROM movies
                  LEFT JOIN ageRatings ON ageRatings.ageRatingId = movies.ageRatingId
                  WHERE movies.movieId = :movieId AND movies.isActive = 1";
        $statement = $this->connection->prepare($query);
        $statement->execute(['movieId' => $movieId]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getScreeningsByMovieId($movieId) {
        $query = "SELECT screeningId, startsAt, endsAt, ticketPrice,
                         auditoriums.name AS auditoriumName
                  FROM screenings
                  INNER JOIN auditoriums ON auditoriums.auditoriumId = screenings.auditoriumId
                  WHERE screenings.movieId = :movieId
                  ORDER BY screenings.startsAt";
        $statement = $this->connection->prepare($query);
        $statement->execute(['movieId' => $movieId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getScreeningSeats($screeningId) {
        $query = "SELECT screenings.screeningId, screenings.movieId, screenings.startsAt,
                         screenings.endsAt, screenings.ticketPrice,
                         movies.title, auditoriums.name AS auditoriumName,
                         seats.seatId, seats.rowLabel, seats.seatNumber,
                         bookingSeats.seatId IS NOT NULL AS isBooked
                  FROM screenings
                  INNER JOIN movies ON movies.movieId = screenings.movieId
                  INNER JOIN auditoriums ON auditoriums.auditoriumId = screenings.auditoriumId
                  INNER JOIN seats ON seats.auditoriumId = screenings.auditoriumId
                  LEFT JOIN bookingSeats
                      ON bookingSeats.screeningId = screenings.screeningId
                      AND bookingSeats.seatId = seats.seatId
                  WHERE screenings.screeningId = :screeningId
                  ORDER BY seats.rowLabel, seats.seatNumber";
        $statement = $this->connection->prepare($query);
        $statement->execute(['screeningId' => $screeningId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
