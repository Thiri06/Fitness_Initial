<?php

// Include common functions
include 'common.php';

// Initialize variables
$bmiResult = "";
$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit = $_POST['unit'];
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);

    if ($weight <= 0 || $height <= 0) {
        $error = "Please enter valid positive values for weight and height.";
    } else {
        // Call API function
        $bmi = bmiCalculatorWebService($weight, $height, $unit);
        if ($bmi !== false) {
            $bmiResult = "Your BMI is: <strong>$bmi</strong>";
        } else {
            $error = "BMI conversion error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Converter - FitTrack</title>
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

        .calculator-card {
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

        .form-select {
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            padding: 12px 20px;
            height: auto;
            font-size: 1rem;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #5346fe;
            box-shadow: 0 0 0 3px rgba(83, 70, 254, 0.2);
        }

        .form-label {
            color: #0b0a18;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .input-group {
            margin-bottom: 25px;
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
            transform: scale(1.02);
            border-color: #5346fe;
            box-shadow: 0 0 20px rgba(83, 70, 254, 0.15);
        }


        .btn-calculate {
            background: #5346fe;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-calculate:hover {
            background: #382cd9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(83, 70, 254, 0.2);
        }

        .result-box {
            background: rgba(83, 70, 254, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .result-value {
            font-size: 2rem;
            font-weight: 700;
            color: rgb(47, 215, 10);
            margin-bottom: 5px;
        }

        .result-unit {
            color: #666;
            font-size: 0.9rem;
        }
    </style>

    <script>
        function updateLabels() {
            var unit = document.getElementById("unit").value;
            document.getElementById("weightLabel").innerText = unit === "metric" ? "Weight (kg)" : "Weight (lbs)";
            document.getElementById("heightLabel").innerText = unit === "metric" ? "Height (m)" : "Height (in)";
        }
    </script>

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

    <!-- BMI Form Container -->
    <section class="header-section">
        <div class="container">
            <div class="header-content">
                <h1 class="header-title">BMI Calculator</h1>
                <p class="header-subtitle">Calculate your BMI value in both metric and imperial unit easily.</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="calculator-card">
                    <form method="post" id="calculatorForm">
                        <label for="unit" class="form-label">Select Unit System</label>
                        <select class="form-select" id="unit" name="unit" onchange="updateLabels()" required>
                            <option value="metric" selected>Metric (kg/m)</option>
                            <option value="imperial">Imperial (lbs/in)</option>
                        </select>

                        <div class="mb-4">
                            <label for="weight" class="form-label" id="weightLabel">Weight (kg)</label>
                            <input type="number" class="form-control" id="inputValue" name="weight" step="0.01" placeholder="Enter weight">
                        </div>

                        <div class="mb-4">
                            <label for="height" class="form-label" id="heightLabel">Height (m)</label>
                            <input type="number" class="form-control" id="inputValue" name="height" step="0.01" placeholder="Enter height">
                        </div>


                        <!-- Calculate Button -->
                        <button type="submit" class="btn btn-calculate mb-4">Calculate BMI</button>

                        <!-- Display Result -->
                        <div class="text-center mt-3 mb-2">
                            <?php if ($bmiResult): ?>
                                <div class="result-box">
                                    <div class="result-unit" id="resultUnit">Result</div>
                                    <div class="result-value" id="resultValue">Your BMI is <?php echo $bmi; ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($error) echo "<p class='error'>$error</p>"; ?>
                        </div>
                    </form>
                </div>

                <!-- Bootstrap JS -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>