<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['resident_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

$residentId = $_SESSION['resident_id'];

// Fetch payment history from the database
$paymentHistory = [];
$sql = "SELECT * FROM pending_gcashpayment WHERE resident_id = ? ORDER BY payment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $residentId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $paymentHistory[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>
    <style>
        /* Custom CSS for Payment History page */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #e0e0e0;
        }

    </style>
</head>
<body>

<?php include('../navbar/nav.php'); ?>

<div class="container mt-4">
    <h1>Payment History</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Payment Coverage</th>
                <th>Payment Term</th>
                <th>Next Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($paymentHistory as $payment): ?>
        <tr>
    <td><?php echo date('F d, Y', strtotime($payment['payment_date'])); ?></td>
    <td><?php echo $payment['amount']; ?></td>

    <td>
        <?php
        $paymentTerm = $payment['payment_term'];
        $endDate = $payment['payment_end_date'];

        if ($paymentTerm === 'monthly') {
            echo date('F', strtotime('-1 month', strtotime($endDate)));
        } elseif ($paymentTerm === 'quarterly') {
            $lastPaymentYear = date('Y', strtotime($endDate));
            $lastPaymentMonth = date('n', strtotime($endDate));
            $quarterStartMonth = (($lastPaymentMonth - 1) / 3) * 2 ;
            $quarterEndMonth = $quarterStartMonth + 2;
            $quarterStartMonthName = date('F', mktime(0, 0, 0, $quarterStartMonth, 1, $lastPaymentYear));
            $quarterEndMonthName = date('F', mktime(0, 0, 0, $quarterEndMonth, 1, $lastPaymentYear));
            echo "$quarterStartMonthName-$quarterEndMonthName $lastPaymentYear";
        } elseif ($paymentTerm === 'yearly') {
            $lastPaymentYear = date('Y', strtotime($endDate));
            echo date('F', strtotime('-1 year', strtotime($endDate))) . "-December $lastPaymentYear";
        } else {
            echo 'Invalid payment term';
        }
        ?>
    </td>
    <td><?php echo ucfirst($payment['payment_term']); ?></td>
    <td><?php echo date('F d, Y', strtotime($payment['payment_end_date'])); ?></td>

    <td><?php echo ucfirst($payment['status']); ?></td>
   
</tr>

    <?php endforeach; ?>
</tbody>
    </table>
</div>

</body>
</html>


