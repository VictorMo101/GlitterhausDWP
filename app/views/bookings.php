<?php
$pageTitle = 'My bookings - Glimmerhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
<section class="page-heading">
    <p class="eyebrow">Your cinema plans</p>
    <h1>My bookings</h1>
    <p>Keep track of your upcoming and past movie reservations.</p>
</section>

<?php if (empty($bookings)): ?>
    <section class="empty-state">
        <h2>No bookings yet</h2>
        <p>Your movie bookings will appear here.</p>
        <a class="button" href="index.php?page=home">Browse movies</a>
    </section>
<?php else: ?>
    <section class="booking-list">
        <?php foreach ($bookings as $booking): ?>
            <article class="booking-card">
                <?php if (!empty($booking['posterUrl'])): ?>
                    <div class="booking-poster">
                        <img src="<?= htmlspecialchars($booking['posterUrl'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="Poster for <?= htmlspecialchars($booking['title'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                <?php endif; ?>
                <div class="booking-info">
                    <div class="booking-heading">
                        <div>
                            <p class="eyebrow">Booking #<?= (int) $booking['bookingId'] ?></p>
                            <h2><?= htmlspecialchars($booking['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        </div>
                    </div>
                    <dl class="booking-details">
                        <div>
                            <dt>When</dt>
                            <dd><?= htmlspecialchars(date('D, M j, Y \a\t g:i A', strtotime($booking['startsAt'])), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Auditorium</dt>
                            <dd><?= htmlspecialchars($booking['auditoriumName'], ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Booked seats</dt>
                            <dd><?= htmlspecialchars($booking['seatNames'] ?? 'None', ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Total</dt>
                            <dd><?= htmlspecialchars(number_format((float) $booking['totalPrice'], 2), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                    </dl>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
