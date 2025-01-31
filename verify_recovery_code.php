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
    $recovery_code = isset($_POST['recovery_code']) ? $_POST['recovery_code'] : null;

    // Check if the recovery code is valid
    $sql_check = "SELECT * FROM users WHERE email = ? AND recovery_code = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $email, $recovery_code);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Recovery code is valid, allow user to set a new password
        echo '<h1>Set New Password</h1>';
        echo '<form action="reset_password.php" method="post">
                <input type="hidden" name="email" value="'.htmlspecialchars($email).'">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <button type="submit">Reset Password</button>
              </form>';
    } else {
        echo "Invalid recovery code. Please try again.";
    }

    // Close the statement
    $stmt_check->close();
}

// Close the connection
$conn->close();
?>