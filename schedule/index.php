<?php session_start()?>
<?php
require_once('db-connect.php');

// Get the logged-in user's resident_id
$residentId = $_SESSION['resident_id'];

// Perform date and time validation
$currentDateTime = new DateTime();
if (isset($_POST['start-date']) && isset($_POST['start-time'])) {
    $userDateTime = new DateTime($_POST['start-date'] . ' ' . $_POST['start-time']);
    $timeThreshold = new DateInterval('PT15M'); // 15 minutes difference allowed

    if ($userDateTime < $currentDateTime || $userDateTime->diff($currentDateTime) > $timeThreshold) {
        // Display an error message or redirect to an error page if the user's date and time settings are incorrect
        echo '<h1>Please correct your time and date.</h1>';
        // Or redirect to an error page
        // header('Location: error.php');
        // exit();
    }
}

$bookingsSql = "SELECT b.*, u.email FROM bookings AS b INNER JOIN approved_users AS u ON b.resident_id = u.resident_id";
$bookingsResult = $conn->query($bookingsSql);

$sched_res = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $row['sdate'] = date("F d, Y", strtotime($row['start_date']));
    $row['edate'] = date("F d, Y", strtotime($row['end_date']));

    // Check if the user is logged in and the resident_id matches the booking's resident_id
    if ($residentId == $row['resident_id']) {
        $row['display'] = 'BOOKED';
    } else {
        $row['display'] = '';
        // Hide the event details for events booked by other users
        $row['title'] = 'BOOKED';
        $row['description'] = '';
    }

    $sched_res[$row['id']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index-cal.css">

    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>


</head>
<?php include('../navbar/nav.php'); ?>

<body>
    <div class="container py-5" id="page-container">
        <?php if (isset($_SESSION['resident_id'])) : ?>
            <div class="row">
                <div class="col-md-9">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-3">
    <div class="card rounded-0 shadow">
        <div class="card-header bg-gradient bg-primary text-light">
            <h5 class="card-title">Schedule Form</h5>
        </div>
        <div class="card-body">
    <div class="container-fluid">
    <form method="post" id="schedule-form" class="modern-form">
            <input type="hidden" name="id" value="">
            <div class="form-group mb-2">
                <label for="venue">Event Venue:</label>
                <select id="venue" name="venue">
                    <option value="" disabled selected>Select Venue</option>
                    <option value="Covered Court">Covered Court</option>
                    <option value="Clubhouse">Clubhouse</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="form-group mb-2">
                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <div class="form-group mb-2">
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start-date" max="9999-12-31" min="1970-01-01">
            </div>
            <div class="form-group mb-2">
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end-date" max="9999-12-31">
            </div>
            <div class="form-group mb-2">
                <label for="start-time">Start Time:</label>
                <input type="time" id="start-time" name="start-time">
            </div>
            <div class="form-group mb-2">
                <label for="end-time">End Time:</label>
                <input type="time" id="end-time" name="end-time">
            </div>
        </form>
    </div>
</div>
<div class="card-footer">
    <div class="text-center">
        <!-- Buttons are inside the form, so they can trigger form submission -->
        <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form" id="book-btn" disabled><i class='bx bx-check'></i> Book</button>
        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
    </div>
</div>
</div>
</div>

                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                <div class="container-fluid">
                        <dl>
                        <dt class="text-muted">Venue</dt>
                        <dd id="Venue" class=""></dd>
                        <dt class="text-muted">Title</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Start Date</dt>
                        <dd id="start-date" class=""></dd>
                        <dt class="text-muted">End Date</dt>
                        <dd id="end-date" class=""></dd>
                        <dt class="text-muted">Start Time</dt>
                        <dd id="start-time" class=""></dd>
                        <dt class="text-muted">End Time</dt>
                        <dd id="end-time" class=""></dd>

                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add this in your HTML where you want the modal to appear -->
<!-- Add this in your HTML where you want the modal to appear -->
<div class="modal custom-popup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <i class="icon-class"></i>
                <h5 class="modal-title" id="modal-message"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <script>
        var scheds = <?= json_encode($sched_res) ?>;
    </script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script>

    <script>
        
    </script>
   <script>
    var startDateInput = document.getElementById("start-date");
    var currentDate = new Date();
    var timezoneOffset = currentDate.getTimezoneOffset() * 60000; // Get the timezone offset in milliseconds
    var currentDateString = new Date(Date.now() - timezoneOffset).toISOString().split("T")[0];
    startDateInput.setAttribute("min", currentDateString);

    var endDateInput = document.getElementById("end-date");

    startDateInput.addEventListener("input", function() {
        endDateInput.setAttribute("min", this.value);
    });

    endDateInput.addEventListener("input", function() {
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(this.value);

        if (endDate < startDate) {
            this.value = "";
        }
    });

    var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    var startTimeInput = document.getElementById("start-time");
    var endTimeInput = document.getElementById("end-time");

    endTimeInput.addEventListener("input", function() {
        var startTime = new Date(currentDateString + "T" + startTimeInput.value);
        var endTime = new Date(currentDateString + "T" + this.value);

        if (endTime < startTime) {
            this.value = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    });
</script>
 <script>
    // Function to validate the form before submission
    function validateForm() {
        // Get form element by its ID
        var form = document.getElementById('schedule-form');

        // Get the values of the required fields
        var venue = form.elements['venue'].value;
        var title = form.elements['title'].value;
        var startDate = form.elements['start-date'].value;
        var endDate = form.elements['end-date'].value;
        var startTime = form.elements['start-time'].value;
        var endTime = form.elements['end-time'].value;

        // Check if any required field is empty
        if (venue === '' || title === '' || startDate === '' || endDate === '' || startTime === '' || endTime === '') {
            // Disable the "Book" button if there are missing inputs
            document.getElementById('book-btn').disabled = true;
        } else {
            // Enable the "Book" button if all inputs are filled
            document.getElementById('book-btn').disabled = false;
        }
    }

    // Add event listener to the form's submit button
    var submitButton = document.querySelector('button[type="submit"]');
    submitButton.addEventListener('click', validateForm);

    // Add event listeners to input fields to trigger form validation on change
    var inputFields = document.querySelectorAll('input, select, textarea');
    inputFields.forEach(function (field) {
        field.addEventListener('change', validateForm);
    });
</script>
<script>
  $(document).ready(function() {
    // Create an alerts container
    var alertsContainer = $('<div class="alerts-container"></div>');
    $('body').append(alertsContainer);

    // Handle form submission using AJAX
    $("#schedule-form").submit(function(e) {
        e.preventDefault(); // Prevent the form from redirecting

        // Serialize the form data
        var formData = $(this).serialize();

        // Make an AJAX POST request to the server
        $.ajax({
            url: "save_schedule.php", // URL to handle form data on the server
            type: "POST",
            data: formData,
            dataType: "json", // Expect JSON response from the server
            success: function(response) {
                // Handle the response from the server
                if (response.status === "success") {
                    showCustomPopup(response.message, "alert-success");
                    $("#schedule-form")[0].reset(); // Clear the form
                } else {
                    showCustomPopup(response.message, "alert-danger");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any error that occurs during the AJAX request
                showCustomPopup("An error occurred during the AJAX request.", "alert-danger");
                console.error(textStatus, errorThrown);
            }
        });
    });
    function showCustomPopup(message, alertType) {
    // Determine the icon class based on the alertType
    var iconClass = (alertType === 'alert-success') ? 'bx bx-check-circle bx-md' : 'bx bx-error-circle bx-md';

    // Create an alert element
    var alert = $('<div class="alert ' + alertType + ' alert-dismissible fade show d-flex align-items-center animate__animated animate__shakeX" role="alert">' +
        '<i class="' + iconClass + ' mr-2"></i>' +
        '<strong class="flex-grow-1">' + message + '</strong>' +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

    // Add the alert to the alerts container
    alertsContainer.append(alert);

    // Set position to lower right
    alert.css({
        'position': 'fixed',
        'bottom': '20px',
        'right': '20px',
        'z-index': '1000'
    });

    // Automatically remove the alert after a few seconds
    setTimeout(function() {
        alert.alert('close');
        // Refresh the page only on success
        if (alertType === 'alert-success') {
            location.reload();
        }
    }, 5000);

    // Add event listener for the close button
    alert.find('.btn-close').on('click', function() {
        // Refresh the page only on success
        if (alertType === 'alert-success') {
            location.reload();
        }
    });
}

  });

</script>


</body>

</html>