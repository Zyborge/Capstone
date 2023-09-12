<?php
// Include the database connection file (db.php)
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
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

    // Sanitize input data
    $id = intval($id);
    $lastname = mysqli_real_escape_string($mysqli, $lastname);
    $firstname = mysqli_real_escape_string($mysqli, $firstname);
    $middlename = mysqli_real_escape_string($mysqli, $middlename);
    $gender = mysqli_real_escape_string($mysqli, $gender);
    $phase = mysqli_real_escape_string($mysqli, $phase);
    $block = mysqli_real_escape_string($mysqli, $block);
    $lot = mysqli_real_escape_string($mysqli, $lot);
    $street = mysqli_real_escape_string($mysqli, $street);
    $birthdate = mysqli_real_escape_string($mysqli, $birthdate);
    $age = intval($age);
    $contactnumber = mysqli_real_escape_string($mysqli, $contactnumber);
    $maritalstatus = mysqli_real_escape_string($mysqli, $maritalstatus);
    $citizenship = mysqli_real_escape_string($mysqli, $citizenship);

    $errors = [];

    // Validate Last Name
  // Validate Last Name
$lastnames = is_array($_POST['lastname']) ? $_POST['lastname'] : [$_POST['lastname']];
foreach ($lastnames as $lastname) {
    if (empty($lastname)) {
        $errors[] = "Last Name is required.";
    } elseif (strlen($lastname) > 50 || !preg_match("/^[a-zA-Z\s]+$/", $lastname)) {
        $errors[] = "Last Name should not exceed 50 characters and must contain only alphabetic characters and spaces.";
    }
}

// Validate First Name
$firstnames = is_array($_POST['firstname']) ? $_POST['firstname'] : [$_POST['firstname']];
foreach ($firstnames as $firstname) {
    if (empty($firstname)) {
        $errors[] = "First Name is required.";
    } elseif (strlen($firstname) > 50 || !preg_match("/^[a-zA-Z\s]+$/", $firstname)) {
        $errors[] = "First Name should not exceed 50 characters and must contain only alphabetic characters and spaces.";
    }
}

// Validate Middle Name
$middlenames = is_array($_POST['middlename']) ? $_POST['middlename'] : [$_POST['middlename']];
foreach ($middlenames as $middlename) {
    if (strlen($middlename) > 50 || !preg_match("/^[a-zA-Z\s]*$/", $middlename)) {
        $errors[] = "Middle Name should not exceed 50 characters and must contain only alphabetic characters and spaces.";
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
        } elseif (strlen($phase) > 2 || !preg_match("/^[0-9]+$/", $phase)) {
            $errors[] = "Phase should not exceed 2 characters and must contain only numeric characters.";
        }
    }

    // Validate Block
    $blocks = is_array($_POST['block']) ? $_POST['block'] : [$_POST['block']];
    foreach ($blocks as $block) {
        if (empty($block)) {
            $errors[] = "Block is required.";
        } elseif (strlen($block) > 2 || !preg_match("/^[0-9]+$/", $block)) {
            $errors[] = "Block should not exceed 2 characters and must contain only numeric characters.";
        }
    }

    // Validate Lot
    $lots = is_array($_POST['lot']) ? $_POST['lot'] : [$_POST['lot']];
    foreach ($lots as $lot) {
        if (empty($lot)) {
            $errors[] = "Lot is required.";
        } elseif (strlen($lot) > 2 || !preg_match("/^[0-9]+$/", $lot)) {
            $errors[] = "Lot should not exceed 2 characters and must contain only numeric characters.";
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
        } elseif (strlen($citizenship) > 20 || !preg_match("/^[a-zA-Z]+$/", $citizenship)) {
            $errors[] = "Citizenship should not exceed 20 characters and must contain only alphabetic characters.";
        }
    else{
        // Update data in the table using a prepared statement
        $query = "UPDATE residents SET lastname=?, firstname=?, middlename=?, gender=?, phase=?, block=?, lot=?, street=?, birthdate=?, age=?, contactnumber=?, maritalstatus=?, citizenship=? WHERE id=?";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sssssssssisssi", $lastname, $firstname, $middlename, $gender, $phase, $block, $lot, $street, $birthdate, $age, $contactnumber, $maritalstatus, $citizenship, $id);

        if ($stmt->execute()) {
            // Data updated successfully, redirect to a success page or back to the list.
            header("Location: residents.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
        $stmt->close();
    }
}

// Fetch the record to be updated
$id = $_GET['id'];
$query = "SELECT * FROM residents WHERE id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Resident</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
</head>
<body>
        <div class="container mt-5">
        <h2>Update Resident</h2>
        <!-- Bootstrap Form for updating a resident -->
        <form method="POST" action="update.php" novalidate>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="lastname" class="form-label">Last Name <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" maxlength="50" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="firstname" class="form-label">First Name <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" maxlength="50" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="middlename" class="form-label">Middle Name </label>
                    <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $row['middlename']; ?>" maxlength="50" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Gender <strong class="text-danger">*</strong></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="phase" class="form-label">Phase <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="phase" name="phase" value="<?php echo $row['phase']; ?>" maxlength="2" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="block" class="form-label">Block <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="block" name="block" value="<?php echo $row['block']; ?>" maxlength="2" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="lot" class="form-label">Lot <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="lot" name="lot" value="<?php echo $row['lot']; ?>" maxlength="2" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="street" class="form-label">Street <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="street" name="street" value="<?php echo $row['street']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="birthdate" class="form-label">Birthdate <strong class="text-danger">*</strong></label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate']; ?>" max="9999-12-31" min="1800-01-01" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">Age <strong class="text-danger">*</strong></label>
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo $row['age']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="contactnumber" class="form-label">Contact Number <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="contactnumber" name="contactnumber" value="<?php echo $row['contactnumber']; ?>" maxlength="11" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="maritalstatus" class="form-label">Marital Status <strong class="text-danger">*</strong></label>
                    <select class="form-select" id="maritalstatus" name="maritalstatus" required>
                        <option value="Single" <?php if ($row['maritalstatus'] === 'Single') echo 'selected'; ?>>Single</option>
                        <option value="Married" <?php if ($row['maritalstatus'] === 'Married') echo 'selected'; ?>>Married</option>
                        <option value="Divorced" <?php if ($row['maritalstatus'] === 'Divorced') echo 'selected'; ?>>Divorced</option>
                        <option value="Widowed" <?php if ($row['maritalstatus'] === 'Widowed') echo 'selected'; ?>>Widowed</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="citizenship" class="form-label">Citizenship <strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" id="citizenship" name="citizenship" value="<?php echo $row['citizenship']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Resident</button>
        </form>
    </div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
<script>
    // JavaScript function to validate the form before submission
    document.getElementById('resident-form').addEventListener('submit', function (event) {
        // Remove any existing error messages
        let errorMessages = document.querySelectorAll('.text-danger');
        for (let errorMessage of errorMessages) {
            errorMessage.remove();
        }

        // Validate Last Name
        let lastNames = document.getElementsByName('lastname[]');
        for (let i = 0; i < lastNames.length; i++) {
            let lastName = lastNames[i].value.trim();
            if (lastName === '') {
                addErrorAfterField(lastNames[i], 'Last Name is required.');
            } else if (!/^[a-zA-Z\s ]+$/.test(lastName)) {
                addErrorAfterField(lastNames[i], 'Last Name should only contain letters and spaces.');
            } else if (lastName.length > 50) {
                addErrorAfterField(lastNames[i], 'Last Name should not exceed 50 characters.');
            }
        }

        // Validate First Name
        let firstNames = document.getElementsByName('firstname[]');
        for (let i = 0; i < firstNames.length; i++) {
            let firstName = firstNames[i].value.trim();
            if (firstName === '') {
                addErrorAfterField(firstNames[i], 'First Name is required.');
            } else if (!/^[a-zA-Z\s ]+$/.test(firstName)) {
                addErrorAfterField(firstNames[i], 'First Name should only contain letters and spaces.');
            } else if (firstName.length > 50) {
                addErrorAfterField(firstNames[i], 'First Name should not exceed 50 characters.');
            }
        }

        // Validate Middle Name
        let middleNames = document.getElementsByName('middlename[]');
        for (let i = 0; i < middleNames.length; i++) {
            let middleName = middleNames[i].value.trim();
            if (middleName === '') {
            }else if (!/^[a-zA-Z\s ]+$/.test(middleName)) {
                addErrorAfterField(middleNames[i], 'Middle Name should only contain letters and spaces.');
            } else if (middleName.length > 50) {
                addErrorAfterField(middleNames[i], 'Middle Name should not exceed 50 characters.');
            }
        }

   

        // Validate Birthdate
        let birthdates = document.getElementsByName('birthdate[]');
        for (let i = 0; i < birthdates.length; i++) {
            if (birthdates[i].value.trim() === '') {
                addErrorAfterField(birthdates[i], 'Birthdate is required.');
            } else if (!/^\d{4}-\d{2}-\d{2}$/.test(birthdates[i].value)) {
                addErrorAfterField(birthdates[i], 'Invalid birthdate format. Use YYYY-MM-DD.');
            }
        }

        // Validate Age
        let ages = document.getElementsByName('age[]');
        for (let i = 0; i < ages.length; i++) {
            if (ages[i].value.trim() === '') {
                addErrorAfterField(ages[i], 'Age is required.');
            } else if (!/^\d+$/.test(ages[i].value) || parseInt(ages[i].value) < 0) {
                addErrorAfterField(ages[i], 'Invalid age.');
            }
        }

        // Validate Gender
        let genders = document.getElementsByName('gender[]');
        for (let i = 0; i < genders.length; i++) {
            if (genders[i].value === '') {
                addErrorAfterField(genders[i], 'Gender is required.');
            }
        }

        // Validate Phase
        let phases = document.getElementsByName('phase[]');
        for (let i = 0; i < phases.length; i++) {
            if (phases[i].value.trim() === '') {
                addErrorAfterField(phases[i], 'Phase is required.');
            } else if (phases[i].value.length > 2) {
                addErrorAfterField(phases[i], 'Phase should not exceed 2 characters.');
            }
        }

        // Validate Block
        let blocks = document.getElementsByName('block[]');
        for (let i = 0; i < blocks.length; i++) {
            if (blocks[i].value.trim() === '') {
                addErrorAfterField(blocks[i], 'Block is required.');
            } else if (blocks[i].value.length > 2) {
                addErrorAfterField(blocks[i], 'Block should not exceed 2 characters.');
            }
        }

        // Validate Lot
        let lots = document.getElementsByName('lot[]');
        for (let i = 0; i < lots.length; i++) {
            if (lots[i].value.trim() === '') {
                addErrorAfterField(lots[i], 'Lot is required.');
            } else if (lots[i].value.length > 2) {
                addErrorAfterField(lots[i], 'Lot should not exceed 2 characters.');
            }
        }

        // Validate Street
        let streets = document.getElementsByName('street[]');
        for (let i = 0; i < streets.length; i++) {
            if (streets[i].value === '' || streets[i].value === 'Select Street') {
                addErrorAfterField(streets[i], 'Please select a valid street.');
            }
        }

        // Validate Contact Number
        let contactNumbers = document.getElementsByName('contactnumber[]');
        for (let i = 0; i < contactNumbers.length; i++) {
            if (contactNumbers[i].value.trim() === '') {
                addErrorAfterField(contactNumbers[i], 'Contact Number is required.');
            } else if (!/^(09|\+639)\d{9}$/.test(contactNumbers[i].value)) {
                addErrorAfterField(contactNumbers[i], 'Invalid contact number. Please use a valid Philippines mobile number format (e.g., 09123456789 or +639123456789).');
            }
        }

        // Validate Marital Status
        let maritalStatuses = document.getElementsByName('maritalstatus[]');
        for (let i = 0; i < maritalStatuses.length; i++) {
            if (maritalStatuses[i].value === '') {
                addErrorAfterField(maritalStatuses[i], 'Marital Status is required.');
            }
        }

        // Validate Citizenship
        let citizenships = document.getElementsByName('citizenship[]');
        for (let i = 0; i < citizenships.length; i++) {
            if (citizenships[i].value.trim() === '') {
                addErrorAfterField(citizenships[i], 'Citizenship is required.');
            } else if (citizenships[i].value.length > 20) {
                addErrorAfterField(citizenships[i], 'Citizenship should not exceed 20 characters.');
            }
        }

        // Check if there are errors
        if (document.querySelectorAll('.text-danger').length > 0) {
            event.preventDefault(); // Prevent form submission
        }
    });

    // Function to add an error message after a field
    function addErrorAfterField(field, errorMessage) {
        let errorElement = document.createElement('div');
        errorElement.className = 'text-danger';
        errorElement.textContent = errorMessage;
        field.parentNode.appendChild(errorElement);
    }
</script>
<script>
    // JavaScript function to validate the form fields while typing
    document.getElementById('resident-form').addEventListener('input', function (event) {
        const field = event.target;
        const fieldName = field.name;
        const errorElement = field.nextElementSibling; // The div element for error message

        // Function to add an error message
        function addError(errorMessage) {
            errorElement.textContent = errorMessage;
            field.classList.add('is-invalid');
        }

        // Function to remove an error message
        function removeError() {
            errorElement.textContent = '';
            field.classList.remove('is-invalid');
        }

       // Validate Last Name
if (fieldName.includes('lastname')) {
    const lastName = field.value.trim();
    if (lastName === '') {
        addError('Last Name is required.');
    } else if (!/^[a-zA-Z\s ]+$/.test(lastName)) {
        addError('Last Name should only contain letters and spaces.');
    } else if (lastName.length < 2) {
        addError('Last Name should have at least 2 characters.');
    } else if (lastName.length > 50) {
        addError('Last Name should not exceed 50 characters.');
    } else {
        removeError();
    }
}

// Validate First Name
if (fieldName.includes('firstname')) {
    const firstName = field.value.trim();
    if (firstName === '') {
        addError('First Name is required.');
    } else if (!/^[a-zA-Z\s ]+$/.test(firstName)) {
        addError('First Name should only contain letters and spaces.');
    } else if (firstName.length < 2) {
        addError('First Name should have at least 2 characters.');
    } else if (firstName.length > 50) {
        addError('First Name should not exceed 50 characters.');
    } else {
        removeError();
    }
}


        // Validate Middle Name
        if (fieldName.includes('middlename')) {
            const middleName = field.value.trim();
            if (!/^[a-zA-Z\s ]+$/.test(middleName)) {
            } else if (middleName.length > 50) {
                addError('Middle Name should not exceed 50 characters.');
            } else {
                removeError();
            }
        }

        // Validate Birthdate
        if (fieldName.includes('birthdate')) {
            if (field.value.trim() === '') {
                addError('Birthdate is required.');
            } else if (!/^\d{4}-\d{2}-\d{2}$/.test(field.value)) {
                addError('Invalid birthdate format. Use YYYY-MM-DD.');
            } else {
                removeError();
            }
        }

        // Validate Age
        if (fieldName.includes('age')) {
            if (field.value.trim() === '') {
                addError('Age is required.');
            } else if (!/^\d+$/.test(field.value) || parseInt(field.value) < 0) {
                addError('Invalid age.');
            } else {
                removeError();
            }
        }

        // Validate Gender
        if (fieldName.includes('gender')) {
            if (field.value === '') {
                addError('Gender is required.');
            } else {
                removeError();
            }
        }

        // Validate Phase
        if (fieldName.includes('phase')) {
            const phase = field.value.trim();
            if (phase === '') {
                addError('Phase is required.');
            } else if (phase.length > 2) {
                addError('Phase should not exceed 2 characters.');
            } else {
                removeError();
            }
        }

        // Validate Block
        if (fieldName.includes('block')) {
            const block = field.value.trim();
            if (block === '') {
                addError('Block is required.');
            } else if (block.length > 2) {
                addError('Block should not exceed 2 characters.');
            } else {
                removeError();
            }
        }

        // Validate Lot
        if (fieldName.includes('lot')) {
            const lot = field.value.trim();
            if (lot === '') {
                addError('Lot is required.');
            } else if (lot.length > 2) {
                addError('Lot should not exceed 2 characters.');
            } else {
                removeError();
            }
        }

        // Validate Street
        if (fieldName.includes('street')) {
            if (field.value === '' || field.value === 'Select Street') {
                addError('Please select a valid street.');
            } else {
                removeError();
            }
        }

        // Validate Contact Number
        if (fieldName.includes('contactnumber')) {
            const contactNumber = field.value.trim();
            if (contactNumber === '') {
                addError('Contact Number is required.');
            } else if (!/^(09|\+639)\d{9}$/.test(contactNumber)) {
                addError('Invalid contact number. Please use a valid Philippines mobile number format (e.g., 09123456789 or +639123456789).');
            } else {
                removeError();
            }
        }

        // Validate Marital Status
        if (fieldName.includes('maritalstatus')) {
            if (field.value === '') {
                addError('Marital Status is required.');
            } else {
                removeError();
            }
        }

        // Validate Citizenship
        if (fieldName.includes('citizenship')) {
            const citizenship = field.value.trim();
            if (citizenship === '') {
                addError('Citizenship is required.');
            } else if (citizenship.length > 20) {
                addError('Citizenship should not exceed 20 characters.');
            } else {
                removeError();
            }
        }

    });
</script>
<script>
    // Function to allow only numbers for input fields
    function allowOnlyNumbers(element) {
        element.addEventListener('input', function (event) {
            const inputValue = event.target.value;
            const newValue = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            event.target.value = newValue;
        });

        // Handle paste events
        element.addEventListener('paste', function (event) {
            event.preventDefault();
            const clipboardData = event.clipboardData || window.clipboardData;
            const pastedData = clipboardData.getData('text/plain').replace(/[^0-9]/g, ''); // Remove non-numeric characters
            element.value = pastedData;
        });
    }

    // Apply the function to the Phase, Block, and Lot fields
    allowOnlyNumbers(document.getElementById('phase'));
    allowOnlyNumbers(document.getElementById('block'));
    allowOnlyNumbers(document.getElementById('lot'));
    allowOnlyNumbers(document.getElementById('contactnumber'))
</script>