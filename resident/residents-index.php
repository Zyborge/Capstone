<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home</title>

  <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/carousel/">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="assets/css/home.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/img/phase5.png" alt="Your Brand Image" style="width: 50px; height: 50px;">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link js-scroll-trigger" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="bd-placeholder-img" src="assets/img/Rect Light.svg" alt="Your Image Description">


          <div class="container">
            <div class="carousel-caption text-left">
              <h1>Example headline.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
                metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="bd-placeholder-img" src="assets/img/Colored Shapes.svg" alt="Your Image Description">


          <div class="container">
            <div class="carousel-caption">
              <h1>Another example headline.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
                metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="bd-placeholder-img" src="assets/img/Moon.svg" alt="Your Image Description">


          <div class="container">
            <div class="carousel-caption text-right">
              <h1>One more for good measure.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
                metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="container marketing">
      <div class="h1">Announcement</div>
  <!-- Announcement Container with Horizontal Scrolling -->
  <div class="announcement-container">
    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gardenvillas_db";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve announcements
    $sql = "SELECT * FROM announcements";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
    ?>
<div class="announcement-card">
  <div class="text-center"> <!-- Center the image and text -->
    <img src="assets/img/phase5.png" alt="HOA Announcement" class="bd-placeholder-img rounded-circle announcement-image">
  </div>
  <h2 class="text-center"><?php echo $row["title"]; ?></h2>
  <div class="announcement-content text-center">
    <?php
    $content = $row["content"];
    if (strlen($content) > 100) {
      // If content is longer than 100 characters, truncate it and display "Read More" button
      $truncated_content = substr($content, 0, 100);
      echo '<p class="initial-content">' . $truncated_content . '...</p>';
      echo '<span class="read-more-btn-container"><a class="read-more btn btn-secondary" role="button">Read More</a></span>';
    } else {
      // If content is shorter, display it without truncation and hide "Read More" button
      echo '<p class="initial-content">' . $content . '</p>';
    }
    ?>
    <p class="full-content" style="display: none;"><?php echo $content; ?></p>
    <p class="show-less btn btn-secondary" role="button" style="display: none;">Show Less &laquo;</p>
  </div>
</div>
    <?php
        }
    } else {
        echo "No announcements found.";
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>
</div>


<?php
// Connect to your database (replace with your database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define a SQL query to fetch event data from the database
$sql = "SELECT * FROM events";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 0; // Initialize a counter variable
    
    // Loop through the database results and generate HTML for each event
    while ($row = $result->fetch_assoc()) {
        $counter++; // Increment the counter on each iteration
        
        // Determine whether to alternate the layout based on the counter
        $textOnLeft = ($counter % 2 === 0); // Use even/odd check
        
        // Start the container and set the appropriate CSS class
        echo '<div class="container marketing">';
        
        // Start the featurette and set the appropriate CSS classes
        echo '<hr class="featurette-divider">';
        echo '<div class="row featurette animate-text">';
        echo '<div class="col-md-7' . ($textOnLeft ? '' : ' order-md-2') . '">'; // Add order class for text
        echo '<h2 class="featurette-heading">' . $row['title'] . ' <span class="text-muted">- ' . '</span></h2>';
        echo '<p class="lead">' . $row['content'] . '</p>';
        echo '</div>';
        echo '<div class="col-md-5' . ($textOnLeft ? ' order-md-1' : '') . ' animate-image">'; // Add order class for image
        echo '<img src="assets/img/3.jpg" alt="' . $row['title'] . '" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">';
        echo '</div>';
        echo '</div>';
        
        // End the featurette
       
        
        // End the container
        echo '</div>';
    }
} else {
    echo "No events found in the database.";
}

// Close the database connection
$conn->close();
?>

    <!-- FOOTER -->
    <?php 
    include('footer.php');
    ?>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
    crossorigin="anonymous"></script>

  <!-- Smooth Scrolling JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha384-KyZXEAg3QhqLMpG8r+J4DgM5Z1s5O5wK5b5g5CQh7f7j4C4Ck4M5M5e5I5e5U5S5f5w"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  
  

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $(".read-more").click(function() {
      var announcementContent = $(this).closest(".announcement-content");
      announcementContent.find(".initial-content").hide();
      announcementContent.find(".full-content").show();
      announcementContent.find(".read-more").hide();
      announcementContent.find(".show-less").show();
    });

    $(".show-less").click(function() {
      var announcementContent = $(this).closest(".announcement-content");
      announcementContent.find(".initial-content").show();
      announcementContent.find(".full-content").hide();
      announcementContent.find(".read-more").show();
      announcementContent.find(".show-less").hide();
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Smooth scrolling for navigation links
    $(".js-scroll-trigger").click(function() {
      var target = $(this).attr("data-scroll");
      var offset = $(target).offset().top;
      
      // Animate the scroll
      $("html, body").animate(
        {
          scrollTop: offset
        },
        800, // Scroll duration in milliseconds
        "easeInOutExpo" // Easing function from the jquery.easing library
      );
    });
  });
</script>

</body>

</html>
