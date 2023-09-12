<?php 
include('../admins/sidebarcontent.php');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Map</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="mapping.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link rel="stylesheet" href="./boxicons/css/boxicons.css">
  <link rel="stylesheet" href="../admins/side.css">

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
    <div class="container mt-5">
<div id="housesModal" style="display: none;">
  <button id='closeModal'><i class='bx bx-x'></i></button>
  <h2>Resident Details</h2>
  <div id="residentDetails"></div>
</div>

  <div class='header'>
    <h1><i class='bx bx-map-alt'></i>Map</h1>
  </div>
  <div id='mainContainer'>
    <div id="map"></div>

    <div id='btnContainer'>
        <div id='searchContainer'>
          <div id='searchbar'>
            <i class='bx bx-search'></i>
            <input type='text' id='searchinput' name='search'>
          </div>
          <button id='filterBtn'><i class='bx bx-filter-alt' ></i></button>
        </div>
        <div id='header'><i id='headerIcon' class='bx bx-show-alt'></i><span id="headerText">Viewing map....</span></div>

        <button id='editMapBtn'><i class='bx bx-edit'></i>Edit Map</button>
          <button id='addTextBtn' style="display: none;"><i class='bx bx-text' ></i>Add Text</button>
            <div id='textHeader' style='display:none;'>Enter text<span class='asterisk'>*</span></div>
            <input type="text" id="inputText" placeholder="Enter text" style='display:none;'>
            <button id='placeText' style='display: none;'>Place Text</button>
            <button id='cancelText' style='display:none;'>Cancel Text</button>
            <button id='saveText' style='display:none;'>Save Text</button>
          <button id="addShapeBtn" style="display: none;"><i class='bx bx-shape-square' ></i>Add Custom Shape</button>
            <div id='streetHeader' style='display:none;'>Select street for this area<span class='asterisk'>*</span></div>
            <select id="streetDropdown" style='display:none;'><br>
            </select>

            <button id="saveBtn" style="display: none;"><i class='bx bx-save' ></i>Save Shape</button>
            <button id="cancelBtn" style="display: none;"><i class='bx bx-left-arrow-alt'></i>Cancel</button>

          <button id='saveEditBtn' style="display: none;"><i class='bx bx-check' ></i>Save Edit</button>
          <button id='cancelEditBtn' style="display: none;"><i class='bx bx-x'></i>Cancel Edit</button>

        <!--<ul>
          <li id='editMapBtn'>Edit Map</li><br>
          <ul>
            <li id='addTextBtn' style="display: none;">Add Text</li><br>
            <li id="addShapeBtn" style="display: none;">Add Custom Shape</li><br>
            <ul>
              <li id="saveBtn" style="display: none;">Save Shape</li><br>
              <li id="cancelBtn" style="display: none;">Cancel</li><br>
            </ul>
          <li id='saveEditBtn' style="display: none;">Save Edit</li><br>
          <li id='cancelEditBtn' style="display: none;">Cancel Edit</li><br>
        </ul>-->
    </div>
  </div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script type="text/javascript" src='leaflet.mask.js'></script>
  <script>
  
  // Map Creation
  // Define Map maximum viewing area
  var southwest = L.latLng(14.30039, 121.11747); // Define the southwest corner
  var northeast = L.latLng(14.3154, 121.1242); // Define the northeast corner
  var bounds = L.latLngBounds(southwest, northeast); // Create a LatLngBounds object

  //Initialize map
  var map = L.map('map', {
    maxBounds: bounds, // Set the maxBounds option to restrict map panning
    maxBoundsViscosity: 1.0,
    maxZoom:18,
    minZoom: 17 // Adjust the behavior of dragging the map within bounds
  }).setView([14.30536, 121.12233], 18); // Use the obtained latitude and longitude

  //Initialize map tile and style
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  // Highlight ph5 region
  L.mask('coordinates.json', {fillOpacity: 0.7,}).addTo(map);
  

</script>
<script type="text/javascript" src='mapping.js'></script>
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
