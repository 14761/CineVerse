<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Movie Hub</title>

    <!-- Google Fonts for Modern Aesthetic -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CineVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="../Views/index.php" class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Views/movies.php" class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a href="../Views/shows.php" class="nav-link" href="#">TV Shows</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2 search" type="search" placeholder="Search" aria-label="Search" />
                </form>
                <a href="../Views/login.php" class="bt-login">Login</a>
                <a href="../Views/register.php" class="btn-primary">Register</a>

            </div>
        </div>
    </nav>

    <div class="page">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Welcome</h1>
                <p class="auth-subtitle">Log in to track your favourite movies</p>
            </div>

            <form action="../Controllers/UserController.php?action=login" method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                        required>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                        <a href="forgot_password.php" class="auth-link" style="font-size: 0.85rem;">Forgot Password?</a>
                    </div>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">Sign In</button>
            </form>

            <div class="auth-footer">
                Don't have an account? <a href="register.php" class="auth-link">Sign up</a>
            </div>
        </div>
    </div>

    <div class="join-community">
        <h2>
            Join Our Community
        </h2>
        <p>Create your account to rate movies, leave comments, and build your personalized watchlist.</p>
        <a href="../Views/register.php" class="btn-primary">Register</a>
    </div>

    <div class="footer">
        <p>© 2026 CineVerse. All rights reserved.</p>
        <p>Your personal movie and TV show discovery platform</p>
    </div>
    <script src="../helpers/script.js"></script>
</body>

</html>