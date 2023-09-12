<?php
// Include the database connection file (db.php)
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    // Sanitize input data
    $id = intval($id);

    // Delete data from the table using a prepared statement
    $query = "DELETE FROM residents WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Data deleted successfully, redirect to a success page or back to the list.
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>
