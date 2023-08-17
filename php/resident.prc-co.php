<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Function to generate a random verification code
function generateVerificationCode() {
    // Implement your logic to generate a unique verification code
    // For example, you can use a combination of random numbers and letters
    $length = 6; // Length of the verification code
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $verificationCode = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $verificationCode .= $characters[$randomIndex];
    }

    return $verificationCode;
}

// Retrieve form data
$name = $_POST['name'];
$ownershipType = $_POST['ownership_type'];
$block = $_POST['block'];
$lot = $_POST['lot'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

    // Check if email is already taken in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    // Check if email is already taken in approved_users table
    $stmt = $conn->prepare("SELECT * FROM approved_users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $resultApproved = $stmt->fetch();

    if ($result || $resultApproved) {
        $errorMessage = 'Email already taken. Please choose a different email address.';
    } else {
        // Check if name is already taken in users table
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch();

        // Check if name is already taken in approved_users table
        $stmt = $conn->prepare("SELECT * FROM approved_users WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $resultApproved = $stmt->fetch();

        if ($result || $resultApproved) {
            $errorMessage = 'Name already taken. Please enter a different name.';
        } else {
            // Check the number of existing accounts for the same block and lot in users table
            $stmt = $conn->prepare("SELECT COUNT(*) AS num_accounts FROM users WHERE block = :block AND lot = :lot");
            $stmt->bindParam(':block', $block);
            $stmt->bindParam(':lot', $lot);
            $stmt->execute();
            $result = $stmt->fetch();

            // Check the number of existing accounts for the same block and lot in approved_users table
            $stmt = $conn->prepare("SELECT COUNT(*) AS num_accounts FROM approved_users WHERE block = :block AND lot = :lot");
            $stmt->bindParam(':block', $block);
            $stmt->bindParam(':lot', $lot);
            $stmt->execute();
            $resultApproved = $stmt->fetch();

            if (($result['num_accounts'] + $resultApproved['num_accounts']) >= 2) {
                $errorMessage = 'Maximum number of accounts reached for the specified block and lot.';
            } else {
                // Validate password complexity
                if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password)) {
                    $errorMessage = 'Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.';
                } else {
                    // Generate verification code
                    $verificationCode = generateVerificationCode();

                    // Insert registration data into the users table
                    $stmt = $conn->prepare("INSERT INTO users (name, house_ownership_type, block, lot, email, password, verification_code, status) VALUES (:name, :ownershipType, :block, :lot, :email, :hashedPassword, :verificationCode, 'Pending')");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':ownershipType', $ownershipType);
                    $stmt->bindParam(':block', $block);
                    $stmt->bindParam(':lot', $lot);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':hashedPassword', $hashedPassword);
                    $stmt->bindParam(':verificationCode', $verificationCode);
                    $stmt->execute();

                    // Send verification code email
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = "mailergarden@gmail.com";
                    $mail->Password = "ywuxhbebsmbspxkp";
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom('mailergarden@gmail.com');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Account Verification';
                    $mail->Body = 'Thank you for registering. Your verification code is: <strong>' . $verificationCode . '</strong>';
                    $mail->send();

                    // Display a success message on the resident-registration page
                    $successMessage = 'Registration successful. Please check your email for the verification code.';
                }
            }
        }
    }
    $conn = null;

    // If an error occurred, store the error message in a session variable
    if (isset($errorMessage)) {
        session_start();
        $_SESSION['registration_error'] = $errorMessage;
    }

    // Redirect back to the registration page
    header("Location: ../resident/resident-register.php");
    exit();
} catch (PDOException $e) {
    // Handle the error and redirect back to the registration page with a generic error message
    session_start();
    $_SESSION['registration_error'] = 'Registration failed due to a database error.';

    // Redirect back to the registration page
    header("Location: ../resident/resident-register.php");
    exit();
}
?>
