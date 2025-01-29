<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "smart_mess";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $productName = $_POST['product_name'] ?? null;
    $quantityHeld = $_POST['quantity_held'] ?? null;
    $type = $_POST['type'] ?? null;

    // Validate inputs
    if ($productName && $quantityHeld && $type) {
        $stmt = $conn->prepare("INSERT INTO inventory (product_name, quantity_held, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $productName, $quantityHeld, $type);

        if ($stmt->execute()) {
            echo "New inventory item added successfully!";
            header("Location: add_inventory.html");
            exit();
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: All fields are required.";
    }
} else {
    echo "No form data received.";
}

$conn->close();
?>
