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

// Fetch data from the database
$query = "SELECT * FROM shopping";  // Replace with your table name
$result = mysqli_query($conn, $query);

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Prepare the row data
        $data[] = [
            'id' => $row['id'], // Adjust column names
            'buyer' => $row['buyer'],
            'unit_price' => $row['unit_price'],
            'amount' => $row['amount'],
            'total_price' => $row['total_price'],
            'date' => $row['date'],
            'voucher_id' => $row['voucher_id']

        ];
    }
}

// Return the data as JSON
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
