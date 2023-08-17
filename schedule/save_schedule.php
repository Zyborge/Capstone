<?php
require_once('db-connect.php');
session_start();

// Function to sanitize input data
function sanitize_input($input)
{
    return htmlspecialchars(trim($input));
}

$title = sanitize_input($_POST['title']);
$description = sanitize_input($_POST['description']);
$start_date = sanitize_input($_POST['start-date']);
$end_date = sanitize_input($_POST['end-date']);
$start_time = sanitize_input($_POST['start-time']);
$end_time = sanitize_input($_POST['end-time']);
$venue = sanitize_input($_POST['venue']);
$resident_id = $_SESSION['resident_id'];
$status = 'pending';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $response = array('status' => 'error', 'message' => 'Error: No data to save.');
} else {
    // Get the current time in the desired format (Philippine time)
    $currentTime = date("h:i A");

    // Check if the start_time is earlier than the current time
    if ($start_date === date("Y-m-d") && $start_time < $currentTime) {
        $response = array('status' => 'error', 'message' => 'Error: Start time cannot be earlier than the current time.');
    }
    // Check if the end_time is earlier than the current time
    elseif ($end_date === date("Y-m-d") && $end_time < $currentTime) {
        $response = array('status' => 'error', 'message' => 'Error: End time cannot be earlier than the current time.');
    }
    // Check if the end_date is before the start_date
    elseif ($end_date < $start_date) {
        $response = array('status' => 'error', 'message' => 'Error: End date cannot be before the start date.');
    } else {
        // Check if the desired time slot overlaps with existing bookings for the venue
       // Check if the desired time slot overlaps with existing bookings for the venue
        $availabilitySql = "SELECT * FROM `bookings` WHERE `venue` = ? AND `resident_id` != ? AND ((`start_date` = ? AND `end_time` > ?) OR (`end_date` = ? AND `start_time` < ?) OR (`start_date` < ? AND `end_date` > ?))";
        $stmt = $conn->prepare($availabilitySql);
        $stmt->bind_param("ssssssss", $venue, $resident_id, $start_date, $start_time, $end_date, $end_time, $start_date, $end_date);
        $stmt->execute();
        $availabilityResult = $stmt->get_result();


        if ($availabilityResult && $availabilityResult->num_rows > 0) {
            while ($row = $availabilityResult->fetch_assoc()) {
                $existingStartTime = $row['start_time'];
                $existingEndTime = $row['end_time'];

                // Convert existing start and end times to DateTime objects
                $existingStartDateTime = new DateTime($existingStartTime);
                $existingEndDateTime = new DateTime($existingEndTime);

                // Convert new start and end times to DateTime objects
                $newStartDateTime = new DateTime($start_time);
                $newEndDateTime = new DateTime($end_time);

                // Check if the desired time slot overlaps with the existing booking
                if ($newStartDateTime < $existingEndDateTime && $newEndDateTime > $existingStartDateTime) {
                    $response = array('status' => 'error', 'message' => 'The selected time slot overlaps with an existing booking.');
                    $stmt->close();
                    $conn->close();
                    echo json_encode($response);
                    exit;
                }
            }
        }

        // Format the start_time and end_time to display AM or PM
        $start_time_formatted = date("h:i A", strtotime($start_time));
        $end_time_formatted = date("h:i A", strtotime($end_time));

        // Insert the schedule using prepared statement to prevent SQL injection
        $insertSql = "INSERT INTO `bookings` (`title`, `description`, `start_date`, `end_date`, `start_time`, `end_time`, `venue`, `resident_id`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sssssssss", $title, $description, $start_date, $end_date, $start_time_formatted, $end_time_formatted, $venue, $resident_id, $status);
        $save = $stmt->execute();

        if ($save) {
            $response = array('status' => 'success', 'message' => 'Booking already submitted, Wait for the admin to approve.');
        } else {
            $response = array('status' => 'error', 'message' => 'An error occurred. Please try again.');
        }

        $stmt->close();
        $conn->close();
    }
}

// Set appropriate headers and echo the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
