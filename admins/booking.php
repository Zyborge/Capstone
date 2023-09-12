<?php
require('../configs/config.php');
include('sidebarcontent.php');

// Function to fetch pending bookings from the database
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Bootstrap JS (required dependencies) -->
    <link rel="stylesheet" type="text/css" href="../calendar.css">
    <link rel="stylesheet" href="side.css">
    <style>
        /* Updated CSS for the confirmation popup with Boxicons question mark icon */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .icon-container {
            font-size: 70px;
            margin-bottom: 10px;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 450px; /* Set max-width here */
        }
        #alertContainer {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    /* Style for individual alerts */
    .custom-alert {
        position: relative;
        display: block;
        max-width: 300px;
        margin-top: 10px;
        right: -100%;
        opacity: 0;
        transition: right 0.3s, opacity 0.3s;
    }

    /* Style for success alerts */
    .custom-alert.alert-success {
        background-color: #4CAF50;
    }

    /* Style for danger alerts */
    .custom-alert.alert-danger {
        background-color: #f44336;
    }

    /* Show the alert with a sliding animation */
    .custom-alert.show {
        right: 20px;
        opacity: 1;
    }
    </style>

    <title>Booking Approval</title>
</head>
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
    <div class="container mt-5">

        <!-- Display Pending Bookings -->
        <h2>Pending Bookings</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th> <!-- Added table head for Name -->
                <th>Venue</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <!-- PHP code to fetch and display pending bookings -->
            <?php
            // Replace with your database connection code
            $conn = new mysqli("localhost", "root", "", "gardenvillas_db");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM bookings WHERE status='pending'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";

                    // Fetch resident's name based on resident_id
                    $residentId = $row['resident_id'];
                    $residentName = "";
                    $residentQuery = "SELECT name FROM approved_users WHERE resident_id = $residentId";
                    $residentResult = $conn->query($residentQuery);
                    if ($residentResult->num_rows > 0) {
                        $residentRow = $residentResult->fetch_assoc();
                        $residentName = $residentRow['name'];
                    }

                    // Display the resident's name before the venue
                    echo "<td>$residentName</td>";

                    echo "<td>" . $row['Venue'] . "</td>";
                    echo "<td>" . $row['start_date'] . "</td>";
                    echo "<td>" . $row['end_date'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td id='status-" . $row['id'] . "'>" . $row['status'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-success approve-button' data-id='" . $row['id'] . "' style='margin-right: 10px;'><i class='bx bx-check'></i></button>";
                    echo "<button class='btn btn-danger reject-button' data-id='" . $row['id'] . "'><i class='bx bx-x'></i></button>";
                    echo "<span id='action-" . $row['id'] . "'></span>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No pending bookings</td></tr>";
            }

            $conn->close();
            ?>

            </tbody>
        </table>
    </div>
</div>
</div>
<div class="popup" id="confirmationPopup" style="display: none;">
    <div class="popup-content">
        <div class="icon-container">
            <i class='bx bx-question-mark bx-xl'></i>
        </div>
        <p style="font-size:18px">Are you sure you want to <span id="popupActionText" style="font-size:18px"></span> this booking?</p>
        <button class="btn btn-secondary" id="cancelActionBtn">Cancel</button>
        <button class="btn btn-primary" id="confirmActionBtn">Confirm</button>
    </div>
</div>

<!-- Alert container to display success and error messages -->
<div id="alertContainer" class="position-fixed bottom-0 end-0 p-3"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    $(document).ready(function() {
        // Variables to store the selected booking ID and action
        let selectedBookingId;
        let selectedAction;

        // Function to open the confirmation popup
        function openConfirmationPopup(bookingId, action) {
            selectedBookingId = bookingId;
            selectedAction = action;
            $("#popupActionText").text(action);
            $("#confirmationPopup").show();
        }

        // Function to close the confirmation popup
        function closeConfirmationPopup() {
            $("#confirmationPopup").hide();
        }

        // Function to handle booking approval
        function approveBooking(bookingId) {
            $.ajax({
                type: "POST",
                url: "../admin/approve-booking.php",
                data: { id: bookingId, action: "approve" },
                success: function(response) {
                    // Update the status in the table and display a message
                    $("#status-" + bookingId).text("approved");

                    // Display a success alert
                    displayAlert("Booking approved successfully!", "success");
                },
                error: function() {
                    // Handle errors here
                    // Display an error alert
                    displayAlert("Error approving booking. Please try again.", "danger");
                }
            });
        }

        // Function to handle booking rejection
        function rejectBooking(bookingId) {
            $.ajax({
                type: "POST",
                url: "../admin/approve-booking.php",
                data: { id: bookingId, action: "reject" },
                success: function(response) {
                    // Update the status in the table and display a message
                    $("#status-" + bookingId).text("rejected");

                    // Display a danger alert
                    displayAlert("Booking rejected successfully!", "success");
                },
                error: function() {
                    // Handle errors here
                    // Display an error alert
                    displayAlert("Error rejecting booking. Please try again.", "danger");
                }
            });
        }

        // Function to display Bootstrap alerts
        function displayAlert(message, type) {
            var alertContainer = $("#alertContainer");
            var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
            alertContainer.html(alertHtml);
            // Automatically close the alert after a few seconds (optional)
            setTimeout(function() {
                alertContainer.html("");
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Attach click event handlers to approve and reject buttons
        $(".approve-button").click(function() {
            var bookingId = $(this).data("id");
            openConfirmationPopup(bookingId, "approve");
        });

        $(".reject-button").click(function() {
            var bookingId = $(this).data("id");
            openConfirmationPopup(bookingId, "reject");
        });

        // Attach click event handler to the Cancel button in the popup
        $("#cancelActionBtn").click(function() {
            closeConfirmationPopup();
        });

        // Attach click event handler to the Confirm button in the popup
        $("#confirmActionBtn").click(function() {
            closeConfirmationPopup();
            if (selectedAction === "approve") {
                approveBooking(selectedBookingId);
            } else if (selectedAction === "reject") {
                rejectBooking(selectedBookingId);
            }
        });
    });
</script>
</body>
</html>
