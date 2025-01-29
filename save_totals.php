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

// Get JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

$totalMembers = $data['total_members'];
$totalCooks = $data['total_cooks'];
$totalStaffsAdmins = $data['total_staffs_admins'];
$totalDiningMembers = $data['total_dining_members'];
$totalActiveMembers = $data['total_active_members'];
$totalActiveDiningMembers = $data['total_active_dining_members'];

// Insert or update query
$recordDate = date('Y-m-d');  // Get today's date
$sql = "INSERT INTO total (total_members, total_cooks, total_staffs_admins, total_dining_members, total_active_members, total_active_dining_members, record_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        total_members = VALUES(total_members),
        total_cooks = VALUES(total_cooks),
        total_staffs_admins = VALUES(total_staffs_admins),
        total_dining_members = VALUES(total_dining_members),
        total_active_members = VALUES(total_active_members),
        total_active_dining_members = VALUES(total_active_dining_members)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiiii", $totalMembers, $totalCooks, $totalStaffsAdmins, $totalDiningMembers, $totalActiveMembers, $totalActiveDiningMembers, $recordDate);


if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "error" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
