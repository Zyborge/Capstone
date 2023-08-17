<?php
// Replace the database connection credentials below with the appropriate values.
$host = 'localhost';
$dbname = 'gardenvillas_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set Philippine time as the default timezone
    date_default_timezone_set('Asia/Manila');

    // Check if the form is submitted
    if (isset($_GET['selected_month'])) {
        $selectedMonth = $_GET['selected_month'];
        // Query to retrieve pending GCash payments with resident names for the selected month
        $pendingPaymentsQuery = "SELECT p.*, u.name AS resident_name FROM `pending_gcashpayment` AS p INNER JOIN `approved_users` AS u ON p.resident_id = u.resident_id WHERE p.status = 'pending' AND DATE_FORMAT(payment_date, '%Y-%m') = :selected_month";
        $pendingPaymentsStmt = $pdo->prepare($pendingPaymentsQuery);
        $pendingPaymentsStmt->execute(array(':selected_month' => $selectedMonth));
        $pendingPayments = $pendingPaymentsStmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Query to retrieve all pending GCash payments with resident names
        $pendingPaymentsQuery = "SELECT p.*, u.name AS resident_name FROM `pending_gcashpayment` AS p INNER JOIN `approved_users` AS u ON p.resident_id = u.resident_id WHERE p.status = 'pending'";
        $pendingPaymentsStmt = $pdo->prepare($pendingPaymentsQuery);
        $pendingPaymentsStmt->execute();
        $pendingPayments = $pendingPaymentsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Financial Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .print-button {
            display: none;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>Financial Report</h1>
    <form method="get">
        <label for="selected_month">Select Month:</label>
        <select name="selected_month" id="selected_month">
            <?php
                // Generate options for the dropdown menu with the last 12 months
                for ($i = 0; $i < 12; $i++) {
                    $month = date('Y-m', strtotime("-$i months"));
                    $monthName = date('F Y', strtotime("-$i months"));
                    $selected = isset($_GET['selected_month']) && $_GET['selected_month'] === $month ? 'selected' : '';
                    echo "<option value=\"$month\" $selected>$monthName</option>";
                }
            ?>
        </select>
        <button type="submit">Generate Report</button>
    </form>
    <p>Date Generated: <?php echo date('M d, Y \a\t h:i A'); ?></p>
    <h2>Pending GCash Payments</h2>
    <p>Total Pending Payments: <?php echo count($pendingPayments); ?></p>
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Resident Name</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingPayments as $payment) : ?>
                <tr>
                    <td><?php echo $payment['payment_id']; ?></td>
                    <td><?php echo $payment['resident_name']; ?></td>
                    <td><?php echo $payment['amount']; ?></td>
                    <td><?php echo $payment['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Print button -->
    <button class="print-button" onclick="window.print()">Print Report</button>
</body>
</html>
