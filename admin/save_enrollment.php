<?php
// Adjust this path based on where config.php is located
include('../config.php'); // use 'config.php' if it's in the same folder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id            = mysqli_real_escape_string($con, $_POST['id']); // Capture the ID
    $course_code   = mysqli_real_escape_string($con, $_POST['course_code']);
    $course_title  = mysqli_real_escape_string($con, $_POST['course_title']);
    $semester      = mysqli_real_escape_string($con, $_POST['semester']);
    $grade         = mysqli_real_escape_string($con, $_POST['grade']);

    // SQL query to update the record with the specific ID
    $sql = "UPDATE course_enrollments
            SET course_code = '$course_code', course_title = '$course_title', semester = '$semester', grade = '$grade'
            WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('✅ Course enrollment updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating enrollment: " . mysqli_error($con) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='dashboard.php';</script>";
}
?>
