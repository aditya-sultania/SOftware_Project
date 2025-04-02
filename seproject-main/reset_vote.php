<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$id = $_GET['id'];
$conn->query("UPDATE users SET has_voted = 0 WHERE id = $id");

header("Location: manage_users.php");
exit();
?>
