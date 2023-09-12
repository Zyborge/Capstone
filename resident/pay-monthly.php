<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Garden Villas III - Admin Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../css/resident-home.css">
  <style>
   /* payment-page.css */

/* Center the form on the page */
.container {
    max-width: 400px;
    margin: 0 auto;
}

/* Style the form elements */
.form-group {
    margin-bottom: 20px;
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
}

/* Style the select input */
.select-control {
    appearance: none; /* Remove default styles on some browsers */
    -webkit-appearance: none; /* Remove default styles on WebKit browsers */
    -moz-appearance: none; /* Remove default styles on Mozilla browsers */
    background: url("../path-to-custom-select-icon.png") no-repeat right center; /* Add custom select icon */
    padding-right: 30px; /* Add space for the icon */
}

/* Style the invalid feedback message */
.invalid-feedback {
    color: #ff0000;
    font-size: 12px;
}

/* Style the pay now button */
#payNowButton {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 15px;
    cursor: pointer;
}

/* Add additional custom styles as needed */

    .gcash-logo {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 10px;
    }

    .gcash-logo img {
      max-width: 100%;
      max-height: 100%;
    }
    
  </style>
</head>
<body>

<?php include('../navbar/nav.php'); ?>

<div class="container mt-4">
  <h1>Monthly Dues Payment</h1>
  <form id="paymentForm" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="residentName" class="form-label">Resident Name:</label>
      <input type="text" class="form-control" id="residentName" name="residentName" readonly value="<?php echo $_SESSION['name']; ?>" required>
    </div>
    <div class="mb-3">
      <label for="amount" class="form-label">Amount:</label>
      <input type="number" class="form-control" id="amount" name="amount" readonly required>
    </div>
    <div class="mb-3">
      <label for="paymentTerm" class="form-label">Payment Term:</label>
      <select class="form-select" id="paymentTerm" name="paymentTerm" required>
        <option value="" disabled selected>Select Payment Term</option>
        <option value="monthly">Monthly</option>
        <option value="quarterly">Quarterly</option>
        <option value="yearly">Yearly</option>
      </select>
      <div class="invalid-feedback">Please select a payment term.</div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" id="paymentEndDate" name="paymentEndDate" readonly style="display: none;">
    </div>
    <div class="mb-3">
      <label for="paymentMethod" class="form-label">Payment Method:</label>
      <select class="form-select" id="paymentMethod" name="paymentMethod" required>
        <option value="">Select Payment Method</option>
        <option value="cash">Cash</option>
        <option value="gcash">Gcash</option>
      </select>
      <div class="invalid-feedback">Please select a payment method.</div>
    </div>
    <div class="gcash-logo" id="gcashlogoContainer" style="display: none;">
      <img src="../backgrounds/gcash_qr.jpg" alt="GCash Logo" width="250">
    </div>
    <div id="imageUploadContainer" class="mb-3" style="display: none;">
      <label for="paymentImage" class="form-label">Payment Image:</label>
      <input type="file" class="form-control" id="paymentImage" name="paymentImage" required>
      <div class="invalid-feedback">Please select a payment image.</div>
    </div>
    <div id="responseMessage" class="mt-3"></div>
    <button type="button" id="payNowButton" class="btn btn-primary">Pay Now</button>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Your HTML code remains unchanged -->

<script>
 $(document).ready(function() {
        // Fetch the last payment end date from the server
        $.ajax({
            type: 'POST',
            url: '../php/last_payment_date.php',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Save the last payment end date as a data attribute for future use
                    $('#paymentEndDate').data('lastPaymentEndDate', response.lastPaymentEndDate);

                    // Calculate and populate the next payment end date based on the selected payment term
                    $('#paymentTerm').change(function() {
                        var paymentTerm = $(this).val();
                        calculateAndPopulateCoverage(paymentTerm);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Error fetching last payment: ' + error);
            }
        });

        // Update amount field based on paymentTerm selection
        $('#paymentTerm').change(function() {
            var paymentTerm = $(this).val();
            var amount = "";

            if (paymentTerm === 'monthly') {
                amount = 100;
            } else if (paymentTerm === 'quarterly') {
                amount = 300;
            } else if (paymentTerm === 'yearly') {
                amount = 1200;
            }

            $('#amount').val(amount);
            calculateAndPopulateCoverage(paymentTerm);
        });

        // Show/hide GCash logo based on paymentMethod selection
        $('#paymentMethod').change(function() {
            var paymentMethod = $(this).val();

            if (paymentMethod === 'gcash') {
                $('.gcash-logo').show();
                imageUploadContainer.style.display = 'block';

            } else {
                $('.gcash-logo').hide();
                imageUploadContainer.style.display = 'none';

            }
        });

        // Form submission with AJAX
        $(document).on('click', '#payNowButton', function() {
    var form = $('#paymentForm');
    var url = '../php/payment-process.php'; // Specify the URL to handle the form submission
    var responseMessage = $('#responseMessage');
    var gcashLogoContainer = $('#gcashlogoContainer');

    // Get the selected payment term from the dropdown
    var paymentTerm = $('#paymentTerm option:selected').val();

    // Add the payment term to the form data before submitting the AJAX request
    var formData = new FormData(form[0]);
    formData.append('paymentTerm', paymentTerm); // Use 'paymentTerm' instead of 'payment_term'

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Determine the alert type and icon class
            var alertType = response.includes("successful") ? 'alert-success' : 'alert-danger';
            var iconClass = alertType === 'alert-success' ? 'bx bx-check-circle bx-md' : 'bx bx-error-circle bx-md';
            
            // Create a Bootstrap alert element with shake animation
            var alert = $('<div class="alert ' + alertType + ' alert-dismissible fade show d-flex align-items-center animate__animated animate__shakeX custom-alert" role="alert">' +
                '<i class="' + iconClass + ' mr-2"></i>' +
                '<strong class="flex-grow-1">' + response + '</strong>' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

            // Clear existing response messages and show the new alert
            responseMessage.empty(); // Empty the container before appending
            $('body').append(alert); // Append the alert to the body

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

            if (response.includes("successful")) {
                gcashLogoContainer.hide(); // Hide the GCash logo container
            }
        },
        error: function(xhr, status, error) {
            // Create a Bootstrap error alert
            var errorAlert = $('<div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">' +
                'Error: ' + error +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

            // Clear existing response messages and show the error alert
            responseMessage.empty();
            $('body').append(errorAlert); // Append the alert to the body
        }
    });
});


        function calculateAndPopulateCoverage(paymentTerm) {
        var lastPaymentEndDate = new Date($('#paymentEndDate').data('lastPaymentEndDate'));
        var currentDate = new Date();
        var formattedCurrentDate = formatDate(currentDate);
        var paymentCoverage = ""; // Initialize the payment coverage variable

        // Calculate the difference in months between the last payment end date and January 1 of the current year
        var diffMonths = (currentDate.getFullYear() - lastPaymentEndDate.getFullYear()) * 12;
        diffMonths -= lastPaymentEndDate.getMonth();

        // Use January 1 of the current year as the starting point for payment coverage
        var firstDayOfYear = new Date(currentDate.getFullYear(), 0, 1);

        // If the current date is before or equal to January 1 of the current year, use January 1 of the current year
        if (currentDate <= firstDayOfYear) {
            currentDate = firstDayOfYear;
        }

        // Add the remaining months based on the selected payment term and store the coverage
        if (paymentTerm === 'monthly') {
            currentDate.setMonth(currentDate.getMonth() + 1);
            paymentCoverage = formatDate(currentDate, "F");
        } else if (paymentTerm === 'quarterly') {
            currentDate.setMonth(currentDate.getMonth() + 3 - (diffMonths % 3));
            var quarterStartMonth = currentDate.getMonth() - (currentDate.getMonth() % 3);
            var quarterEndMonth = quarterStartMonth + 2;
            paymentCoverage = formatDate(currentDate, "F") + " - " + formatDate(new Date(currentDate.getFullYear(), quarterEndMonth), "F");
        } else if (paymentTerm === 'yearly') {
            currentDate.setFullYear(currentDate.getFullYear() + 1 - (diffMonths % 12));
            paymentCoverage = formatDate(currentDate, "F Y") + " - " + formatDate(new Date(currentDate.getFullYear(), 11), "F Y");
        }

        var formattedNextPaymentEndDate = formatDate(currentDate);
        $('#paymentEndDate').val(formattedNextPaymentEndDate + " (" + paymentCoverage + ")"); // Update the paymentEndDate input field
    }

        // Helper function to format the date as 'YYYY-MM-DD'
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

    });
</script>



</body>
</html>