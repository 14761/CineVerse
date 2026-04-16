<?php
session_start();

$searchResults = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']);

require_once __DIR__ . '/../Views/MovieCard.php';
require_once __DIR__ . '/../Models/NetworkManager.php';

$selectedGenre = $_GET['genre'] ?? 'all';
$selectedSort = $_GET['sort'] ?? 'popularity.desc';
$currentPage = max(1, (int) ($_GET['page'] ?? 1));

$networkManager = NetworkManager::get_instance();
$availableGenres = $networkManager->get_genre_names();
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
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class=" card">
                    <a href="../Views/movie-details.php?id=<?= htmlspecialchars($movie['id'] ?? '') ?>">
                        <img src="<?= htmlspecialchars(movie_poster_url($movie, 'w500')) ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($movie['title'] ?? 'Movie poster') ?>"
                            onerror="this.onerror=null;this.src='images/img_sample_movie_cover.png';">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title'] ?? '') ?></h5>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="movies.php" method="GET" id="filter-form">
        <input type="hidden" name="page" id="page" value="1">
        <div class="filters">
            <div class="select-wrap">
                <select name="genre" class="custom-select" onchange="resetPageAndSubmit()">
                    <option value="all" <?= $selectedGenre === 'all' ? 'selected' : '' ?>>All Genres</option>
                    <?php foreach ($availableGenres as $genre): ?>
                        <option value="<?= htmlspecialchars((string) $genre['id']) ?>" <?= $selectedGenre === (string) $genre['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="select-icon">
                    <i class="bi bi-chevron-down"></i>
                </span>
            </div>

            <div class="select-wrap">
                <select name="sort" class="custom-select" onchange="resetPageAndSubmit()">
                    <option value="vote_average.desc" <?= $selectedSort === 'vote_average.desc' ? 'selected' : '' ?>>Highest Rated</option>
                    <option value="popularity.desc" <?= $selectedSort === 'popularity.desc' ? 'selected' : '' ?>>Most Popular</option>
                    <option value="primary_release_date.desc" <?= $selectedSort === 'primary_release_date.desc' ? 'selected' : '' ?>>Newest</option>
                    <option value="primary_release_date.asc" <?= $selectedSort === 'primary_release_date.asc' ? 'selected' : '' ?>>Oldest</option>
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
            [$movies, $totalPages] = $networkManager->getFilteredMovies(
                $selectedGenre,
                $selectedSort,
                $currentPage
            );

            $movies = array_values($movies);

            foreach ($movies as $movie) {
                if ($movie !== null) {
                    echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2">';
                    echo '<div class=" card">';
                    movie_banner($movie);
                    echo '<h5 class="card-title">' . e($movie['title']) . '</h5>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav aria-label="Movies pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php
                    $baseParams = [
                        'genre' => $selectedGenre,
                        'sort' => $selectedSort,
                    ];
                    ?>

                    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($baseParams, ['page' => max(1, $currentPage - 1)])) ?>">Previous</a>
                    </li>


                    <?php
                    $window = 1; // shows current-1, current, current+1

                    $pagesToShow = [1, $totalPages];

                    for ($p = $currentPage - $window; $p <= $currentPage + $window; $p++) {
                        if ($p >= 1 && $p <= $totalPages) {
                            $pagesToShow[] = $p;
                        }
                    }

                    $pagesToShow = array_values(array_unique($pagesToShow));
                    sort($pagesToShow);

                    $previousShown = null;
                    foreach ($pagesToShow as $page):
                        if ($previousShown !== null && $page > $previousShown + 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>

                        <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($baseParams, ['page' => $page])) ?>">
                                <?= $page ?>
                            </a>
                        </li>

                    <?php
                        $previousShown = $page;
                    endforeach;
                    ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>


    <?php
    require_once 'footer.php';
    renderFooter();
    ?>

    <script>
        function resetPageAndSubmit() {
            document.getElementById('page').value = '1';
            document.getElementById('filter-form').submit();
        }
    </script>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>