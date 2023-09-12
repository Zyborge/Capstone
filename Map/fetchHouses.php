<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardenvillas_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['shapeId'])) {
    // Get the shapeId from the POST data
    $shapeId = $_POST['shapeId'];

    // Query the database to fetch data based on the shapeId
    $sql = "SELECT * FROM residents WHERE street='$shapeId'";
    $result = $conn->query($sql);

    $responseData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
       
            $responseData[] = array(
                'lastname' => $row["lastname"],
                'block' => $row["block"],
                'lot' => $row["lot"],
                'resident_id' => $row["id"]
            );
        }
    }
    
    // Send the data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    // If shapeId is not received, return an error response
    $responseData = array('error' => 'shapeId not provided');
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json');
    echo json_encode($responseData);
}


// Close the database connection
$conn->close();
?>
