<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';


$connection = new mysqli($host, $user, $password, $database);


if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$product_name = $data['product_name'];
$quantity_held = $data['quantity_held'];
$type = $data['type'];

$sql = "UPDATE inventory SET quantity_held = ?, type = ? WHERE product_name = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("iss", $quantity_held, $type, $product_name);

if ($stmt->execute()) {
    echo "Row updated successfully.";
} else {
    echo "Failed to update row.";
}

$stmt->close();
$connection->close();
?>
