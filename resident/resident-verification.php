<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .form-group button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Email Verification</h2>
        <form action="../php/verification_process.php" method="POST">
            <div class="form-group">
                <label for="verification_code">Verification Code:</label>
                <input type="text" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
