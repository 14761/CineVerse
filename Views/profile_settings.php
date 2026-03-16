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
    <?php
    require_once 'navbar.php';

    renderNavbar();
    ?>

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


    <?php
    require_once 'footer.php';
    renderLoggedInFooter();
    ?>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>