<?php

use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function testWeightConversions()
    {
        $this->assertEquals(110, KilosToPounds(50));
        $this->assertEquals(50, PoundsToKilos(110));
    }

    public function testHeightConversions()
    {
        $this->assertEquals(6.56, MeterToFeet(2));
        $this->assertEquals(2, FeetToMeter(6.56));
    }

    public function testBMICalculations()
    {
        $this->assertEquals(24.69, BMICalculator(75, 1.75));
        $this->assertEquals(25.08, BMICalculatorImperial(160, 5.67));
    }

    public function testCalorieCalculations()
    {
        $this->assertEquals(375, CaloriesBurnedInCustomTime(10, 75, 30));
        $this->assertEquals(0.05, WeightLostInKilosInCustomTime(10, 75, 30));
    }
}
