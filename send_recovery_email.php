<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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

    // Check if email exists in the database
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);

    if (!$stmt_check) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique recovery code
        $recovery_code = bin2hex(random_bytes(16));

        // Store the recovery code in the database
        $sql_update = "UPDATE users SET recovery_code = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);

        if (!$stmt_update) {
            die("Error in SQL query: " . $conn->error);
        }

        $stmt_update->bind_param("ss", $recovery_code, $email);
        $stmt_update->execute();

        // Send the recovery email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hosenrefath516@gmail.com';
            $mail->Password   = 'pccg dfcy tpia lhyp';  // Ensure you're using an **App Password**, not your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('hosenrefath516@gmail.com', 'Smart Mess Support');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Recovery Code';
            $mail->Body    = "To recover your ID, please use the following code: <strong>$recovery_code</strong>";

            $mail->send();
            echo 'Recovery code has been sent to your email.';

            // Redirect to the recovery code input page
            header("Location: recovery_code_input.php?email=" . urlencode($email));
            exit();
        } catch (Exception $e) {
            echo "Failed to send the email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in our records.";
    }

    // Close the statements
    $stmt_check->close();
    $stmt_update->close();
}

// Close the connection
$conn->close();
?>