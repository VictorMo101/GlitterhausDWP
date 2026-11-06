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
}
