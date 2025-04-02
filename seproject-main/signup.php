<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $voter_id = $_POST['voter_id'] ?? '';
    $aadhaar = $_POST['aadhaar'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';
    $state = $_POST['state'] ?? '';
    $role = $_POST['role'] ?? 'user'; // Default role is user

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match!";
        exit;
    }

    // Aadhaar validation: Exactly 12 digits
    if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
        echo "Error: Invalid Aadhaar Number!";
        exit;
    }

    // Voter ID validation: Alphanumeric (6-12 characters)
    if (!preg_match('/^[a-zA-Z0-9]{6,12}$/', $voter_id)) {
        echo "Error: Invalid Voter ID!";
        exit;
    }

    // Check if voter ID already exists
    $check_voter = "SELECT voter_id FROM users WHERE voter_id = ?";
    $stmt = $conn->prepare($check_voter);
    $stmt->bind_param("s", $voter_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Error: Voter ID already exists!";
        exit;
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (voter_id, aadhaar, password, state, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $voter_id, $aadhaar, $hashed_password, $state, $role);

    if ($stmt->execute()) {
        if ($role === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: indexclone.html");
        }
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}
?>
