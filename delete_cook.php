<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$no = $data['no'];

$sql = "DELETE FROM cooks WHERE no='$no'";
$result = $conn->query($sql);

echo json_encode(['success' => $result]);

$conn->close();
?>
