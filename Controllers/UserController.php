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
    header('Location: ../Views/login.php');
    exit;
}