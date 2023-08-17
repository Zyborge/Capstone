<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["booking_id"]) && isset($_POST["approve"])) {
        // Database connection parameters (same as in the first block of code)
        $servername = "localhost";
        $dbname = "gardenvillas_db";
        $username = "root";
        $password = "";

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Get the booking ID from the form submission
            $bookingId = $_POST["booking_id"];

            // Update the booking status to "approved" in the database
            $stmt = $conn->prepare("UPDATE bookings SET status = 'Approved' WHERE id = :bookingId");
            $stmt->bindParam(':bookingId', $bookingId);
            $stmt->execute();

            // Close the database connection
            $conn = null;

            // Return a success response
            echo json_encode(["status" => "success", "message" => "Booking approved successfully."]);
            exit();
        } catch (PDOException $e) {
            // Return an error response if there's an exception
            echo json_encode(["status" => "error", "message" => "An error occurred while processing the request."]);
            exit();
        }
    } elseif (isset($_POST["booking_id"]) && isset($_POST["reject"])) {
        // Database connection parameters (same as in the first block of code)
        $servername = "localhost";
        $dbname = "gardenvillas_db";
        $username = "root";
        $password = "";

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Get the booking ID from the form submission
            $bookingId = $_POST["booking_id"];

            // Update the booking status to "rejected" in the database
            $stmt = $conn->prepare("UPDATE bookings SET status = 'Rejected' WHERE id = :bookingId");
            $stmt->bindParam(':bookingId', $bookingId);
            $stmt->execute();

            // Close the database connection
            $conn = null;

            // Return a success response
            echo json_encode(["status" => "success", "message" => "Booking rejected successfully."]);
            exit();
        } catch (PDOException $e) {
            // Return an error response if there's an exception
            echo json_encode(["status" => "error", "message" => "An error occurred while processing the request."]);
            exit();
        }
    }
}
?>
