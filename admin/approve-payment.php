<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="../dashboard.css">
  <link rel="stylesheet" href="side.css">
  <title>Dashboard</title>
</head>
<body>


<div class="home-section">
  <i class="bx bx-menu" id="btn"></i>
  <div class="text fw-bold" style="margin-left: 70px; margin-top:25px"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></div>
  <div class="container">
    <h2>Pending Payments</h2>

    <?php
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

        // Function to update payment status
        function updatePaymentStatus($paymentID, $status) {
          global $conn;
          $stmt = $conn->prepare("UPDATE pending_gcashpayment SET status = :status WHERE payment_id = :payment_id");
          $stmt->bindParam(':status', $status);
          $stmt->bindParam(':payment_id', $paymentID);
          $stmt->execute();
        }

        // Handle form submission
       // Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['verify'])) {
      $paymentID = $_POST['payment_id'];
      updatePaymentStatus($paymentID, 'received');
      header("Location: generate_receipt.php?payment_id=$paymentID");
      exit();
  } elseif (isset($_POST['reject'])) {
      $paymentID = $_POST['payment_id'];
      updatePaymentStatus($paymentID, 'not_received');
      header("Location: {$_SERVER['PHP_SELF']}");
      exit();
  }
}


        // Fetch pending payments from the database with resident names
        $stmt = $conn->prepare("SELECT p.payment_id, a.name, p.amount, p.payment_term, p.reference_number, p.payment_image, p.payment_date, p.payment_time, p.status FROM pending_gcashpayment p
          INNER JOIN approved_users a ON p.resident_id = a.resident_id
          WHERE p.status = 'pending'");
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
          echo '<table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Resident Name</th>
                <th>Amount</th>
                <th>Payment Term</th>
                <th>Reference Number</th>
                <th>Payment Image</th>
                <th>Payment Date</th>
                <th>Payment Time</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

          foreach ($result as $row) {
            $id = $row['payment_id'];
            $residentName = $row['name'];
            $amount = $row['amount'];
            $paymentTerm = $row['payment_term'];
            $referenceNumber = $row['reference_number'];
            $paymentImage = $row['payment_image'];
            $paymentDate = $row['payment_date'];
            $paymentTime = $row['payment_time'];
            $status = $row['status'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $residentName . '</td>
              <td>' . $amount . '</td>
              <td>' . $paymentTerm . '</td>
              <td>' . $referenceNumber . '</td>
              <td><img src="../' . $paymentImage . '" alt="Payment Image" style="max-width: 100px;"></td>
              <td>' . $paymentDate . '</td>
              <td>' . $paymentTime . '</td>
              <td>' . $status . '</td>
              <td>
                <form method="POST" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="payment_id" value="' . $id . '">
                  <button type="submit" name="verify" class="btn btn-success">Verify</button>
                  <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                </form>
              </td>
            </tr>';
          }

          echo '</tbody></table>';
        } else {
          echo "No pending payments.";
        }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      // Close the database connection
      $conn = null;
    ?>

  </div>
</div>

<script>
  let sidebar = document.querySelector(".sidenav");
  let menuBtn = document.querySelector("#btn");

  menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("minimized");
    menuBtnChange();
  });

  function menuBtnChange() {
    if (sidebar.classList.contains("minimized")) {
      menuBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
      menuBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
  }
</script>

</body>
</html>
