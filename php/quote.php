<?php 
include '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $company = $_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $message = $_POST['message'];

    $insertSql = "INSERT INTO quote (name, company, email, phone, category, message, notification) VALUES ('$name', '$company', '$email', '$phone', '$category', '$message', 0)";

    if (mysqli_query($conn, $insertSql)) {
        echo 1;
    } else {
        // Error in insertion
        $errorMessage = "Error submitting form: " . mysqli_error($conn);
        echo 0;
    }
}
?>