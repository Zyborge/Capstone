<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database to fetch distinct street names
$sql = "SELECT DISTINCT street FROM residents ORDER BY street ASC";
$result = $conn->query($sql);

$streetOptions = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $streetOptions[] = $row["street"];
    }
}

// Close the database connection
$conn->close();

// Return the street options as JSON
header('Content-Type: application/json');
echo json_encode($streetOptions);
?>
