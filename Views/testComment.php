<?php
session_start();

require_once __DIR__ . '/../Models/DBManager.php';
$dbManager = DBManager::get_instance();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Movie Hub</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <link rel="stylesheet" href="../style.css">


</head>

<body>
    <?php
    require_once 'navbar.php';

    renderNavbar();
    ?>

    <div class="page">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Rate movie</h1>
                <p class="auth-subtitle">Rate the movie!</p>
            </div>

            <form action="../Controllers/MovieController.php?action=rate_movie" method="POST">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="number" class="form-control" id="rating" name="rating" placeholder="Enter your rating"
                        required>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <input type="text" class="form-control" id="comment" name="comment" placeholder="Enter your comment"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">Post</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="login.php" class="auth-link">Log in</a>
            </div>
        </div>
    </div>


    <?php
    require_once 'footer.php';
    renderFooter();
    ?>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>