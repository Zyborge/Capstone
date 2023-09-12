<?php
// Replace with your database connection code
$conn = new mysqli("localhost", "root", "", "gardenvillas_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['action'])) {
    $bookingId = $_POST['id'];
    $action = $_POST['action'];

    // Update the status in the database based on the action
    $sql = "UPDATE bookings SET status='" . ($action == 'approve' ? 'approved' : 'rejected') . "' WHERE id=$bookingId";

    if ($conn->query($sql) === TRUE) {
        // You can return a success message if needed
        echo "Booking " . $action . " successfully.";
    } else {
        // Handle errors here
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
