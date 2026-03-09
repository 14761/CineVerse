<?php
session_start();
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

    <div class="browse-movie-title">
        <h2>
            Browse Movies
        </h2>
    </div>

    <div class="filters">
        <div class="select-wrap">
            <select class="custom-select">
                <option>All Genres</option>
                <option>Action</option>
                <option>Sci-Fi</option>
                <option>Mystery</option>
                <option>Romance</option>
                <option>Horror</option>
                <option>Comedy</option>
                <option>Fantasy</option>
                <option>Thriller</option>
                <option>Adventure</option>
                <option>War</option>
            </select>
            <span class="select-icon">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>

        <div class="select-wrap">
            <select class="custom-select">
                <option>Highest Rated</option>
                <option>Most Popular</option>
                <option>Newest</option>
                <option>Oldest</option>
            </select>
            <span class="select-icon">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>
    </div>

    <div class="movie-image">
        <img src="../Views/images/img_sample_movie_cover.jpeg" alt="Movie Poster">
    </div>
    <h2 class="movie-title">
        <a href="../Views/movie-details.php">Movie Name</a>
    </h2>

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

    <script src="../helpers/script.js"></script>
</body>

</html>