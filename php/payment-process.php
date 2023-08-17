<?php
session_start();

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Retrieve form data
$amount = $_POST['amount'];
$paymentMethod = $_POST['paymentMethod'];
$paymentTerm = isset($_POST['paymentTerm']) ? $_POST['paymentTerm'] : null;
$residentId = $_SESSION['resident_id'];

// Initialize the variable
$stmt = null;

// Validate form data
$errorMessages = [];

if (empty($amount)) {
    $errorMessages[] = "Amount is required.";
}

if (empty($paymentMethod)) {
    $errorMessages[] = "Payment Method is required.";
}

if (empty($paymentTerm)) {
    $errorMessages[] = "Payment Term is required.";
}

if (!empty($errorMessages)) {
    $response = implode(' ', $errorMessages);
    echo $response;
    exit;
}

// Validate additional fields for GCash payment (if needed)
if ($paymentMethod === 'gcash') {
    if (empty($_FILES['paymentImage']['tmp_name'])) {
        $errorMessages[] = "Payment Image is required for GCash payment.";
        $response = implode(' ', $errorMessages);
        echo $response;
        exit;
    }
}

// Fetch the last payment end date from the database
$lastPaymentEndDate = '';
$sql = "SELECT IFNULL(MAX(payment_end_date), DATE_FORMAT(NOW(), '%Y-01-01')) AS last_payment_end_date FROM pending_gcashpayment WHERE resident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$residentId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$lastPaymentEndDate = $result['last_payment_end_date'];

// Calculate the payment end date and coverage based on the last payment end date
$paymentEndDate = '';
$paymentCoverage = '';
if ($paymentTerm === 'monthly') {
    $nextPaymentEndDateObj = new DateTime($lastPaymentEndDate);
    $nextPaymentEndDateObj->modify('+1 month');

    $coverageStartObj = new DateTime($lastPaymentEndDate);
    $coverageStartObj->modify('+1 day'); // Start coverage from the next day after the last payment end date
    $coverageEndObj = new DateTime($paymentEndDate);
    $coverageEndObj->modify('-1 day'); // End coverage one day before the next payment end date

    $paymentCoverage = $coverageStartObj->format('F Y');
    while ($coverageStartObj <= $coverageEndObj) {
        $coverageStartObj->modify('+1 month');
        $paymentCoverage .= ', ' . $coverageStartObj->format('F Y');
    }
} elseif ($paymentTerm === 'quarterly') {
    $nextPaymentEndDateObj = new DateTime($lastPaymentEndDate);
    $nextPaymentEndDateObj->modify('+3 months');

    $coverageStartObj = new DateTime($lastPaymentEndDate);
    $coverageStartObj->modify('+1 day');
    $coverageEndObj = new DateTime($paymentEndDate);
    $coverageEndObj->modify('-1 day');

    $paymentCoverage = 'Quarter ' . ceil($coverageStartObj->format('n') / 3) . ' - ' . 'Quarter ' . ceil($coverageEndObj->format('n') / 3);
} elseif ($paymentTerm === 'yearly') {
    $nextPaymentEndDateObj = new DateTime($lastPaymentEndDate);
    $nextPaymentEndDateObj->modify('+1 year');

    $coverageStartObj = new DateTime($lastPaymentEndDate);
    $coverageStartObj->modify('+1 day');
    $coverageEndObj = new DateTime($paymentEndDate);
    $coverageEndObj->modify('-1 day');

    $paymentCoverage = $coverageStartObj->format('Y') . ' - ' . $coverageEndObj->format('Y');
}

$paymentEndDate = $nextPaymentEndDateObj->format('Y-m-d');

// Insert data into the appropriate table based on the payment method
if ($paymentMethod === 'cash') {
    // Insert data into pending_cashpayment table
    $stmt = $conn->prepare("INSERT INTO pending_cashpayment (resident_id, amount, payment_term, payment_end_date, payment_date, payment_time) VALUES (?, ?, ?, ?, CURDATE(), CURTIME())");
    $stmt->execute([$residentId, $amount, $paymentTerm, $paymentEndDate]);
} elseif ($paymentMethod === 'gcash') {
    $imageUploadDir = '../images/'; // Modify this path to your image upload directory
    $paymentImageTmp = $_FILES['paymentImage']['tmp_name'];
    $paymentImageExtension = pathinfo($_FILES['paymentImage']['name'], PATHINFO_EXTENSION);

    // Generate a unique name for the image
    $uniqueImageName = uniqid() . '_' . time() . '.' . $paymentImageExtension;
    $paymentImageLocation = $imageUploadDir . $uniqueImageName;

    move_uploaded_file($paymentImageTmp, $paymentImageLocation);

    // Insert data into pending_gcashpayment table
    $stmt = $conn->prepare("INSERT INTO pending_gcashpayment (resident_id, amount, payment_term, payment_end_date, payment_coverage, payment_image, payment_date, payment_time) VALUES (?, ?, ?, ?, ?, ?, CURDATE(), CURTIME())");
    $stmt->execute([$residentId, $amount, $paymentTerm, $paymentEndDate, $paymentCoverage, $uniqueImageName]);
} else {
    echo "Invalid payment method.";
    exit;
}

if ($stmt) {
    echo "Payment successful. Thank you!";
} else {
    echo "Payment failed. Please try again.";
}
?>
