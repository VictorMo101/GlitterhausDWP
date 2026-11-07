<?php

class MovieController {
    private $movie;

    public function __construct($movie) {
        $this->movie = $movie;
    }

    public function home() {
        $movies = $this->movie->getActiveMovies();
        require __DIR__ . '/../views/home.php';
    }

    public function movieDetails() {
        $movieId = filter_input(INPUT_GET, 'movieId', FILTER_VALIDATE_INT);
        $movie = $movieId ? $this->movie->getActiveMovieById($movieId) : false;
        $screenings = $movie ? $this->movie->getScreeningsByMovieId($movieId) : [];

        if (!$movie) {
            http_response_code(404);
        }

        require __DIR__ . '/../views/movieDetails.php';
    }
}
