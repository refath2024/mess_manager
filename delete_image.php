<?php
// delete_image.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $mealType = $input['mealType']; // 'breakfast', 'lunch', or 'dinner'
    $id = intval($input['id']);

    $column = '';
    switch ($mealType) {
        case 'breakfast':
            $column = 'breakfast_image';
            break;
        case 'lunch':
            $column = 'lunch_image';
            break;
        case 'dinner':
            $column = 'dinner_image';
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid meal type.']);
            exit;
    }

    // Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $query = "UPDATE menu_table SET $column = NULL WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }

    $stmt->close();
    $conn->close();
}
?>
