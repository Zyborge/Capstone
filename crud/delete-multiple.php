<?php
// Include the database connection file (db.php)
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'selectedIds' key exists in the POST data
    if (isset($_POST['selectedIds']) && is_array($_POST['selectedIds'])) {
        $selectedIds = $_POST['selectedIds'];

        // Use prepared statement to safely delete records
        $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
        $query = "DELETE FROM residents WHERE id IN ($placeholders)";

        $stmt = $mysqli->prepare($query);
        if (!$stmt) {
            echo "Error: " . $mysqli->error;
        } else {
            // Bind the selected IDs to the placeholders
            $types = str_repeat('i', count($selectedIds));
            $stmt->bind_param($types, ...$selectedIds);

            if ($stmt->execute()) {
                echo "Records deleted successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "Invalid input for deletion.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$mysqli->close();
?>
