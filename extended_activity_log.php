<?php
include 'config.php';
include 'fileio.php';
include 'common.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$defaultData = LoadDefaultData();
$units = $defaultData[3];
$displayWeightUnit = ($units == 'LB') ? 'LB' : 'KG';

// Extended calculations
$avgCalories = calculateAverageCaloriesBurned();

$maxCaloriesData = findLargestCaloriesBurned();

$biggestInterval = findBiggestWeightLossInterval($units);

$displayInterval = ($units == 'LB') ? KilosToPounds($biggestInterval) : $biggestInterval;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Analytics - FitTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }

        .analytics-header {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            padding: 50px 0;
            color: white;
            margin-bottom: 40px;
        }

        .insight-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .insight-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #1a2a6c, #b21f1f);
        }

        .insight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .metric-title {
            font-size: 1.1rem;
            color: #1a2a6c;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .metric-context {
            font-size: 0.9rem;
            color: #636e72;
            margin-top: 10px;
        }

        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .trend-positive {
            background-color: #d4edda;
            color: #155724;
        }

        .trend-neutral {
            background-color: #fff3cd;
            color: #856404;
        }

        .metric-icon {
            font-size: 2.5rem;
            color: #1a2a6c;
            opacity: 0.1;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .btn-nav {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="analytics-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Advanced Analytics</h1>
                    <p class="mb-0">Detailed insights for <?php echo htmlspecialchars($username); ?></p>
                </div>
                <div>
                    <a href="view_log.php" class="btn btn-nav me-2">
                        <i class="fas fa-list me-2"></i>Activity Log
                    </a>
                    <a href="basic_activity_log.php" class="btn btn-nav">
                        <i class="fas fa-chart-simple me-2"></i>Basic Stats
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Average Calories Card -->
            <div class="col-md-4">
                <div class="insight-card">
                    <i class="fas fa-fire-flame-curved metric-icon"></i>
                    <div class="metric-title">Average Calories Burned</div>
                    <div class="metric-value"><?php echo round($avgCalories, 1); ?></div>
                    <div class="metric-context">kcal per activity session</div>
                    <div class="trend-indicator trend-positive">
                        <i class="fas fa-arrow-up me-2"></i>12% vs. Last Month
                    </div>
                </div>
            </div>

            <!-- Peak Performance Card -->
            <div class="col-md-4">
                <div class="insight-card">
                    <i class="fas fa-trophy metric-icon"></i>
                    <div class="metric-title">Peak Performance</div>
                    <div class="metric-value"><?php echo $maxCaloriesData['calories']; ?></div>
                    <div class="metric-context">
                        Highest calories burned in one session
                    </div>
                    <div class="metric-context">
                        Activity: <?php echo $maxCaloriesData['activity']; ?>
                    </div>
                </div>
            </div>

            <!-- Weight Loss Progress Card -->
            <div class="col-md-4">
                <div class="insight-card">
                    <i class="fas fa-weight-scale metric-icon"></i>
                    <div class="metric-title">Best Weight Loss Interval</div>
                    <div class="metric-value">
                        <?php echo round($displayInterval, 2); ?>
                        <span class="fs-4"><?php echo $displayWeightUnit; ?></span>
                    </div>
                    <div class="metric-context">Maximum weight loss between sessions</div>
                    <div class="trend-indicator trend-neutral">
                        <i class="fas fa-arrows-left-right me-2"></i>Consistent Progress
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>