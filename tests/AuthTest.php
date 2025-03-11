<?php
require_once __DIR__ . '/../config.php';

class AuthTest
{
    public function setUp()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function testValidLogin()
    {
        $_POST['username'] = 'Eaint';
        $_POST['password'] = 'Eaint01';

        $loginSuccessful = false;
        foreach ($GLOBALS['ListofUsers'] as $user) {
            if ($user['UserName'] == $_POST['username'] && $user['Password'] == $_POST['password']) {
                $loginSuccessful = true;
                break;
            }
        }
        assert($loginSuccessful === true, "Valid login failed");
    }
    public function testInvalidLogin()
    {
        $_POST['username'] = 'invalid';
        $_POST['password'] = 'wrong';

        $loginSuccessful = false;
        foreach ($GLOBALS['ListofUsers'] as $user) {
            if ($user['UserName'] == $_POST['username'] && $user['Password'] == $_POST['password']) {
                $loginSuccessful = true;
                break;
            }
        }
        assert($loginSuccessful === false, "Invalid login should fail");
    }
    public function runTests()
    {
        $this->setUp();
        $this->testValidLogin();
        $this->testInvalidLogin();
        echo "Authentication tests passed!\n";
    }
}

$test = new AuthTest();
$test->runTests();


