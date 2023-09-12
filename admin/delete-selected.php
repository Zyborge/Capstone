<?php
require('../configs/config.php'); // Include your database configuration if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
    $ids = $_POST['ids'];

    // Database connection
    $dsn = "mysql:host=localhost;dbname=gardenvillas_db;charset=utf8mb4";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query to delete records
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("DELETE FROM residents WHERE id IN ($placeholders)");
        $stmt->execute($ids);

        // Return a success message
        echo json_encode(['success' => true, 'message' => 'Selected records have been deleted.']);
    } catch (PDOException $e) {
        // Return an error message
        echo json_encode(['success' => false, 'message' => 'An error occurred while deleting records.']);
    }
} else {
    // Return an error message
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>