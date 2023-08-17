<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Retrieve form data
$residentName = $_POST['residentName'];
$amount = $_POST['amount'];
$paymentMethod = $_POST['paymentMethod'];
$paymentTerm = isset($_POST['paymentTerm']) ? $_POST['paymentTerm'] : null;

// Initialize the variable
$stmt = null;

// Validate form data
$errorMessages = [];

if (empty($residentName)) {
    $errorMessages[] = "Resident Name is required.";
}

if (empty($amount)) {
    $errorMessages[] = "Amount is required.";
}

if (empty($paymentMethod)) {
    $errorMessages[] = "Payment Method is required.";
}

if (!empty($errorMessages)) {
    $response = implode(' ', $errorMessages);
    echo $response;
    exit;
}

// Insert data into the appropriate table based on the payment method
if ($paymentMethod === 'cash') {
    // Insert data into pending_cashpayment table
    $stmt = $conn->prepare("INSERT INTO pending_cashpayment (resident_name, amount, payment_term, payment_date, payment_time) VALUES (?, ?, ?, CURDATE(), CURTIME())");
    $stmt->execute([$residentName, $amount, $paymentTerm]);
} elseif ($paymentMethod === 'gcash') {
    $referenceNumber = $_POST['referenceNumber'];
    $stmt = $conn->prepare("SELECT * FROM pending_gcashpayment WHERE reference_number = ?");
    $stmt->execute([$referenceNumber]);
    $existingReference = $stmt->fetch();

    if ($existingReference) {
        die("Error: That reference is already in use! Enter a valid reference!");
    }
    // Validate additional fields for GCash payment
    if (empty($referenceNumber) || empty($_FILES['paymentImage']['tmp_name'])) {
        $errorMessages[] = "Reference Number and Payment Image are required for GCash payment.";
        $response = implode(' ', $errorMessages);
        echo $response;
        exit;
    }

    $imageUploadDir = '../images/'; // Modify this path to your image upload directory
    $paymentImageTmp = $_FILES['paymentImage']['tmp_name'];
    $paymentImageExtension = pathinfo($_FILES['paymentImage']['name'], PATHINFO_EXTENSION);
    
    // Generate a unique name for the image
    $uniqueImageName = uniqid() . '_' . time() . '.' . $paymentImageExtension;
    $paymentImageLocation = $imageUploadDir . $uniqueImageName;
    
    move_uploaded_file($paymentImageTmp, $paymentImageLocation);
    
    // Insert data into pending_gcashpayment table
    $stmt = $conn->prepare("INSERT INTO pending_gcashpayment (resident_name, amount, payment_term, reference_number, payment_image, payment_date, payment_time) VALUES (?, ?, ?, ?, ?, CURDATE(), CURTIME())");
    $stmt->execute([$residentName, $amount, $paymentTerm, $referenceNumber, $paymentImageLocation]);
}

// Check if $stmt is not null before calling rowCount()
if ($stmt !== null && $stmt->rowCount() > 0) {
    // Success message
    $response = "Payment successful.";
} else {
    // Error message
    $response = "Error: Payment could not be processed.";
}

$conn = null;

// Send the response back to the AJAX request
echo $response;
?>
