<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $movie ? htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') : 'Movie not found' ?> - Glimmerhaus Cinema</title>
</head>
<body>
<header>
    <h1>Glimmerhaus Cinema</h1>
    <a href="index.php?page=home">Back to home</a>
</header>

<main>
    <?php if (!$movie): ?>
        <h2>Movie not found</h2>
        <p>The movie you requested is not available.</p>
    <?php else: ?>
        <article>
            <?php if (!empty($movie['posterUrl'])): ?>
                <img src="<?= htmlspecialchars($movie['posterUrl'], ENT_QUOTES, 'UTF-8') ?>"
                     alt="Poster for <?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>"
                     width="300">
            <?php endif; ?>
            <h2><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p>
                <?= (int) $movie['durationMinutes'] ?> minutes
                <?php if ($movie['ageRating']): ?>
                    · Rated <?= htmlspecialchars($movie['ageRating'], ENT_QUOTES, 'UTF-8') ?>
                <?php endif; ?>
            </p>
            <p><?= htmlspecialchars($movie['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
        </article>
    <?php endif; ?>
</main>
</body>
</html>