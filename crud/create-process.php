<?php

// Include the database connection file (db.php)
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define an array to store validation errors
    $errors = [];

    // Validate Last Name
    $lastnames = is_array($_POST['lastname']) ? $_POST['lastname'] : [$_POST['lastname']];
    foreach ($lastnames as $lastname) {
        if (empty($lastname)) {
            $errors[] = "Last Name is required.";
        } elseif (strlen($lastname) > 50) {
            $errors[] = "Last Name should not exceed 50 characters.";
        }
    }

    // Validate First Name
    $firstnames = is_array($_POST['firstname']) ? $_POST['firstname'] : [$_POST['firstname']];
    foreach ($firstnames as $firstname) {
        if (empty($firstname)) {
            $errors[] = "First Name is required.";
        } elseif (strlen($firstname) > 50) {
            $errors[] = "First Name should not exceed 50 characters.";
        }
    }

    // Validate Middle Name
    $middlenames = is_array($_POST['middlename']) ? $_POST['middlename'] : [$_POST['middlename']];
    foreach ($middlenames as $middlename) {
        if (empty($middlename)) {
            $errors[] = "Middle Name is required.";
        } elseif (strlen($middlename) > 50) {
            $errors[] = "Middle Name should not exceed 50 characters.";
        }
    }

    // Validate Birthdate
    $birthdates = is_array($_POST['birthdate']) ? $_POST['birthdate'] : [$_POST['birthdate']];
    foreach ($birthdates as $birthdate) {
        if (empty($birthdate)) {
            $errors[] = "Birthdate is required.";
        } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthdate)) {
            $errors[] = "Invalid birthdate format. Use YYYY-MM-DD.";
        }
    }

    // Validate Age
    $ages = is_array($_POST['age']) ? $_POST['age'] : [$_POST['age']];
    foreach ($ages as $age) {
        if (empty($age)) {
            $errors[] = "Age is required.";
        } elseif (!is_numeric($age) || $age < 0) {
            $errors[] = "Invalid age.";
        }
    }

    // Validate Gender
    $genders = isset($_POST['gender']) ? $_POST['gender'] : [];
    foreach ($genders as $gender) {
        if (empty($gender)) {
            $errors[] = "Gender is required.";
        }
    }

    // Validate Phase
    $phases = is_array($_POST['phase']) ? $_POST['phase'] : [$_POST['phase']];
    foreach ($phases as $phase) {
        if (empty($phase)) {
            $errors[] = "Phase is required.";
        } elseif (strlen($phase) > 2) {
            $errors[] = "Phase should not exceed 2 characters.";
        }
    }

    // Validate Block
    $blocks = is_array($_POST['block']) ? $_POST['block'] : [$_POST['block']];
    foreach ($blocks as $block) {
        if (empty($block)) {
            $errors[] = "Block is required.";
        } elseif (strlen($block) > 2) {
            $errors[] = "Block should not exceed 2 characters.";
        }
    }

    // Validate Lot
    $lots = is_array($_POST['lot']) ? $_POST['lot'] : [$_POST['lot']];
    foreach ($lots as $lot) {
        if (empty($lot)) {
            $errors[] = "Lot is required.";
        } elseif (strlen($lot) > 2) {
            $errors[] = "Lot should not exceed 2 characters.";
        }
    }

    // Validate Street
    $streets = isset($_POST['street']) ? $_POST['street'] : [];
    foreach ($streets as $street) {
        if (empty($street) || $street == "Select Street") {
            $errors[] = "Please select a valid street.";
        }
    }

    // Validate Contact Number
    $contactnumbers = is_array($_POST['contactnumber']) ? $_POST['contactnumber'] : [$_POST['contactnumber']];
    foreach ($contactnumbers as $contactnumber) {
        if (empty($contactnumber)) {
            $errors[] = "Contact Number is required.";
        } elseif (!preg_match("/^(09|\+639)\d{9}$/", $contactnumber)) {
            $errors[] = "Invalid contact number. Please use a valid Philippines mobile number format (e.g., 09123456789 or +639123456789).";
        }
    }

    // Validate Marital Status
    $maritalstatuses = isset($_POST['maritalstatus']) ? $_POST['maritalstatus'] : [];
    foreach ($maritalstatuses as $maritalstatus) {
        if (empty($maritalstatus)) {
            $errors[] = "Marital Status is required.";
        }
    }

    // Validate Citizenship
    $citizenships = is_array($_POST['citizenship']) ? $_POST['citizenship'] : [$_POST['citizenship']];
    foreach ($citizenships as $citizenship) {
        if (empty($citizenship)) {
            $errors[] = "Citizenship is required.";
        } elseif (strlen($citizenship) > 20) {
            $errors[] = "Citizenship should not exceed 20 characters.";
        }
    }

    // If there are no errors, proceed with data insertion
    if (empty($errors)) {
        // Loop through the arrays to insert each resident
        for ($i = 0; $i < count($lastnames); $i++) {
            $lastname = mysqli_real_escape_string($mysqli, $lastnames[$i]);
            $firstname = mysqli_real_escape_string($mysqli, $firstnames[$i]);
            $middlename = mysqli_real_escape_string($mysqli, $middlenames[$i]);
            $gender = mysqli_real_escape_string($mysqli, $genders[$i]);
            $phase = mysqli_real_escape_string($mysqli, $phases[$i]);
            $block = mysqli_real_escape_string($mysqli, $blocks[$i]);
            $lot = mysqli_real_escape_string($mysqli, $lots[$i]);
            $street = mysqli_real_escape_string($mysqli, $streets[$i]);
            $birthdate = mysqli_real_escape_string($mysqli, $birthdates[$i]);
            $age = intval($ages[$i]);
            $contactnumber = mysqli_real_escape_string($mysqli, $contactnumbers[$i]);
            $maritalstatus = mysqli_real_escape_string($mysqli, $maritalstatuses[$i]);
            $citizenship = mysqli_real_escape_string($mysqli, $citizenships[$i]);

            // Insert data into the table using a prepared statement
            $query = "INSERT INTO residents (lastname, firstname, middlename, gender, phase, block, lot, street, birthdate, age, contactnumber, maritalstatus, citizenship)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sssssssssisss", $lastname, $firstname, $middlename, $gender, $phase, $block, $lot, $street, $birthdate, $age, $contactnumber, $maritalstatus, $citizenship);

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        // Data inserted successfully, redirect to a success page or back to the list.
        header("Location: index.php");
        exit();
    }
}

// Close the database connection
$mysqli->close();
?>
