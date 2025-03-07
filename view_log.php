<?php
include 'config.php';
include 'fileio.php';
include 'common.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Load default data
$defaultData = LoadDefaultData();
if (count($defaultData) == 4) {
    $startHeight = $defaultData[0];
    $startWeight = $defaultData[1];
    $startBMI = $defaultData[2];
    $units = $defaultData[3]; // Get the unit system (KG or LB)
} else {
    $startHeight = 0;
    $startWeight = 0;
    $startBMI = 0;
    $units = 'KG';
}

// Load activity data
$activityData = LoadActivityRecords();

// Calculate totals
$totalDuration = 0;
$totalCalories = 0;
$totalWeightLoss = 0;
foreach ($activityData as $line) {
    $parts = explode(", ", $line);
    if (count($parts) == 5) {
        $duration = floatval($parts[1]);
        $calories = floatval($parts[2]);
        $weightLost = floatval($parts[3]);
        $totalDuration += $duration;
        $totalCalories += $calories;
        $totalWeightLoss += $weightLost;
    }
}

// Convert stats if units are in pounds
if ($units == 'LB') {
    $displayWeight = KilosToPounds($startWeight);
    $displayHeight = MeterToFeet($startHeight);
    $displayWeightLoss = KilosToPounds($totalWeightLoss);
    $displayBMI = $startBMI; // Use stored BMI directly
} else {
    $displayWeight = $startWeight;
    $displayHeight = $startHeight;
    $displayWeightLoss = $totalWeightLoss;
    $displayBMI = $startBMI;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - FitTrack</title>
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

        .header-section {
            background: linear-gradient(135deg, #382cd9 0%, #867ff4 100%);
            padding: 60px 0 100px;
            margin-bottom: -60px;
            position: relative;
        }

        .header-content {
            color: white;
            text-align: center;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            position: relative;
            border-left: 4px solid #5346fe;
            /* Accent color border */
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            color: #382cd9;
            font-size: 1.8rem;
            margin-right: 10px;
        }

        .stat-title {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #382cd9;
            font-size: 1.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        .activity-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            animation: slideUp 0.6s ease forwards;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: rgba(83, 70, 254, 0.05);
            border-bottom: none;
            color: #382cd9;
            font-weight: 600;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #0b0a18;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:hover {
            background-color: rgba(83, 70, 254, 0.02);
        }

        .btn-back {
            background: #5346fe;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: #382cd9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(83, 70, 254, 0.2);
            color: white;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

    <section class="header-section">
        <div class="container">
            <div class="header-content">
                <h1 class="header-title">Your Activity Log</h1>
                <p class="header-subtitle">Track your progress and celebrate your achievements</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="stats-grid mt-5">
            <div class="stat-card">
                <div class="stat-title">Total Duration</div>
                <div class="stat-value">
                    <i class="fas fa-clock stat-icon"></i><?php echo $totalDuration; ?> mins
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Calories Burned</div>
                <div class="stat-value">
                    <i class="fas fa-fire stat-icon"></i><?php echo round($totalCalories, 2); ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Weight Lost</div>
                <div class="stat-value">
                    <i class="fas fa-arrow-down stat-icon"></i>
                    <?php echo round($displayWeightLoss, 2); ?> <?php echo $units; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Current BMI</div>
                <div class="stat-value">
                    <i class="fas fa-weight stat-icon"></i>
                    <?php echo round($displayBMI, 2); ?>
                </div>
            </div>
        </div>

        <div class="activity-card">
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                Measurements shown in: <?php echo $units == 'KG' ? 'Kilograms (KG)' : 'Pounds (LB)'; ?>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Duration (mins)</th>
                        <th>Calories Burned (kcal)</th>
                        <th>Weight Lost (<?php echo $units; ?>)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activityData as $line): ?>
                        <?php
                        $record = explode(", ", trim($line));
                        if (count($record) == 5):
                            $weightLost = floatval($record[3]);
                            if ($units == 'LB') {
                                $weightLost = KilosToPounds($weightLost);
                            }
                        ?>
                            <tr>
                                <td><?php echo $record[0]; ?></td>
                                <td><?php echo $record[1]; ?></td>
                                <td><?php echo $record[2]; ?></td>
                                <td><?php echo round($weightLost, 2); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <a href="basic_activity_log.php" class="btn btn-primary me-3" style="background: #382cd9;">
                        <i class="fas fa-list me-2"></i>Basic Activity Log
                    </a>
                    <a href="extended_activity_log.php" class="btn btn-primary" style="background: #5346fe;">
                        <i class="fas fa-chart-bar me-2"></i>Extended Activity Log
                    </a>
                </div>
            </div>
        </div>


        <div class="text-center mb-5">
            <a href="main.php" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>