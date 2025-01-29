<?php

// Database connection
$servername = "localhost";
$username = "root"; // Change this as per your setup
$password = ""; // Change this as per your setup
$dbname = "smart_mess"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

// Prepare the data


$unit_price = $data['unit_price'];
$amount = $data['amount'];
$total_price = $data['total_price'];
$date = $data['date'];
$buyer = $data['buyer'];
$voucher_id = $data['voucher_id'];

// Update the row in the database
$query = "UPDATE shopping SET 
            unit_price = '$unit_price',
            amount = '$amount',
            total_price = '$total_price',
            date = '$date',
            buyer = '$buyer'
          WHERE voucher_id = '$voucher_id'";

if (mysqli_query($conn, $query)) {
    // Respond with success if the update was successful
    echo json_encode(['success' => true]);
} else {
    // Respond with failure if the update failed
    echo json_encode(['success' => false, 'message' => 'Failed to update row']);
}

// Close the database connection
mysqli_close($conn);
?>
 