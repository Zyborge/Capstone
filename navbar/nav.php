

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <title>Navbar</title>
</head>
<body>
        <header> 
            <a href="../resident/home.php"  class="logo"><img src="../backgrounds/phase5.png" alt="Logo" style="width: 60px;margin-right:10px; height: 60px;">
<span>Garden Villas III | Phase 5</span></a>
<ul class="navbar">
<?php
  // Check if the user is logged in
  if (isset($_SESSION['resident_id'])) {
    // User is logged in, display all navbar links
    echo '
      <li><a href="../resident/home.php" class="active">Home</a></li>
      <li><a href="../schedule/index.php">Calendar</a></li>
      <li class="nav-item dropdown" id="paymentDropdown">
  <a class="nav-link dropdown-toggle" href="../resident/pay-monthly.php" id="navbarDropdownMenuLink" role="button" aria-haspopup="true" aria-expanded="false">
    Payment
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
    <li><a class="dropdown-item" href="../resident/payment-history.php">Payment History</a></li>
  </ul>
  <li><a href="../resident/about-us.php"> About us</a></li>

</li>

    ';
  } else {
    // User is not logged in, display only the "Home" link
    echo '<li><a href="../resident/home.php" class="active"> Home</a></li>
    <li><a href="../schedule/public-calendar.php">Calendar</a></li>
    <li><a href="../resident/about-us.php"> About us</a></li>
    ';
  }
?>


</ul>
             <div class="main">
             <?php
            // Start the session

            // Check if the user is logged in
            if (isset($_SESSION['resident_id'])) {
              // User is logged in, display logout link and notification bell icon
              echo '
              <li class="nav-item">
                <a class="nav-link" href="../php/logout.php">Logout</a>
              </li>
            ';
            } else {
              // User is not logged in, display login link
              echo '
              
              <li class="nav-item">
                <a class="nav-link" href="../resident/resident-login.php">Login</a>
              </li>';
            }
          ?>
                <div class="fas fas-menu" id="menu-icon"><i class="fas fa-bars"></i>
</div>

            </div>
        </header>
        <div class="div"></div>

    <script src="../js/nav.js"></script>
</body>
</html>
