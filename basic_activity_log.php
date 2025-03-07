<?php
include 'config.php';
include 'fileio.php';
include 'common.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Load and calculate data
$defaultData = LoadDefaultData();
$username = $_SESSION['username'];
$startHeight = $defaultData[0];
$startWeight = $defaultData[1];
$startBMI = $defaultData[2];
$units = $defaultData[3];

$displayWeight = ($units == 'LB') ? KilosToPounds($startWeight) : $startWeight;
$displayWeightUnit = ($units == 'LB') ? 'lbs' : 'kg';

$activityData = LoadActivityRecords();

// Calculate totals
$totalDuration = 0;
$totalCalories = 0;
$totalWeightLoss = 0;

foreach ($activityData as $line) {
    $parts = explode(", ", $line);
    if (count($parts) == 5) {
        $totalDuration += floatval($parts[1]);
        $totalCalories += floatval($parts[2]);
        $totalWeightLoss += floatval($parts[3]);
    }
}

$newWeight = $startWeight - $totalWeightLoss;
$newBMI = BMICalculator($newWeight, $startHeight);
$displayWeightLoss = ($units == 'LB') ? KilosToPounds($totalWeightLoss) : $totalWeightLoss;
$displayNewWeight = ($units == 'LB') ? KilosToPounds($newWeight) : $newWeight;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Stats - FitTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f3fc;
            color: #0b0a18;
        }

        .header-section {
            background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
            padding: 60px 0;
            color: white;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(83, 70, 254, 0.1);
            border-left: 4px solid #5346fe;
            transition: transform 0.2s ease;
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #382cd9;
            opacity: 0.2;
        }

        .stat-title {
            color: #382cd9;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0b0a18;
            margin-bottom: 10px;
        }

        .stat-trend {
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trend-up {
            color: #22c55e;
        }

        .trend-down {
            color: #ef4444;
        }

        .stats-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #382cd9;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>

<body>
    <div class="header-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Activity Statistics</h1>
                    <p class="mb-0">Hello, <?php echo htmlspecialchars($username); ?></p>
                </div>
                <a href="view_log.php" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Back to Log
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Activity Stats -->
        <div class="stats-section">
            <h2 class="section-title">Activity Overview</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-clock stat-icon"></i>
                        <div class="stat-title">Total Duration</div>
                        <div class="stat-value"><?php echo $totalDuration; ?> mins</div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up trend-up"></i>
                            <span>15% increase from last week</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-fire stat-icon"></i>
                        <div class="stat-title">Total Calories Burned</div>
                        <div class="stat-value"><?php echo round($totalCalories, 2); ?> kcal</div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up trend-up"></i>
                            <span>20% above target</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weight Progress -->
        <div class="stats-section">
            <h2 class="section-title">Weight Progress</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-weight-scale stat-icon"></i>
                        <div class="stat-title">Starting Weight</div>
                        <div class="stat-value"><?php echo $displayWeight . ' ' . $displayWeightUnit; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-chart-line stat-icon"></i>
                        <div class="stat-title">Weight Lost</div>
                        <div class="stat-value"><?php echo round($displayWeightLoss, 2) . ' ' . $displayWeightUnit; ?></div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up trend-up"></i>
                            <span>Steady progress</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-scale-balanced stat-icon"></i>
                        <div class="stat-title">Current Weight</div>
                        <div class="stat-value"><?php echo round($displayNewWeight, 2) . ' ' . $displayWeightUnit; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMI Progress -->
        <div class="stats-section">
            <h2 class="section-title">BMI Progress</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-chart-simple stat-icon"></i>
                        <div class="stat-title">Starting BMI</div>
                        <div class="stat-value"><?php echo $startBMI; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-chart-line stat-icon"></i>
                        <div class="stat-title">Current BMI</div>
                        <div class="stat-value"><?php echo round($newBMI, 2); ?></div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up trend-up"></i>
                            <span>Improving</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>