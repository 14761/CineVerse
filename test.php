<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Movie Tracker</title>

    <!-- !!!!!!!!!!!  DO NOT DELETE THIS LINE. IT IS NECESSARY FOR BOOTSTRAP TO WORK PROPERLY. !!!!!!!!! -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <div class="container-fuid">
        <h1 class="text-center my-4">Trending Movies</h1>
        <div class="d-flex flex-wrap justify-content-center gap-4">
            <?php
                // Include the necessary files for NetworkManager and MovieCard
                require_once __DIR__ . '/NetworkManager/NetworkManager.php';
                require_once __DIR__ . '/BootstrapElements/MovieCard.php';

                // Get the singleton instance of NetworkManager and fetch trending movies
                $networkManager = NetworkManager::get_instance();
                $movies = $networkManager->get_trending_movies();

                // Display the movie posters and titles
                foreach ($movies as $movie) {
                    echo_movie_card($movie);
                }
            ?>
        </div>
    </div>
    <?php
        require_once __DIR__ . '/NetworkManager/NetworkManager.php';
        require_once __DIR__ . '/BootstrapElements/MovieCard.php';

        // Get the singleton instance of NetworkManager and fetch trending movies
        $networkManager = NetworkManager::get_instance();
        $movies = $networkManager->get_trending_movies();
    ?>



    <!-- !!!!!!!!!!!  DO NOT DELETE THIS LINE. IT IS NECESSARY FOR BOOTSTRAP TO WORK PROPERLY. !!!!!!!!! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>