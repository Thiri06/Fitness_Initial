<?php
require_once __DIR__ . '/../common.php';
require_once __DIR__ . '/../fileio.php';
class ActivityTest
{
    public function testAverageCaloriesBurned()
    {
        $average = calculateAverageCaloriesBurned();
        assert(is_float($average), "Average calories should be float");
        assert($average >= 0, "Average calories should be non-negative");
    }
    public function testLargestCaloriesBurned()
    {
        $maxData = findLargestCaloriesBurned();
        assert(is_array($maxData), "Max calories data should be array");
        assert(isset($maxData['calories']), "Calories value missing");
        assert(isset($maxData['activity']), "Activity name missing");
    }
    public function testBiggestWeightLossInterval()
    {
        $interval = findBiggestWeightLossInterval();
        assert(is_float($interval), "Weight loss interval should be float");
        assert($interval >= 0, "Weight loss should be non-negative");
    }
    public function runTests()
    {
        $this->testAverageCaloriesBurned();
        $this->testLargestCaloriesBurned();
        $this->testBiggestWeightLossInterval();
        echo "Activity calculations tests passed!\n";
    }
}
$test = new ActivityTest();
$test->runTests();
