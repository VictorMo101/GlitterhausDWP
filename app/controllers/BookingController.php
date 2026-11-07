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
        if (!logged_in()) {
            redirect_to('index.php?page=login');
        }

        $screeningId = filter_input(INPUT_GET, 'screeningId', FILTER_VALIDATE_INT);
        $bookingError = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $screeningId = filter_input(INPUT_POST, 'screeningId', FILTER_VALIDATE_INT);
            $selectedSeats = isset($_POST['seatIds']) && is_array($_POST['seatIds'])
                ? $_POST['seatIds']
                : [];

            try {
                $this->booking->create($_SESSION['user_id'], $screeningId, $selectedSeats);
                redirect_to('index.php?page=bookings');
            } catch (InvalidArgumentException $exception) {
                $bookingError = $exception->getMessage();
            } catch (PDOException $exception) {
                $bookingError = 'The booking could not be completed. Please try again.';
            }
        }

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
