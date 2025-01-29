<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "smart_mess"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$id_no = $_POST['id_no'];
$rank = $_POST['rank'];
$name = $_POST['name'];
$unit = $_POST['unit'];
$mobile_no = $_POST['mobile_no'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO staffs (no, rank, name, unit, mobile, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss",$id_no, $rank, $name, $unit, $mobile_no, $email, $hashed_password, $role);

// Execute and check for success
if ($stmt->execute()) {
    // Successfully inserted
    echo "<script>alert('{$name} has been successfully added!'); window.location.href = 'staff_state.html';</script>";
} else {
    // Failed to insert
    echo "<script>alert('Error adding user. Please try again.'); window.location.href = 'add_staffs.html';</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
