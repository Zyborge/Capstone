        
$(document).ready(function () {
var residentCounter = 0;

// Function to add a new set of resident fields
function addResidentFields() {
residentCounter++;
console.log('Adding new resident fields. Resident Counter:', residentCounter); // Add this line for debugging

var newFields = `
<div class="row">
<!-- Personal Information - Left Half -->
<div class="col-md-6 mb-3">
<div class="container h-100"> <!-- Use h-100 to make it 100% height -->
        <h3>Personal Information</h3>
        <div class="row">
            <div class="col-md-12">
                <label for="lastname${residentCounter}" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lastname${residentCounter}" name="lastname[]" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please provide a valid last name.
                </div>
            </div>
            <div class="col-md-12">
                <label for="firstname${residentCounter}" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="firstname${residentCounter}" name="firstname[]" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please provide a valid first name.
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label for="middlename${residentCounter}" class="form-label">Middle Name:</label>
                <input type="text" class="form-control" id="middlename${residentCounter}" name="middlename[]
                " required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please provide a valid middle name.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="birthdate${residentCounter}" class="form-label">Birthdate:</label>
                <input type="date" class="form-control" id="birthdate${residentCounter}" name="birthdate[]" required max="9999-12-31" min="1800-01-01">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please provide a valid birthdate.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="age${residentCounter}" class="form-label">Age:</label>
                <input type="number" class="form-control" id="age${residentCounter}" name="age[]" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please provide a valid age.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="gender${residentCounter}" class="form-label">Gender:</label>
                <select class="form-select" id="gender${residentCounter}" name="gender[]" required>
                <option value="" selected disabled>Select Gender</option>

                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please select a gender.
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- RIGHT-->
        <div class="col-md-6">
        <!-- Address - Top Half -->
        <div class="container">
            <h3>Address</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phase${residentCounter}" class="form-label">Phase:</label>
                    <input type="text" class="form-control" id="phase${residentCounter}" name="phase[]" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid phase.
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="block${residentCounter}" class="form-label">Block:</label>
                    <input type="text" class="form-control" id="block${residentCounter}" name="block[]" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid block.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="lot${residentCounter}" class="form-label">Lot:</label>
                    <input type="text" class="form-control" id="lot${residentCounter}" name="lot[]" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid lot.
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="street${residentCounter}">Street</label>
                    <select id="street${residentCounter}" class="form-control" name="street[]" required>
                    <option value="" selected disabled>Select Street</option>
                    <option value="ANDROMEDA">ANDROMEDA</option>
                    <option value="ASTEROID">ASTEROID</option>
                    <option value="ASTRONOMY">ASTRONOMY</option>
                    <option value="ATMOSPHERE">ATMOSPHERE</option>
                    <option value="BUTTERCUP">BUTTERCUP</option>
                    <option value="CADILLAC">CADILLAC</option>
                    <option value="COMETS">COMETS</option>
                    <option value="CONSTELLATION">CONSTELLATION</option>
                    <option value="COSMOS">COSMOS</option>
                    <option value="ECLIPSE">ECLIPSE</option>
                    <option value="EVOLUTION">EVOLUTION</option>
                    <option value="GRAVITY">GRAVITY</option>
                    <option value="HALO/NEBULA">HALO/NEBULA</option>
                    <option value="JUPITER">JUPITER</option>
                    <option value="LUNAR">LUNAR</option>
                    <option value="MERCURY">MERCURY</option>
                    <option value="METEORS">METEORS</option>
                    <option value="MILKYWAY">MILKYWAY</option>
                    <option value="NEPTUNE/ZURICH">NEPTUNE/ZURICH</option>
                    <option value="ORBIT">ORBIT</option>
                    <option value="ORION">ORION</option>
                    <option value="PLASMA">PLASMA</option>
                    <option value="PLUTO">PLUTO</option>
                    <option value="ROTATION">ROTATION</option>
                    <option value="SATURN">SATURN</option>
                    <option value="SOLAR">SOLAR</option>
                    <option value="SPHERE">SPHERE</option>
                    <option value="SPINAL">SPINAL</option>
                    <option value="STARBURST">STARBURST</option>
                    <option value="STARGAZER">STARGAZER</option>
                    <option value="STELLARS">STELLARS</option>
                    <option value="SUPERNOVA">SUPERNOVA</option>
                    <option value="SUTTER">SUTTER</option>
                    <option value="SUTTER EXT">SUTTER EXT</option>
                    <option value="UNIVERSE">UNIVERSE</option>
                    <option value="VENUS">VENUS</option>
                    <option value="MERCURY P8">MERCURY P8</option>
                    <option value="MARS">MARS</option>
                </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid street.
                    </div>
                </div>
            </div>
        </div>
        <!-- Other Information - Bottom Half -->
        <div class="container mt-3">
            <h3>Other Information</h3>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="contactnumber${residentCounter}" class="form-label">Contact Number:</label>
                    <input type="text" class="form-control" id="contactnumber${residentCounter}" name="contactnumber[]" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid contact number.
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="maritalstatus${residentCounter}" class="form-label">Marital Status:</label>
                    <select class="form-select" id="maritalstatus${residentCounter}" name="maritalstatus[]" required>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please select a marital status.
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="citizenship${residentCounter}" class="form-label">Citizenship:</label>
                    <input type="text" class="form-control" id="citizenship${residentCounter}" name="citizenship[]" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please provide a valid citizenship.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

`;

$('#resident-fields').append(newFields);

        $('#resident-fields').append('<hr class="form-divider">');

}

// Add a new set of resident fields when the button is clicked
$('#add-resident').click(function () {
addResidentFields();
});
});

(function () {
'use strict';

// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.querySelectorAll('.needs-validation');

// Loop over them and prevent submission
Array.from(forms).forEach(function (form) {
form.addEventListener('submit', function (event) {
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    // Inside the form submission event listener
form.addEventListener('submit', function (event) {
if (!form.checkValidity()) {
event.preventDefault();
event.stopPropagation();
}

console.log('Form submitted. Resident Counter:', residentCounter); // Add this line for debugging

// Get all the form data here and log it for debugging
var formData = {
lastnames: [],
firstnames: [],
middlenames: [],
genders: [],
phases: [],
blocks: [],
lots: [],
streets: [],
birthdates: [],
ages: [],
contactnumbers: [],
maritalstatuses: [],
citizenships: []
};

for (var i = 1; i <= residentCounter; i++) {
formData.lastnames.push($('#lastname' + i).val());
formData.firstnames.push($('#firstname' + i).val());
formData.middlenames.push($('#middlename' + i).val());
formData.genders.push($('#gender' + i).val());
formData.phases.push($('#phase' + i).val());
formData.blocks.push($('#block' + i).val());
formData.lots.push($('#lot' + i).val());
formData.streets.push($('#street' + i).val());
formData.birthdates.push($('#birthdate' + i).val());
formData.ages.push($('#age' + i).val());
formData.contactnumbers.push($('#contactnumber' + i).val());
formData.maritalstatuses.push($('#maritalstatus' + i).val());
formData.citizenships.push($('#citizenship' + i).val());
}

console.log('Form Data:', formData); // Add this line for debugging

form.classList.add('was-validated');
}, false);

    form.classList.add('was-validated');
}, false);
});
})();
$(document).ready(function() {
// Get the birthdate input field
var birthdateInput = document.getElementById('birthdate');

// Add an event listener for the input field
birthdateInput.addEventListener('change', function() {
    // Get the selected birthdate value
    var birthdate = new Date(this.value);

    // Calculate the current date
    var today = new Date();

    // Calculate the age
    var age = today.getFullYear() - birthdate.getFullYear();

    // Check if the birthday hasn't occurred yet this year
    if (today.getMonth() < birthdate.getMonth() ||
        (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
        age--;
    }

    // Set the calculated age value to the age input field
    document.getElementById('age').value = age;
});
});
