<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {

    // Simulate login data in different scenarios
    public function setUp(): void {
        $_POST['email'] = '';   // Default to empty email
        $_POST['pass'] = '';     // Default to empty password
    }

    public function testLoginSuccess() {
        // Simulate correct login data
        $_POST['email'] = '11/12@email.com';
        $_POST['pass'] = 'Pass123';

        // Start output buffering to capture the headers
        ob_start();
        // Include the login.php script to execute the logic
        include '../php/login.php';  // This will execute the login logic

        // Capture the output and check for redirection
        $output = ob_get_clean();

        // Check for the expected redirection
        $this->assertStringContainsString('Location: ../dashboard.php', $output);
    }

    public function testIncorrectPassword() {
        // Simulate incorrect password
        $_POST['email'] = '11/12@email.com';
        $_POST['pass'] = 'WrongPass';

        // Start output buffering
        ob_start();
        include '../php/login.php';

        $output = ob_get_clean();

        // Check for the incorrect password redirection
        $this->assertStringContainsString('Location: ../loginform.php?error=incorrect_password', $output);
    }

    public function testEmailNotFound() {
        // Simulate email not found in the database
        $_POST['email'] = 'nonexistent@email.com';
        $_POST['pass'] = 'password123';

        // Start output buffering
        ob_start();
        include '../php/login.php';

        $output = ob_get_clean();

        // Check for the email not found redirection
        $this->assertStringContainsString('Location: ../loginform.php?error=email_not_found', $output);
    }
}
?>
