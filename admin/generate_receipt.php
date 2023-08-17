<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Receipt</title>
  <style>
    .receipt {
      max-width: 400px;
      margin: 0 auto;
      padding: 30px;
      border: 2px solid #000;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .receipt-logo {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      height: 100px;
      margin-left : 40%;
      width:50px;
    }

    .receipt h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .receipt p {
      margin-bottom: 10px;
    }

    .receipt .info p {
      margin: 0;
    }

    .receipt .info p:first-child {
      font-weight: bold;
    }

    .receipt .total {
      margin-top: 20px;
    }

    .receipt .total p {
      margin: 0;
    }

    .receipt .total p:first-child {
      font-weight: bold;
    }

    .receipt .thanks {
      text-align: center;
      margin-top: 20px;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="receipt">
  <div class="receipt-logo">
      <img src="../backgrounds/phase5.png" alt="Logo">
    </div>
    <h2>Receipt</h2>

    <?php
    // Check if the payment ID is provided as a query parameter
    if(isset($_GET['payment_id'])) {
        // Retrieve the payment ID from the query parameter
        $paymentID = $_GET['payment_id'];

        // Database connection parameters
        $servername = "localhost";
        $dbname = "gardenvillas_db";
        $username = "root";
        $password = "";

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch the payment details from the database
            $stmt = $conn->prepare("SELECT pg.*, r.name
                                    FROM pending_gcashpayment pg
                                    INNER JOIN approved_users r ON pg.resident_id = r.resident_id
                                    WHERE pg.payment_id = :payment_id");
            $stmt->bindParam(':payment_id', $paymentID);
            $stmt->execute();
            $payment = $stmt->fetch();

            // Check if the payment exists
            if($payment) {
                // Retrieve the necessary payment details
                $residentName = $payment['name'];
                $amount = $payment['amount'];
                $paymentTerm = $payment['payment_term'];
                $referenceNumber = $payment['reference_number'];
                $paymentDate = $payment['payment_date'];

                // Display the resident's name and amount paid on the receipt
                echo "<div class='info'>";
                echo "<p>Resident Name: $residentName</p>";
                echo "<p>Amount: $amount</p>";
                echo "<p>Payment Term: $paymentTerm</p>";
                echo "<p>Reference Number: $referenceNumber</p>";
                echo "<p>Payment Date: $paymentDate</p>";
                echo "</div>";

                // Calculate the total amount due
                $totalAmountDue = $amount;

                // Display the total amount due on the receipt
                echo "<div class='total'>";
                echo "<p>Total Amount Due:</p>";
                echo "<p>$totalAmountDue</p>";
                echo "</div>";

                // Display the thank you message
                echo "<p class='thanks'>Thank you for your payment!</p>";
            } else {
                echo "Payment not found.";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;
    } else {
        echo "Invalid payment ID.";
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
