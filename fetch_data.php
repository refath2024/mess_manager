<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from 'user' table
$sql = "SELECT no, rank, name, unit, mobile, email, role, status  FROM users";
$result = $conn->query($sql);

// Prepare data as an array
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
