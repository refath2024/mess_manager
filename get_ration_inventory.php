<?php
// Database connection
$host = 'localhost'; // Database host
$db = 'smart_mess';  // Database name
$user = 'root';      // Database username
$pass = '';          // Database password

// Create a PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SQL query to fetch data where type = 'fresh'
$query = "SELECT id, product_name, quantity_held FROM inventory WHERE type = 'ration'";
$stmt = $pdo->query($query);

// Fetch the data
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);
?>
