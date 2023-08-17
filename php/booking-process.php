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

// Retrieve form data
$eventType = $_POST['event-type'];
$title = $_POST['title'];
$description = $_POST['description'];
$startDate = $_POST['start-date'];
$endDate = $_POST['end-date'];
$startTime = $_POST['start-time'];
$endTime = $_POST['end-time'];
$status = 'pending'; // Assign the value to a variable

// Retrieve the resident ID from the session
session_start();
$residentId = $_SESSION['resident_id'];

// Prepare and execute the SQL statement
$stmt = $conn->prepare("INSERT INTO bookings (resident_id, start_date, end_date, title, description, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $residentId, $startDate, $endDate, $title, $description, $status);
$stmt->execute();

// Check if the data was inserted successfully
if ($stmt->affected_rows > 0) {
    echo "Form data inserted successfully.";
} else {
    echo "Error inserting form data: " . $stmt->error;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
