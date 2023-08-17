<?php
include "db_conn.php";


if (isset($_POST['submit'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $phase = $_POST['phase'];
    $block = $_POST['block'];
    $lot = $_POST['lot'];
    $gender = $_POST['gender'];
    $street = $_POST['street'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $contactnumber = $_POST['contactnumber'];
    $maritalstatus = $_POST['maritalstatus'];
    $citizenship = $_POST['citizenship'];

    $sql = "UPDATE residents SET 
    lastname=:lastname,
    firstname=:firstname,
    middlename=:middlename,
    phase=:phase,
    block=:block,
    lot=:lot,
    gender=:gender,
    street=:street,
    birthdate=:birthdate,
    age=:age,
    contactnumber=:contactnumber,
    maritalstatus=:maritalstatus,
    citizenship=:citizenship
    WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':middlename', $middlename);
    $stmt->bindParam(':phase', $phase);
    $stmt->bindParam(':block', $block);
    $stmt->bindParam(':lot', $lot);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':contactnumber', $contactnumber);
    $stmt->bindParam(':maritalstatus', $maritalstatus);
    $stmt->bindParam(':citizenship', $citizenship);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location:index.php?msg=Data Updated successfully");
        exit();
    } else {
        echo "Failed: " . $stmt->errorInfo()[2];
    }
}
?>
