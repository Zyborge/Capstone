<?php
  // Retrieve form data
  $userId = $_POST['user_id'];
  $status = '';

  if (isset($_POST['approve'])) {
    $status = "Approved";
  } elseif (isset($_POST['reject'])) {
    $status = "Rejected";
  }

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

    // Move the user to the appropriate table based on status
    if ($status === "Approved") {
      // Move to the approved_users table with verification code
      $stmt = $conn->prepare("INSERT INTO approved_users (resident_id, name, house_ownership_type, block, lot,street, email, password, status, verification_code) SELECT id, name, house_ownership_type, block, lot, street, email, password, :status, verification_code FROM users WHERE id = :userId");
    } elseif ($status === "Rejected") {
      // Move to the rejected_users table without verification code
      $stmt = $conn->prepare("INSERT INTO rejected_users (resident_id, name, house_ownership_type, block, lot,street, email, password, status) SELECT id, name, house_ownership_type, block, lot,street, email, password, :status FROM users WHERE id = :userId");
    }

    // Bind parameters and execute the statement
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Delete the user from the users table
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    echo "Registration $status successfully.";
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Close the database connection
  $conn = null;
?>
