<?php 
require('residents-con.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Bootstrap JS (required dependencies) -->


  <link rel="stylesheet" href="../css/table.css">
  
  <link rel="stylesheet" href="side.css">

  <title>Residents</title>
</head>
<body>
 <div class="container-fluid">
    <div class="row">
      <div class="col-2 sidenav">
          <div class="logo-details">
      <i class="bx bx-home"></i>
      <span class="logo_name">Garden Villas III</span>
    </div>
    <ul class="nav flex-column">
    <?php echo generateSidebarLinks($sidebarLinks); ?>
  </ul>
  </div>
<div class="col-10 home-section">
    <i class="bx bx-menu" id="btn"></i>
    <div class="text fw-bold" style="margin-left: 70px; margin-top: 25px"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></div>
    <div class="flex-grow-1 table-container overflow-auto">

<!-- Modal -->

        <!-- Button to trigger the modal for adding a new user -->
        <div class="table-controls d-flex justify-content-end mb-3">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-primary me-3" id="add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bx bx-plus"></i> Resident
        </button>

        <button type="button" id="delete-selected-button" class="btn btn-danger">
            <i class="bx bx-trash"></i> Delete
        </button>
        
        <button type="button" id="edit-selected-button" class="btn btn-primary" style="margin-left: 15px;" >
        <i class="bx bx-edit"></i> Edit</button>


        <input type="text" class="form-control ms-3" id="searchInput" placeholder="Search">
    </div>
</div>

    <div class="table-container">
  <table class="table table-hover mx-auto" id="table">
            <thead class="bg-danger">
                <tr class='text-center'>
                <th>
</th>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phase</th>
                    <th>Block</th>
                    <th>Lot</th>
                    <th>Street</th>
                    <th>Birthdate</th>
                    <th>Age</th>
                    <th>Contact Number</th>
                    <th>Marital Status</th>
                    <th>Citizenship</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                    <td>
                    <input type="checkbox" class="record-checkbox" value="<?= $user['id']; ?>">
</td>

                        <td><?= $user['id']; ?></td>
                        <td><?= $user['lastname'] . ' ' 
                        . $user['firstname'] . ' ' 
                        . substr($user['middlename'], 0, 1); ?></td>
                        <td><?= $user['gender']; ?></td>
                        <td><?= $user['phase']; ?></td>
                        <td><?= $user['block']; ?></td>
                        <td><?= $user['lot']; ?></td>
                        <td><?= $user['street']; ?></td>
                        <td><?= $user['birthdate']; ?></td>
                        <td><?= $user['age']; ?></td>
                        <td><?= $user['contactnumber']; ?></td>
                        <td><?= $user['maritalstatus']; ?></td>
                        <td><?= $user['citizenship']; ?></td>
                        <td>
                        <div class="btn-group" role="group" aria-label="Edit and Delete Buttons">
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id']; ?>">
  
    <i class='bx bx-edit'></i>
  </button>
  <a href="residents.php?delete=<?= $user['id']; ?>" class="btn btn-danger btn-sm" style="margin-left: 5px;">
    <i class='bx bx-trash'></i>
  </a>
</div>

                        </td>
                    </tr>

                    <!-- Modal for editing a user -->
                    <div class="modal fade" id="editModal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $user['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?= $user['id']; ?>">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <input type="hidden" name="edit_id" value="<?= $user['id']; ?>">
                                        
                                        <div class="row mt-3">
                                            <div class="col">
                                            <label for="edit_lastname<?= $user['id']; ?>" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="edit_lastname<?= $user['id']; ?>" name="edit_lastname" value="<?= $user['lastname']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_firstname<?= $user['id']; ?>" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="edit_firstname<?= $user['id']; ?>" name="edit_firstname" value="<?= $user['firstname']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_middlename<?= $user['id']; ?>" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" id="edit_middlename<?= $user['id']; ?>" name="edit_middlename" value="<?= $user['middlename']; ?>" required>
                                        </div>
                                        </div>
                                        <div class="row mt-3">
                                        <div class="col">
                                            <label for="edit_gender<?= $user['id']; ?>" class="form-label">Gender</label>
                                            <select class="form-select fw-bold" id="edit_gender<?= $user['id']; ?>" name="edit_gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" <?php if ($user['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                                <option value="Female" <?php if ($user['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="edit_birthdate<?= $user['id']; ?>" class="form-label">Birthdate</label>
                                            <input type="date" class="form-control" id="edit_birthdate<?= $user['id']; ?>" name="edit_birthdate" value="<?= $user['birthdate']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_age<?= $user['id']; ?>" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="edit_age<?= $user['id']; ?>" name="edit_age" value="<?= $user['age']; ?>" required>
                                        </div>
                                        </div>
                                        <div class="row mt-3">
                                        <div class="col">
                                            <label for="edit_phase<?= $user['id']; ?>" class="form-label">Phase</label>
                                            <select class="form-select fw-bold" id="edit_phase<?= $user['id']; ?>" name="edit_phase" required>
                                                <option value="">Select Phase</option>
                                                <option value="5" <?php if ($user['phase'] === '5') echo 'selected'; ?>>5</option>
                                                <option value="6" <?php if ($user['phase'] === '6') echo 'selected'; ?>>6</option>
                                                <option value="8" <?php if ($user['phase'] === '8') echo 'selected'; ?>>8</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="edit_block<?= $user['id']; ?>" class="form-label">Block</label>
                                            <input type="text" class="form-control" id="edit_block<?= $user['id']; ?>" name="edit_block" value="<?= $user['block']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_lot<?= $user['id']; ?>" class="form-label">Lot</label>
                                            <input type="text" class="form-control" id="edit_lot<?= $user['id']; ?>" name="edit_lot" value="<?= $user['lot']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_street<?= $user['id']; ?>" class="form-label">Street</label>
                                            <input type="text" class="form-control" id="edit_street<?= $user['id']; ?>" name="edit_street" value="<?= $user['street']; ?>" required>
                                        </div>
                                        </div>
                                        <div class="row mt-3">
                                        <div class="col">
                                            <label for="edit_contactnumber<?= $user['id']; ?>" class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" id="edit_contactnumber<?= $user['id']; ?>" name="edit_contactnumber" value="<?= $user['contactnumber']; ?>" required>
                                        </div>
                                        <div class="col">
                                            <label for="edit_maritalstatus<?= $user['id']; ?>" class="form-label">Marital Status</label>
                                            <select class="form-select fw-bold" id="edit_maritalstatus<?= $user['id']; ?>" name="edit_maritalstatus" required>
                                                    <option value="">Select Marital Status</option>
                                                    <option value="Single" <?php if ($user['maritalstatus'] === 'Single') echo 'selected'; ?>>Single</option>
                                                    <option value="Married" <?php if ($user['maritalstatus'] === 'Married') echo 'selected'; ?>>Married</option>
                                                    <option value="Divorced" <?php if ($user['maritalstatus'] === 'Divorced') echo 'selected'; ?>>Divorced</option>
                                                    <option value="Widowed" <?php if ($user['maritalstatus'] === 'Widowed') echo 'selected'; ?>>Widowed</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_citizenship<?= $user['id']; ?>" class="form-label">Citizenship</label>
                                            <input type="text" class="form-control" id="edit_citizenship<?= $user['id']; ?>" name="edit_citizenship" value="<?= $user['citizenship']; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <!-- Add a select dropdown for choosing items per page -->
    <div class="pagination">
<label for="limit">Items per Page:</label>
<select id="limit" name="limit">
    <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
    <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
    <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
</select>
</div>

<!-- Pagination -->
<ul class="pagination justify-content-center">
    <?php if ($currentpage > 1) : ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?= $currentpage - 1 ?>&limit=<?= $limit ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <li class="page-item <?= ($i == $currentpage) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($currentpage < $totalPages) : ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?= $currentpage + 1 ?>&limit=<?= $limit ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    <?php endif; ?>
</ul>
</div>

<div class="modal fade" id="editSelectedModal" tabindex="-1" aria-labelledby="editSelectedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSelectedModalLabel">Edit Selected Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Selected records will be appended here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <!-- Modal for adding a new user -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Resident</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="add_user" value="1">
                            <div class = "row mt-3">
                            <div class="col">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            <div class="col">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            <div class="col">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" required>
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select fw-bold" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>                         
                           </div>
                            <div class="col">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            </div>
                            <div class="col">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" name="age" readonly required>
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col">
                                <label for="phase" class="form-label">Phase</label>
                                <select class="form-select fw-bold" name="phase" required>
                                <option value="">Select Phase</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                            </select>
                            </div>
                            <div class="col">
                                <label for="block" class="form-label">Block</label>
                                <input type="text" class="form-control" id="block" name="block" required>
                            </div>
                            <div class="col">
                                <label for="lot" class="form-label">Lot</label>
                                <input type="text" class="form-control" id="lot" name="lot" required>
                            </div>
                            <div class="col">
                                <label for="street" class="form-label">Street</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            </div>
                           <div class="row mt-3">
                            <div class="col">
                                <label for="contactnumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactnumber" name="contactnumber" required>
                            </div>
                            <div class="col">
                                <label for="maritalstatus" class="form-label">Marital Status</label>
                                <select class="form-select fw-bold" name="maritalstatus" required>
                    <option value="">Select Marital Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                  </select>                            </div>
                              </div>
                            <div class="mb-3">
                                <label for="citizenship" class="form-label">Citizenship</label>
                                <input type="text" class="form-control" id="citizenship" name="citizenship" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Resident</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
<!-- Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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

<script>

      // Wait for the document to be ready
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
</script>

<script>
    // Handle change event of the limit dropdown
    $('#limit').on('change', function() {
        const selectedLimit = $(this).val();
        const currentURL = window.location.href;

        // Update the URL with the selected limit value
        const updatedURL = updateQueryStringParameter(currentURL, 'limit', selectedLimit);

        // Redirect to the updated URL
        window.location.href = updatedURL;
    });

    // Function to update query string parameter in the URL
    function updateQueryStringParameter(url, key, value) {
        const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        const separator = url.indexOf('?') !== -1 ? "&" : "?";
        if (url.match(re)) {
            return url.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return url + separator + key + "=" + value;
        }
    }
</script>
<script>
    $(document).ready(function() {
        // Triggered when the search input value changes
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();

            // Loop through each table row
            $('tbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();

                // Show/hide the row based on the search input
                if (rowText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', adjustSidebarHeight);

    function adjustSidebarHeight() {
      const sidebar = document.querySelector('.sidenav');
      const mainContent = document.querySelector('.main-content');
      sidebar.style.height = `${mainContent.offsetHeight}px`;
    }

    window.addEventListener('resize', adjustSidebarHeight);
  </script>  
  <script>
    // Select All checkbox functionality
    $('#select-all').on('click', function() {
        $('.record-checkbox').prop('checked', this.checked);
    });

    // Handle the "Delete Selected" button click
    $('#delete-selected-button').on('click', function() {
        const selectedIds = [];
        $('.record-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            // Show a confirmation dialog using SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete selected!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the actual deletion using an AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '../admin/delete-selected.php', // Modify this URL to your deletion script
                        data: { ids: selectedIds },
                        success: function(response) {
                            // Reload the page or update the table after successful deletion
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error if necessary
                            console.error(error);
                        },
                    });
                }
            });
        } else {
            // Display a message if no records are selected
            Swal.fire('No records selected', 'Please select records to delete.', 'warning');
        }
    });
    $(document).ready(function() {
    // Edit button click event
    $('.record-edit-button').on('click', function() {
        const userId = $(this).data('id');
        $(`#editModal${userId}`).modal('show');
    });

    // Edit selected records using checkboxes
    $('#edit-selected-button').on('click', function() {
        const selectedIds = [];

        // Loop through each selected checkbox
        $('.record-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            // Show the modal for editing selected records
            const editModal = $('#editSelectedModal');
            editModal.modal('show');

            // Clear previous content and add selected records
            const modalBody = editModal.find('.modal-body');
            modalBody.empty();

            // Loop through selected IDs and add user data
            selectedIds.forEach(function(userId) {
                const userData = $(`#editModal${userId}`).html();
                modalBody.append(userData);
                modalBody.append('<hr>');
            });

            // Enable form submission inside the modal
            editModal.find('form').off('submit').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                const formData = $(this).serialize();

                // Send AJAX request to update selected records
                $.ajax({
                    url: 'residents-con.php', // Replace with the appropriate PHP script
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Handle the success response
                        // You can display an alert or perform any other actions here
                        console.log(response);
                    },
                    error: function() {
                        // Handle the error
                        console.error('An error occurred while updating records.');
                    }
                });
            });
        } else {
            console.warn('No records selected for editing.');
        }
    });
});


</script>


  

</body>
</html>