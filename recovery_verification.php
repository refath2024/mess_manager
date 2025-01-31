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

    // Check if recovery code exists in the database
    $sql_check = "SELECT * FROM users WHERE recovery_code = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $recovery_code);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // If recovery code is valid, show the form to reset the password
        echo '
        <div class="container3">
            <h1>Reset Your Password</h1>
            <form action="update_password.php" method="post">
                <input type="hidden" name="recovery_code" value="' . htmlspecialchars($recovery_code) . '">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button type="submit" class="btn">Reset Password</button>
            </form>
        </div>';
    } else {
        echo "Invalid recovery code. Please try again.";
    }

    // Close the statement
    $stmt_check->close();
}

// Close the connection
$conn->close();
?>