<?php
include('db_conn.php')
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student Create</title>
</head>
<body>


<div class="container">
    <?php
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        echo '<div class="alert alert-warning alert-dismissible fade show fw-bold" role="alert">' . $msg . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

    }
    ?>

    <a href="add_new.php" class="btn btn-secondary fw-bold">Add New</a>
    <div class="table-responsive-xl">

    <table class="table table-hover text-center mt-5 fw-bold">
        <thead class="table-dark">
        <tr>
        <tr>
            <th scope="col" colspan="2">Resident ID</th>
            <th scope="col" colspan="2">Last Name</th>
            <th scope="col" colspan="2">First Name</th>
            <th scope="col" colspan="2">Middle Name</th>
            <th scope="col" colspan="2">Phase</th>
            <th scope="col" colspan="2">Block</th>
            <th scope="col" colspan="2">Lot</th>
            <th scope="col" colspan="2">Street</th>
            <th scope="col" colspan="2">Birthdate</th>
            <th scope="col" colspan="2">Age</th>
            <th scope="col" colspan="2">Contact Number</th>
            <th scope="col" colspan="2">Citizenship</th>
            <th scope="col" colspan="2">Action</th>
        </tr>

        </tr>
        </thead>
        <tbody>
        <?php
        include "db_conn.php";

        $sql = "SELECT * FROM `residents`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
           <tr>
                <td colspan="2"><?php echo $row['id'] ?></td>
                <td colspan="2"><?php echo $row['lastname'] ?></td>
                <td colspan="2"><?php echo $row['firstname'] ?></td>
                <td colspan="2"><?php echo $row['middlename'] ?></td>
                <td colspan="2"><?php echo $row['phase'] ?></td>
                <td colspan="2"><?php echo $row['block'] ?></td>
                <td colspan="2"><?php echo $row['lot'] ?></td>
                <td colspan="2"><?php echo $row['street'] ?></td>
                <td colspan="2"><?php echo $row['birthdate'] ?></td>
                <td colspan="2"><?php echo $row['age'] ?></td>
                <td colspan="2"><?php echo $row['contactnumber'] ?></td>
                <td colspan="2"><?php echo $row['citizenship'] ?></td>
                <td colspan="2">
                    <a href="edit.php?id=<?php echo $row['id'] ?>" class="link-warning">
                        <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                    </a>
                    <a href="delete.php?id=<?php echo $row['id'] ?>" class="link-danger">
                        <i class="fa-solid fa-trash fs-5"></i>
                    </a>
                </td>
            </tr>
                  
            <?php
        }
        ?>

        </tbody>
    </table>

</div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/b0d0eaa2c0.js" crossorigin="anonymous"></script>
</body>
</html>
