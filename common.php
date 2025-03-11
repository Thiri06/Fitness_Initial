<?php

/**
 * An API function that will convert weight from kilograms to pounds
 * @param float $weightInKilos Weight in kilograms
 * @return float Weight in pounds rounded to 2 decimal places
 * RETURNS Weight in pounds rounded to 2 decimal places
 */
function KilosToPounds($weightInKilos)
{
    return round($weightInKilos * 2.2, 2);
}

function PoundsToKilos($weightInPounds)
{
    return round($weightInPounds / 2.2, 2);
}

function MeterToFeet($heightInMeters)
{
    return round($heightInMeters * 3.28084, 2);
}

function FeetToMeter($heightInFeet)
{
    return round($heightInFeet / 3.28084, 2);
}
// ======================== Metric Calculations ========================
/**
 * An API function that will calculate Body Mass Index (BMI) using weight and height
 * @param float $weightInKilos Weight in kilograms
 * @param float $height Height in meters
 * @return float BMI value rounded to 2 decimal places
 * RETURNS BMI value rounded to 2 decimal places
 */
function BMICalculator($weightInKilos, $height)
{
    if ($weightInKilos <= 0 || $height <= 0) {
        throw new InvalidArgumentException("Weight and height must be positive numbers.");
    }
    return round($weightInKilos / ($height * $height), 2);
}

function CaloriesBurnedInCustomTime($METvalue, $weightInKilos, $duration)
{
    $caloriesPerMinute = ($METvalue * $weightInKilos) / 60;
    return round($caloriesPerMinute * $duration, 2);
}

function WeightLostInKilosInCustomTime($METvalue, $weightInKilos, $duration)
{
    $caloriesBurned = CaloriesBurnedInCustomTime($METvalue, $weightInKilos, $duration);
    return round($caloriesBurned / 7700, 2);
}

// ==================================Imperial Calculations============================

/**
 * Calculates BMI using weight in pounds and height in feet
 * @param float $weightInPounds Weight in pounds
 * @param float $heightInFeet Height in feet
 * @return float BMI value rounded to 2 decimal places
 */
function BMICalculatorImperial($weightInPounds, $heightInFeet)
{
    if ($weightInPounds <= 0 || $heightInFeet <= 0) {
        throw new InvalidArgumentException("Weight and height must be positive numbers.");
    }
    // Convert height in feet to inches
    $heightInInches = $heightInFeet * 12;
    // Calculate BMI using the imperial formula
    return round(($weightInPounds * 703) / ($heightInInches * $heightInInches), 2);
}

/**
 * Calculates calories burned using weight in pounds for custom duration
 * @param float $METvalue Activity MET value
 * @param float $weightInPounds Weight in pounds
 * @param float $duration Duration in minutes
 * @return float Calories burned rounded to 2 decimal places
 */
function CaloriesBurnedInCustomTimeImperial($METvalue, $weightInPounds, $duration)
{
    $weightInKg = PoundsToKilos($weightInPounds);
    return CaloriesBurnedInCustomTime($METvalue, $weightInKg, $duration);
}

/**
 * Calculates weight lost in pounds for custom duration
 * @param float $METvalue Activity MET value
 * @param float $weightInPounds Weight in pounds
 * @param float $duration Duration in minutes
 * @return float Weight lost in pounds rounded to 2 decimal places
 */
function WeightLostInPoundsInCustomTime($METvalue, $weightInPounds, $duration)
{
    $caloriesBurned = CaloriesBurnedInCustomTimeImperial($METvalue, $weightInPounds, $duration);
    return round($caloriesBurned / 3500, 2);
}
// =================================Extended API Functions============================
/**
 * Ext_API_15: Calculate average calories burned over all activities
 * @return float Average calories burned rounded to 2 decimal places
 */
function calculateAverageCaloriesBurned()
{
    $activityData = LoadActivityRecords();
    $totalCalories = 0;
    $count = 0;

    if (!empty($activityData)) {
        foreach ($activityData as $line) {
            if (!empty($line)) {
                $parts = explode(", ", $line);
                if (isset($parts[2])) {
                    $totalCalories += floatval($parts[2]);
                    $count++;
                }
            }
        }
    }

    return $count > 0 ? $totalCalories / $count : 0;
}

/**
 * Ext_API_16: Calculate largest amount of calories burned
 * @return float Maximum calories burned in a single activity
 */
function findLargestCaloriesBurned()
{
    $activityData = LoadActivityRecords();
    $maxCalories = 0;
    $maxActivity = '';

    if (!empty($activityData)) {
        foreach ($activityData as $line) {
            if (!empty($line)) {
                $parts = explode(", ", $line);
                if (isset($parts[0]) && isset($parts[2])) {
                    $calories = floatval($parts[2]);
                    if ($calories > $maxCalories) {
                        $maxCalories = $calories;
                        $maxActivity = $parts[0];
                    }
                }
            }
        }
    }
    return ['calories' => round($maxCalories, 2), 'activity' => $maxActivity];
}

/**
 * Ext_API_17: Calculate biggest weight loss interval between activities
 * @param string $units Current unit system (KG or LB)
 * @return float Largest weight loss difference between consecutive activities
 */
function findBiggestWeightLossInterval()
{
    $activityData = LoadActivityRecords();
    $weightLosses = [];

    // First collect all weight loss values
    foreach ($activityData as $line) {
        if (!empty($line)) {
            $parts = explode(", ", $line);
            if (isset($parts[3])) {
                $weightLosses[] = floatval($parts[3]);
            }
        }
    }

    // Sort weight losses to find biggest difference
    if (count($weightLosses) > 0) {
        sort($weightLosses);
        return round($weightLosses[count($weightLosses) - 1] - $weightLosses[0], 2);
    }

    return 0;
}


/**
 * Ext_API_18: Convert kilograms to pounds using RapidAPI
 * @param float $weightInKilos - Weight in kilograms
 * @return float Converted weight in pounds
 */
function kilosToPoundsWebService($weightInKilos)
{
    $apiKey = '47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c'; // Replace with your actual API key
    $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=weight&fromUnit=kilogram&toUnit=pound&fromValue=$weightInKilos";
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Add this
        CURLOPT_SSL_VERIFYHOST => false, // Add this
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Key: $apiKey",
            "X-RapidAPI-Host: unit-measurement-conversion.p.rapidapi.com"
        ]
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    error_log("🔍 Debugging API Response:\nURL: $url\nHTTP Code: $httpCode\nResponse: $response\nError: $curlError");
    curl_close($curl);
    // Convert JSON string to PHP array
    $data = json_decode($response, true);
    // Check if the conversion was successful
    if (isset($data['value'])) {
        return $data['value'] . " " . $data['abbreviation']; // Example: "2.2046 lb"
    } else {
        return "Conversion error";
    }
}

/**
 * Ext_API_19: Convert pounds to kilograms using RapidAPI
 * @param float $weightInPounds - Weight in pounds
 * @return float Converted weight in kilograms
 */
function poundsToKilosWebService($weightInPounds)
{
    $apiKey = '47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c'; // 🔥 Replace with your actual API key
    $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=weight&fromUnit=pound&toUnit=kilogram&fromValue=$weightInPounds";
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Add this
        CURLOPT_SSL_VERIFYHOST => false, // Add this
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Key: $apiKey",
            "X-RapidAPI-Host: unit-measurement-conversion.p.rapidapi.com"
        ]
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    error_log("🔍 Debugging API Response:\nURL: $url\nHTTP Code: $httpCode\nResponse: $response\nError: $curlError");
    curl_close($curl);
    // Convert JSON string to PHP array
    $data = json_decode($response, true);

    // Check if the conversion was successful
    if (isset($data['value'])) {
        return $data['value'] . " " . $data['abbreviation']; // Example: "2.2046 lb"
    } else {
        return "Conversion error";
    }
}
// Meter To Feet

function metersToFeetWebService($heightInMeters)
{
    $apiKey = '47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c'; // 🔥 Replace with your actual API key
    $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=length&fromUnit=meter&toUnit=feet&fromValue=$heightInMeters";
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Add this
        CURLOPT_SSL_VERIFYHOST => false, // Add this
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Key: $apiKey",
            "X-RapidAPI-Host: unit-measurement-conversion.p.rapidapi.com"
        ]
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    error_log("🔍 Debugging API Response:\nURL: $url\nHTTP Code: $httpCode\nResponse: $response\nError: $curlError");
    curl_close($curl);

    // Convert JSON string to PHP array
    $data = json_decode($response, true);

    // Check if the conversion was successful
    if (isset($data['value'])) {
        return $data['value'] . " " . $data['abbreviation']; // Example: "2.2046 lb"
    } else {
        return "Conversion error";
    }
}
// Feet To Meter
function feetToMetersWebService($heightInFeet)
{
    $apiKey = '47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c'; // 🔥 Replace with your actual API key
    $url = "https://unit-measurement-conversion.p.rapidapi.com/convert?type=length&fromUnit=feet&toUnit=meter&fromValue=$heightInFeet";
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Add this
        CURLOPT_SSL_VERIFYHOST => false, // Add this
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Key: $apiKey",
            "X-RapidAPI-Host: unit-measurement-conversion.p.rapidapi.com"
        ]
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    error_log("🔍 Debugging API Response:\nURL: $url\nHTTP Code: $httpCode\nResponse: $response\nError: $curlError");
    curl_close($curl);
    // Convert JSON string to PHP array
    $data = json_decode($response, true);

    // Check if the conversion was successful
    if (isset($data['value'])) {
        return $data['value'] . " " . $data['abbreviation']; // Example: "2.2046 lb"
    } else {
        return "Conversion error";
    }
}

//  BMI calculations.  

/**
 * Ext_API_20: Calculates BMI using an online service API.
 * Supports both metric (kg/m) and imperial (lbs/inches) systems.
 *
 * @param float $weight - Weight of the person (kg or lbs).
 * @param float $height - Height of the person (m or inches).
 * @param string $unit - Measurement system ("metric" for kg/m, "imperial" for lbs/inches).
 * @return float|bool - BMI value or false on failure.
 */
function bmiCalculatorWebService($weight, $height, $unit = "metric")
{
    $apiKey = "47aa2183f5msh38cd0fce4a47025p1d3e85jsn3e3ea4b8426c";  // 🔥 Replace with your actual API key
    $headers = [
        "X-RapidAPI-Key: $apiKey",
        "X-RapidAPI-Host: smart-body-mass-index-calculator-bmi.p.rapidapi.com"
    ];
    // Set API URL based on unit system
    if ($unit === "metric") {
        $heightInCm = $height * 100;
        $url = "https://smart-body-mass-index-calculator-bmi.p.rapidapi.com/api/BMI/metric?kg=$weight&cm=$heightInCm";
    } else {
        // Convert metric to imperial format
        $url = "https://smart-body-mass-index-calculator-bmi.p.rapidapi.com/api/BMI/imperial?lbs=$weight&inches=$height";
    }
    // Initialize cURL session
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false, // 🔥 Remove this in production (use Fix 2 from SSL guide)
        CURLOPT_HTTPHEADER => $headers
    ]);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);
    // Debugging API response
    error_log("🔍 Debugging API Response:\nURL: $url\nHTTP Code: $httpCode\nResponse: $response\nError: $curlError");
    // Check if response is valid JSON
    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if (isset($data["bmi"])) {  // Adjust this key if needed based on actual API response
            return round($data["bmi"], 2);
        }
    }
    return false; // Return false if response format is unexpected
}
