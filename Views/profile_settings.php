<!-- Generic page to populate with film details from API -->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - CineVerse</title>

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

    <div class="page-title">
        Profile Settings
    </div>
    <div class="profile-settings-container">
        <div class="profile_settings_left_container">
            <span>
                Profile Picture
            </span>
            <div class="profile-settings-avatar">
                <img src="../Views/images/profile_sample.jpg" alt="Profile Picture">
            </div>
        </div>

        <div class="profile_settings_right_container">
            <span>
                Personal Information
            </span>
            <form action="../Controllers/profile_settings_controller.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $_SESSION['username']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo $_SESSION['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="New password">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <div class="delete_account_container">
        <span>
            Delete Account
        </span>
        <span class="settings_subtitle">If you delete your account, you will lose all your data.</span>
        <button class="btn btn-danger">Delete Account</button>
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