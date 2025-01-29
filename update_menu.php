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

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$meal_date = $data['meal_date'];
$breakfast_item = $data['breakfast_item'];
$breakfast_price = $data['breakfast_price'];
$lunch_item = $data['lunch_item'];
$lunch_price = $data['lunch_price'];
$dinner_item = $data['dinner_item'];
$dinner_price = $data['dinner_price'];

// Update query excluding image fields
$sql = "UPDATE menu_list SET 
            meal_date = ?, 
            breakfast_item = ?, 
            breakfast_price = ?, 
            lunch_item = ?, 
            lunch_price = ?, 
            dinner_item = ?, 
            dinner_price = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsdsdi", $meal_date, $breakfast_item, $breakfast_price, $lunch_item, $lunch_price, $dinner_item, $dinner_price, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Menu updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update menu"]);
}

$stmt->close();
$conn->close();
?>
