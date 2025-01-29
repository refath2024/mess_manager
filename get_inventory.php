<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';


$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT id, product_name, quantity_held, type FROM inventory";
$result = $connection->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
$connection->close();
?>
