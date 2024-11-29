<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>Register</title>
  </head>
  <body>
    <div id="header"></div>
    <div class = "register-container">
       <?php if (isset($_GET['error'])): ?>
        <p class="error-message">
            <?php 
                if ($_GET['error'] == 'passwords_mismatch') echo "Passwords do not match.";
                elseif ($_GET['error'] == 'email_exists') echo "This email is already registered.";
                elseif ($_GET['error'] == 'registration_failed') echo "Registration failed. Please try again.";
            ?>
        </p>
    <?php endif; ?>
        <div class="register-title">
            <h2>Create an account</h2>
        </div>
        <form method="post" action = "php/register.php">
            <label for="name">Company Name:</label><br>
          <input type="text" id="name" name="name" required><br>
 
         
          <label for="email">Email:</label><br>
          <input type="text" id="email" name="email" required><br>

           <label for="pass">Password:</label><br>
          <input type="text" id="pass" name="pass" required><br>

            <label for="pass">Confirm Password:</label><br>
          <input type="text" id="cpass" name="cpass" required><br>

          <input type="submit" id="register-button"value="Register"> 

        </form>
        <div class ="go-to-login">
          <h4>Already got an Account?</h4>
          <a href="login.html">LogIn here</a>
        </div>
    </div>


    <script src="script.js"></script>
  </body>
</html>