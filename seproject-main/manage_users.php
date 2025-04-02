<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Fetch all users
$result = $conn->query("SELECT id, voter_id, aadhaar, state, has_voted FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    width: 80%;
}

h2 {
    color: #333;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.user-table th, .user-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.user-table th {
    background-color: #007bff;
    color: white;
}

.user-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.btn {
    display: inline-block;
    padding: 8px 15px;
    margin: 5px;
    text-decoration: none;
    color: white;
    background-color: #007bff;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.reset {
    background-color: #dc3545;
}

.reset:hover {
    background-color: #a71d2a;
}

.back {
    background-color: #28a745;
}

.back:hover {
    background-color: #1e7e34;
}

</style>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table class="user-table">
            <tr>
                <th>ID</th>
                <th>Voter ID</th>
                <th>Aadhaar</th>
                <th>State</th>
                <th>Has Voted</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['voter_id'] ?></td>
                    <td><?= $row['aadhaar'] ?></td>
                    <td><?= $row['state'] ?></td>
                    <td><?= $row['has_voted'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn">Edit</a> 
                        <a href="reset_vote.php?id=<?= $row['id'] ?>" class="btn reset">Reset Vote</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <br>
        <a href="admin.php" class="btn back">Back to Admin Dashboard</a>
    </div>
</body>
</html>