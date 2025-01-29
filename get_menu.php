<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT id, meal_date, breakfast_item, breakfast_price, lunch_item, lunch_price, dinner_item, dinner_price, breakfast_image, lunch_image, dinner_image FROM menu_list";
$result = $connection->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure the image paths are included as they are
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$connection->close();
?>
