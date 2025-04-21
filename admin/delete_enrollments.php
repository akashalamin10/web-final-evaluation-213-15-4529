<?php
include('../config.php');
include('header.php');

// Check if the 'id' is set in the URL
if (!isset($_GET['id'])) {
    die("❌ Invalid ID.");
}

$id = $_GET['id'];

// Delete the record from the database
$sql_delete = "DELETE FROM course_enrollments WHERE id = '$id'";

if (mysqli_query($con, $sql_delete)) {
    header("Location: manage_enrollments.php?success=1");
    exit();
} else {
    echo "❌ Error deleting enrollment: " . mysqli_error($con);
}
