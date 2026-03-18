<?php

function renderNavbar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    $username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : '';

    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Views/index.php">CineVerse</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a href="../Views/index.php" class="nav-link active">Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="../Views/movies.php" class="nav-link">Movies</a>
                    </li>

                    <li class="nav-item">
                        <a href="../Views/watchLaterList.php" class="nav-link">Watch Later</a>
                    </li>

                </ul>

                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2 search"
                        type="search"
                        placeholder="Search"
                        aria-label="Search">
                </form>';

    if ($isLoggedIn) {
        echo '
                <a href="../Views/profile_settings.php" class="nav-link">
                <span class="me-3 text-white">Hi, ' . $username . '</span>
                </a>
                <a href="../Controllers/UserController.php?action=logout" class="bt-login">Logout</a>';
    } else {
        echo '
                <a href="../Views/login.php" class="bt-login">Login</a>
                <a href="../Views/register.php" class="btn-primary">Register</a>';
    }

    echo '
            </div>
        </div>
    </nav>
    ';
}