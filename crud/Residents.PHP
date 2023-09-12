<?php
// Include the database connection file (db.php)
include 'db.php';
include('../admins/sidebarcontent.php');

// Define the number of records to display per page and get the user's choice
if (isset($_GET['recordsPerPage']) && is_numeric($_GET['recordsPerPage'])) {
    $recordsPerPage = intval($_GET['recordsPerPage']);
} else {
    // Default to 10 records per page if not set
    $recordsPerPage = 10;
}

// Determine the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// Fetch records for the current page
$query = "SELECT * FROM residents LIMIT ?, ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $offset, $recordsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// Calculate the total number of records
$totalRecordsQuery = "SELECT COUNT(*) as total FROM residents";
$totalRecordsResult = $mysqli->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);
// Check if a search query is submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify your SQL query to include the search condition
    $query = "SELECT * FROM residents WHERE CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE ? LIMIT ?, ?";
    $stmt = $mysqli->prepare($query);
    $searchTerm = "%$search%";
    $stmt->bind_param("sii", $searchTerm, $offset, $recordsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If no search query, retrieve all records
    $query = "SELECT * FROM residents LIMIT ?, ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $offset, $recordsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Read Data</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../admins/side.css">

    <style>
        /* Custom CSS for modern table layout */
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table {
            background-color: #ffffff;
        }

        th, td {
            vertical-align: middle;
        }

        .record-checkbox {
            margin: 0;
        }

        /* Pagination style */
        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-link {
            color: #007bff;
        }

        .page-link:hover {
            color: #0056b3;
        }

        /* Search and Add buttons style */
        .input-group {
            margin-bottom: 10px;
        }

        /* Add new Resident button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .modal {
        z-index: 1050 !important;
    }
    .modal-backdrop{
        display:none;
    }

    .modal-backdrop {
        z-index: 1040 !important;
    }
        .modal-backdrop {
        opacity: 0 !important; /* Make the backdrop transparent */
    }

    .modal.fade.show {
        display: block !important; /* Ensure the modal is displayed */
    }

    /* Center the modal vertically and horizontally */
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100% - 60px);
    }

    /* Additional styling for the modal content */
    .modal-content {
        padding: 20px;
        border-radius: 10px;
    }
    .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s;
        }

        /* Show the notification */
        .show {
            opacity: 1;
        }
     

    </style>
</head>
<body>
<div class="sidenav">
    <div class="logo-details">
      <i class="bx bx-home"></i>
      <span class="logo_name">Garden Villas III</span>
    </div>
    <ul class="nav flex-column">
    <?php echo generateSidebarLinks($sidebarLinks); ?>
  </ul>
  </div>
  <div class="home-section">
  <i class="bx bx-menu" id="btn"></i>
  <div class="text fw-bold" style="margin-left: 70px; margin-top:25px"><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></div>
<!-- Admin Panel -->
    <div class="container mt-5">
        <h2>Resident Data</h2>

        <div class="row">
            <div class="col-md-5 mb-3">
        <form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search by Name">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
    </div>
</form>

        <!-- Hover added -->
        <div class="col-md-2 mb-3">
    <a class="btn btn-primary" href="create.php" role="button">Add new Resident</a>

</div>
<div class="col-md-2 mb-3">
<button class="btn btn-danger" id="delete-selected" >Delete Selected</button>

</div>

</div>
<div class="table-responsive">

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all">
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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td>
                <input type="checkbox" class="record-checkbox" data-record-id="<?php echo $row['id']; ?>">
                </td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['phase']; ?></td>
                <td><?php echo $row['block']; ?></td>
                <td><?php echo $row['lot']; ?></td>
                <td><?php echo $row['street']; ?></td>
                <td><?php echo $row['birthdate']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['contactnumber']; ?></td>
                <td><?php echo $row['maritalstatus']; ?></td>
                <td><?php echo $row['citizenship']; ?></td>
                <td>
                    <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
   <!-- Form to select records per page -->
<form method="GET">
    <label for="recordsPerPage">Records per Page:</label>
    <select id="recordsPerPage" name="recordsPerPage" onchange="this.form.submit()">
        <option value="10" <?php if ($recordsPerPage == 10) echo 'selected'; ?>>10</option>
        <option value="20" <?php if ($recordsPerPage == 20) echo 'selected'; ?>>20</option>
        <option value="30" <?php if ($recordsPerPage == 30) echo 'selected'; ?>>30</option>
    </select>
</form>

<!-- Pagination links -->
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- Confirmation Modal -->
    </div>
    </div>
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete these records?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirm-delete" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div id="notification" class="position-fixed bottom-0 end-0 p-3 alert" role="alert"></div>
    <?php if (isset($successMessage)) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
  </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        // JavaScript to handle Select All functionality
        window.addEventListener("load", function () {
        deleteSelectedButton.disabled = true;
    });
const selectAllCheckbox = document.getElementById("select-all");
const recordCheckboxes = document.querySelectorAll(".record-checkbox");
const deleteSelectedButton = document.getElementById("delete-selected");

deleteSelectedButton.addEventListener("mouseenter", function () {
    if (this.disabled) {
        this.style.cursor = "not-allowed";
    }
});

deleteSelectedButton.addEventListener("mouseleave", function () {
    this.style.cursor = "pointer";
});

selectAllCheckbox.addEventListener("change", function () {
    const isChecked = this.checked;
    recordCheckboxes.forEach((checkbox) => {
        checkbox.checked = isChecked;
    });
    logSelectedIds();
    updateDeleteSelectedButtonState(); // Update the button state when Select All is clicked
});

recordCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        logSelectedIds();
        updateDeleteSelectedButtonState(); // Update the button state when individual checkboxes are clicked
    });
});

function logSelectedIds() {
    const selectedRecordIds = [];

    // Loop through the record checkboxes and get the IDs of selected records
    recordCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            selectedRecordIds.push(checkbox.getAttribute("data-record-id"));
        }
    });

    // Log the selected IDs to the console
    console.log("Selected Record IDs:", selectedRecordIds);
}

function updateDeleteSelectedButtonState() {
    const selectedRecordCount = document.querySelectorAll(".record-checkbox:checked").length;

    // Disable the button if no checkboxes are selected, otherwise enable it
    deleteSelectedButton.disabled = selectedRecordCount === 0;
}

    </script>
<script>
    $(document).ready(function () {
        // Handle the "Delete Selected" button click event
        $("#delete-selected").click(function () {
            const selectedRecordIds = [];

            // Loop through the record checkboxes and get the IDs of selected records
            $(".record-checkbox:checked").each(function () {
                selectedRecordIds.push($(this).data("record-id"));
            });

            if (selectedRecordIds.length === 0) {
                alert("No records selected for deletion.");
            } else {
                // Display the confirmation modal
                $("#confirmationModal").modal("show");
            }
        });

        // Handle the "Delete" button click in the modal
        $("#confirm-delete").click(function () {
            const selectedRecordIds = [];

            // Loop through the record checkboxes and get the IDs of selected records
            $(".record-checkbox:checked").each(function () {
                selectedRecordIds.push($(this).data("record-id"));
            });

            if (selectedRecordIds.length === 0) {
                alert("No records selected for deletion.");
                return; // Prevent further execution
            }

            // Send the selected record IDs to the server for deletion using AJAX
            $.ajax({
                type: "POST",
                url: "delete-multiple.php",
                data: { selectedIds: selectedRecordIds },
                success: function (response) {
                    console.log(response);

                    // Close the modal
                    $("#confirmationModal").modal("hide");

                    // Show a notification with the deletion result
                    showNotification(response);

                    // Refresh the page after 3 seconds
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        });

        // Function to show a notification
        function showNotification(message, isError = false) {
            const notification = $("#notification");

            // Remove existing alert classes
            notification.removeClass("alert-success alert-danger");

            // Set the appropriate alert class based on isError
            if (isError) {
                notification.addClass("alert alert-danger");
            } else {
                notification.addClass("alert alert-success");
            }

            notification.text(message);
            notification.removeClass("d-none"); // Show the alert

            // Hide the notification after 5 seconds
            setTimeout(function () {
                notification.addClass("d-none"); // Hide the alert
            }, 5000);
        }
    });
</script>


    
</body>
</html>
