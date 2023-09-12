<?php
// Retrieve form data
$userId = $_POST['user_id'];
$action = $_POST['action'];

// Database connection parameters
$servername = "localhost";
$dbname = "gardenvillas_db";
$dbUsername = "root";
$dbPassword = "";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);

    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the user status in the users table based on the action
    if ($action === "approve") {
        $status = "Approved";

        // Move the approved user to the approved_users table
        $stmt = $conn->prepare("INSERT INTO approved_users (resident_id, name, house_ownership_type, block, lot, street, email, password, status, verification_code) SELECT id, name, house_ownership_type, block, lot, street, email, password, :status, verification_code FROM users WHERE id = :userId");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM users WHERE id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    } elseif ($action === "reject") {
        $status = "Rejected";
        $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :userId");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        // You can add additional logic here if needed for rejected users
    }

    echo "Registration $action successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
