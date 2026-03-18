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
    <?php
    require_once 'navbar.php';

    renderNavbar();
    ?>

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
        <a href="../Views/movie-details.php?id=starwars">Movie Name</a>
    </h2>

    <?php
    require_once 'footer.php';
    renderFooter();
    ?>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>