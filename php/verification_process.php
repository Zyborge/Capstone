<?php
// Retrieve form data
$verificationCode = $_POST['verification_code'];

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

    // Check if verification code exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE verification_code = :verificationCode");
    $stmt->bindParam(':verificationCode', $verificationCode);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid verification code.'
        ];
    } else {
        // Update the verification status in the users table
        $stmt = $conn->prepare("UPDATE users SET verification_status = 'Verified' WHERE verification_code = :verificationCode");
        $stmt->bindParam(':verificationCode', $verificationCode);
        $stmt->execute();
        header('Location: ../resident/resident-login.php'); // Replace "login.php" with the actual login page URL

        $response = [
            'status' => 'success',
            'message' => 'Email verification successful.'
        ];
    }
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ];
}

// Close the database connection
$conn = null;

// Return the response as JSON
echo json_encode($response);
?>
