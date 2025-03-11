<?php
include 'config.php';
include 'fileio.php';
include 'common.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $activity = $_POST['activity'];
    $duration = intval($_POST['duration']); // Get user input duration

    // Find MET value for the activity
    $METvalue = 0;
    foreach ($ListofActivities as $act) {
        if ($act['Activity'] == $activity) {
            $METvalue = $act['METvalue'];
            break;
        }
    }
    // Load current data
    $defaultData = LoadDefaultData();

    if (count($defaultData) >= 4) {
        $startWeight = floatval($defaultData[1]);
        $units = $defaultData[3]; // Get the unit system (KG or LB)

        // Convert weight to kilograms if the unit is pounds
        $weightForCalculation = ($units == 'KG') ? $startWeight : PoundsToKilos($startWeight);

        // Calculate calories burned
        $caloriesBurned = CaloriesBurnedInCustomTime($METvalue, $weightForCalculation, $duration);
        // Calculate weight lost
        $weightLost = WeightLostInKilosInCustomTime($METvalue, $weightForCalculation, $duration);

        // Convert weight lost to pounds if the unit is imperial
        if ($units == 'LB') {
            $weightLost = KilosToPounds($weightLost);
        }
        if (AddNewActivityRecord($activity, $duration, $caloriesBurned, $weightLost, $units)) {
            $_SESSION['activity_recorded'] = true;
            header('Location: main.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Activity - FitTrack</title>
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

        .activity-card {
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

        .form-select {
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            padding: 12px 20px;
            height: auto;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
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

        .btn-add {
            background-color: #867ff4;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .activity-info {
            background: rgba(83, 70, 254, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .activity-info-title {
            color: #382cd9;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .activity-info-text {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0;
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
                <h1 class="header-title">Record Your Activity</h1>
                <p class="header-subtitle">Track your workouts and monitor your progress</p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="activity-card">
                    <form method="post">
                        <div class="mb-4">
                            <label for="activity" class="form-label">Select Activity</label>
                            <select class="form-select" id="activity" name="activity" required>
                                <?php foreach ($ListofActivities as $act): ?>
                                    <option value="<?php echo $act['Activity']; ?>">
                                        <?php echo $act['Activity']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="form-label">Duration (minutes)</label>
                            <input type="number" class="form-control" id="duration" name="duration" min="1" required>
                        </div>


                        <div class="activity-info">
                            <h5 class="activity-info-title">Activity Duration</h5>
                            <p class="activity-info-text">Enter the duration of your activity in minutes</p>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-5">Record Activity</button>
                            <a href="main.php" class="btn btn-secondary">Cancel</a>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="button" class="btn btn-add mb-4" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                <i class="fas fa-plus"></i> Add New Activity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="addActivityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="newActivityForm">
                        <div class="mb-3">
                            <label class="form-label">Select New Activity</label>
                            <select class="form-select" id="newActivity" onchange="updateMETValue()">
                                <option value="">Choose activity...</option>
                                <?php foreach ($NewActivities as $activity): ?>
                                    <option value="<?php echo $activity['Activity']; ?>"
                                        data-met="<?php echo $activity['METvalue']; ?>">
                                        <?php echo $activity['Activity']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">MET Value</label>
                            <input type="text" class="form-control" id="metValue" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addNewActivity()">Add Now</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateMETValue() {
            const select = document.getElementById('newActivity');
            const metInput = document.getElementById('metValue');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption && selectedOption.getAttribute('data-met')) {
                metInput.value = selectedOption.getAttribute('data-met');
            } else {
                metInput.value = '';
            }
        }

        function addNewActivity() {
            const select = document.getElementById('newActivity');
            const activitySelect = document.getElementById('activity');
            const selectedActivity = select.value;
            const metValue = document.getElementById('metValue').value;

            if (selectedActivity && metValue) {
                // Add to existing dropdown
                const option = document.createElement('option');
                option.value = selectedActivity;
                option.text = selectedActivity;
                option.setAttribute('data-met', metValue);
                activitySelect.add(option);

                // Automatically select the newly added activity
                activitySelect.value = selectedActivity;

                // Send data to PHP via AJAX to persist changes
                fetch('save_activity.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `activity=${encodeURIComponent(selectedActivity)}&met=${encodeURIComponent(metValue)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Activity saved successfully.");
                        } else {
                            console.error("Error saving activity.");
                        }
                    });

                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('addActivityModal')).hide();
            }
        }
    </script>
</body>

</html>