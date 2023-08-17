<?php 
require_once('db-connect.php');

if (!isset($_GET['id'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Undefined Schedule ID.'));
    exit;
}

$eventId = $_GET['id'];

$delete = $conn->query("DELETE FROM `bookings` WHERE id = '$eventId'");
if ($delete) {
    echo json_encode(array('status' => 'success', 'message' => 'Event deleted successfully.'));
} else {
    error_log("Error deleting event: " . $conn->error);
    echo json_encode(array('status' => 'error', 'message' => 'An error occurred while trying to delete the event.'));
}

$conn->close();
?>
