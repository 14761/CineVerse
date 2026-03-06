<!DOCTYPE html>
<html>
<body>
<!-- <h1>My first PHP page</h1> -->
<?php
    require_once __DIR__ . '/NetworkManager/NetworkManager.php';

    // Get the singleton instance of NetworkManager and fetch trending movies
    $networkManager = NetworkManager::get_instance();
    $movies = $networkManager->get_trending_movies();

    // Display the movie posters and titles
    foreach ($movies as $movie) {
        echo "<img src='https://image.tmdb.org/t/p/w342{$movie['poster_path']}' alt='Movie Poster'><br>";
        echo $movie['title'] . "<br>";
    }

?>
</body>
</html>