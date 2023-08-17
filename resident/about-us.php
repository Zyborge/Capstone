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
.container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two equal-width columns */
    grid-gap: 20px; /* Add some space between the columns */
    margin: 20px; /* Add margin around the container */
}

/* Style for the rows */
.row {
    display: flex;
}

/* Style for the left and right parts */
.left,
.right {
    flex: 1; /* Each part takes equal space within the row */
}

/* Style for the images */
.row img {
    width: 600px; /* Make the images fill the available width in their containers */
    height: auto; /* Auto adjust the height to maintain the aspect ratio */
    border: 2px solid #ccc; /* Add a border to the images */
    border-radius: 10px; /* Add some border radius for a rounded effect */
}
.left{
    margin-top: 50px;
}
.right{
    margin-top: 200px;
}
@media (max-width: 768px) {
    .container {
        grid-template-columns: 1fr; /* Single column */
    }
}

/* For even smaller screens, adjust the image width */
@media (max-width: 576px) {
    .row img {
        width: 100%; /* Full width for images */
    }
    .left,
    .right {
        margin-top: 0px;
    }
    
}






        </style>
</head>
<body>
    <?php include('../navbar/nav.php'); ?>
   

    <div class="container">
    <div class="row">
        <div class="left">
            <img src="../png/3.png" alt="Image 1">
        </div>
    </div>
    <div class="row">
        <div class="right">
            <img src="../png/4.png" alt="Image 2">
        </div>
    </div>
</div>


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   


</body>
</html>
