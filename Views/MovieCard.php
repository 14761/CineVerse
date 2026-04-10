<?php
require_once __DIR__ . '/../helpers/functions.php';


// Display movie card
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

// Display movie banner
function movie_banner($movie)
{
  echo "<div class='movie-banner'>";
  echo "<a href='movie-details.php?id=" . e($movie['id']) . "'>";
  echo "<img src='https://image.tmdb.org/t/p/w342" . e($movie['poster_path']) . "' class='movie-banner-img' alt='" . e($movie['title']) . "'>";
  echo "</a>";
  echo "</div>";
}

// Display movie title
function movie_title($movie)
{
  echo "<div class='movie-title'>";
  echo "<h2 class='movie-title-text'>" . e($movie['title']) . "</h2>";
  echo "</div>";
}

// Display movie description
function movie_description($movie)
{
  echo "<div class='movie-description'>";
  echo "<p class='movie-description-text'>" . e($movie['overview']) . "</p>";
  echo "</div>";
}

// Display movie genre
function movie_genre($movie)
{
  echo "<div class='movie-genre'>";
  echo "<p class='movie-genre-text'>" . e($movie['genre']) . "</p>";
  echo "</div>";
}

// Display movie release date
function movie_release_date($movie)
{
  echo "<div class='movie-release-date'>";
  echo "<p class='movie-release-date-text'>" . e($movie['release_date']) . "</p>";
  echo "</div>";
}

// Display movie duration
function movie_duration($movie)
{
  echo "<div class='movie-duration'>";
  echo "<p class='movie-duration-text'>" . e($movie['duration']) . "</p>";
  echo "</div>";
}

// Display movie rating
function movie_rating($movie)
{
  echo "<div class='movie-rating'>";
  echo "<span>IMDb: </span>";
  echo "<span class='movie-rating-text'>" . e(round($movie['vote_average'], 1)) . " ⭐️</span>";
  echo "</div>";
}

