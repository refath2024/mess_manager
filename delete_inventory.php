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

if (isset($data['id']) && !empty($data['id'])) {
    $id = $data['id'];

    $sql = "DELETE FROM inventory WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id); // Use integer binding for id

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Row deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete row.']);
    }

    $stmt->close();
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
}

$connection->close();
?>
