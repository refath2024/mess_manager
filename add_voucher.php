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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $unit_price = $_POST['unit_price'];
    $amount = $_POST['amount'];
    $total_price = $_POST['total_price'];
    $date = $_POST['date'];
    $buyer = $_POST['buyer'];
    $voucher_id = $_POST['voucher_id'];

    // Prepare SQL statement to insert data into shopping table
    $stmt = $conn->prepare("INSERT INTO shopping (product_name, unit_price, amount, total_price, date, buyer, voucher_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt->bind_param("sddsdss", $product_name, $unit_price, $amount, $total_price, $date, $buyer, $voucher_id)) {
        echo "Error binding parameters: " . $stmt->error;
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the same page to refresh the form
        header("Location: add_voucher.html " );
        exit();  // Ensure no further code is executed after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
