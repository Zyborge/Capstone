<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Email</title>
</head>
<body>
  <form action="send.php" method="POST">
    Email: <input type="email" name="email" required><br>
    Subject: <input type="text" name="subject" required><br>
    Message: <input type="text" name="message" required><br>
    <button type="submit" name="send">Send</button>
  </form>

  <?php
  if (isset($_POST["send"])) {
    echo '
      <script>
        alert("Send Success");
        document.location.href = "index.php";
      </script>
    ';
  }
  ?>
</body>
</html>