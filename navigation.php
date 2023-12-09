<?php
include_once("config.php");
include_once("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/nav.css">
    <link rel="stylesheet" href="resources\fa\css\all.min.css">
    <link rel="shortcut icon" href="resources/images/fav.png" type="image/x-icon">
</head>

<body style="margin: 0;">

    <header class="header">
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="loans.php">Loans</a></li>
            <li><a href="lenders.php">Lenders</a></li>
            <li><a href="add_loan.php">Add Loan</a></li>
        </ul>
    </header>
    <script src="resources/js/nav.js"></script>
</body>

</html>