<?php
$pageTitle = $movie
    ? $movie['title'] . ' - Glimmerhaus Cinema'
    : 'Movie not found - Glimmerhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
        <a class="back-link" href="index.php?page=home">&larr; Back to movies</a>
    <?php if (!$movie): ?>
        <section class="empty-state">
            <h1>Movie not found</h1>
            <p>The movie you requested is not available.</p>
        </section>
    <?php else: ?>
        <article class="detail-card">
            <?php if (!empty($movie['posterUrl'])): ?>
                <div class="detail-poster">
                    <img src="<?= htmlspecialchars($movie['posterUrl'], ENT_QUOTES, 'UTF-8') ?>"
                         alt="Poster for <?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>">
                </div>
            <?php endif; ?>
            <div class="detail-content">
                <p class="eyebrow">Now showing</p>
                <h1><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="movie-meta">
                    <?= (int) $movie['durationMinutes'] ?> min
                <?php if ($movie['ageRating']): ?>
                    · Rated <?= htmlspecialchars($movie['ageRating'], ENT_QUOTES, 'UTF-8') ?>
                <?php endif; ?>
                </p>
                <div class="description">
                    <h2>About the movie</h2>
                    <p><?= htmlspecialchars($movie['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </div>
        </article>
        <section class="showtimes detail-card">
            <div class="showtimes-heading">
                <p class="eyebrow">Plan your visit</p>
                <h2>Showtimes</h2>
            </div>
            <?php if (empty($screenings)): ?>
                <p class="empty-state">No showtimes are currently available.</p>
            <?php else: ?>
                <?php
                $screeningsByDate = [];
                foreach ($screenings as $screening) {
                    $dateKey = date('Y-m-d', strtotime($screening['startsAt']));
                    $screeningsByDate[$dateKey][] = $screening;
                }
                ?>
                <div class="showtime-grid">
                    <?php foreach ($screeningsByDate as $date => $dateScreenings): ?>
                        <div class="showtime-day">
                            <h3><?= htmlspecialchars(date('D, M j', strtotime($date)), ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="showtime-list">
                                <?php foreach ($dateScreenings as $screening): ?>
                                    <a class="button showtime-button"
                                       href="makeBooking.php?screeningId=<?= (int) $screening['screeningId'] ?>">
                                        <span class="showtime-auditorium"><?= htmlspecialchars($screening['auditoriumName'], ENT_QUOTES, 'UTF-8') ?></span>
                                        <strong><?= htmlspecialchars(date('g:i A', strtotime($screening['startsAt'])), ENT_QUOTES, 'UTF-8') ?></strong>
                                        <span class="showtime-meta"><?= htmlspecialchars(date('M j', strtotime($screening['startsAt'])), ENT_QUOTES, 'UTF-8') ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../../includes/footer.php'; ?>