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

    public function getScreeningSeats($screeningId) {
        $query = "SELECT screenings.screeningId, screenings.movieId, screenings.startsAt,
                         screenings.endsAt, screenings.ticketPrice,
                         movies.title, auditoriums.name AS auditoriumName,
                         seats.seatId, seats.rowLabel, seats.seatNumber,
                         bookingSeats.seatId IS NOT NULL AS isBooked
                  FROM screenings
                  INNER JOIN movies ON movies.movieId = screenings.movieId
                  INNER JOIN auditoriums ON auditoriums.auditoriumId = screenings.auditoriumId
                  INNER JOIN seats ON seats.auditoriumId = screenings.auditoriumId
                  LEFT JOIN bookingSeats
                      ON bookingSeats.screeningId = screenings.screeningId
                      AND bookingSeats.seatId = seats.seatId
                  WHERE screenings.screeningId = :screeningId
                  ORDER BY seats.rowLabel, seats.seatNumber";
        $statement = $this->connection->prepare($query);
        $statement->execute(['screeningId' => $screeningId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $screeningId, $seatIds) {
        $seatIds = array_values(array_unique(array_filter(array_map('intval', $seatIds))));

        if (empty($seatIds)) {
            throw new InvalidArgumentException('Select at least one seat.');
        }

        $this->connection->beginTransaction();

        try {
            $screeningStatement = $this->connection->prepare(
                'SELECT auditoriumId, ticketPrice
                 FROM screenings
                 WHERE screeningId = :screeningId
                 FOR UPDATE'
            );
            $screeningStatement->execute(['screeningId' => $screeningId]);
            $screening = $screeningStatement->fetch(PDO::FETCH_ASSOC);

            if (!$screening) {
                throw new InvalidArgumentException('The selected screening is not available.');
            }

            $placeholders = implode(',', array_fill(0, count($seatIds), '?'));
            $seatStatement = $this->connection->prepare(
                "SELECT seatId
                 FROM seats
                 WHERE auditoriumId = ? AND seatId IN ($placeholders)"
            );
            $seatStatement->execute(array_merge([(int) $screening['auditoriumId']], $seatIds));
            $validSeatIds = array_map('intval', $seatStatement->fetchAll(PDO::FETCH_COLUMN));

            if (count($validSeatIds) !== count($seatIds)) {
                throw new InvalidArgumentException('One or more selected seats are invalid.');
            }

            $bookedStatement = $this->connection->prepare(
                "SELECT seatId
                 FROM bookingSeats
                 WHERE screeningId = ? AND seatId IN ($placeholders)
                 FOR UPDATE"
            );
            $bookedStatement->execute(array_merge([$screeningId], $seatIds));

            if ($bookedStatement->fetchColumn() !== false) {
                throw new InvalidArgumentException('One or more selected seats have already been booked.');
            }

            $totalPrice = count($seatIds) * (float) $screening['ticketPrice'];
            $bookingStatement = $this->connection->prepare(
                'INSERT INTO bookings (userId, screeningId, totalPrice)
                 VALUES (:userId, :screeningId, :totalPrice)'
            );
            $bookingStatement->execute([
                'userId' => $userId,
                'screeningId' => $screeningId,
                'totalPrice' => $totalPrice
            ]);
            $bookingId = $this->connection->lastInsertId();

            $seatInsertStatement = $this->connection->prepare(
                'INSERT INTO bookingSeats
                    (bookingId, screeningId, seatId, auditoriumId, priceAtBooking)
                 VALUES (:bookingId, :screeningId, :seatId, :auditoriumId, :priceAtBooking)'
            );

            foreach ($seatIds as $seatId) {
                $seatInsertStatement->execute([
                    'bookingId' => $bookingId,
                    'screeningId' => $screeningId,
                    'seatId' => $seatId,
                    'auditoriumId' => $screening['auditoriumId'],
                    'priceAtBooking' => $screening['ticketPrice']
                ]);
            }

            $this->connection->commit();
        } catch (InvalidArgumentException | PDOException $exception) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }

            throw $exception;
        }
    }
}
