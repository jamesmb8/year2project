

<div class="sidenvav">
    <?php  if ($role =="customer"): ?>
    <a href="dashboard.html">Home</a>
    <a href="account.html">Account</a>
    <?php  elseif ($role =="manager"): ?>
   <a href="dashboard.html">Home</a>
    <a href="account.html">Account</a>
    <a href="reports.html">Reports</a>
     <?php  elseif ($role =="manager"): ?>
   <a href="dashboard.html">Home</a>
    <a href="account.html">Account</a>
    <a href="reports.html">Reports</a>
    <a href="stock.html">Stock</a>
<?php endif; ?>
</div>

