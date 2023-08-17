<?php
require('../configs/config.php');
include('sidebarcontent.php');

// Function to fetch pending bookings from the database
function getPendingBookings()
{
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

        // Fetch pending bookings from the database
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE status = 'pending'");
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }

    return [];
}

// Function to get the resident name from the database based on resident_id
function getResidentName($residentId)
{
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

        // Fetch resident name from the database
        $stmt = $conn->prepare("SELECT name FROM approved_users WHERE resident_id = :residentId");
        $stmt->bindParam(':residentId', $residentId);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result['name'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn = null;
    }

    return "Unknown Resident";
}

// Function to display the pending bookings in a table
function displayPendingBookings($bookings)
{
    if (count($bookings) > 0) {
        echo '<table class="table">
                <thead>
                    <tr>
                        <th>Resident Name</th>
                        <th>Venue</th>
                        <th>Booking Period</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($bookings as $booking) {
            $bookingId = $booking['id'];
            $residentId = $booking['resident_id'];
            $venue = $booking['Venue'];
            $startDate = $booking['start_date'];
            $endDate = $booking['end_date'];
            $startTime = $booking['start_time'];
            $endTime = $booking['end_time'];
            $bookingStatus = $booking['status'];

            echo '<tr>
    <td>' . getResidentName($residentId) . '</td>
    <td>' . $venue . '</td>
    <td>' . $startDate . ' to ' . $endDate . '</td>
    <td>' . $startTime . '</td>
    <td>' . $endTime . '</td>
    <td>' . $bookingStatus . '</td>
    <td>
        <form method="POST" action="../admin/approve-booking.php" id="approvalForm">
            <input type="hidden" name="booking_id" value="' . $bookingId . '">
            <button type="submit" name="approve" class="btn btn-success">Approve</button>
            <button type="submit" name="reject" class="btn btn-danger">Reject</button>
        </form>
    </td>
</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo "No pending bookings.";
    }
}

// Get pending bookings from the database
$pendingBookings = getPendingBookings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- Bootstrap JS (required dependencies) -->


  <link rel="stylesheet" type="text/css" href="../calendar.css">
  <link rel="stylesheet" href="side.css">

  <title>Booking Approval </title></head>
<body>
<div class="sidenav">
    <div class="logo-details">
      <i class="bx bx-home"></i>
      <span class="logo_name">Garden Villas III</span>
    </div>
    <ul class="nav flex-column">
    <?php echo generateSidebarLinks($sidebarLinks); ?>
  </ul>
  </div>
  <div class="home-section">
  <i class="bx bx-menu" id="btn"></i>
  <div class="text fw-bold" style="margin-left: 70px; margin-top:25px"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></div>

    <div class="container">
        <h2>Pending Bookings</h2>
        <?php displayPendingBookings($pendingBookings); ?>
    </div>
  </div>
  <div class="modal custom-popup" tabindex="-1" role="dialog" id="confirmationModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <i class="icon-class"></i>
                <h5 class="modal-title" id="modal-message"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="confirmAction()">Yes</button>
            </div>
        </div>
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

<script>
    function showConfirmationModal(event, action) {
        event.preventDefault(); // Prevent the form from submitting immediately

        // Display the Yes/No confirmation modal
        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        var confirmBtn = document.getElementById('confirmBtn');

        // Update the modal content with the confirmation message
        var message = (action === 'approve') ? 'Are you sure you want to approve?' : 'Are you sure you want to reject?';
        document.getElementById('modal-message').innerText = message;

        // Show the modal
        confirmationModal.show();

        // Set up event listener for the "Yes" button
        confirmBtn.onclick = function() {
            // User clicked "Yes"
            confirmationModal.hide(); // Close the modal

            // Get the form element and submit it
            var form = document.getElementById('approvalForm');
            form.submit();
        };

        // Assuming you have a button with 'id="cancelBtn"' for "No" action
        var cancelBtn = document.getElementById('cancelBtn');
        cancelBtn.onclick = function() {
            // User clicked "No"
            confirmationModal.hide(); // Close the modal
        };
    }
</script>


</body>
</html>
