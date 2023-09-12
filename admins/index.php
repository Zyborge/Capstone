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
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Homeowners Association Portal</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Link to Boxicons CSS -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <style>
      /* POPPINS FONT */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

*{
    font-family: 'Poppins', sans-serif;
}
/* Modern Modal Styles */
.modal-content {
    border: none;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background-color: #007bff;
    color: #fff;
    border-radius: 10px 10px 0 0;
    padding: 15px;
    border: none;
}

.modal-title {
    font-size: 24px;
}

.modal-body {
    padding: 20px;
    background-color: #f7f7f7;
}

.modal-footer {
    border-radius: 0 0 10px 10px;
    border: none;
    padding: 15px;
    background-color: #f7f7f7;
}

.btn-close {
    color: #007bff;
    background-color: transparent;
    border: none;
    font-size: 1.5rem;
    position: absolute;
    top: 15px;
    right: 15px;
    cursor: pointer;
}

.btn-close:hover {
    color: #0056b3;
}

/* Additional Styles for Better Responsiveness */
@media (max-width: 768px) {
    .modal-dialog {
        max-width: 90%;
    }
    .modal-header, .modal-footer {
        border-radius: 10px;
    }
}

.wrapper{
    background: #ececec;
    padding: 0 20px 0 20px;
}
.main{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.side-image{
    background-image: url("images/2.jpg");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 10px 0 0 10px;
    position: relative;
}
.row{
  width:  900px;
  height:550px;
  border-radius: 10px;
  background: #fff;
  padding: 0px;
  box-shadow: 5px 5px 10px 1px rgba(0,0,0,0.2);
}
.text{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.text p{
    color: #fff;
    font-size: 20px; 
}
i{
    font-weight: 400;
    font-size: 15px;
}
.right{
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
.input-box{
  width: 330px;
  box-sizing: border-box;
}
img{
    width: 400px;
    height: 500px;
    object-fit: cover;
    position: absolute;
    top: 30px;
    left: 30px;
}
.input-box header{
    font-weight: 700;
    text-align: center;
    margin-bottom: 45px;
}
.input-field{
    display: flex;
    flex-direction: column;
    position: relative;
    padding: 0 10px 0 10px;
}
.input{
    height: 45px;
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    outline: none;
    margin-bottom: 20px;
    color: #40414a;
}
.input-box .input-field label{
    position: absolute;
    top: 10px;
    left: 10px;
    pointer-events: none;
    transition: .5s;
}
.input-field input:focus ~ label
   {
    top: -10px;
    font-size: 13px;
  }
  .input-field input:valid ~ label
  {
   top: -10px;
   font-size: 13px;
   color: #5d5076;
 }
 .input-field .input:focus, .input-field .input:valid{
    border-bottom: 1px solid #743ae1;
 }
 .submit{
    border: none;
    outline: none;
    height: 45px;
    background: #ececec;
    border-radius: 5px;
    transition: .4s;
 }
 .submit:hover{
    background: rgba(37, 95, 156, 0.937);
    color: #fff;
 }
 .signin{
    text-align: center;
    font-size: small;
    margin-top: 25px;
}
span a{
    text-decoration: none;
    font-weight: 700;
    color: #000;
    transition: .5s;
}
span a:hover{
    text-decoration: underline;
    color: #000;
}

@media only screen and (max-width: 768px){
    .right{
        margin-top:250px;
    }
    .side-image{
        border-radius: 10px 10px 0 0;
    }
    img{
        width: 250px;
        height: 200px;
        position: absolute;
        top: 20px;
    }
    .text{
        position: absolute;
        top: 70%;
        text-align: center;
        
    }
    .text p, i{
        font-size: 14px;
    }
    .row{
        max-width:420px;
        width: 100%;
        height: 650px;
    }
}
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">
                       
                <!-------------      image     ------------->
                
                <img src="../backgrounds/garden.png" alt="">
               
                
            </div>
            
            <div class="col-md-6 right">
            <form class="login-form" method="POST">
    <h3 class="fw-normal mb-3">Login</h3>
    <h4> Welcome to Garden Villas III , Phase 5 Standard Admin Portal</h4>
    <h8> Please Login to continue</h8>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
            <span class="input-group-text"><i class='bx bx-user'></i></span>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
    </div>
    <div class="login-button">
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </div>
</form>

                   
                </div>  
            </div>
        </div>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


        </section>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Login Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($error)): ?>
                    <!-- Display error message if $error is set -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php else: ?>
                    <!-- Display success message if authentication is successful -->
                    <p>You have successfully logged in.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>