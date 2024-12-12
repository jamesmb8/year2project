<?php

use PHPUnit\Framework\TestCase;

class loginTest extends TestCase {
    public function testLoginSuccess() {
        // Simulate login data
        $_POST['email'] = '11/12@email.com';
        $_POST['pass'] = 'Pass123';

        // Call the login.php script
        ob_start();
        include '../php/login.php';
        $output = ob_get_clean();

        // Assert successful login redirection
        $this->assertStringContainsString('Location: ../dashboard.php', $output);
    }

    public function testIncorrectPassword() {
        // Simulate login data with an incorrect password
        $_POST['email'] = 'test@example.com';
        $_POST['pass'] = 'wrongpassword';

        // Call the login.php script
        ob_start();
        include 'php/login.php';
        $output = ob_get_clean();

        // Assert redirection with the error message
        $this->assertStringContainsString('Location: ../loginform.php?error=incorrect_password', $output);
    }

    public function testEmailNotFound() {
        // Simulate login data with an email not in the database
        $_POST['email'] = 'nonexistent@example.com';
        $_POST['pass'] = 'password123';

        // Call the login.php script
        ob_start();
        include 'php/login.php';
        $output = ob_get_clean();

        // Assert redirection with the error message
        $this->assertStringContainsString('Location: ../loginform.php?error=email_not_found', $output);
        
    }
}
?>