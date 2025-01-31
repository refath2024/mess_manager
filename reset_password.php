<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess";

// Establish the connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql_update = "UPDATE users SET password = ?, recovery_code = NULL WHERE email = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $hashed_password, $email);

    if ($stmt_update->execute()) {
        echo "Your password has been reset successfully.";
        echo '<p><a href="officers_portal.html">Click here to login</a></p>';
    } else {
        echo "Error resetting password: " . $stmt_update->error;
    }

    // Close the statement
    $stmt_update->close();
}

// Close the connection
$conn->close();
?>