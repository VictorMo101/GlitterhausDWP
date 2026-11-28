<?php
require_once __DIR__ . "/app/config/session.php";
require_once __DIR__ . "/app/config/connection.php";
require_once __DIR__ . "/app/helpers/functions.php";
require_once __DIR__ . "/app/models/User.php";
require_once __DIR__ . "/app/models/Movie.php";
require_once __DIR__ . "/app/models/Booking.php";
require_once __DIR__ . "/app/models/About.php";
require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/MovieController.php";
require_once __DIR__ . "/app/controllers/BookingController.php";
require_once __DIR__ . "/app/controllers/AboutController.php";
require_once __DIR__ . "/app/controllers/AdminController.php";

$about = new AboutController(new About($connection));
$auth = new AuthController(new User($connection));
$movies = new MovieController(new Movie($connection));
$bookings = new BookingController(new Booking($connection));
$admin = new AdminController(['about' => new About($connection)]);

$routes = [
    'about' => [$about, 'about'],
    'home' => [$movies, 'home'],
    'movieDetails' => [$movies, 'movieDetails'],
    'movieBooking' => [$bookings, 'movieBooking'],
    'bookings' => [$bookings, 'index'],
    'login' => [$auth, 'login'],
    'register' => [$auth, 'register'],
    'logout' => [$auth, 'logout'],
    'admin' => [$admin, 'admin'],
    'adminAbout' => [$admin, 'adminAbout'],
];
$page = $_GET['page'] ?? 'home';

if (!isset($routes[$page])) {
    http_response_code(404);
    $page = 'home';
}

call_user_func($routes[$page]);
