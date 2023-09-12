<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/admin-login.css">
</head>
<body>
    <div class="container">
        <div class="back-icon">
            <a href="../resident/home.php"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="d-flex justify-content-center position-relative">
            <div class="circle">
                <img src="../backgrounds/phase5.png" alt="Image" class="img-circle">
            </div>
            <p class="welcome-text">Welcome Back!</p>
        </div>

        <form class="login-form" id="loginForm">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" maxlength="255" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group password-toggle" id="divpassword">
                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" maxlength="255" aria-describedby="basic-addon2">
                    <i class="fas fa-eye toggle-icon" id="toggleIcon" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
                <a href="#" class="forgot-password">Forgot Password</a>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <p class="register-text">Don't have an account? <a class="register-link" href="resident-register.php">Register Here</a></p>
        </form>
    </div>

    <div class="modal" id="errorMessageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errorMessagePopup"></div>
            </div>
        </div>
    </div>
</div>


    <script src="../js/admin-login.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Show the pop-up when an error occurs
        function showErrorMessage(message) {
            $('#errorMessagePopup').text(message);
            $('#errorMessageModal').modal('show');
        }

        // Handle the close event of the modal
        $('#errorMessageModal').on('hidden.bs.modal', function () {
            $('#errorMessagePopup').empty();
        });

   

        // AJAX request and form submission code
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            var email = $('#email').val();
            var password = $('#password').val();
            var rememberMe = $('#rememberMe').is(':checked');

            $.ajax({
                url: '../php/login-process.php',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        if (rememberMe) {
                            setCookie('email', email, 30); // Set cookie for 30 days
                            setCookie('password', password, 30);
                        } else {
                            deleteCookie('email');
                            deleteCookie('password');
                        }
                        window.location.href = 'home.php'; // Redirect to home page or any other authenticated page
                    } else {
                        showErrorMessage(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    showErrorMessage('An error occurred. Please try again.');
                }
            });
        });

        // Close the modal when the close button is clicked
        $('.btn-close').click(function() {
            $('#errorMessageModal').modal('hide');
        });

        // Function to set a cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        // Function to get the value of a cookie
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0)
                    return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Function to delete a cookie
        function deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }

        // Check if the "email" cookie exists and populate the field
        var emailCookie = getCookie('email');
        if (emailCookie) {
            $('#email').val(emailCookie);
        }

        // Check if the "password" cookie exists and populate the field
        var passwordCookie = getCookie('password');
        if (passwordCookie) {
            $('#password').val(passwordCookie);
        }
    });
</script>
</body>
</html>
