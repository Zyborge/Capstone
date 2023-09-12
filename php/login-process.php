<?php
  // Retrieve form data
  $email = $_POST['email'];
  $password = $_POST['password'];

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

    // Prepare and execute the SQL statement in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    // Prepare and execute the SQL statement in approved_users table if no result in users table
    if (!$result) {
      $stmt = $conn->prepare("SELECT * FROM approved_users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $result = $stmt->fetch();
    }

    // Prepare and execute the SQL statement in rejected_users table if no result in approved_users table
    if (!$result) {
      $stmt = $conn->prepare("SELECT * FROM rejected_users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $result = $stmt->fetch();
    }

    if ($result) {
      if (password_verify($password, $result['password'])) {
        if ($result['status'] == 'Approved') {
          // Start the session
          session_start();
    
          // Store user data in session variables
          $_SESSION['resident_id'] = $result['resident_id'];
          $_SESSION['email'] = $result['email'];
          $_SESSION['name'] = $result['name']; // Store the user's name in the session
    
          // Return success response
          echo json_encode(['status' => 'success']);
        } else if ($result['status'] == 'Pending') {
          // Debugging: Check the status value
          $message = 'Your account is not yet approved. Please wait for the admin to approve your registration. Status: ' . $result['status'];
          echo json_encode(['status' => 'error', 'message' => $message]);
        } else if ($result['status'] == 'Rejected') {
          // Debugging: Check the status value
          $message = 'Your account is rejected. Please contact the admin for more information. Status: ' . $result['status'];
          echo json_encode(['status' => 'error', 'message' => $message]);
        }
      } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
      }
    } else {
      // Debugging: Check if the query is returning any rows
      echo json_encode(['status' => 'error', 'message' => 'No user found with this email.']);
    }
  } catch(PDOException $e) {
    // Return error response with detailed error information
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage(), 'code' => $e->getCode()]);
  }

  // Close the database connection
  $conn = null;
?>
