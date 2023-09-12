var drawnItems = new L.FeatureGroup();
var recentlyCreatedShapes = new L.FeatureGroup();
var drawing = false;
var points = [];
var pointCircles = [];
var savedShapes = [];
var streetName;
var fetched = 0;

function enableDrawing() {
  drawing = true;
  points = [];
  document.getElementById('addShapeBtn').style.display = 'none';
  document.getElementById('addTextBtn').style.display = 'none';
  document.getElementById('saveBtn').style.display = 'flex';
  document.getElementById('cancelBtn').style.display = 'flex';
  document.getElementById('headerText').textContent = 'Drawing a shape...';
  document.getElementById('headerIcon').classList.replace('bx-edit', 'bx-shape-square');
  document.getElementById('streetHeader').style.display = 'flex';
  document.getElementById('streetDropdown').style.display = 'flex';
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';
  document.getElementById('cancelText').style.display = 'none';
  document.getElementById('saveText').style.display = 'none';
    // Perform an AJAX request to fetch street names
    if (fetched === 0) {
    $.ajax({
        url: 'fetchStreetName.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var streetDropdown = $('#streetDropdown');
            streetName = data;
            console.log(data);
            
            // Populate the dropdown with fetched street names
            $.each(data, function(index, value) {
                streetDropdown.append($('<option>', {
                    value: value,
                    text: value
                }));
            });
        fetched = 1;},
        error: function(xhr, status, error) {
            console.error('Failed to fetch street names:', error);
        }
    });
    }
}

function showButtonsForAddingShape() {
  document.getElementById('addTextBtn').style.display = 'flex';
  document.getElementById('addShapeBtn').style.display = 'flex';
  document.getElementById('editMapBtn').style.display = 'none';
  document.getElementById('saveEditBtn').style.display = 'flex';
  document.getElementById('cancelEditBtn').style.display = 'flex';
  
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';

  document.getElementById('headerText').textContent = 'Editing Map...';
  document.getElementById('headerIcon').classList.replace('bx-show-alt', 'bx-edit');
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';
  document.getElementById('cancelText').style.display = 'none';
  document.getElementById('saveText').style.display = 'none';
}

function saveShape(id) {
  var selectedStreet = document.getElementById('streetDropdown').value;
  
  // Check if the selected street is in the streetName array
  if (streetName.indexOf(selectedStreet) === -1) {
    alert('Invalid street name');
    return; // Don't proceed with saving the shape
  }

  if (points.length > 2) {
    var polygon = L.polygon(points, { color: 'blue' }).addTo(recentlyCreatedShapes);
    polygon.id = id;
    polygon.on('click', handleShapeClick);
    savedShapes.push({ id: id, points: points }); 
    map.addLayer(drawnItems);
    map.addLayer(recentlyCreatedShapes);
    points = [];
    drawing = false;
    document.getElementById('addTextBtn').style.display = 'flex';
    document.getElementById('addShapeBtn').style.display = 'flex';
    document.getElementById('editMapBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
    document.getElementById('streetHeader').style.display = 'none';
    document.getElementById('streetDropdown').style.display = 'none';
    pointCircles.forEach(function (circle) {
      map.removeLayer(circle);
    });
    pointCircles = [];
  } else {
    alert('Please add at least 3 points to create a shape.');
  }
}

function cancelDrawing() {
  points = [];
  drawing = false;
  document.getElementById('addShapeBtn').style.display = 'flex';
  document.getElementById('addTextBtn').style.display = 'flex';
  document.getElementById('saveBtn').style.display = 'none';
  document.getElementById('cancelBtn').style.display = 'none';
  document.getElementById('streetHeader').style.display = 'none';
  document.getElementById('streetDropdown').style.display = 'none';
  document.getElementById('headerText').textContent = 'Editing Map...';
  document.getElementById('headerIcon').classList.replace('bx-shape-square', 'bx-edit');
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';
  document.getElementById('cancelText').style.display = 'none';
  document.getElementById('saveText').style.display = 'none';
  pointCircles.forEach(function (circle) {
    map.removeLayer(circle);
  });
  pointCircles = [];
  recentlyCreatedShapes.clearLayers();
}

function saveEdit() {
  // Move shapes from recentlyCreatedShapes to drawnItems
  recentlyCreatedShapes.eachLayer(function (layer) {
    savedShapes.push(layer.getLatLngs());
    drawnItems.addLayer(layer);
  });

  // Prepare the shapes data to save to shapes.json
  const shapesData = JSON.stringify(savedShapes);

  // Save shapesData to shapes.json
  const blob = new Blob([shapesData], { type: 'application/json' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.style.display = 'none';
  a.href = url;
  a.download = 'shapes.json';
  document.body.appendChild(a);
  a.click();
  window.URL.revokeObjectURL(url);

  document.getElementById('addTextBtn').style.display = 'none';
  document.getElementById('addShapeBtn').style.display = 'none';
  document.getElementById('editMapBtn').style.display = 'flex';
  document.getElementById('saveEditBtn').style.display = 'none';
  document.getElementById('cancelEditBtn').style.display = 'none';
}

function cancelEdit() {
  // Reset the map and UI
  recentlyCreatedShapes.clearLayers(); // Remove recently created shapes
  document.getElementById('addTextBtn').style.display = 'none';
  document.getElementById('addShapeBtn').style.display = 'none';
  document.getElementById('editMapBtn').style.display = 'flex';
  document.getElementById('saveEditBtn').style.display = 'none';
  document.getElementById('cancelEditBtn').style.display = 'none';
  document.getElementById('headerText').textContent = 'Viewing Map....';
  document.getElementById('headerIcon').classList.replace('bx-edit', 'bx-show-alt');
  document.getElementById('streetHeader').style.display = 'none';
  document.getElementById('streetDropdown').style.display = 'none';
  document.getElementById('saveBtn').style.display = 'none';
  document.getElementById('cancelBtn').style.display = 'none';
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';
  document.getElementById('cancelText').style.display = 'none';
  document.getElementById('saveText').style.display = 'none';
}

map.on('click', function (e) {
  if (drawing) {
    points.push(e.latlng);
    var circle = L.circle(e.latlng, {
      color: 'red',
      fillColor: '#f03',
      fillOpacity: 0.5,
      radius: 5
    }).addTo(map);
    pointCircles.push(circle);
  }
});

// Function to handle shape click events
function handleShapeClick(event) {
  var clickedShape = event.target;
  var shapeId = clickedShape.id;

  // Send the shapeId to the PHP file using AJAX
  $.ajax({
    url: 'fetchHouses.php',
    method: 'POST',
    data: { shapeId: shapeId },
    success: function(response) {
      var modal = document.getElementById('housesModal');
      var residentDetailsContainer = document.getElementById('residentDetails');

      // Clear any previous resident details
      residentDetailsContainer.innerHTML = '';

      if (response.length > 0) {
        response.forEach(function(resident) {
          // Create a new div for each resident
          var residentDiv = document.createElement('div');
          residentDiv.className = 'resident';
          // Populate the resident div with data
          residentDiv.innerHTML = `
            <div class='residentHouses'><i class='bx bx-home'></i>
            <div>Resident: ${resident.lastname} </div><br>
            <div> Block: ${resident.block} </div>
            <div> Lot: ${resident.lot} </div>
            </div>
          `;
          
          // Append the resident div to the container
          residentDetailsContainer.appendChild(residentDiv);
        });

        modal.style.display = 'block';
        document.getElementById('closeModal').style.display ='flex';
      } else {
        alert('No residents found for this shape.');
      }
    },
    error: function(xhr, status, error) {
      console.error('Failed to send shapeId:', error);
    }
  });
}

// Iterate through the savedShapes array and add each shape to the map
savedShapes.forEach(function (shape) {
  var polygon = L.polygon(shape.points, { color: 'blue' }).addTo(recentlyCreatedShapes);
  // Add a click event listener to the shape
  polygon.on('click', handleShapeClick);
});

var addedText = null;

// Function to add text to the map
function enableAddingText() {
  document.getElementById('inputText').style.display = 'flex';
  document.getElementById('textHeader').style.display = 'flex';
  document.getElementById('placeText').style.display = 'flex';
  document.getElementById('cancelText').style.display = 'flex';
  document.getElementById('saveText').style.display = 'flex';
  document.getElementById('addShapeBtn').style.display = 'none';
  document.getElementById('addTextBtn').style.display = 'none';
  addedText = null;
}

function addTextToMap() {
  var text = document.getElementById('inputText').value;
  if (text) {
    var textMarker = L.marker(map.getCenter(), {
      icon: L.divIcon({
        className: 'custom-div-icon',
        html: '<div>' + text + '</div>',
        iconSize: [100, 40]
      }),
      draggable: true, // Make the marker draggable
    });

    textMarker.addTo(map);

    // Store the added text marker in the addedText variable
    addedText = textMarker;
  } else {
    alert('Please enter text in the input field.');
  }
}

function saveText() {
  if (addedText) {
    addedText.dragging.disable(); // Disable dragging to make it non-draggable
  }
}

function cancelText() {
  if (addedText) {
    addedText.dragging.disable(); // Disable dragging to make it non-draggable
    map.removeLayer(addedText);
  }
  textMarker = [];
  document.getElementById('inputText').style.display = 'none';
  document.getElementById('textHeader').style.display = 'none';
  document.getElementById('placeText').style.display = 'none';
  document.getElementById('cancelText').style.display = 'none';
  document.getElementById('saveText').style.display = 'none';
  document.getElementById('addShapeBtn').style.display = 'flex';
  document.getElementById('addTextBtn').style.display = 'flex';
}

// Add a click event listener to the "Add Text" button
document.getElementById('addTextBtn').addEventListener('click', enableAddingText);
document.getElementById('placeText').addEventListener('click', addTextToMap);
document.getElementById('saveText').addEventListener('click', saveText);
document.getElementById('cancelText').addEventListener('click', cancelText);


document.getElementById('addShapeBtn').addEventListener('click', enableDrawing);
document.getElementById('saveBtn').addEventListener('click', function () {
  var id = document.getElementById('streetDropdown').value;
  saveShape(id);
});
document.getElementById('cancelBtn').addEventListener('click', cancelDrawing);
document.getElementById('editMapBtn').addEventListener('click', showButtonsForAddingShape);
document.getElementById('saveEditBtn').addEventListener('click', saveEdit);
document.getElementById('cancelEditBtn').addEventListener('click', cancelEdit);
document.getElementById('closeModal').addEventListener('click', function(){
  document.getElementById('housesModal').style.display = 'none';
});
// Load shapes data from shapes.json when the page loads
function loadShapes() {
  fetch('shapes.json')
    .then((response) => response.json())
    .then((shapesData) => {
      // Create and add shapes to the map based on shapesData
      shapesData.forEach((shapeData) => {
        const polygon = L.polygon(shapeData.points, { color: 'blue' }).addTo(drawnItems);
        polygon.id = shapeData.id; // Set the ID from your JSON data
        polygon.on('click', handleShapeClick);
        savedShapes.push(shapeData); // Push the entire shapeData object if needed
        map.addLayer(drawnItems);
      });
      console.log('Shapes data loaded successfully.');
    })
    .catch((error) => {
      console.error('Failed to load shapes data:', error);
    });
}

// Call loadShapes() when the page loads
window.addEventListener('load', loadShapes);
