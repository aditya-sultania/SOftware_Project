
<?php
include 'config.php';

$sql = "SELECT candidates.name, candidates.party, COUNT(votes.id) AS total_votes 
        FROM candidates 
        LEFT JOIN votes ON candidates.id = votes.candidate_id 
        GROUP BY candidates.id";
$result = $conn->query($sql);

echo "<h2>Election Results</h2>";
echo "<table border='1'>
<tr>
    <th>Candidate Name</th>
    <th>Party</th>
    <th>Total Votes</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['party']}</td>
        <td>{$row['total_votes']}</td>
    </tr>";
}

echo "</table>";
?>
