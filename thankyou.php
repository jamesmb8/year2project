<?php
if (!isset($_GET['order_id'])) {
    header("Location: basket.php");
    exit();
}

$orderId = intval($_GET['order_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div id="header"></div>
    <div id="sidenav"></div>
    <main>
        <h1>Thank You for Your Order!</h1>
        <p>Your order number is <strong>#<?php echo $orderId; ?></strong>.</p>
    </main>
    <script src="script.js"></script>
</body>

</html>
