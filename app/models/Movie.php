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
}
