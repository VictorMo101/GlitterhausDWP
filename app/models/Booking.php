<?php

class Booking {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getForUser($userId) {
        $query = "SELECT bookings.bookingId, bookings.createdAt, bookings.totalPrice,
                         movies.title, movies.posterUrl, screenings.startsAt,
                         screenings.endsAt, auditoriums.name AS auditoriumName,
                         COUNT(bookingSeats.bookingSeatId) AS seatCount,
                         GROUP_CONCAT(
                             CONCAT(seats.rowLabel, seats.seatNumber)
                             ORDER BY seats.rowLabel, seats.seatNumber
                             SEPARATOR ', '
                         ) AS seatNames
                  FROM bookings
                  INNER JOIN screenings ON screenings.screeningId = bookings.screeningId
                  INNER JOIN movies ON movies.movieId = screenings.movieId
                  INNER JOIN auditoriums ON auditoriums.auditoriumId = screenings.auditoriumId
                  LEFT JOIN bookingSeats ON bookingSeats.bookingId = bookings.bookingId
                      AND bookingSeats.screeningId = bookings.screeningId
                  LEFT JOIN seats ON seats.seatId = bookingSeats.seatId
                      AND seats.auditoriumId = screenings.auditoriumId
                  WHERE bookings.userId = :userId
                  GROUP BY bookings.bookingId, bookings.createdAt, bookings.totalPrice,
                           movies.title, movies.posterUrl, screenings.startsAt,
                           screenings.endsAt, auditoriums.name
                  ORDER BY screenings.startsAt DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute(['userId' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
