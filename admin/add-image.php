<!DOCTYPE html>
<html>
<head>
  <title>Image Upload Form</title>
  <style>
    .upload-form {
      margin-top: 50px;
      text-align: center;
    }
    
    .upload-form input[type="file"] {
      display: none;
    }
    
    .upload-form label {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="upload-form">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="image" accept="image/*" id="image-input" required>
      <label for="image-input">Select Image</label>
      <input type="submit" value="Upload">
    </form>
  </div>
</body>
</html>
