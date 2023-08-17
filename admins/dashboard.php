<?php
require('../configs/config.php');
include('sidebarcontent.php')
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
  <!-- Bootstrap JS (required dependencies) -->


  <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
  <link rel="stylesheet" href="side.css">

  <title>Dashboard</title>
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
  <?php
// Query to count the total number of rows
$sql = "SELECT COUNT(*) AS total FROM residents";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$totalRows = $row['total'];
// Count the number of males
$sqlMale = "SELECT COUNT(*) AS maleCount FROM residents WHERE gender = 'Male'";
$resultMale = mysqli_query($conn, $sqlMale);
$rowMale = mysqli_fetch_assoc($resultMale);
$maleCount = $rowMale['maleCount'];

// Count the number of females
$sqlFemale = "SELECT COUNT(*) AS femaleCount FROM residents WHERE gender = 'Female'";
$resultFemale = mysqli_query($conn, $sqlFemale);
$rowFemale = mysqli_fetch_assoc($resultFemale);
$femaleCount = $rowFemale['femaleCount'];

?>

<!-- HTML structure to display population counts in separate cards -->
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Male Count</h5>
        <h6 class="card-subtitle mb-2 text-muted">Total Males</h6>
        <p class="card-text"><?php echo $maleCount; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Female Count</h5>
        <h6 class="card-subtitle mb-2 text-muted">Total Females</h6>
        <p class="card-text"><?php echo $femaleCount; ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Total Population</h5>
        <h6 class="card-subtitle mb-2 text-muted">Population Count</h6>

        <p class="card-text"><?php echo $totalRows; ?></p>
      </div>
    </div>
  </div>
</div>






</div>
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