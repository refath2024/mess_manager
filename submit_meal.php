<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "smart_mess";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$meal_date = $_POST['mealDate'];
$breakfast_item = $_POST['breakfastItem'];
$breakfast_price = $_POST['breakfastPrice'];
$lunch_item = $_POST['lunchItem'];
$lunch_price = $_POST['lunchPrice'];
$dinner_item = $_POST['dinnerItem'];
$dinner_price = $_POST['dinnerPrice'];

// Check if the meal date already exists
$sql_check = "SELECT COUNT(*) AS count FROM menu_list WHERE meal_date = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $meal_date);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();

if ($count > 0) {
    // If date exists, send a failure message
    echo "<script>
        alert('Data already entered for this date!');
        window.location.href = 'edit_menu.html';
    </script>";
} else {
    // If date doesn't exist, insert the data
    $sql_insert = "INSERT INTO menu_list (meal_date, breakfast_item, breakfast_price, lunch_item, lunch_price, dinner_item, dinner_price) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssdsdsd", $meal_date, $breakfast_item, $breakfast_price, $lunch_item, $lunch_price, $dinner_item, $dinner_price);

    if ($stmt_insert->execute()) {
        echo "<script>
            alert('Meal entry added successfully!');
            window.location.href = 'edit_menu.html';
        </script>";
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    // Close the insert statement
    $stmt_insert->close();
}

// Close connection
$stmt_check->close();
$conn->close();
?>
