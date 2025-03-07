<?php
// Include configuration file
include 'config.php';

// Check if form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize username and password from POST data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // Initialize login status flag
    $loginSuccessful = false;

    // Iterate through user list to check credentials
    // Check if the provided username and password match any in the list
    foreach ($ListofUsers as $user) {
        // Compare username and password case-insensitively
        if (strtolower($user['UserName']) == strtolower($username) && $user['Password'] == $password) {
            // Set login status to true if credentials match
            $loginSuccessful = true;
            break;
        }
    }

    if ($loginSuccessful) {
        // Set session variable to indicate the user is logged in
        $_SESSION['logged_in'] = true;
        // Store username status in session
        $_SESSION['username'] = $username;
        // Redirect to the main page (replace 'main.php' with your actual main page)
        header('Location: main.php');
        // Stop script execution
        exit;
    } else {
        // Set error message for invalid credentials
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #382cd9 0%, #867ff4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -100px;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(30px, 30px) rotate(180deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 2;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #382cd9;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            padding: 12px 20px;
            height: auto;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #5346fe;
            box-shadow: 0 0 0 3px rgba(83, 70, 254, 0.2);
        }

        .form-label {
            color: #0b0a18;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .btn-login {
            background: #5346fe;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #382cd9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(83, 70, 254, 0.2);
        }

        .back-to-home {
            color: white;
            text-decoration: none;
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            z-index: 3;
        }

        .back-to-home:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <a href="index.php" class="back-to-home">
        <i class="fas fa-arrow-left me-2"></i> Back to Home
    </a>

    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to continue your fitness journey</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login">
                Sign In <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>
    </div>
</body>

</html>