<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initial Setup Required - FitTrack</title>
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
            letter-spacing: -0.5px;
        }

        .setup-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        .setup-icon {
            font-size: 4rem;
            color: #382cd9;
            margin-bottom: 1.5rem;
        }

        .btn-setup {
            background: #5346fe;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px 40px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-setup:hover {
            background: #382cd9;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="main.php">
                <i class="me-2">💪</i>
                <span>FitTrack</span>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="setup-card text-center">
                    <i class="fas fa-clipboard-list setup-icon"></i>
                    <h1 class="mb-4">Initial Setup Required</h1>
                    <p class="lead mb-4">Before you can track your activities, we need your initial measurements to calculate accurate results.</p>
                    <a href="enter_data.php" class="btn btn-setup">
                        <i class="fas fa-arrow-right me-2"></i>Enter Your Measurements
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>