<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$name = $_POST['name'];
$ownershipType = $_POST['ownership_type'];
$block = $_POST['block'];
$lot = $_POST['lot'];
$street = $_POST['street']; // Add this line to retrieve the street value
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

    // Check if username is already taken in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    // Check if username is already taken in approved_users table
    $stmt = $conn->prepare("SELECT * FROM approved_users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $resultApproved = $stmt->fetch();

    if ($result || $resultApproved) {
        $response = [
            'status' => 'error',
            'message' => 'Email already taken. Please choose a different Email.'
        ];
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
            $response = [
                'status' => 'error',
                'message' => 'Name already taken. Please enter a different name.'
            ];
        } else {
            // Check the number of existing accounts for the same block, lot, and street in users table
            $stmt = $conn->prepare("SELECT COUNT(*) AS num_accounts FROM users WHERE block = :block AND lot = :lot AND street = :street");
            $stmt->bindParam(':block', $block);
            $stmt->bindParam(':lot', $lot);
            $stmt->bindParam(':street', $street);
            $stmt->execute();
            $result = $stmt->fetch();
            
            // Check the number of existing accounts for the same block, lot, and street in approved_users table
            $stmt = $conn->prepare("SELECT COUNT(*) AS num_accounts FROM approved_users WHERE block = :block AND lot = :lot AND street = :street");
            $stmt->bindParam(':block', $block);
            $stmt->bindParam(':lot', $lot);
            $stmt->bindParam(':street', $street);
            $stmt->execute();
            $resultApproved = $stmt->fetch();
            
            if (($result['num_accounts'] + $resultApproved['num_accounts']) >= 2) {
                $response = [
                    'status' => 'error',
                    'message' => 'Maximum number of accounts reached for the specified block, lot, and street.'
                ];
            } else {
                // Validate password complexity
                if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password)) {
                    $response = [
                        'status' => 'error',
                        'message' => 'Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.'
                    ];
                } else {
                    $verificationCode = generateVerificationCode();

                    // Insert registration data into the users table
                    $stmt = $conn->prepare("INSERT INTO users (name, house_ownership_type, block, lot, street, email, password, verification_code, status) VALUES (:name, :ownershipType, :block, :lot, :street, :email, :hashedPassword, :verificationCode, 'Pending')");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':ownershipType', $ownershipType);
                    $stmt->bindParam(':block', $block);
                    $stmt->bindParam(':lot', $lot);
                    $stmt->bindParam(':street', $street); // Add this line for the street value
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
                    $mail->Subject = 'Account Registration Confirmation';
                    $mail->Body = '
                    <html>
                    <head>
                    <style>
                        /* Inline CSS styles for better compatibility */
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333333;
                            background-color: #f7f7f7;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            background-color: #ffffff;
                            border: 1px solid #cccccc;
                            border-radius: 4px;
                        }
                        h1 {
                            font-size: 24px;
                            margin-bottom: 20px;
                        }
                        p {
                            margin-bottom: 10px;
                        }
                        .verification-code {
                            font-weight: bold;
                            color: #ff6600;
                        }
                        .footer {
                            margin-top: 30px;
                            font-size: 14px;
                            color: #777777;
                        }
                    </style>
                    </head>
                    <body>
                    <div class="container">
                        <h1>Account Registration Confirmation</h1>
                        <p>Dear ' . $name . ',</p>
                        
                        <p>Thank you for registering an account with our website. We\'re excited to have you on board! To complete the registration process, please verify your account by entering the verification code provided below:</p>
                        
                        <p>Verification Code: <span class="verification-code">' . $verificationCode . '</span></p>
                        
                        <p>If you did not initiate this registration or believe this to be a mistake, please ignore this email.</p>
                        
                        <p>Once your account is verified and approved by the Officers, you\'ll be able to access all the features and benefits of our website. If you have any questions or need assistance, feel free to contact our support team at <a href="mailto:gardenmailer@gmail.com">gardenmailer@gmail.com</a>.</p>
                        
                        <p>Thank you again for choosing to be a part of our community!</p>
                        
                        <p class="footer">Best regards,<br>[Garden Villas III || Phase 5 Homeowners Association]</p>
                    </div>
                    </body>
                    </html>';
                    
                    
                    $mail->send();

                    $response = [
                        'status' => 'success',
                        'message' => 'Registration successful.'
                    ];

                    // Redirect to verification page
                    header('Location: ../resident/resident-verification.php');
                    exit();
                }
            }
        }
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

function generateVerificationCode() {
    // Implement your logic to generate a unique verification code
    // For example, you can use a combination of random numbers and letters
    $length = 6; // Length of the verification code
    $characters = '0123456789';
    $verificationCode = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $verificationCode .= $characters[$randomIndex];
    }

    return $verificationCode;
}
