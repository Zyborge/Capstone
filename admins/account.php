<?php
require('../configs/config.php');
include('sidebarcontent.php');
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
  <link rel="stylesheet" type="text/css" href="../dashboard.css">
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
  <title>Account Approval</title>
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

  <div class="container">
    <h2>Pending Registrations</h2>

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

        // Fetch pending registrations from the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE verification_status = 'Verified' AND status = 'Pending'");
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
          echo '<table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>House Ownership Type</th>
                <th>Block</th>
                <th>Lot</th>
                <th>Username</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

          foreach ($result as $row) {
            $userId = $row['id'];
            $name = $row['name'];
            $ownershipType = $row['house_ownership_type'];
            $block = $row['block'];
            $lot = $row['lot'];
            $email = $row['email'];

            echo '<tr>
              <td>' . $name . '</td>
              <td>' . $ownershipType . '</td>
              <td>' . $block . '</td>
              <td>' . $lot . '</td>
              <td>' . $email . '</td>
              <td>
                <button type="button" class="btn btn-success approve-button" data-user-id="' . $userId . '">Approve</button>
                <button type="button" class="btn btn-danger reject-button" data-user-id="' . $userId . '">Reject</button>
              </td>
            </tr>';
          }

          echo '</tbody></table>';
        } else {
          echo "No pending registrations.";
        }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      // Close the database connection
      $conn = null;
    ?>
  </div>
</div>

<!-- Popup for confirmation -->
<div class="popup" id="confirmationPopup" style="display: none;">
    <div class="popup-content">
        <div class="icon-container">
            <i class='bx bx-question-mark bx-xl'></i>
        </div>
        <p style="font-size: 18px">Are you sure you want to <span id="popupActionText" style="font-size: 18px"></span> this registration?</p>
        <button class="btn btn-secondary" id="cancelActionBtn">Cancel</button>
        <button class="btn btn-primary" id="confirmActionBtn">Confirm</button>
    </div>
</div>

<!-- Alert container to display success and error messages -->
<div id="alertContainer" class="position-fixed bottom-0 end-0 p-3"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let selectedUserId;
        let selectedAction;

        // Function to open the confirmation popup
        function openConfirmationPopup(userId, action) {
            selectedUserId = userId;
            selectedAction = action;
            $("#popupActionText").text(action);
            $("#confirmationPopup").show();
        }

        // Function to close the confirmation popup
        function closeConfirmationPopup() {
            $("#confirmationPopup").hide();
        }

        // Function to handle user registration approval
        function approveRegistration(userId) {
            $.ajax({
                type: "POST",
                url: "../php/approve_registration.php",
                data: { user_id: userId, action: "approve" },
                success: function(response) {
                    // Handle success response and display appropriate message
                    // ...

                    // Display a success alert
                    displayAlert("User registration approved successfully!", "success");
                },
                error: function() {
                    // Handle errors here
                    // Display an error alert
                    displayAlert("Error approving user registration. Please try again.", "danger");
                }
            });
        }

        // Function to handle user registration rejection
        function rejectRegistration(userId) {
            $.ajax({
                type: "POST",
                url: "../php/approve_registration.php",
                data: { user_id: userId, action: "reject" },
                success: function(response) {
                    // Handle success response and display appropriate message
                    // ...

                    // Display a danger alert
                    displayAlert("User registration rejected successfully!", "success");
                },
                error: function() {
                    // Handle errors here
                    // Display an error alert
                    displayAlert("Error rejecting user registration. Please try again.", "danger");
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
            var userId = $(this).data("user-id");
            openConfirmationPopup(userId, "approve");
        });

        $(".reject-button").click(function() {
            var userId = $(this).data("user-id");
            openConfirmationPopup(userId, "reject");
        });

        // Attach click event handler to the Cancel button in the popup
        $("#cancelActionBtn").click(function() {
            closeConfirmationPopup();
        });

        // Attach click event handler to the Confirm button in the popup
        $("#confirmActionBtn").click(function() {
            closeConfirmationPopup();
            if (selectedAction === "approve") {
                approveRegistration(selectedUserId);
            } else if (selectedAction === "reject") {
                rejectRegistration(selectedUserId);
            }
        });
    });
</script>
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