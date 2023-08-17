<?php
session_start();

// Database connection parameters
$servername = "localhost";
$dbname = "gardenvillas_db";
$dbUsername = "root";
$dbPassword = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to authenticate user
function authenticateUser($username, $password)
{
    global $conn;
    $sql = "SELECT role FROM roles WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['role'];
    }

    return false;
}

// Check if form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user
    $userRole = authenticateUser($username, $password);

    if ($userRole) {
        // Store user role in session or cookies for subsequent requests
        $_SESSION['user_role'] = $userRole;

        // Redirect to home.php
        echo "<script>
        window.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 3000); // Redirect after 3 seconds
        });
        </script>";
    } else {
        // Authentication failed, show an error message
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Homeowners Association Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-image: url('../png/bg.jpg');
            background-size: cover;
            background-position: center;
        }

        .container {
            margin-top: 100px;
            width: auto;
        }

        .h-custom-2 {
            height: calc(100% - 6.5rem - 10px);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <section class="vh-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-black">
                        <div class="px-5 ms-xl-4">
                            <i class='bx bxs-building-house bx-lg'></i>
                            <span class="h2 fw-bold mb-0">Garden Villas III</span>
                        </div>
                        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                            <form class="w-100" method="POST">
                                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color:black; text-decoration:dotted;">Official Login</h3>
                                <div class="col-auto mb-3">
                                    <label class="visually-hidden" for="autoSizingInputGroup">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class='bx bx-user'></i></div>
                                        <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Username" name="username">
                                    </div>
                                </div>
                                <div class="col-auto mb-3">
                                    <label class="visually-hidden" for="autoSizingInputGroup">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class='bx bx-lock-alt'></i></div>
                                        <input type="password" class="form-control" id="autoSizingInputGroup" placeholder="Password" name="password">
                                    </div>
                                </div>
                                <div class="pt-1 mb-4">
                                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 px-0 d-none d-sm-block" style="background-image: url('../png/phase5.png'); background-size: cover; background-position: left; height: 500px"></div>
                </div>
            </div>
        </section>
        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Login Successful</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>You have successfully logged in.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
