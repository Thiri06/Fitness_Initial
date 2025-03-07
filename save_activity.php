<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity']) && isset($_POST['met'])) {
    $newActivity = [
        "Activity" => $_POST['activity'],
        "METvalue" => floatval($_POST['met'])
    ];

    if (!isset($_SESSION['NewActivities'])) {
        $_SESSION['NewActivities'] = [];
    }

    $_SESSION['NewActivities'][] = $newActivity;

    echo json_encode(["success" => true]);
    exit;
}

echo json_encode(["success" => false]);
