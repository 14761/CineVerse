<?php

function renderNavbar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    $username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : '';


    // Renders the default Navbar
    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand title-logo" href="../Views/index.php">CINEVERSE</a>

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
                        <a href="../Views/watchLaterList.php" class="nav-link">Favourites</a>
                    </li>

                </ul>

                <form action="../Controllers/MovieController.php"  class="d-flex me-3"  method="get" role="search">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="keyword" placeholder="Search movies" class="search">
                    <button type="submit" class="btn btn-primary search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </form>';

    // Checks if user is logged in and displays the profile and sigout buttons
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