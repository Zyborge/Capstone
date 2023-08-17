<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDir = 'uploads/';
    $imageFile = $_FILES['image'];
    $imageFileType = strtolower(pathinfo($imageFile['name'], PATHINFO_EXTENSION));
    
    // Check if the uploaded file is an image
    $check = getimagesize($imageFile['tmp_name']);
    if ($check === false) {
        echo 'Error: Invalid image file.';
        exit;
    }
    
    // Generate a unique file name
    $uniqueFileName = uniqid() . '.' . $imageFileType;
    $uploadFile = $uploadDir . $uniqueFileName;
    
    // Check if the file already exists
    if (file_exists($uploadFile)) {
        echo 'Error: File already exists.';
        exit;
    }
    
    // Check file size (optional)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    if ($imageFile['size'] > $maxFileSize) {
        echo 'Error: File size exceeds the maximum limit (5MB).';
        exit;
    }
    
    // Allow only certain file formats (e.g., JPEG, PNG)
    $allowedFormats = array('jpg', 'jpeg', 'png');
    if (!in_array($imageFileType, $allowedFormats)) {
        echo 'Error: Only JPEG and PNG file formats are allowed.';
        exit;
    }
    
    // Move the uploaded file to the destination directory
    if (move_uploaded_file($imageFile['tmp_name'], $uploadFile)) {
        // Database connection
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'gardenvillas_db';

        // Create connection
        // ...

        // Save the file name to the database
        $sql = "INSERT INTO images (filename) VALUES ('$uniqueFileName')";
        // Execute the SQL query
        // ...

        echo 'Success: File uploaded and saved successfully.';
    } else {
        echo 'Error: Failed to upload the file.';
    }
} else {
    echo 'Error: Invalid request.';
}
?>
