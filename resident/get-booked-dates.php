<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch the booked dates from the bookings table
$sql = "SELECT start_date FROM bookings";
$result = $conn->query($sql);

$bookedDates = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $bookedDates[] = $row["start_date"];
  }
}

// Send the booked dates as JSON response
header('Content-Type: application/json');
echo json_encode($bookedDates);

// Close the connection
$conn->close();
?>
