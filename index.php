<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack - Your Personal Fitness Journey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f3fc;
            color: #0b0a18;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #382cd9 0%, #867ff4 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 100px 0;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
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

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            color: white;
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            animation: fadeInUp 1s ease 0.2s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .btn-start {
            background-color: #867ff4;
            color: white;
            border: none;
            padding: 18px 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: fadeInUp 1s ease 0.4s;
            opacity: 0;
            animation-fill-mode: forwards;
            position: relative;
            overflow: hidden;
        }

        .btn-start:hover {
            background-color: #382cd9;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(83, 70, 254, 0.3);
            color: white;
            text-decoration: none;
        }

        .stats-bar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 50px;
            animation: fadeInUp 1s ease 0.6s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .stat-item {
            text-align: center;
            color: white;
            padding: 20px;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .features-section {
            padding: 100px 0;
            background: #f4f3fc;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            color: #382cd9;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(83, 70, 254, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 25px;
            color: #382cd9;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #0b0a18;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            background: #382cd9;
            color: white;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-7">
                    <h1 class="hero-title">Transform Your <br>Fitness Journey</h1>
                    <p class="hero-subtitle">Track your progress, achieve your goals, and become the best version of yourself with our advanced fitness tracking system.</p>
                    <a href="login.php" class="btn btn-start">
                        Begin Your Journey <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <div class="stats-bar">
                        <div class="row">
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">7+</div>
                                <div class="stat-label">Workout Types</div>
                            </div>
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Accuracy</div>
                            </div>
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Progress Tracking</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose FitTrack?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Track Progress</h3>
                        <p class="feature-description">Monitor your activities and see your improvements over time with detailed analytics and insights.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3 class="feature-title">Multiple Activities</h3>
                        <p class="feature-description">Choose from various exercises including yoga, running, cycling, and more to diversify your fitness routine.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="feature-title">Goal Setting</h3>
                        <p class="feature-description">Set personal fitness goals and track your journey to achieving them with our smart tracking system.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p class="mt-1 mb-0">© 2024 FitTrack. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>