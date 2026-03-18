<!-- Generic page to populate with film details from API -->

<?php
session_start();
require_once __DIR__ . '/../Views/MovieCard.php';
require_once __DIR__ . '/../Models/NetworkManager.php';
require_once __DIR__ . '/../Models/DBManager.php';


$id = $_GET['id'] ?? null;
$networkManager = NetworkManager::get_instance();
$movies = $networkManager->get_trending_movies();
$movie_detail = $networkManager->get_movie_details((int) $id);

if (!$id) {
    die("Movie ID not provided.");
}
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
                    <?php movie_banner($movie_detail); ?>
                </div>
                <div class="movie-details-section">
                    <h2 class="movie-title">
                        <?php echo $movie_detail['title']; ?>
                    </h2>
                    <div class="movie-description">
                        <span>
                            <?php echo $movie_detail['overview']; ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="movie-info-container">
            <div class="movie-info">
                <!-- Genre <?php echo $movie_detail['genres']; ?> -->
                <?php echo implode(', ', $movie_detail['genres']); ?>
            </div>
            <div class="movie-info">
                <!-- Release Date --> <?php echo $movie_detail['release_date']; ?>
            </div>
            <div class="movie-info">
                <!-- Duration --> <?php echo $movie_detail['runtime'] . " m"; ?>
            </div>
        </div>
        <div class="rating-container">
            <div class="rating-tmdb">
                <!-- Rating --> <?php echo "TMDB: " . $movie_detail['vote_average'] . "/10 ⭐️"; ?>
            </div>
            <div class="rating-user">
                <!-- Rating --> <?php echo "CineVerse Rating: " . $movie_detail['vote_average'] . "/10 ⭐️"; ?>
            </div>
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
    renderFooter();
    ?>


    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>