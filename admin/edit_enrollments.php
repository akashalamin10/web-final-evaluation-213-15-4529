<?php
include('../config.php');
include('header.php');

// Check if the 'id' is set in the URL
if (!isset($_GET['id'])) {
    die("❌ Invalid ID.");
}

$id = $_GET['id'];

// Fetch the existing data from the database
$sql = "SELECT * FROM course_enrollments WHERE id = '$id'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    die("❌ Enrollment not found.");
}

// Handle form submission (Update data)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
    $course_title = mysqli_real_escape_string($con, $_POST['course_title']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $grade = mysqli_real_escape_string($con, $_POST['grade']);

    // Update query
    $sql_update = "UPDATE course_enrollments SET 
                   course_code = '$course_code', 
                   course_title = '$course_title', 
                   semester = '$semester', 
                   grade = '$grade' 
                   WHERE id = '$id'";

    if (mysqli_query($con, $sql_update)) {
        header("Location: manage_enrollments.php?success=1");
        exit();
    } else {
        $message = "❌ Error updating enrollment: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Enrollment</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
        }

        .form-container {
            max-width: 600px;
            margin: 80px auto;
            background-color: rgba(255, 255, 255, 0.97);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2e3094;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            flex: 1 1 30%;
            margin: 5px;
        }

        .btn-back {
            background-color: #198754;
            color: white;
        }

        .btn-submit {
            background-color: #2e3094;
            color: white;
        }

        .btn-back:hover {
            background-color: #146c43;
        }

        .btn-submit:hover {
            background-color: #1f256f;
        }

        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>✏️ Edit Course Enrollment</h2>
    
    <?php if (isset($message)): ?>
        <div class="error"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="course_code">Course Code *</label>
        <input type="text" name="course_code" value="<?= htmlspecialchars($row['course_code']) ?>" required>

        <label for="course_title">Course Title *</label>
        <input type="text" name="course_title" value="<?= htmlspecialchars($row['course_title']) ?>" required>

        <label for="semester">Semester *</label>
        <input type="text" name="semester" value="<?= htmlspecialchars($row['semester']) ?>" required>

        <label for="grade">Grade (optional)</label>
        <input type="text" name="grade" value="<?= htmlspecialchars($row['grade']) ?>" placeholder="Leave blank if not available">

        <div class="button-group">
            <button class="btn-back" type="button" onclick="window.location.href='manage_enrollments.php'">⬅️ Back</button>
            <button class="btn-submit" type="submit">✅ Update Enrollment</button>
        </div>
    </form>
</div>

</body>
</html>
