<?php
$pageTitle = 'Book ' . $screening['title'] . ' - Glimmerhaus Cinema';
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
    </div>
    <div class="screen-label">Screen</div>
    <div class="seat-map">
        <?php foreach ($seatsByRow as $rowLabel => $rowSeats): ?>
            <div class="seat-row">
                <span class="seat-row-label"><?= htmlspecialchars($rowLabel, ENT_QUOTES, 'UTF-8') ?></span>
                <?php foreach ($rowSeats as $seat): ?>
                    <span class="seat <?= $seat['isBooked'] ? 'seat-unavailable' : 'seat-available' ?>"
                          aria-label="Row <?= htmlspecialchars($seat['rowLabel'], ENT_QUOTES, 'UTF-8') ?> seat <?= (int) $seat['seatNumber'] ?>">
                        <?= (int) $seat['seatNumber'] ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>