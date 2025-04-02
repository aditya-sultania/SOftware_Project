<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
}

.nav-links {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    text-decoration: none;
    color: white;
    background-color: #007bff;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.logout {
    background-color: #dc3545;
}

.logout:hover {
    background-color: #a71d2a;
}
</style>
<body>
    <div class="container">
        <h2>Welcome, Admin</h2>
        <div class="nav-links">
            <a href="manage_users.php" class="btn">Manage Users</a>
            <a href="publish_results.php" class="btn">Publish Results</a>
            <a href="./login.html" class="btn logout">Logout</a>
        </div>
    </div>
</body>
</html>