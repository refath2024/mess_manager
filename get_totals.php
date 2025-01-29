<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the latest totals
$sql = "SELECT * FROM total ORDER BY record_date DESC LIMIT 1";  // Only fetch the latest record
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);  // Return the data as JSON
} else {
    echo json_encode(["status" => "error", "message" => "No data found"]);
}

$conn->close();
?>
