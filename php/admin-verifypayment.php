<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending payments from the database with resident name
$sql = "SELECT p.id, a.resident_name, p.amount, p.payment_term, p.reference_number, p.payment_image, p.payment_date, p.payment_time, p.status FROM pending_gcashpayment p
        INNER JOIN approved_users a ON p.resident_id = a.resident_id
        WHERE p.status = 'pending'";
$result = $conn->query($sql);

$payments = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
}

// Close database connection
$conn->close();

// Return the payments data as JSON
header('Content-Type: application/json');
echo json_encode($payments);
?>
