<?php
$pageTitle = 'Glitterhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
    <section class="page-heading">
        <p class="eyebrow">Your next night out</p>
        <h1>Now showing</h1>
        <p>Discover something worth watching at Glitterhaus Cinema.</p>
    </section>
    <?php if (empty($movies)): ?>
        <div class="empty-state">
            <p>No movies are currently available.</p>
        </div>
    <?php else: ?>
        <section class="movie-grid">
            <?php foreach ($movies as $movie): ?>
                <a class="movie-link" href="index.php?page=movieDetails&amp;movieId=<?= (int) $movie['movieId'] ?>">
                    <article class="movie-card">
                        <?php if (!empty($movie['posterUrl'])): ?>
                            <div class="poster-wrap">
                                <img src="<?= htmlspecialchars($movie['posterUrl'], ENT_QUOTES, 'UTF-8') ?>"
                                     alt="Poster for <?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="movie-meta">
                            <?= (int) $movie['durationMinutes'] ?> min
                            <?php if ($movie['ageRating']): ?>
                                · Rated <?= htmlspecialchars($movie['ageRating'], ENT_QUOTES, 'UTF-8') ?>
                            <?php endif; ?>
                        </p>
                    </article>
                </a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
