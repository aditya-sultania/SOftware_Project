<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['party'])) {
        echo "No candidate selected!";
        exit;
    }

    $selected_party = $_POST['party'];
    $voter_id = $_SESSION['voter_id'] ?? '';

    if (empty($voter_id)) {
        echo "User not logged in!";
        exit;
    }

    // Check if the voter has already voted from the users table
    $check_voter = "SELECT has_voted FROM users WHERE voter_id = ?";
    $stmt = $conn->prepare($check_voter);
    $stmt->bind_param("s", $voter_id);
    $stmt->execute();
    $stmt->bind_result($has_voted);
    $stmt->fetch();
    $stmt->close();

    if ($has_voted) {
        echo "You have already voted!";
        exit;
    }

    // Insert the vote
    $insert_vote = "INSERT INTO votes (voter_id, party) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_vote);
    $stmt->bind_param("ss", $voter_id, $selected_party);

    if ($stmt->execute()) {
        // Update has_voted in users table
        $update_user = "UPDATE users SET has_voted = 1 WHERE voter_id = ?";
        $stmt_update = $conn->prepare($update_user);
        $stmt_update->bind_param("s", $voter_id);
        $stmt_update->execute();
        $stmt_update->close();

        echo "Vote successfully cast!";
    } else {
        echo "Error casting vote!";
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}
?>
