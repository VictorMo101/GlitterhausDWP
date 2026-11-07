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

        if (!$movie) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            exit;
        }

        $screenings = $this->movie->getScreeningsByMovieId($movieId);
        require __DIR__ . '/../views/movieDetails.php';
    }
}
