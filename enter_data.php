<?php
include 'config.php';
include 'fileio.php';
include 'common.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Load current data from file
$defaultData = LoadDefaultData();

// Check if user data is available
if (count($defaultData) == 4) {
    $startHeight = $defaultData[0];
    $startWeight = $defaultData[1];
    $units = $defaultData[3];
} else {
    $startHeight = '';
    $startWeight = '';
    $units = 'KG';
}

// Handle unit conversion
if (isset($_POST['convert_unit'])) {
    if ($units == 'KG') {
        // Convert from metric to imperial
        $startWeight = KilosToPounds($startWeight);
        $startHeight = MeterToFeet($startHeight);
        $units = 'LB';
    } else {
        // Convert from imperial to metric
        $startWeight = PoundsToKilos($startWeight);
        $startHeight = FeetToMeter($startHeight);
        $units = 'KG';
    }
    // Recalculate BMI based on the new units
    $bmi = ($units == 'KG') ? BMICalculator($startWeight, $startHeight) : BMICalculatorImperial($startWeight, $startHeight);

    InsertNewUserData($startHeight, $startWeight, $bmi, $units);
}

// Handle form submission for new measurements
if (isset($_POST['save_measurements'])) {
    $height = floatval(trim($_POST['height']));
    $weight = floatval(trim($_POST['weight']));

    // Validate inputs
    if ($height <= 0 || $weight <= 0) {
        $error = "Height and weight must be positive numeric numbers.";
    } else {
        // Calculate BMI based on the current unit system
        $bmi = ($units == 'KG') ? BMICalculator($weight, $height) : BMICalculatorImperial($weight, $height);
        if (InsertNewUserData($height, $weight, $bmi, $units)) {
            $_SESSION['data_updated'] = true;
            header('Location: main.php');
            exit;
        } else {
            $error = "Failed to save measurements. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Data - FitTrack</title>
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

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease forwards;
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

        .form-label {
            color: #0b0a18;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
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

        .btn-primary {
            background: #5346fe;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #382cd9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(83, 70, 254, 0.2);
        }

        .btn-secondary {
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
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
                <h1 class="header-title">Update Your Measurements</h1>
                <p class="header-subtitle">Keep track of your progress by updating your current measurements</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="form-card">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($units == 'KG'): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            Current units: Kilograms (kg) and Meters (m)
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            Current units: Pounds (lb) and Feet (ft)
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-4">
                            <label for="height" class="form-label">Height (<?php echo $units == 'KG' ? 'm' : 'ft'; ?>)</label>
                            <input type="number" step="0.01" class="form-control" id="height" name="height"
                                value="<?php echo htmlspecialchars($startHeight); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="weight" class="form-label">Weight (<?php echo $units == 'KG' ? 'kg' : 'lb'; ?>)</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                                value="<?php echo htmlspecialchars($startWeight); ?>" required>
                        </div>

                        <div class="conversion-info mb-4">
                            <small class="text-muted">
                                Conversion rates:<br>
                                1 KG = 2.2 LB<br>
                                1 M = 3.28 FT
                            </small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="convert_unit" class="btn btn-secondary">
                                Convert To <?php echo $units == 'KG' ? 'Pounds' : 'Kilograms'; ?>
                            </button>
                            <button type="submit" name="save_measurements" class="btn btn-primary px-5">Save</button>
                            <a href="main.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>