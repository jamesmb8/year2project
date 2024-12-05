<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginform.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/adminstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="header"></div>
    <div id="sidenav"></div>
    <div class="content">
        <div class="container">
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <div class="dashboard-row">
                <div class="dashboard-col">
                    <div class="card">
                        <div class="card-header">Sales Overview</div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="dashboard-col">
                    <div class="card">
                        <div class="card-header">Top Best-Selling Products</div>
                        <div class="card-body">
                            <ul id="topProducts" class="product-list"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-row">
                <div class="dashboard-col">
                    <div class="card">
                        <div class="card-header">Orders for <span id="currentMonth"></span></div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="monthlyOrders"></tbody>
                            </table>
                            <select id="monthSelector" class="month-selector"></select>
                        </div>
                    </div>
                </div>
                <div class="dashboard-col">
                    <div class="card">
                        <div class="card-header">Low Stock Products</div>
                        <div class="card-body">
                            <ul id="lowStock" class="product-list"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>
