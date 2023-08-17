<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['resident_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

$residentId = $_SESSION['resident_id'];

// Fetch the latest payment end date and next payment end date from the database
$sql = "SELECT payment_end_date FROM pending_gcashpayment WHERE resident_id = ? ORDER BY payment_date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $residentId);
$stmt->execute();
$result = $stmt->get_result();
$lastPayment = $result->fetch_assoc();

$stmt->close();

$response = array();
if ($lastPayment) {
    $response['success'] = true;
    $lastPaymentEndDate = $lastPayment['payment_end_date'];

    // Calculate the next payment end date based on the payment term (monthly, quarterly, yearly)
    $nextPaymentEndDate = date('Y-m-d', strtotime($lastPaymentEndDate . ' +1 month')); // Modify the interval based on payment term

    $response['lastPaymentEndDate'] = $lastPaymentEndDate;
    $response['nextPaymentEndDate'] = $nextPaymentEndDate;
} else {
    $response['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
