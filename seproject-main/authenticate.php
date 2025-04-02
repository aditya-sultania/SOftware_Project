<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voter_id = $_POST['voter_id'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE voter_id = ? AND role = ?");
    $stmt->bind_param("ss", $voter_id, $role);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $db_role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['voter_id'] = $voter_id;
            $_SESSION['role'] = $db_role;
            
            if ($db_role == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: indexclone.html");
            }
            exit();
        }
    }
    
    echo "Invalid credentials.";
}
?>
