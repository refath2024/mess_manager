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
    $recovery_code = isset($_POST['recovery_code']) ? $_POST['recovery_code'] : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

    // Check if the new passwords match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $sql_update = "UPDATE users SET password = ?, recovery_code = NULL WHERE recovery_code = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $hashed_password, $recovery_code);

    if ($stmt_update->execute()) {
        echo "Your password has been successfully updated.";
        // Optionally, you can redirect to the login page
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt_update->error;
    }

    // Close the statement
    $stmt_update->close();
}

// Close the connection
$conn->close();
?>