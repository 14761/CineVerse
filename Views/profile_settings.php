<!-- Generic page to populate with film details from API -->

<?php
session_start();
require_once __DIR__ . '/../Models/DBManager.php';

$profilePicture = $_SESSION['profile_picture'] ?? null;
if ($profilePicture === null && isset($_SESSION['user_id'])) {
    $dbManager = DBManager::get_instance();
    $user = $dbManager->get_user_by_id((int) $_SESSION['user_id']);
    if ($user && !empty($user['profile_picture'])) {
        $profilePicture = $user['profile_picture'];
        $_SESSION['profile_picture'] = $profilePicture;
    }
}
$profilePicture = $profilePicture ?? 'images/profile_sample.jpg';
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
                <?php $profilePicture = $_SESSION['profile_picture'] ?? 'images/profile_sample.jpg'; ?>
                <img src="<?php echo htmlspecialchars($profilePicture, ENT_QUOTES); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="profile_settings_right_container">
            <span>
                Personal Information
            </span>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="../Controllers/UserController.php?action=update_info" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" id="username" name="username" required
                        value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/gif">
                    <small class="form-text text-muted">Optional. JPG, PNG, or GIF up to 2MB.</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                        value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES); ?>">
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password"
                        placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label for="confirm_new_password">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password"
                        placeholder="Confirm new password">
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="Enter current password to confirm changes">
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
    renderFooter();
    ?>

    <script src="../helpers/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>