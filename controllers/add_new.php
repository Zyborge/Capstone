<?php
include "db_conn.php";

if (isset($_POST['submit'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];

    // Check if resident already exists
    $query = "SELECT * FROM residents WHERE lastname = ? AND firstname = ? AND middlename = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$lastname, $firstname, $middlename]);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        echo "Resident already exists.";
    } else {
        $gender = $_POST['gender'];
        $phase = $_POST['phase'];
        $block = $_POST['block'];
        $lot = $_POST['lot'];
        $street = $_POST['street'];
        $birthdate = $_POST['birthdate'];
        $age = $_POST['age'];
        $contactnumber = $_POST['contactnumber'];
        $maritalstatus = $_POST['maritalstatus'];
        $citizenship = $_POST['citizenship'];

        $query = "INSERT INTO residents (lastname, firstname, middlename, gender, phase, block, lot, street, birthdate, age, contactnumber, maritalstatus, citizenship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$lastname, $firstname, $middlename, $gender, $phase, $block, $lot, $street, $birthdate, $age, $contactnumber, $maritalstatus, $citizenship]);

        if ($stmt->rowCount() > 0) {
            header("Location:../try-for-side/residents.php");
            exit;
        } else {
            echo "Failed: " . $stmt->errorInfo()[2];
        }
    }
}
?>
