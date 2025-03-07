<?php
// Include configuration file
include 'config.php';

// Check if user is not logged in
/**
 * Checks if the user is logged in and redirects to the login page if not.
 * This code is used to ensure that only authenticated users can access the main application.
 */

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    // Redirect to login page if not authenticated
    header('Location: login.php');

    // Stop script execution
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f3fc;
            color: #0b0a18;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #382cd9 0%, #867ff4 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 800;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            font-size: 1.6rem;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 10px;
        }

        .logo-text {
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .navbar-nav .separator {
            color: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
        }

        @media (max-width: 991.98px) {
            .navbar-nav .separator {
                display: none;
            }
        }

        .welcome-section {
            background: linear-gradient(135deg, #382cd9 0%, #867ff4 100%);
            padding: 60px 0;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="2" fill="white" fill-opacity="0.1"/></svg>') repeat;
            opacity: 0.3;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
            color: white;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .success-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(83, 70, 254, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: opacity 0.5s ease;
        }

        .success-icon {
            color: #28a745;
            font-size: 2rem;
        }

        .success-content h4 {
            color: #0b0a18;
            margin-bottom: 5px;
        }

        .success-content p {
            color: #666;
            margin-bottom: 0;
        }

        .dashboard-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: #0b0a18;
            display: block;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(83, 70, 254, 0.1);
            color: #0b0a18;
        }

        .card-icon {
            font-size: 2.5rem;
            color: #382cd9;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease forwards;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="main.php">
                <i class="me-2">💪</i>
                <span class="logo-text">FitTrack</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="enter_data.php">Enter Data</a>
                    </li>
                    <li class="nav-item separator">|</li>
                    <li class="nav-item">
                        <a class="nav-link" href="record_activity.php">Record Activity</a>
                    </li>
                    <li class="nav-item separator">|</li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_log.php">View Log</a>
                    </li>
                    <li class="nav-item separator">|</li>
                    <li class="nav-item">
                        <a class="nav-link" href="convertor.php">Convertor</a>
                    </li>
                    <li class="nav-item separator">|</li>
                    <li class="nav-item">
                        <a class="nav-link" href="bmi_calculator.php">BMI Calculator</a>
                    </li>
                    <li class="nav-item separator">|</li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="welcome-section">
        <div class="container">
            <div class="welcome-content">
                <h1 class="welcome-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p class="welcome-subtitle">Track your progress and achieve your fitness goals with FitTrack.</p>
            </div>
        </div>
    </section>
    <?php if (isset($_SESSION['data_updated'])): ?>
        <div class="container">
            <div class="success-card animate-fade-up">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="success-content">
                    <h4>Data Updated Successfully!</h4>
                    <p>Your height and weight measurements have been updated.</p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['data_updated']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['activity_recorded'])): ?>
        <div class="container">
            <div class="success-card animate-fade-up">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="success-content">
                    <h4>Activity Recorded Successfully!</h4>
                    <p>Your workout has been added to your activity log.</p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['activity_recorded']); ?>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="enter_data.php" class="dashboard-card animate-fade-up" style="animation-delay: 0.1s">
                    <div class="card-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="card-title">Enter/Update Data</h3>
                    <p class="card-description">Update your measurements and track your progress over time.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="record_activity.php" class="dashboard-card animate-fade-up" style="animation-delay: 0.2s">
                    <div class="card-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3 class="card-title">Record Activity</h3>
                    <p class="card-description">Log your workouts and monitor your exercise routine.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="view_log.php" class="dashboard-card animate-fade-up" style="animation-delay: 0.3s">
                    <div class="card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="card-title">View Progress</h3>
                    <p class="card-description">Check your activity history and track your improvements.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="convertor.php" class="dashboard-card animate-fade-up" style="animation-delay: 0.4s">
                    <div class="card-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3 class="card-title">Unit Converter</h3>
                    <p class="card-description">Convert between metric and imperial measurements easily.</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="bmi_calculator.php" class="dashboard-card animate-fade-up" style="animation-delay: 0.5s">
                    <div class="card-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="card-title">BMI Calculator</h3>
                    <p class="card-description">Calculate and track your Body Mass Index.</p>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Make success card disappear after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successCard = document.querySelector('.success-card');
            if (successCard) {
                setTimeout(() => {
                    successCard.style.opacity = '0'; // Fade out
                    setTimeout(() => {
                        successCard.remove(); // Remove from DOM after fade
                    }, 500); // Match the CSS transition duration
                }, 3000); // 3 seconds delay
            }
        });
    </script>
</body>

</html>