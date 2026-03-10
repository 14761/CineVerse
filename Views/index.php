<?php
session_start();
require_once __DIR__ . '/../Views/MovieCard.php';
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CineVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="../Views/index.php" class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Views/movies.php" class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Views/shows.php" class="nav-link" href="#">TV Shows</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2 search" type="search" placeholder="Search" aria-label="Search" />
                </form>
                <a href="../Views/login.php" class="bt-login">Login</a>
                <a href="../Views/register.php" class="btn-primary">Register</a>

            </div>
        </div>
    </nav>

    <div class="trending-movies">
        <h2 class="trending-title">
            <i class="bi bi-graph-up-arrow"></i>Trending Movies
        </h2>

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
        <div class="row">
            <?php

            $movies = [
                [
                    "title" => "Inception",
                    "overview" => "A thief who steals corporate secrets through dream-sharing technology.",
                    "poster_path" => "/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg",
                    "vote_average" => 8.8
                ],
                [
                    "title" => "Interstellar",
                    "overview" => "A team travels through a wormhole in space in an attempt to ensure humanity's survival.",
                    "poster_path" => "/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg",
                    "vote_average" => 8.6
                ]
            ];

            foreach ($movies as $movie) {
                echo_movie_card($movie);
            }

            ?>
        </div>
    </div>

    <div class="trending-shows">
        <h2 class="trending-title">
            <i class="bi bi-graph-up-arrow"></i>Trending Shows
        </h2>
        <div class="row">
            <?php

            $movies = [
                [
                    "title" => "Inception",
                    "overview" => "A thief who steals corporate secrets through dream-sharing technology.",
                    "poster_path" => "/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg",
                    "vote_average" => 8.8
                ],
                [
                    "title" => "Interstellar",
                    "overview" => "A team travels through a wormhole in space in an attempt to ensure humanity's survival.",
                    "poster_path" => "/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg",
                    "vote_average" => 8.6
                ]
            ];

            foreach ($movies as $movie) {
                echo_movie_card($movie);
            }

            ?>
        </div>
    </div>

    <a href="movie-details.php?id=inception">Movie 1</a>
    <a href="movie-details.php?id=interstellar">Movie 2</a>

    <!-- If user already logged in do not show this section -->
    <div class="join-community">
        <h2>
            Join Our Community
        </h2>
        <p>Create your account to rate movies, leave comments, and build your personalized watchlist.</p>
        <a href="../Views/register.php" class="btn-primary">Register</a>
    </div>

    <div class="footer">
        <p>© 2026 CineVerse. All rights reserved.</p>
        <p>Your personal movie and TV show discovery platform</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../helpers/script.js"></script>
</body>

</html>