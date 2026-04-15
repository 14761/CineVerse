<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../Models/DBManager.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        register_user();
        break;
    case 'login':
        login_user();
        break;
    case 'logout':
        logout_user();
        break;
    case 'update_info':
        update_info();
        break;
    case 'toggleFavourite':
        toggle_favourite();
        break;
    default:
        die('Invalid action.');
}

// Method to register a new user
function register_user(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../Views/register.php');
        exit;
    }

    $userName = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($userName === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $_SESSION['error'] = 'Please fill in all fields.';
        header('Location: ../Views/register.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please enter a valid email address.';
        header('Location: ../Views/register.php');
        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../Views/register.php');
        exit;
    }

    try {
        $dbManager = DBManager::get_instance();
        $success = $dbManager->create_user($userName, $email, $password);

        if ($success) {
            $_SESSION['success'] = 'Account created successfully.';
            header('Location: ../Views/login.php');
            exit;
        }

        $_SESSION['error'] = 'Could not create account.';
        header('Location: ../Views/register.php');
        exit;

    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = 'This email may already be registered.';
        header('Location: ../Views/register.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header('Location: ../Views/register.php');
        exit;
    }
}

// Method to login a user
function login_user(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../Views/login.php');
        exit;
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $_SESSION['error'] = 'Please fill in all fields.';
        header('Location: ../Views/login.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please enter a valid email address.';
        header('Location: ../Views/login.php');
        exit;
    }

    try {
        $dbManager = DBManager::get_instance();
        $user = $dbManager->user_sign_in($email, $password);

        if ($user !== null) {
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_picture'] = $user['profile_picture'] ?? 'images/profile_sample.jpg';

            $_SESSION['success'] = 'Login successful.';
            header('Location: ../Views/index.php');
            exit;
        }

        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: ../Views/login.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header('Location: ../Views/login.php');
        exit;
    }
}

// Method to logout a user
function logout_user(): void
{
    $_SESSION = [];
    session_destroy();
    header('Location: ../Views/index.php');
    exit;
}

// Method to toggle favourite
function toggle_favourite(): void
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Please log in first.']);
        exit;
    }

    $userId = (int) ($_SESSION['user_id'] ?? 0);
    $movieId = (int) ($_POST['movie_id'] ?? 0);

    if ($userId <= 0 || $movieId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid user or movie ID.']);
        exit;
    }

    try {
        $dbManager = DBManager::get_instance();

        if ($dbManager->is_favourite($userId, $movieId)) {
            $removed = $dbManager->remove_from_favourites($userId, $movieId);

            echo json_encode([
                'success' => $removed,
                'isFavourite' => false,
                'message' => $removed ? 'Removed from favourites.' : 'Could not remove favourite.'
            ]);
            exit;
        }

        // Ensure movie exists in local DB first
        $movie = $dbManager->get_movie_by_id($movieId);

        if (!$movie) {
            require_once __DIR__ . '/../Models/NetworkManager.php';
            $networkManager = NetworkManager::get_instance();
            $movieDetails = $networkManager->get_movie_details($movieId);

            $dbManager->add_movie_to_DB($movieDetails);
        }

        $added = $dbManager->add_to_favourites($userId, $movieId);

        echo json_encode([
            'success' => $added,
            'isFavourite' => true,
            'message' => $added ? 'Added to favourites.' : 'Could not add favourite.'
        ]);
        exit;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

function update_info(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../Views/profile_settings.php');
        exit;
    }

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: ../Views/login.php');
        exit;
    }

    $userId = (int) ($_SESSION['user_id'] ?? 0);
    $userName = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmNewPassword = $_POST['confirm_new_password'] ?? '';
    $profilePicturePath = null;

    if ($userName === '' || $email === '' || $password === '') {
        $_SESSION['error'] = 'Please fill in all fields (including current password to confirm changes).';
        header('Location: ../Views/profile_settings.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Please enter a valid email address.';
        header('Location: ../Views/profile_settings.php');
        exit;
    }

    if ($newPassword !== '' && $newPassword !== $confirmNewPassword) {
        $_SESSION['error'] = 'New passwords do not match.';
        header('Location: ../Views/profile_settings.php');
        exit;
    }

    if ($newPassword !== '' && strlen($newPassword) < 8) {
        $_SESSION['error'] = 'New password must be at least 8 characters long.';
        header('Location: ../Views/profile_settings.php');
        exit;
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'There was a problem uploading the profile picture.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        if ($_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = 'Profile picture must be 2MB or smaller.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['profile_picture']['tmp_name']);
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];

        if (!isset($allowedTypes[$mimeType])) {
            $_SESSION['error'] = 'Only JPG, PNG, and GIF profile pictures are allowed.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        $fileExtension = $allowedTypes[$mimeType];
        $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
        $uploadDir = __DIR__ . '/../Views/images/profile_pics';

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            $_SESSION['error'] = 'Unable to create profile picture directory.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        $targetPath = $uploadDir . '/' . $newFileName;

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
            $_SESSION['error'] = 'Unable to save the uploaded profile picture.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        $profilePicturePath = 'images/profile_pics/' . $newFileName;
    }

    try {
        $dbManager = DBManager::get_instance();
        $user = $dbManager->get_user_by_id($userId);

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Password confirmation failed. Please enter your current password.';
            header('Location: ../Views/profile_settings.php');
            exit;
        }

        $success = $dbManager->user_update_account($userId, $userName, $email, $newPassword, $profilePicturePath);

        if ($success) {
            $_SESSION['username'] = $userName;
            $_SESSION['email'] = $email;
            if ($profilePicturePath !== null) {
                $_SESSION['profile_picture'] = $profilePicturePath;
            } elseif (!isset($_SESSION['profile_picture'])) {
                $_SESSION['profile_picture'] = $user['profile_picture'] ?? 'images/profile_sample.jpg';
            }
            $_SESSION['success'] = 'Profile updated successfully.';
        } else {
            $_SESSION['error'] = 'Could not update profile or no changes were made.';
        }

        header('Location: ../Views/profile_settings.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header('Location: ../Views/profile_settings.php');
        exit;
    }
}