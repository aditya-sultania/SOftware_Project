<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Get user details
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voter_id = $_POST['voter_id'];
    $aadhaar = $_POST['aadhaar'];
    $state = $_POST['state'];

    $stmt = $conn->prepare("UPDATE users SET voter_id=?, aadhaar=?, state=? WHERE id=?");
    $stmt->bind_param("sssi", $voter_id, $aadhaar, $state, $id);
    $stmt->execute();

    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h2 {
    color: #333;
}

.edit-form {
    display: flex;
    flex-direction: column;
}

.edit-form label {
    font-weight: bold;
    margin-top: 10px;
}

.edit-form input {
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn {
    display: inline-block;
    padding: 10px;
    margin-top: 15px;
    text-decoration: none;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.back {
    background-color: #28a745;
    text-decoration: none;
    padding: 10px;
    display: inline-block;
}

.back:hover {
    background-color: #1e7e34;
}

    </style>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST" class="edit-form">
            <label>Voter ID:</label>
            <input type="text" name="voter_id" value="<?= $user['voter_id'] ?>" required><br>

            <label>Aadhaar:</label>
            <input type="text" name="aadhaar" value="<?= $user['aadhaar'] ?>" required><br>

            <label>State:</label>
            <input type="text" name="state" value="<?= $user['state'] ?>" required><br>

            <button type="submit" class="btn">Update</button>
        </form>
        
        <br>
        <a href="manage_users.php" class="btn back">Back</a>
    </div>
</body>
</html>