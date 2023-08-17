<?php
include "db_conn.php";

if (isset($_GET["id"])) {
    // Single deletion
    $id = $_GET["id"];
    $query = "DELETE FROM `residents` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location:../try-for-side/residents.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} elseif (isset($_GET["ids"])) {
    // Multiple deletions
    $ids = $_GET["ids"];

    // Split the comma-separated IDs into an array
    $idArray = explode(",", $ids);

    // Loop through the IDs and perform the deletion
    foreach ($idArray as $id) {
        $query = "DELETE FROM `residents` WHERE `id`='$id'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Failed to delete record with ID: $id. Error: " . mysqli_error($conn);
            exit;
        }
    }

    header("Location:../try-for-side/residents.php");
} else {
    // No ID or IDs provided
    echo "No ID or IDs provided for deletion.";
}
?>
