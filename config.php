<?php
session_start();

// List of users for authentication
$ListofUsers = [
    ["UserName" => "Eaint", "Password" => "Eaint01"],
    ["UserName" => "Thiri", "Password" => "Thiri01"],
    ["UserName" => "Mon", "Password" => "Mon01"]
];

// List of activities with MET values as per project scenario
$ListofActivities = [
    ["Activity" => "Cycling", "METvalue" => 7.5],
    ["Activity" => "Circuits", "METvalue" => 4.3],
    ["Activity" => "Rowing", "METvalue" => 12],
    ["Activity" => "Yoga", "METvalue" => 2.5],
    ["Activity" => "Aerobics", "METvalue" => 9.5],
    ["Activity" => "Weight", "METvalue" => 5],
    ["Activity" => "Running", "METvalue" => 8]
];
// Additional activities that can be added
$NewActivities = [
    ["Activity" => "Swimming", "METvalue" => 6.0],
    ["Activity" => "Basketball", "METvalue" => 8.0],
    ["Activity" => "Tennis", "METvalue" => 7.0],
    ["Activity" => "Dancing", "METvalue" => 4.8],
    ["Activity" => "Hiking", "METvalue" => 5.3],
    ["Activity" => "Boxing", "METvalue" => 9.0],
    ["Activity" => "Pilates", "METvalue" => 3.0]
];

// Load additional activities from session
if (isset($_SESSION['NewActivities']) && is_array($_SESSION['NewActivities'])) {
    $ListofActivities = array_merge($ListofActivities, $_SESSION['NewActivities']);
}

// default time interval
//$duration = 30; // Fixed at 30 minutes as per Python code
$units = "KG";  // Fixed at KG as per Python code
