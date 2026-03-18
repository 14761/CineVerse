<?php
session_start();

require_once __DIR__ . '/../Views/MovieCard.php';
require_once __DIR__ . '/../Models/NetworkManager.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CineVerse</title>

    <!-- Google Fonts for Modern Aesthetic -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <!-- Navbar -->
    <?php
    require_once 'navbar.php';

    renderNavbar();
    ?>

    <!-- Trending Movies -->
    <div class="trending-movies">

        <!-- Carousel -->
        <div id="carouselExample" class="carousel slide index-carousel-container">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../Views/images/avengers.jpeg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../Views/images/avatar.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../Views/images/batman.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <h2 class="trending-title">
            <i class="bi bi-graph-up-arrow"></i>Trending Movies
        </h2>

        <!-- Movie Cards -->
        <div class="container text-center">
            <div class="row">
                <div class="d-flex flex-wrap justify-content-center gap-4">
                    <?php

                    // Get the singleton instance of NetworkManager and fetch trending movies
                    $networkManager = NetworkManager::get_instance();
                    $movies = $networkManager->get_trending_movies();

                    // Display the movie card for the top 10 movies
                    for ($x = 0; $x < 10; $x++) {
                        movie_banner($movies[$x]);
                    }

                    ?>
                </div>
            </div>
        </div>


        <!-- If user is logged out show this section -->
        <?php
        require_once __DIR__ . '/footer.php';
        renderFooter();
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../helpers/script.js"></script>
</body>

</html>