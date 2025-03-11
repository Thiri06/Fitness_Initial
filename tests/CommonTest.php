<?php
require_once __DIR__ . '/../common.php';

class CommonTest
{
    public function testWeightConversions()
    {
        assert(KilosToPounds(50) == 110, "KG to LB conversion failed");
        assert(PoundsToKilos(110) == 50, "LB to KG conversion failed");
        assert(MeterToFeet(2) == 6.56, "M to FT conversion failed");
        assert(FeetToMeter(6.56) == 2, "FT to M conversion failed");
    }
    public function testBMICalculations()
    {
        assert(BMICalculator(75, 1.75) == 24.49, "BMI metric calculation failed");
        // Using height in feet (5.67 feet) as per function specification
        assert(BMICalculatorImperial(160, 5.6) == 24.91, "BMI imperial calculation failed");
    }
    public function testCalorieCalculations()
    {
        assert(CaloriesBurnedInCustomTime(10, 75, 30) == 375, "Calorie calculation failed");
        assert(WeightLostInKilosInCustomTime(10, 75, 30) == 0.05, "Weight loss calculation failed");
    }
    public function runTests()
    {
        $this->testWeightConversions();
        $this->testBMICalculations();
        $this->testCalorieCalculations();
        echo "Common functions tests passed!\n";
    }
}
$test = new CommonTest();
$test->runTests();
