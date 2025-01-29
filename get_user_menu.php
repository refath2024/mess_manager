<?php
// get_menu.php

// Establish the connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess"; // Use your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's and tomorrow's date
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));

// Query to get today's menu
$sql_today = "SELECT * FROM menu_list WHERE meal_date = '$today'";
$result_today = $conn->query($sql_today);

// Query to get tomorrow's menu
$sql_tomorrow = "SELECT * FROM menu_list WHERE meal_date = '$tomorrow'";
$result_tomorrow = $conn->query($sql_tomorrow);

// Check if today's and tomorrow's menu exists
$today_menu = $result_today->num_rows > 0 ? $result_today->fetch_assoc() : null;
$tomorrow_menu = $result_tomorrow->num_rows > 0 ? $result_tomorrow->fetch_assoc() : null;

// Return the data as JSON
echo json_encode([
    'today' => $today_menu,
    'tomorrow' => $tomorrow_menu
]);

// Close the connection
$conn->close();
?>
