<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_mess";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $no = $_POST['no'];
    $rank = $_POST['rank'];
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        // Prepare the SQL statement to insert the data into the users table
        $stmt = $conn->prepare("INSERT INTO users (no, rank, name, unit, email, mobile, password) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $no, $rank, $name, $unit, $email, $mobile, $password);

        // Execute the statement and check if the insert was successful
        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: officers_portal.html"); // Redirect to the officers portal after success
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>
