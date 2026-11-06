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
                         bookingStatuses.statusName AS status,
                         COUNT(bookingSeats.bookingSeatId) AS seatCount
                  FROM bookings
                  INNER JOIN screenings ON screenings.screeningId = bookings.screeningId
                  INNER JOIN movies ON movies.movieId = screenings.movieId
                  INNER JOIN auditoriums ON auditoriums.auditoriumId = screenings.auditoriumId
                  INNER JOIN bookingStatuses ON bookingStatuses.statusId = bookings.statusId
                  LEFT JOIN bookingSeats ON bookingSeats.bookingId = bookings.bookingId
                      AND bookingSeats.screeningId = bookings.screeningId
                  WHERE bookings.userId = :userId
                  GROUP BY bookings.bookingId, bookings.createdAt, bookings.totalPrice,
                           movies.title, movies.posterUrl, screenings.startsAt,
                           screenings.endsAt, auditoriums.name, bookingStatuses.statusName
                  ORDER BY screenings.startsAt DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute(['userId' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
