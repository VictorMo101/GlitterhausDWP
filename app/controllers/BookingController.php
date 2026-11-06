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
}
