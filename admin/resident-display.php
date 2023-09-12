<?php
// Database connection
$dsn = "mysql:host=localhost;dbname=gardenvillas_db;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if the form is submitted for adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $gender = $_POST['gender'];
    $phase = $_POST['phase'];
    $block = $_POST['block'];
    $lot = $_POST['lot'];
    $street = $_POST['street'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $contactnumber = $_POST['contactnumber'];
    $maritalstatus = $_POST['maritalstatus'];
    $citizenship = $_POST['citizenship'];

    $stmt = $pdo->prepare("INSERT INTO residents (lastname, firstname, middlename, gender, phase, block, lot, street, birthdate, age, contactnumber, maritalstatus, citizenship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lastname, $firstname, $middlename, $gender, $phase, $block, $lot, $street, $birthdate, $age, $contactnumber, $maritalstatus, $citizenship]);

    // Refresh the page after adding a new user
    header('Location: residents.php');
    exit;
}

// Check if the form is submitted for updating a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $lastname = $_POST['edit_lastname'];
    $firstname = $_POST['edit_firstname'];
    $middlename = $_POST['edit_middlename'];
    $gender = $_POST['edit_gender'];
    $phase = $_POST['edit_phase'];
    $block = $_POST['edit_block'];
    $lot = $_POST['edit_lot'];
    $street = $_POST['edit_street'];
    $birthdate = $_POST['edit_birthdate'];
    $age = $_POST['edit_age'];
    $contactnumber = $_POST['edit_contactnumber'];
    $maritalstatus = $_POST['edit_maritalstatus'];
    $citizenship = $_POST['edit_citizenship'];

    $stmt = $pdo->prepare("UPDATE residents SET lastname=?, firstname=?, middlename=?, gender=?, phase=?, block=?, lot=?, street=?, birthdate=?, age=?, contactnumber=?, maritalstatus=?, citizenship=? WHERE id=?");
    $stmt->execute([$lastname, $firstname, $middlename, $gender, $phase, $block, $lot, $street, $birthdate, $age, $contactnumber, $maritalstatus, $citizenship, $id]);

    // Refresh the page after updating the user
    header('Location: residents.php');
    exit;
}

// Check if the delete parameter is present in the URL
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM residents WHERE id=?");
    $stmt->execute([$id]);

    // Refresh the page after deleting the user
    header('Location: residents.php');
    exit;
}

// Retrieve all users from the database
// Pagination variables
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10; // Number of records to display per page

// Get the search query from the URL parameter
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate total number of pages
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM residents WHERE lastname LIKE :search");
$stmt->bindValue(':search', "%{$searchQuery}%", PDO::PARAM_STR);
$stmt->execute();
$totalRecords = $stmt->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Get current page from the query string
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentpage - 1) * $limit;

// Retrieve records for the current page with search query
$stmt = $pdo->prepare("SELECT * FROM residents WHERE lastname LIKE :search LIMIT :start, :limit");
$stmt->bindValue(':search', "%{$searchQuery}%", PDO::PARAM_STR);
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>