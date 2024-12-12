<?php

use PHPUnit\Framework\TestCase;

class registerTest extends TestCase {
    public function testRegisterSuccess() {
        // Simulate form data
        $_POST['name'] = 'Test Company';
        $_POST['email'] = 'test@example.com';
        $_POST['pass'] = 'password123';
        $_POST['cpass'] = 'password123';

        // Call the register.php script
        ob_start();
        include '../php/register.php';
        $output = ob_get_clean();

        // Assertions: Verify that registration was successful and redirect occurred
        $this->assertStringContainsString('Location: ../dashboard.php', $output);
    }

    public function testPasswordsMismatch() {
        // Simulate form data with mismatched passwords
        $_POST['name'] = 'Test Company';
        $_POST['email'] = 'test@example.com';
        $_POST['pass'] = 'password123';
        $_POST['cpass'] = 'differentpassword';

        // Call the register.php script
        ob_start();
        include 'php/register.php';
        $output = ob_get_clean();

        // Assert redirection and error message
        $this->assertStringContainsString('Location: ../registerform.php?error=passwords_mismatch', $output);
    }

    public function testEmailAlreadyExists() {
        // Assume the email already exists in the database
        $_POST['name'] = 'Test Company';
        $_POST['email'] = 'existing@example.com';
        $_POST['pass'] = 'password123';
        $_POST['cpass'] = 'password123';

        // Call the register.php script
        ob_start();
        include '../php/register.php';
        $output = ob_get_clean();

        // Assert redirection and error message
        $this->assertStringContainsString('Location: ../registerform.php?error=email_exists', $output);
    }
}
?>