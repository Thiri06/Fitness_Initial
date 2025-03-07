# FitTrack - Fitness Activity Tracking System

FitTrack is a web-based fitness tracking application that helps users monitor their physical activities, weight progress, and BMI changes over time.

## Features

- User authentication and session management
- Activity logging with duration and intensity tracking
- Automatic calorie burn calculations based on MET values
- Weight progress monitoring
- BMI tracking and calculations
- Support for both metric (KG) and imperial (LB) units
- Basic and extended statistics dashboard
- Visual progress indicators

## Tech Stack

- PHP 7.4+
- Bootstrap 5.3
- Font Awesome 6.0
- Modern UI with Inter font family
- File-based data storage

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/fittrack.git
```

2. Configure your web server (Apache/Nginx) to serve the application
3. Ensure write permissions for data files:
```bash
chmod 755 ExerciseData.txt
```

## File Structure

- `config.php` - Configuration settings
- `common.php` - Common functions and utilities
- `fileio.php` - File I/O operations
- `basic_activity_log.php` - Basic statistics dashboard
- `extended_activity_log.php` - Advanced analytics dashboard
- `view_log.php` - Activity log viewer
- `login.php` - User authentication

## Usage

1. Log in to your account
2. Record new activities from the main dashboard
3. View your progress in the basic or extended statistics views
4. Track weight changes and BMI progress
5. Monitor calorie burn and activity duration
