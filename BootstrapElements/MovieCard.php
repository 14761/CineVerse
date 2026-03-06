<?php
  function echo_movie_card($movie) {
    echo "<div class='card' style='width: 16rem;'>";
    echo "<img src='https://image.tmdb.org/t/p/w342{$movie['poster_path']}' class='card-img-top' alt='{$movie['title']}'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$movie['title']}</h5>";
    echo "<p class='card-text'>{$movie['overview']}</p>";
    echo "<h4 class='card-subtitle mb-2 text-muted'>Rating: {$movie['vote_average']} ⭐️</h4>";
    echo "</div>";
    echo "</div>";
  }
?>