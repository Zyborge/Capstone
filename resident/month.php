<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
            body {
            font-family: Arial, sans-serif;
            background-image: url(../backgrounds/bfa.svg);
            background-size: cover; /* Cover the entire page */
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top:35px;
        }

        .card {
    background-color: rgba(255, 255, 255, 0.9); /* Adjust the alpha (0.9) for transparency */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
    width: 300px;
    height: 500px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}


        .card:hover {
            transform: translateY(-10px);
            transform: scale(1.05); /* Increase the size by 5% */

            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .card p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }

        .price {
            font-size: 36px;
            color: #4CAF50;
            margin: 10px 0;
        }

        .subscribe-button {
            background-color: green;
            color: #fff;
            border: none;
            width: 200px;
            border-radius: 5px;
            padding: 12px 24px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 35px;
        }

        .subscribe-button:hover {
            background-color: #0056b3;
        }
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        /* Style for the popup content */
        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
        }

        /* Style for the close button */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
      

    </style>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<?php include('../navbar/nav.php'); ?>

    <div class="container">
        <div class="card">
            <h2>Monthly</h2>
            <div class="price">₱100/month</div>
            <p style="margin-top: 20px; text-align: center;">
            Your dues contribute to the maintenance and improvement of our community. Thank you for your support!
        </p>
        <button class="subscribe-button" id="openPaymentPopup" data-payment-term="monthly">Pay</button>
        </div>
        <div class="card">
            <h2>Quarterly</h2>
            <div class="price">₱300/quarter</div>
            <p style="margin-top: 20px; text-align: center;">
            Your dues contribute to the maintenance and improvement of our community. Thank you for your support!
        </p>
        <button class="subscribe-button" id="openPaymentPopup" data-payment-term="quarterly">Pay</button>
        </div>
        <div class="card">
            <h2>Yearly</h2>
            <div class="price">₱1200/year</div>
            <p style="margin-top: 20px;  text-align: center;">
            Your dues contribute to the maintenance and improvement of our community. Thank you for your support!
        </p>
        <button class="subscribe-button" id="openPaymentPopup" data-payment-term="yearly">Pay</button>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Monthly Dues Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Payment form content moved here -->
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
                        <div class="gcash-logo" id="gcashlogoContainer" style="display: none;  margin-left:25%; ">
                            <img src="../backgrounds/gcash_qr.jpg" alt="GCash Logo" width="250">
                        </div>
                        <div id="imageUploadContainer" class="mb-3" style="display: none;">
                            <label for="paymentImage" class="form-label">Payment Image:</label>
                            <input type="file" class="form-control" id="paymentImage" name="paymentImage" required>
                            <div class="invalid-feedback">Please select a payment image.</div>
                        </div>
                        <div id="responseMessage" class="mt-3"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="payNowButton" class="btn btn-primary">Pay Now</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        document.querySelectorAll('.subscribe-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var paymentTerm = this.getAttribute('data-payment-term');
                var paymentTermSelect = document.getElementById('paymentTerm');
                var amountInput = document.getElementById('amount');

                // Set the selected payment term in the dropdown
                if (paymentTermSelect) {
                    paymentTermSelect.value = paymentTerm;
                }

                // Set the appropriate amount based on the payment term
                if (amountInput) {
                    if (paymentTerm === 'monthly') {
                        amountInput.value = '100';
                    } else if (paymentTerm === 'quarterly') {
                        amountInput.value = '300';
                    } else if (paymentTerm === 'yearly') {
                        amountInput.value = '1200';
                    }
                }
                

                // Open the payment modal
                var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            });
            $('#paymentMethod').change(function () {
            var paymentMethod = $(this).val();
            var gcashLogoContainer = $('#gcashlogoContainer');
            var imageUploadContainer = $('#imageUploadContainer');

            if (paymentMethod === 'gcash') {
                gcashLogoContainer.show();
                imageUploadContainer.show();
            } else {
                gcashLogoContainer.hide();
                imageUploadContainer.hide();
            }
        });
        });
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
            var gcashLogoContainer = $('#gcashlogoContainer');
            var imageUploadContainer = $('#imageUploadContainer');

            if (paymentMethod === 'gcash') {
                gcashLogoContainer.show();
                imageUploadContainer.show();
            } else {
                gcashLogoContainer.hide();
                imageUploadContainer.hide();
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
