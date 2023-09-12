
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/resident-register.css"> <!-- Update the path to register.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-XdUN+9StkO8Zo53pDQjNjeNZ3/d6PHin+1TQb4hIYIf/dtL4VRlJyEScFyRQeWhccroAY4RJZOWzKozC2u3qqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/css/bootstrap-icons.min.css">

    <title>Resident Registration</title>
</head>
<body>
    <div class="container-1"></div>
    <div class="container-2"></div>

    <div class="container">
    <p class="welcome-text">Sign Up</p>

    <form class="registration-form" id="registration-form" method="POST" action="../php/register-process.php" novalidate>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" class="form-control" name="name" maxlenght="250" required>
            <div class="invalid-feedback" data-toggle="tooltip" data-placement="right" title=""></div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" name="email" required>
            <div class="invalid-feedback" data-toggle="tooltip" data-placement="right" title=""></div>
        </div>

        <div class="form-group">
    <label for="password">Password</label>
    <div class="password-input-wrapper">
        <input type="password" id="password" class="form-control" name="password" maxlength="255" required>
        <i id="toggleIcon" class="toggle-icon fas fa-eye" onclick="togglePasswordVisibility()"></i>
    </div>
    <div class="invalid-feedback" data-toggle="tooltip" data-placement="right" title=""></div>
    <div id="password-strength"></div>
</div>

<div class="form-group">
    <label for="confirmPassword">Confirm Password</label>
    <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" maxlength="255" required>
    <div id="password-error" style="color: red;"></div>
</div>



        <div class="form-group">
            <label for="ownership_type" class="form-label">House Ownership Type</label>
            <select class="form-select" id="ownership_type" name="ownership_type" required>
                <option value="" selected disabled>Select ownership type</option>
                <option value="owner">Owner</option>
                <option value="renter">Renter</option>
            </select>
        </div>
        <div class="form-group">
    <div class="row mt-3">
    <div class="col-md-3 mb-1">
            <label for="block">Block</label>
            <input type="text" id="block" class="form-control" name="block" maxlength="2" required>
        </div>
        <div class="col-md-3 mb-1">
            <label for="lot">Lot</label>
            <input type="text" id="lot" class="form-control" name="lot" maxlength="2" required>
        </div>
        <div class="col-md-3 mb-1">
            <label for="street">Street</label>
            <select id="street" class="form-control" name="street" required>
                <?PHP 
                include('../crud/street.php')
                ?>
            </select>
        </div>
    </div>
</div>

        <button type="submit" class="btn btn-primary" name="register">Register</button>
        <p class="text-center">Already have an account? <a href="resident-login.php">Login Here</a></p>
    </form>
</div>


<!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Add Bootstrap 5 library -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>$(document).ready(function() {
    // Handle form submission
    $('#register-btn').click(function() {
        // Disable the button to prevent multiple submissions
        $(this).prop('disabled', true);

        // Clear previous error messages
        $('.invalid-feedback').empty().hide();
        if (!checkPasswordMatch()) {
            // Enable the button
            $('#register-btn').prop('disabled', false);
            return; // Don't proceed with form submission
        }
        // Get form data
        var formData = $('#registration-form').serialize();

        // Send AJAX request
        $.ajax({
            url: '../php/register-process.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Enable the button
                $('#register-btn').prop('disabled', false);

                if (response.status === 'success') {
                    // Registration successful
                    alert(response.message);
                    // Redirect to verification page or any other desired action
                } else if (response.status === 'error') {
                    // Registration error
                    alert(response.message);
                    // Display error messages next to the corresponding form fields
                    $.each(response.errors, function(fieldName, errorMessage) {
                        $('#' + fieldName).next('.invalid-feedback').text(errorMessage).show();
                    });
                }
            },
            error: function() {
                // Enable the button
                $('#register-btn').prop('disabled', false);
                // Display a generic error message
                alert('An error occurred during registration. Please try again.');
            }
        });
    });
});
</script>
<script>
    // Function to check if the password and confirm password fields match
    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        var errorDiv = document.getElementById("password-error");

        if (password !== confirmPassword) {
            errorDiv.innerHTML = "Password and Confirm Password do not match!";
            errorDiv.style.color = "red";
            return false; // Return false to prevent form submission
        } else {
            errorDiv.innerHTML = ""; // Clear any previous error message
            return true; // Passwords match, allow form submission
        }
    }

    // Add an event listener to the confirm password field to check for match
    document.getElementById("confirmPassword").addEventListener("keyup", checkPasswordMatch);
</script>






<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
<script>
    $(document).ready(function() {
        // Handle form submission
        $('#registration-form').submit(function(event) {
            // Clear previous error messages
            $('.invalid-feedback').empty().hide();

            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });

        function validateForm() {
            var valid = true;

            // Validate Name
            var name = $('#name').val().trim();
            if (name.length <= 5) {
                $('#name').addClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('Name must be more than 5 characters.');
                valid = false;
            }

            // Validate Email
            var email = $('#email').val().trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                $('#email').siblings('.invalid-feedback').text('Please enter a valid email address.');
                valid = false;
            }

            // Validate Password
            var password = $('#password').val().trim();
            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            if (!passwordRegex.test(password)) {
                $('#password').addClass('is-invalid');
                $('#password').siblings('.invalid-feedback').text('Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.');
                valid = false;
            }

            // Validate Confirm Password
            var confirmPassword = $('#confirmPassword').val().trim();
            if (password !== confirmPassword) {
                $('#confirmPassword').addClass('is-invalid');
                $('#password').addClass('is-invalid');
                $('#password').siblings('.invalid-feedback').text('Password and Confirm Password do not match.');
                valid = false;
            }

            // You can add more validations for other fields as needed

            return valid;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function() {
        $('#name').on('input', function() {
            var inputValue = $(this).val();
            var sanitizedValue = sanitizeInput(inputValue);
            $(this).val(sanitizedValue);
            validateNameLength(sanitizedValue);
        });

        function sanitizeInput(input) {
            // Remove non-alphabetic characters except spaces using regular expression
            var sanitizedInput = input.replace(/[^a-zA-Z\s]/g, '');
            return sanitizedInput;
        }

        function validateNameLength(name) {
            if (name.trim().length <= 5) {
                $('#name').addClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('Name must be more than 5 characters.');
            } else {
                $('#name').removeClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('');
            }
        }
        
        $('#name').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#name').removeClass('is-invalid');
                $('#name').siblings('.invalid-feedback').text('');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#email').on('input', function() {
            var inputValue = $(this).val();
            validateEmail(inputValue);
        });

        function validateEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                $('#email').siblings('.invalid-feedback').text('Please enter a valid email address.');
            } else {
                $('#email').removeClass('is-invalid');
                $('#email').siblings('.invalid-feedback').text('');
            }
        }
        
        $('#email').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#email').removeClass('is-invalid');
                $('#email').siblings('.invalid-feedback').text('');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#username').on('input', function() {
            var inputValue = $(this).val();
            validateUsernameLength(inputValue);
        });

        function validateUsernameLength(username) {
            if (username.length <= 5) {
                $('#username').addClass('is-invalid');
                $('#username').siblings('.invalid-feedback').text('Username must be more than 5 characters.');
            } else {
                $('#username').removeClass('is-invalid');
                $('#username').siblings('.invalid-feedback').text('');
            }
        }
        
        $('#username').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#username').removeClass('is-invalid');
                $('#username').siblings('.invalid-feedback').text('');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#password').on('input', function() {
            var inputValue = $(this).val();
            validatePassword(inputValue);
            updatePasswordStrength(inputValue);
        });

        function validatePassword(password) {
            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

            if (!passwordRegex.test(password)) {
                $('#password').addClass('is-invalid');
                $('#password').siblings('.invalid-feedback').text('Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.');
                $('#password').siblings('.invalid-feedback').attr('data-bs-toggle', 'tooltip');
                $('#password').siblings('.invalid-feedback').attr('data-bs-placement', 'top');
                $('#password').siblings('.invalid-feedback').attr('title', 'Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.');
            } else {
                $('#password').removeClass('is-invalid');
                $('#password').siblings('.invalid-feedback').text('');
                $('#password').siblings('.invalid-feedback').removeAttr('data-bs-toggle');
                $('#password').siblings('.invalid-feedback').removeAttr('data-bs-placement');
                $('#password').siblings('.invalid-feedback').removeAttr('title');
            }
        }

        function updatePasswordStrength(password) {
            var strengthText = '';
            var strengthClass = '';

            if (password.length < 8) {
                strengthText = 'Weak';
                strengthClass = 'weak';
            } else if (password.length < 12) {
                strengthText = 'Medium';
                strengthClass = 'medium';
            } else {
                strengthText = 'Strong';
                strengthClass = 'strong';
            }

            if (password.trim() === '') {
                $('#password-strength').text('');
                $('#password-strength').attr('class', 'password-strength');
            } else {
                $('#password-strength').text('Password Strength: ' + strengthText);
                $('#password-strength').attr('class', 'password-strength ' + strengthClass);
            }
        }

        $('#password').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#password').removeClass('is-invalid');
                $('#password').siblings('.invalid-feedback').text('');
                $('#password').siblings('.invalid-feedback').removeAttr('data-bs-toggle');
                $('#password').siblings('.invalid-feedback').removeAttr('data-bs-placement');
                $('#password').siblings('.invalid-feedback').removeAttr('title');
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#phone').on('input', function() {
            var inputValue = $(this).val();
            validatePhoneNumber(inputValue);
        });

        function validatePhoneNumber(phone) {
            var phoneRegex = /^\d{10}$/;

            if (!phoneRegex.test(phone)) {
                $('#phone').addClass('is-invalid');
                $('#phone').siblings('.invalid-feedback').text('Please enter a valid 10-digit phone number.');
            } else {
                $('#phone').removeClass('is-invalid');
                $('#phone').siblings('.invalid-feedback').text('');
            }
        }
        
        $('#phone').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#phone').removeClass('is-invalid');
                $('#phone').siblings('.invalid-feedback').text('');
            }
        });
    });
</script>
