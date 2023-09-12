<?php
$host = 'localhost'; // Replace with your MySQL host
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'crud'; // Replace with your MySQL database name

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
?>
