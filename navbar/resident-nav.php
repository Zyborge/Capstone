<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garden Villas III Phase 5</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/resident-nav.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <style>
    .navbar-custom {
      background-color: #5869bd;
      color: white;
      display: flex;
      align-items: center;
      align-content: center;
    }

    .navbar-custom .navbar-brand {
      font-size: medium;
      color: white;
      align-self: center;
      margin-top: 23px;
      margin-left: auto;
      margin-right: auto;
    }

    .navbar-custom .navbar-nav .nav-link {
      color: white;
      transition: color 0.3s;
      font-size: medium;
      padding: 30px;
    }

    .navbar-custom .navbar-nav .nav-link:hover,
    .navbar-custom .navbar-nav .nav-link.active {
      color: #994A80;
    }

    .navbar-custom .navbar-toggler-icon {
      background-color: white;
    }

    /* Adjustments for mobile view */
    @media (max-width: 767px) {
      .navbar-custom .navbar-nav {
        background-color: #29377E;
        padding-top: 10px;
      }

      .navbar-custom .navbar-nav .nav-item {
        margin-bottom: 10px;
      }

      .navbar-custom .navbar-nav .nav-link {
        color: white;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <div class="logo">
        <img src="../backgrounds/phase5.png" alt="Logo" style="width: 60px; height: 60px;">
      </div>
      <a class="navbar-brand text-center" href="#">
        Garden Villas III Phase 5
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="home.php">Home</a>
          </li>
         
        </ul>
        <ul class="navbar-nav ml-auto">
        <?php
  // Start the session

  // Check if the user is logged in
  if (isset($_SESSION['user_id'])) {
    // User is logged in, display logout link and notification bell icon
    echo '
    <li class="nav-item">
      <a class="nav-link" href="../resident/booking.php"><i class="bx bx-calendar"></i> Booking</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pay-monthlydues.php"><i class="bx bx-money"></i> Pay Monthly Due</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../php/logout.php"><i class="bx bx-log-out"></i> Logout</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="bx bx-bell"></i></a>
    </li>';
  } else {
    // User is not logged in, display login link
    echo '
    <li class="nav-item">
      <a class="nav-link" href="../resident-side/schedule/calendar.php"><i class="bx bx-calendar"></i> Calendar</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="login.php"><i class="bx bx-log-in"></i> Login</a>
    </li>';
  }
?>

        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      // Get the current page URL
      var currentUrl = window.location.href;

      // Find all navigation links
      var navLinks = $('.navbar-nav .nav-link');

      // Iterate over each navigation link
      navLinks.each(function() {
        // Get the link URL
        var linkUrl = $(this).attr('href');

        // Check if the link URL matches the current page URL
        if (currentUrl.indexOf(linkUrl) !== -1) {
          // Add the "active" class to the matching navigation link
          $(this).addClass('active');
        }
      });
    });
  </script>
</body>
</html>
