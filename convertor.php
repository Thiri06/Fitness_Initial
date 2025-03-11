<?php
include 'common.php';

$conversionResult = ""; // Variable to store conversion result

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $amount = floatval($_POST["amount"]);
//     $conversionType = $_POST["conversion_type"];

//     $apiKey = '47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c'; // Replace with your actual API key

//     // Set API URL based on user selection
//     if ($conversionType == "kg_to_lb") {
//         $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=weight&fromUnit=kilogram&toUnit=pound&fromValue=$amount";
//     } elseif ($conversionType == "lb_to_kg") {
//         $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=weight&fromUnit=pound&toUnit=kilogram&fromValue=$amount";
//     } elseif ($conversionType == "m_to_ft") {
//         $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=length&fromUnit=meter&toUnit=feet&fromValue=$amount";
//     } else {
//         $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=length&fromUnit=feet&toUnit=meter&fromValue=$amount";
//     }


//     // Call API using cURL
//     $curl = curl_init();
//     curl_setopt_array($curl, [
//         CURLOPT_URL => $url,
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_SSL_VERIFYPEER => false, // 🔥 Disable SSL verification
//         CURLOPT_SSL_VERIFYHOST => false, // 🔥 Disable SSL hostname verification
//         CURLOPT_HTTPHEADER => [
//             "X-RapidAPI-Key: $apiKey",
//             "X-RapidAPI-Host: unit-measurement-conversion.p.rapidapi.com"
//         ]
//     ]);


//     $response = curl_exec($curl);
//     $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // ✅ Fix: Properly get HTTP response code
//     $curlError = curl_error($curl); // Check for cURL errors
//     curl_close($curl);



//     // Decode JSON response
//     $data = json_decode($response, true);

//     // Display conversion result
//     if ($httpCode == 200 && isset($data['value'])) {
//         $conversionResult = "$amount " .
//             ($conversionType == "kg_to_lb" ? "kg" : ($conversionType == "lb_to_kg" ? "lb" : ($conversionType == "m_to_ft" ? "m" : "ft"))) .
//             " = " . $data['value'] . " " . $data['abbreviation'];
//     } else {
//         $conversionResult = "Conversion error. Please try again.";
//     }
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $amount = floatval($_POST["amount"]);

    // Add positive value validation
    if ($amount <= 0) {
        $conversionResult = "Please enter a positive value";
    } else {
        $conversionType = $_POST["conversion_type"];

        // Use the existing API functions with proper formatting
        switch ($conversionType) {
            case "kg_to_lb":
                $result = kilosToPoundsWebService($amount);
                $conversionResult = "$amount kg = $result";
                break;
            case "lb_to_kg":
                $result = poundsToKilosWebService($amount);
                $conversionResult = "$amount lb = $result";
                break;
            case "m_to_ft":
                $result = metersToFeetWebService($amount);
                $conversionResult = "$amount m = $result";
                break;
            case "ft_to_m":
                $result = feetToMetersWebService($amount);
                $conversionResult = "$amount ft = $result";
                break;
        }

        if (!$result || $result == "Conversion error") {
            $conversionResult = "Conversion error. Please try again.";
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

        .converter-card {
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


        .btn-convert {
            background: #5346fe;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-convert:hover {
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

        .conversion-info {
            background: rgba(83, 70, 254, 0.05);
            border-radius: 12px;
            padding: 15px;
            margin-top: 25px;
        }

        .conversion-info-title {
            font-weight: 600;
            color: #382cd9;
            margin-bottom: 10px;
        }

        .conversion-rate {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .conversion-rate i {
            color: #5346fe;
            margin-right: 10px;
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
                <h1 class="header-title">Unit Converter</h1>
                <p class="header-subtitle">Convert between metric and imperial measurements easily</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="converter-card mb-5">
                    <form id="converterForm" method="post">
                        <select class="form-select" id="conversion_type" name="conversion_type" required>
                            <option value="kg_to_lb">Kilograms to Pounds</option>
                            <option value="lb_to_kg">Pounds to Kilograms</option>
                            <option value="m_to_ft">Meters to Feet</option>
                            <option value="ft_to_m">Feet to Meters</option>
                        </select>

                        <div class="mb-4">
                            <input type="number" class="form-control" id="amount" step="0.01" name="amount" placeholder="Enter value" required min="0">
                        </div>

                        <button type="submit" class="btn btn-convert">
                            <i class="fas fa-exchange-alt me-2"></i>Convert
                        </button>

                        <?php if ($conversionResult): ?>
                            <div class="result-box">
                                <div class="result-unit" id="resultUnit">Result</div>
                                <div class="result-value" id="resultValue"><?php echo $conversionResult; ?></div>
                            </div>
                        <?php endif; ?>
                        <div class="conversion-info">
                            <!-- <div class="conversion-info-title">
                                <i class="fas fa-info-circle me-2"></i>Conversion Rates
                            </div> -->
                            <div class="conversion-rate">
                                <i class="fas fa-circle"></i>Powered by RapidAPI
                            </div>
                            <!-- <div class="conversion-rate">
                                <i class="fas fa-circle"></i>1 Kilogram = 2.2 Pounds
                            </div>
                            <div class="conversion-rate">
                                <i class="fas fa-circle"></i>1 Meter = 3.28084 Feet
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>