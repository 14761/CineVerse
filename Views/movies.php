<?php
session_start();

$searchResults = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']);

require_once __DIR__ . '/../Views/MovieCard.php';
require_once __DIR__ . '/../Models/NetworkManager.php';

$selectedGenre = $_GET['genre'] ?? 'All Genres';
$selectedSort = $_GET['sort'] ?? 'Most Popular';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - CineVerse</title>

    <!-- Google Fonts for Modern Aesthetic -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <?php
    require_once 'navbar.php';

    renderNavbar();
    ?>

    <div class="browse-movie-title">
        <h2>
            Browse Movies
        </h2>
    </div>

    <div class="row">
        <?php foreach ($searchResults as $movie): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2"">
                <div class=" card">
                <a href="../Views/movie-details.php?id=<?= htmlspecialchars($movie['id'] ?? '') ?>">
                    <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path'] ?? '') ?>"
                        class="card-img-top" alt="<?= htmlspecialchars($movie['title'] ?? 'Movie poster') ?>">

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($movie['title'] ?? '') ?></h5>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <form action="movies.php" method="GET" id="filter-form">
        <div class="filters">
            <div class="select-wrap">
                <select name="genre" class="custom-select" onchange="document.getElementById('filter-form').submit()">
                    <option <?= $selectedGenre === 'All Genres' ? 'selected' : '' ?>>All Genres</option>
                    <option <?= $selectedGenre === 'Action' ? 'selected' : '' ?>>Action</option>
                    <option <?= $selectedGenre === 'Sci-Fi' ? 'selected' : '' ?>>Sci-Fi</option>
                    <option <?= $selectedGenre === 'Mystery' ? 'selected' : '' ?>>Mystery</option>
                    <option <?= $selectedGenre === 'Romance' ? 'selected' : '' ?>>Romance</option>
                    <option <?= $selectedGenre === 'Horror' ? 'selected' : '' ?>>Horror</option>
                    <option <?= $selectedGenre === 'Comedy' ? 'selected' : '' ?>>Comedy</option>
                    <option <?= $selectedGenre === 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                    <option <?= $selectedGenre === 'Thriller' ? 'selected' : '' ?>>Thriller</option>
                    <option <?= $selectedGenre === 'Adventure' ? 'selected' : '' ?>>Adventure</option>
                    <option <?= $selectedGenre === 'War' ? 'selected' : '' ?>>War</option>
                </select>
                <span class="select-icon">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </div>

            <div class="select-wrap">
                <select name="sort" class="custom-select" onchange="document.getElementById('filter-form').submit()">
                    <option <?= $selectedSort === 'Highest Rated' ? 'selected' : '' ?>>Highest Rated</option>
                    <option <?= $selectedSort === 'Most Popular' ? 'selected' : '' ?>>Most Popular</option>
                    <option <?= $selectedSort === 'Newest' ? 'selected' : '' ?>>Newest</option>
                    <option <?= $selectedSort === 'Oldest' ? 'selected' : '' ?>>Oldest</option>
                </select>
                <span class="select-icon">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </div>
        </div>
    </form>

    <div class="container text-center">
        <div class="row justify-content-center g-4">
            <?php

            // Get the singleton instance of NetworkManager and fetch trending movies
            $networkManager = NetworkManager::get_instance();
            $movies = $networkManager->get_trending_movies();

            // 
            if ($selectedGenre !== 'All Genres') {
                $movies = array_filter($movies, function($movie) use ($selectedGenre) {
                    return in_array($selectedGenre, $movie['genres'] ?? []);
                });
            }

            // Sort movies based on the selected sort option
            usort($movies, function($a, $b) use ($selectedSort) {
                if ($selectedSort === 'Highest Rated') {
                    return ($b['vote_average'] ?? 0) <=> ($a['vote_average'] ?? 0);
                } elseif ($selectedSort === 'Newest') {
                    return strtotime($b['release_date'] ?? '0') <=> strtotime($a['release_date'] ?? '0');
                } elseif ($selectedSort === 'Oldest') {
                    return strtotime($a['release_date'] ?? '0') <=> strtotime($b['release_date'] ?? '0');
                } else { // Most Popular
                    return ($b['popularity'] ?? 0) <=> ($a['popularity'] ?? 0);
                }
            });

            // Display the movie card for the top movies
            foreach ($movies as $movie) {
                if ($movie != null) {
                    echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2">';
                    movie_banner($movie);
                    echo '</div>';
                }
            }

            ?>
        </div>
    </div>


    <?php
    require_once 'footer.php';
    renderFooter();
    ?>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>