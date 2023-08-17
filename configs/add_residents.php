<?php
// Create a connection to the database
$host = "localhost"; // Your host name
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "gardenvillas_db"; // Your database name
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the form input values
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$phase = $_POST['phase'];
$block = $_POST['block'];
$lot = $_POST['lot'];
$street = $_POST['street'];
$birthdate = $_POST['birthdate'];
$age = $_POST['age'];
$contactnumber = $_POST['contactnumber'];
$maritalstatus = $_POST['maritalstatus'];
$citizenship = $_POST['citizenship'];

// Insert the data into the database
$sql = "INSERT INTO residents (lastname, firstname, middlename, phase, block, lot, street, birthdate, age, contactnumber, maritalstatus, citizenship) VALUES ('$lastname', '$firstname', '$middlename', '$phase', '$block', '$lot', '$street', '$birthdate', '$age', '$contactnumber', '$maritalstatus', '$citizenship')";

if (mysqli_query($conn, $sql)) {
    echo "New resident record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
