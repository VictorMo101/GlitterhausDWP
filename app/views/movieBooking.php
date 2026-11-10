<?php
$pageTitle = 'Book ' . $screening['title'] . ' - Glitterhaus Cinema';
require __DIR__ . '/../../includes/header.php';

$seatsByRow = [];
foreach ($seats as $seat) {
    $seatsByRow[$seat['rowLabel']][] = $seat;
}
?>
<a class="back-link" href="index.php?page=movieDetails&amp;movieId=<?= (int) $screening['movieId'] ?>">&#8592; Back to movie</a>
<section class="booking-seat-card detail-card">
    <div class="booking-seat-heading">
        <p class="eyebrow">Choose your seats</p>
        <h1><?= htmlspecialchars($screening['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="movie-meta">
            <?= htmlspecialchars(date('D, M j \a\t g:i A', strtotime($screening['startsAt'])), ENT_QUOTES, 'UTF-8') ?>
            &middot; <?= htmlspecialchars($screening['auditoriumName'], ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>
    <div class="seat-legend" aria-label="Seat availability">
        <span><i class="seat-legend-swatch seat-available"></i> Available</span>
        <span><i class="seat-legend-swatch seat-unavailable"></i> Unavailable</span>
        <span><i class="seat-legend-swatch seat-selected"></i> Selected</span>
    </div>
    <?php if ($bookingError): ?>
        <p class="alert"><?= htmlspecialchars($bookingError, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" class="seat-booking-form" data-seat-booking
          data-ticket-price="<?= htmlspecialchars($screening['ticketPrice'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="screeningId" value="<?= (int) $screening['screeningId'] ?>">
        <div class="screen-label">Screen</div>
        <div class="booking-layout">
            <aside class="seat-selection-panel">
                <h2>Select tickets</h2>
                <div class="ticket-counter">
                    <div>
                        <strong>Seats</strong>
                        <span data-selected-seats>0 selected</span>
                    </div>
                    <div class="counter-controls">
                        <button class="seat-control" type="button" data-seat-minus aria-label="Remove a seat">-</button>
                        <button class="seat-control" type="button" data-seat-plus aria-label="Add a seat">+</button>
                    </div>
                </div>
                <p class="selection-total"><strong>Total</strong> <span data-total-price>0.00</span></p>
                <button class="button" type="submit" data-confirm-booking disabled>Confirm booking</button>
            </aside>
            <div class="seat-map">
                <?php foreach ($seatsByRow as $rowLabel => $rowSeats): ?>
                    <div class="seat-row">
                        <span class="seat-row-label"><?= htmlspecialchars($rowLabel, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php foreach ($rowSeats as $seat): ?>
                            <span class="seat <?= $seat['isBooked'] ? 'seat-unavailable' : 'seat-available' ?>"
                                  data-seat
                                  data-seat-id="<?= (int) $seat['seatId'] ?>"
                                  data-row="<?= htmlspecialchars($seat['rowLabel'], ENT_QUOTES, 'UTF-8') ?>"
                                  data-seat-number="<?= (int) $seat['seatNumber'] ?>"
                                  aria-label="Row <?= htmlspecialchars($seat['rowLabel'], ENT_QUOTES, 'UTF-8') ?> seat <?= (int) $seat['seatNumber'] ?>">
                                <?= (int) $seat['seatNumber'] ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </form>
</section>
<script src="assets/seatBooking.js" defer></script>
<?php require __DIR__ . '/../../includes/footer.php'; ?>