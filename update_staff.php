<?php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'smart_mess';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate data
if (!isset($data['no']) || !isset($data['rank']) || !isset($data['name']) || !isset($data['unit']) || !isset($data['mobile']) || !isset($data['email']) || !isset($data['role']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$no = $data['no'];
$rank = $data['rank'];
$name = $data['name'];
$unit = $data['unit'];
$mobile = $data['mobile'];
$email = $data['email'];
$role = $data['role'];
$status = $data['status'];

$sql = "UPDATE staffs SET rank='$rank', name='$name', unit='$unit', mobile='$mobile', email='$email', role='$role', status='$status' WHERE no='$no'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
