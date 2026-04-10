<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Models/DBManager.php';
require_once __DIR__ . '/../Models/NetworkManager.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'rate_movie':
        rate_movie();
        break;
    case 'search':
        $keyword = trim($_GET['keyword'] ?? '');
        search($keyword);
        break;
    default:
        die('Invalid action.');
}

// Method to rate a movie
function rate_movie(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../Views/testComment.php');
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = 'You must be logged in.';
        header('Location: ../Views/login.php');
        exit;
    }

    $movieId = isset($_GET['movie_id']) ? (int) $_GET['movie_id'] : 0;
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $comment = trim($_POST['comment'] ?? '');

    if ($movieId <= 0) {
        $_SESSION['error'] = 'Invalid movie.';
        header('Location: ../Views/testComment.php');
        exit;
    }

    if ($rating < 1 || $rating > 10 || $comment === '') {
        $_SESSION['error'] = 'Please provide a rating from 1 to 10 and a comment.';
        header('Location: ../Views/movie-details.php?id=' . $movieId);
        exit;
    }

    try {
        $dbManager = DBManager::get_instance();
        $success = $dbManager->rate_movie((int) $_SESSION['user_id'], $movieId, (float) $rating, $comment);

        if ($success) {
            $_SESSION['success'] = 'Rating created successfully.';
        } else {
            $_SESSION['error'] = 'Could not create rating.';
        }

        header('Location: ../Views/movie-details.php?id=' . $movieId);
        exit;

    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        header('Location: ../Views/movie-details.php?id=' . $movieId);
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header('Location: ../Views/movie-details.php?id=' . $movieId);
        exit;
    }
}

function search(string $keyword): void
{
    if ($keyword === '') {
        $_SESSION['error'] = 'Please enter a search term.';
        header('Location: ../Views/movies.php');
        exit;
    }

    try {
        $networkManager = NetworkManager::get_instance();
        $result = $networkManager->search_movies($keyword);

        $_SESSION['search_results'] = $result;
        $_SESSION['search_keyword'] = $keyword;

        header('Location: ../Views/movies.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = 'Search error: ' . $e->getMessage();
        header('Location: ../Views/movies.php');
        exit;
    }
}