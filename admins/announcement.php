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
  <link rel="stylesheet" href="../css/admin-announcement.css">
  <!-- Bootstrap JS (required dependencies) -->


  <link rel="stylesheet" type="text/css" href="../dashboard.css">
  <link rel="stylesheet" href="side.css">

  <title>Annoucement</title>
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
<!-- Admin Panel -->
<section class="py-5">
  <div class="container" id="container">
    <form id="postForm" method="POST" class="needs-validation" novalidate>
      <div class="mb-3">
        <label class="form-label">Create</label>
        <div class="btn-group" role="group" aria-label="Post Type">
  <button type="button" class="btn btn-outline-danger post-type-btn" data-type="announcement" required>Announcement</button>
  <button type="button" class="btn btn-outline-danger post-type-btn" data-type="event" required>Community Event</button>
</div>

        <input type="hidden" id="selectedType" name="type">
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required style="width: 300px;">
        <div class="invalid-feedback">Please provide a title.</div>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" required style="height: 300px; resize:none;"></textarea>
        <div class="invalid-feedback">Please provide content.</div>
      </div>
    
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="responseMessage" class="mt-3" style="display: none;"></div>
  </div>
</section>


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
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
// Button click event handlers
const postTypeButtons = document.querySelectorAll(".post-type-btn");

postTypeButtons.forEach(function(button) {
  button.addEventListener("click", function() {
    // Remove "active" class from all buttons
    postTypeButtons.forEach(function(btn) {
      btn.classList.remove("active");
    });

    // Add "active" class to the clicked button
    this.classList.add("active");

    // Set the selected type value
    document.getElementById("selectedType").value = this.getAttribute("data-type");
  });
});

$(document).ready(function() {
  var form = $('#postForm');
  var responseMessage = $('#responseMessage');

  form.on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
    e.stopPropagation(); // Stop event propagation to prevent Bootstrap from validating the form

    if (!form.hasClass('was-validated')) {
      form.addClass('was-validated'); // Add Bootstrap's "was-validated" class to display validation errors
    }

    // Check if at least one button is selected
    var selectedButtons = form.find('.post-type-btn.active');
    if (selectedButtons.length === 0) {
      responseMessage.removeClass('text-success').addClass('text-danger');
      responseMessage.text('Please select a post type.');
      responseMessage.show();
      return; // Exit the function and do not proceed with form submission
    }

    if (form[0].checkValidity()) { // Check if the form inputs are valid according to HTML5 validation
      // Disable the submit button to prevent multiple submissions
      form.find('[type="submit"]').prop('disabled', true);

      var url = 'add-post.php'; // Specify the URL to handle the form submission

      $.ajax({
        type: 'POST',
        url: url,
        data: form.serialize(), // Serialize the form data
        success: function(response) {
          responseMessage.removeClass('text-danger').addClass('text-success');
          responseMessage.text('Post added successfully.');
          responseMessage.show();
          form[0].reset(); // Reset the form using the DOM form object
          form.removeClass('was-validated'); // Remove the "was-validated" class after successful submission
        },
        error: function(xhr, status, error) {
          responseMessage.removeClass('text-success').addClass('text-danger');
          responseMessage.text('Error: ' + error);
          responseMessage.show();
        },
        complete: function() {
          // Re-enable the submit button after AJAX request is complete
          form.find('[type="submit"]').prop('disabled', false);
        }
      });
    }
  });
});


</script>








  
</body>
</html>