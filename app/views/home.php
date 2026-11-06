<?php
$pageTitle = 'Glimmerhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
    <h2>Now showing</h2>
    <?php if (empty($movies)): ?>
        <p>No movies are currently available.</p>
    <?php else: ?>
        <section>
            <?php foreach ($movies as $movie): ?>
                <a href="index.php?page=movieDetails&amp;movieId=<?= (int) $movie['movieId'] ?>">
                    <article>
                        <?php if (!empty($movie['posterUrl'])): ?>
                            <img src="<?= htmlspecialchars($movie['posterUrl'], ENT_QUOTES, 'UTF-8') ?>"
                                 alt="Poster for <?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
                                 width="180">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p>
                            <?= (int) $movie['durationMinutes'] ?> minutes
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
