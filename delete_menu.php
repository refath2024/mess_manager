<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess";  // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data sent from the client-side
$data = json_decode(file_get_contents("php://input"), true);

// Extract the ID from the request
$id = $data['id'];

// Prepare the SQL query to delete the menu item
$sql = "DELETE FROM menu_list WHERE id = ?";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

// Execute the query and check for success
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Menu deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete menu"]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
