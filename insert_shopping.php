<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this as per your setup
$password = ""; // Change this as per your setup
$dbname = "smart_mess"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$product_name = $data['product_name'];
$unit_price = $data['unit_price'];
$amount = $data['amount'];
$date = $data['date'];
$buyer = $data['buyer'];
$voucher_id = $data['voucher_id'];

$sql = "INSERT INTO shopping (product_name, unit_price, amount, total_price, date, buyer, voucher_id)
        VALUES (:product_name, :unit_price, :amount, :total_price, :date, :buyer, :voucher_id)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':product_name' => $product_name,
    ':unit_price' => $unit_price,
    ':amount' => $amount,
    ':total_price' => $unit_price * $amount,
    ':date' => $date,
    ':buyer' => $buyer,
    ':voucher_id' => $voucher_id
]);

echo json_encode(['success' => true]);
?>
