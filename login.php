<?php
// Start the session to store user data after login
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password
$dbname = "smart_mess"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data from the POST request
$email = $_POST['email'];
$password = $_POST['password'];  // Password will be checked against the hashed password in the database

// Check if email and password are provided
if (!empty($email) && !empty($password)) {
    // Prepare SQL query to check the email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = $user['name'];

        // Verify the password using password_verify() for security
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables for user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['rank'] = $user['rank'];
            $_SESSION['unit'] = $user['unit'];

            // Send JSON response with success status and user name
            echo json_encode(['success' => true, 'userName' => $userName]);
        } else {
            // Invalid password
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        // User not found
        echo json_encode(['success' => false, 'message' => 'No user found with that email address.']);
    }
} else {
    // Missing email or password
    echo json_encode(['success' => false, 'message' => 'Please enter both email and password.']);
}

// Close the connection
$conn->close();
?>
