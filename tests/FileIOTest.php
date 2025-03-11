<?php
require_once __DIR__ . '/../fileio.php';

class FileIOTest
{
    private $testFile = 'ExerciseData_test.txt';
    public function setUp()
    {
        file_put_contents(
            $this->testFile,
            "START_HEIGHT, START_WEIGHT, START_BMI, UNITS\n" .
                "1.75, 75, 24.49, KG\n" .
                "ACTIVITY,DURATION,CALORIES_BURNED,WEIGHT_LOST,UNITS\n"
        );
    }
    public function testLoadDefaultData()
    {
        $data = LoadDefaultData();
        assert(is_array($data), "Default data should be array");
        assert(count($data) == 4, "Default data should have 4 elements");
    }
    public function testAddNewActivityRecord()
    {
        $result = AddNewActivityRecord('Running', 30, 300, 0.05, 'KG');
        assert($result === true, "Adding activity record failed");
    }
    public function tearDown()
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
    }
    public function runTests()
    {
        $this->setUp();
        $this->testLoadDefaultData();
        $this->testAddNewActivityRecord();
        $this->tearDown();
        echo "File I/O tests passed!\n";
    }
}
$test = new FileIOTest();
$test->runTests();



