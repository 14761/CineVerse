<!-- Generic page to populate with film details from API -->

<?php
session_start();

// Array just for ID test
$movies = [
    "inception" => [
        "title" => "Inception",
        "overview" => "A thief who steals corporate secrets through dream-sharing technology.",
        "poster_path" => "/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg",
        "rating" => 8.8,
        "genre" => "Action",
        "released" => "12/2/2000",
        "duration" => "120m",
    ],
    "interstellar" => [
        "title" => "Interstellar",
        "overview" => "A team travels through a wormhole in space to ensure humanity's survival.",
        "poster_path" => "/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg",
        "rating" => 8.6,
        "genre" => "Fiction",
        "released" => "12/2/2002",
        "duration" => "140m",
    ],
    "starwars" => [
        "title" => "Star Wars",
        "overview" => "A team travels through a wormhole in space to ensure humanity's survival.",
        "poster_path" => "/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg",
        "rating" => 8.6,
        "genre" => "Fiction",
        "released" => "12/2/2002",
        "duration" => "140m",
    ],
];

$id = $_GET['id'] ?? null;

if (!$id || !isset($movies[$id])) {
    die("Movie not found.");
}

$movie = $movies[$id];
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

    <div class="movie-details">
        <div class="movie-header">
            <div class="movie-header-content">
                <div class="movie-image">
                    <img src="../Views/images/img_sample_movie_cover.jpeg" alt="Movie Poster">
                </div>
                <h2 class="movie-title">
                    <!-- Movie Name --> <?php echo htmlspecialchars($movie['title']); ?>
                </h2>
            </div>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/sGbxmsDFVnE?si=DsykfgKOIDjSUBys"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="movie-info">
            <div class="movie-genre">
                <span>
                    <!-- Genre --> <?php echo htmlspecialchars($movie['genre']); ?>
                </span>
            </div>
            <div class="movie-release-date">
                <span>
                    <!-- Release Date --> <?php echo htmlspecialchars($movie['released']); ?>
                </span>
            </div>
            <div class="movie-duration">
                <span>
                    <!-- Duration --> <?php echo htmlspecialchars($movie['duration']); ?>
                </span>
            </div>
        </div>
        <div class="movie-rating">
            <span>Rating</span>
        </div>
    </div>

    <div class="movie-description">
        <span>
            Description
        </span>
    </div>

    <div class="comments-section">
        <span>
            Comments
        </span>
        <div class="comments-container">
            <input type="text" placeholder="Join the conversation and share your thoughts.">
            <button class="btn btn-primary">Post</button>
        </div>
    </div>



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