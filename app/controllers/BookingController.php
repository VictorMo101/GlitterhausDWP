<?php

class BookingController {
    private $booking;

    public function __construct($booking) {
        $this->booking = $booking;
    }

    public function index() {
        if (!logged_in()) {
            redirect_to('index.php?page=login');
        }

        $bookings = $this->booking->getForUser($_SESSION['user_id']);
        require __DIR__ . '/../views/bookings.php';
    }

    public function movieBooking() {
        $screeningId = filter_input(INPUT_GET, 'screeningId', FILTER_VALIDATE_INT);
        $seats = $screeningId ? $this->booking->getScreeningSeats($screeningId) : [];

        if (empty($seats)) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            exit;
        }

        $screening = $seats[0];
        require __DIR__ . '/../views/movieBooking.php';
    }
}
