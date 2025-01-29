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
        // Check if email already exists
        $email_check_query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $email_stmt = $conn->prepare($email_check_query);
        $email_stmt->bind_param("s", $email);
        $email_stmt->execute();
        $email_result = $email_stmt->get_result();

        if ($email_result->num_rows > 0) {
            echo "Email is already registered!";
            exit();
        }

        // Check if mobile already exists
        $mobile_check_query = "SELECT * FROM users WHERE mobile = ? LIMIT 1";
        $mobile_stmt = $conn->prepare($mobile_check_query);
        $mobile_stmt->bind_param("s", $mobile);
        $mobile_stmt->execute();
        $mobile_result = $mobile_stmt->get_result();

        if ($mobile_result->num_rows > 0) {
            echo "Mobile number is already registered!";
            exit();
        }

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
