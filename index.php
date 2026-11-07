<?php
require_once __DIR__ . "/includes/session.php";
require_once __DIR__ . "/includes/connection.php";
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/app/models/User.php";
require_once __DIR__ . "/app/models/Movie.php";
require_once __DIR__ . "/app/models/Booking.php";
require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/MovieController.php";
require_once __DIR__ . "/app/controllers/BookingController.php";

$auth = new AuthController(new User($connection));
$movies = new MovieController(new Movie($connection));
$bookings = new BookingController(new Booking($connection));

$routes = [
    'home' => [$movies, 'home'],
    'movieDetails' => [$movies, 'movieDetails'],
    'movieBooking' => [$bookings, 'movieBooking'],
    'bookings' => [$bookings, 'index'],
    'login' => [$auth, 'login'],
    'register' => [$auth, 'register'],
    'logout' => [$auth, 'logout']
];
$page = $_GET['page'] ?? 'home';

if (!isset($routes[$page])) {
    http_response_code(404);
    $page = 'home';
}

call_user_func($routes[$page]);
