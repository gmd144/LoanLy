<?php
include_once("navigation.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>LoanLy | Loan Management System</title>
    <link rel="stylesheet" type="text/css" href="resources\css\home.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Loan Management</h1>
        <p>Manage your loans and lenders efficiently.</p>
        <button onclick="location.href='add_loan.php'">Add New Loan Record</button>
        <button onclick="location.href='loans.php'">View all Loans</button>
    </div>   
</body>
</html>
