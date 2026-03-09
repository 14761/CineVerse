<?php
require_once __DIR__ . '/../helpers/functions.php';


function echo_movie_card($movie)
{
  echo "<div class='card' style='width: 16rem;'>";
  echo "<img src='https://image.tmdb.org/t/p/w342" . e($movie['poster_path']) . "' class='card-img-top' alt='" . e($movie['title']) . "'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title'>" . e($movie['title']) . "</h5>";
  echo "<p class='card-text'>" . e($movie['overview']) . "</p>";
  echo "<h4 class='card-subtitle mb-2 text-muted'>Rating: " . e(round($movie['vote_average'], 1)) . " ⭐️</h4>";
  echo "</div>";
  echo "</div>";
}
