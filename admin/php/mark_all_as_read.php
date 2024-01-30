<?php
include '../../config/db.php';
if (isset($_POST['markAll'])) {
    // Update notification status for all records
    $updateAllQuery = "UPDATE quote SET notification = 1";

    if ($conn->query($updateAllQuery) === TRUE) {
        echo "All quotes marked as read successfully.";
    } else {
        echo "Error marking all quotes as read: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>