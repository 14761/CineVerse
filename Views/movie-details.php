<!-- Generic page to populate with film details from API -->

<?php
session_start();
require_once __DIR__ . '/../Views/MovieCard.php';
require_once __DIR__ . '/../Models/NetworkManager.php';

$id = $_GET['id'] ?? null;
$networkManager = NetworkManager::get_instance();
$movies = $networkManager->get_trending_movies();

// if (!$id || !isset($movies[$id])) {
//     die("Movie not found.");
// }

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

    <div class="movie-details">
        <div class="movie-header">
            <div class="movie-header-content">
                <div class="movie-image">
                    <img src="../Views/images/img_sample_movie_cover.jpeg" alt="Movie Poster">
                </div>
                <div class="movie-details-section">
                    <h2 class="movie-title">
                        <!-- Movie Name --> <?php echo movie_title($movies[0]); ?>
                    </h2>
                    <div class="movie-description">
                        <span>
                            <?php echo movie_description($movies[0]); ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="movie-info">
            <!-- Genre --> <?php echo movie_genre($movies[0]); ?>
            <!-- Release Date --> <?php echo movie_release_date($movies[0]); ?>
            <!-- Duration --> <?php echo movie_duration($movies[0]); ?>
            <!-- Rating --> <?php echo movie_rating($movies[0]); ?>
        </div>
    </div>

    <div class="comments-section">
        <span>
            Comments
        </span>
        <div class="comments-container">
            <textarea placeholder="Join the conversation and share your thoughts."></textarea>
            <button class="btn btn-primary">Post</button>
        </div>
    </div>

    <?php
    require_once 'footer.php';
    renderLoggedInFooter();
    ?>


    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>