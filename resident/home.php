<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gardenvillas Homeowners Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    
    <link rel="stylesheet" href="../css/resident-home.css">
    <style>
 :root {
  --main-color: #4CAF50; /* Main shade of green */
  --light-color: #8BC34A; /* Lighter shade of green */
  --dark-color: #388E3C; /* Darker shade of green */
  --accent-color: #CDDC39; /* Accent color */
  --texter-color: #FFFFFF; /* text color */

}

        .card-img-top {
            width: 100%;
            height: 200px; /* Adjust the desired height */
            object-fit: contain;
        }
        .jumbotron-style {
        background-color: transparent !important; /* Adjust the transparency as needed */
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .jumbotron-style h1 {
        color: var(--texter-color) !important;
        font-size: 40px !important;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .jumbotron-style .lead {
        color: var(--texter-color)!important;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
   

        .card-title {
            font-size: 2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 15px;
            color: black;
        }
        .owl-carousel .item img {
    width: 100%;
    height: 250px;
  }
  .owl-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    font-size: 50px;
    color:#4CAF50;

  }
  
  .owl-prev,
  .owl-next {
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .owl-prev {
    margin-left: 10px;
  }
  
  .owl-next {
    margin-right: 10px;
  }
  
    </style>
</head>
<body>
    <?php include('../navbar/nav.php'); ?>
    <div class="owl-carousel" id="myCarousel">
  <?php
  // Directory path
  $directory = '../admin/uploads/';
  
  // Fetch all files from the directory
  $files = scandir($directory);
  
  // Remove "." and ".." from the file list
  $files = array_diff($files, array('.', '..'));
  
  // Sort the files by modified time (most recent first)
  arsort($files);
  
  // Select the first 10 files
  $recentFiles = array_slice($files, 0, 10);
  
  // Loop through the recent files and generate HTML for each image
  foreach ($recentFiles as $file) {
    // Display only image files
    if (is_file($directory . $file) && getimagesize($directory . $file)) {
      echo '<div class="item">';
      echo '<img src="' . $directory . $file . '" alt="' . $file . '">';
      echo '</div>';
    }
  }
  ?>
</div>





    <div class="container">
    <div class="jumbotron jumbotron-style">
    <h1 class="display-4">Welcome to Gardenvillas Homeowners Website</h1>
    <p class="lead">Explore the latest news, events, and community updates.</p>
</div>

<?php
// Assuming you have the necessary database connection details
$host = 'localhost';
$dbname = 'gardenvillas_db';
$username = 'root';
$password = '';

// Create a new PDO instance
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection error: " . $e->getMessage();
    exit;
}

// Fetch announcements from the database
try {
    $query = "SELECT * FROM announcements";
    $stmt = $db->query($query);
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching announcements: " . $e->getMessage();
    exit;
}
?>

<!-- HTML code -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Announcements</h3>
            </div>
            <div class="card-body">
                <?php
                // Loop through the $announcements array to display each announcement
                foreach ($announcements as $announcement) {
                    $title = $announcement['title'];
                    $content = $announcement['content'];
                ?>
                    <div class="card mb-3">
                        <img src="../backgrounds/phase5.png" class="card-img-top" alt="Announcement">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text"><?php echo $content; ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php
// Assuming you have the necessary database connection details
$host = 'localhost';
$dbname = 'gardenvillas_db';
$username = 'root';
$password = '';

// Create a new PDO instance
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection error: " . $e->getMessage();
    exit;
}

// Fetch events from the database
try {
    $query = "SELECT * FROM events";
    $stmt = $db->query($query);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching events: " . $e->getMessage();
    exit;
}
?>

<!-- HTML code -->
<div class="col-md-6">
    <div class="card">
    <div class="card-header text-center">
            <h3 class="card-title">Events</h3>
        </div>
        <div class="card-body">
            <?php
            // Loop through the $events array to display each event
            foreach ($events as $event) {
                $title = $event['title'];
                $content = $event['content'];
            ?>
                <div class="card mb-3">
                    <img src="../backgrounds/phase5.png" class="card-img-top" alt="Event">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text"><?php echo $content; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
  $(document).ready(function() {
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 0,
      nav: true,
      dots: false,
      autoplay: true, // Enable autoplay
      autoplayTimeout: 3000, // Set autoplay timeout in milliseconds
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    });
  });
</script>


</body>
</html>
