<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Database connection setup
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gardenvillas_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the form
$type = $_POST['type'];
$title = $_POST['title'];
$content = $_POST['content'];

// Insert the post into the appropriate table based on the post type
if ($type === 'announcement') {
  $table = 'announcements';
} elseif ($type === 'event') {
  $table = 'events';
}

$sql = "INSERT INTO $table (title, content) VALUES ('$title', '$content')";
if ($conn->query($sql) === true) {
  echo "Post added successfully.";

  // Retrieve user emails from the database
  $emailQuery = "SELECT email FROM approved_users";
  $result = $conn->query($emailQuery);

  if ($result->num_rows > 0) {
    // Loop through each user and send an email
    while ($row = $result->fetch_assoc()) {
      $to = $row['email'];
      $subject = "New Announcement";
      $message = "A new announcement has been posted. Check it out on the website.";

      // Create a new PHPMailer instance
      $mail = new PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "mailergarden@gmail.com";
        $mail->Password = "ywuxhbebsmbspxkp";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('mailergarden@gmail.com');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "Email sent to: " . $to . "<br>";
      } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo . "<br>";
      }
    }
  } else {
    echo "No users found.";
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
