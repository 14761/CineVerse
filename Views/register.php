<?php
session_start();
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
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
            /* Allow scrolling if content is too tall */
            padding: 2rem 0;
        }

        .auth-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: auto;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.6);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .form-label {
            color: #cbd5e1;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(56, 189, 248, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .auth-link {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: #818cf8;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join us to start reviewing movies!</p>
        </div>

        <form action="../Controllers/UserController.php?action=register" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                    required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Create a password" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="login.php" class="auth-link">Log in</a>
        </div>
    </div>

</body>

</html>