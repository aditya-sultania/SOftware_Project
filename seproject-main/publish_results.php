<?php
session_start();
include 'config.php';

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied! Only admins can publish results.";
    exit;
}

// Fetch vote counts
$sql = "SELECT party, COUNT(*) AS votes FROM votes GROUP BY party ORDER BY votes DESC";
$result = $conn->query($sql);

$votes_data = [];
$total_votes = 0;
$winner = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $votes_data[] = $row;
        $total_votes += $row['votes'];
    }
    $winner = $votes_data[0]['party']; // Party with highest votes
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results</title>
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

h1 {
    color: #333;
}

.results-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.results-table th, .results-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.results-table th {
    background-color: #007bff;
    color: white;
}

.results-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

h2 {
    margin-top: 20px;
    color: #28a745;
}

footer {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 10px;
    text-decoration: none;
    color: white;
    background-color: #007bff;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
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
        <header>
            <h1>Election Results</h1>
        </header>

        <main>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Party</th>
                        <th>Votes</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($votes_data as $vote) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vote['party']); ?></td>
                            <td><?php echo $vote['votes']; ?></td>
                            <td><?php echo round(($vote['votes'] / $total_votes) * 100, 2) . "%"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($winner): ?>
                <h2>Winning Party: <strong><?php echo htmlspecialchars($winner); ?></strong></h2>
            <?php else: ?>
                <h2>No votes cast yet.</h2>
            <?php endif; ?>
        </main>

        <footer>
            <p>&copy; 2025 Polling Booth System</p>
            <a href="admin.php" class="btn back">Back to Admin Dashboard</a>
        </footer>
    </div>
</body>
</html>