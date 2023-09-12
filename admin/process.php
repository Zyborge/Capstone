<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gardenvillas_db';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['delete']) && isset($_POST['selected'])) {
    $selectedIds = $_POST['selected'];
    $deletionSuccessful = true;

    foreach ($selectedIds as $id) {
        $stmt = $connection->prepare("DELETE FROM residents WHERE id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            $deletionSuccessful = false;
        }

        $stmt->close();
    }

    if ($deletionSuccessful) {
        $message = "Deletion of resident(s) successful.";
        $status = "success";
    } else {
        $message = "Error deleting resident(s). Please try again later.";
        $status = "danger";
    }

    header("Location: ../admins/carl.php?message=" . urlencode($message) . "&status=" . $status);
    exit();
}

$connection->close();
?>
