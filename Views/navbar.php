<?php
function renderNavbar()
{
    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CineVerse</a>

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

                <form class="d-flex" role="search">
                    <input class="form-control me-2 search"
                        type="search"
                        placeholder="Search"
                        aria-label="Search">
                </form>

                <a href="../Views/login.php" class="bt-login">Login</a>
                <a href="../Views/register.php" class="btn-primary">Register</a>

            </div>
        </div>
    </nav>
    ';
}
