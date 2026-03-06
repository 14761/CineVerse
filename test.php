<!DOCTYPE html>
<html>
<body>
<h1>My first PHP page</h1>
<?php
    require __DIR__ . '/NetworkManager/NetworkManager.php';

    echo "Hello, World! Welcome to XAMPP.";
    $networkManager = new NetworkManager();
    $networkManager->getTrendingMovies();

?>
</body>
</html>