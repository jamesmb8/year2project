<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
  header("Location: loginform.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
<div class="AccountPage">
  <div id="header"></div>
  <div id="sidenav"></div>
    <div class="aboutUs">
        <div class="webIntro">
            <h1>Hello, and welcome to our inventory management system!</h1>
        </div>
        
        <div class="paraOne">  
            <h2>Who? What? Where? Purpose? </h2> 
            <p> 
                We are a company which is chocolate orientated. We take in mass orders for the great range of chocolate products that we
                have in store. Our company is eager to provide you, the customer, with prices that simply cannot be beaten. We are a fairly
                sized company located in England, London and we became an established business in 1967. We have therefore been in the chocolate
                industry long enough to know what we are talking about when it comes to the topic of confectionaries. Our purpose is to supply the retail business with fine quality chocolate. We have a range of warehouses which allow
                us to store mass amounts of different chocolates.
            </p>
        </div>
    
        <div class="paratwo">  
        <h2>Website Features </h2>  
            <p> 
                The features of our website allow the user to track their order numbers immediately after they have placed an order.
                This can be done through their account page and will show the order ID alongside the item and quantity, and price of that item they 
                have ordered. 
    
                As well as this, the user will also be able to change their password at any time through their account page, too. This 
                means that they will be able to ensure further security at all times by being able to constantly change their log-in details.
    
                A further feature that our website allows for is for the user to view all the items in their basket at all times through
                the top of our item dashboard page. This means that the user is able to add more or less of a pre-existing item in their 
                basket or remove it if they decide they do not want it anymore.
            </p>
        </div>
    
        <div class="paraThree">  
            <h2> Meet the team</h2> 
            <p> 
                <b> people who were behind creating this system were: </b>
            </p>
            <div class="creatorList" style="list-style-type:square;">
                
                    <li>Declan Clifford-Johnson</li>
                <li>James Briggs</li>
                <li>Seb Alliaj</li>
                <li>James Hibbert</li>
            
                
            </div>
            
        
            <p>
                These were the creators who made this system from scratch on behalf of a university assignment at the Sheffield Hallam University.
                This assignment took around 4 months to build from the ground up. This system involves a mixture of HTML, JavaScript, CSS and PHP.
            </p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
