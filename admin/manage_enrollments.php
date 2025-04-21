<?php
include('../config.php');
include('header.php');

// Handle DB connection error
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission (Insert data)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
    $course_title = mysqli_real_escape_string($con, $_POST['course_title']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $grade = mysqli_real_escape_string($con, $_POST['grade']);

    $sql_insert = "INSERT INTO course_enrollments (id, course_code, course_title, semester, grade) 
                   VALUES ('$id', '$course_code', '$course_title', '$semester', '$grade')";

    if (!mysqli_query($con, $sql_insert)) {
        $message = "❌ Error saving enrollment: " . mysqli_error($con);
    } else {
        $message = "✅ Enrollment added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Course Enrollments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .top-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .top-buttons a {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .top-buttons a:first-child {
            background-color: #007bff;
        }

        .top-buttons a:first-child:hover {
            background-color: #0056b3;
        }

        .top-buttons .logout {
            background-color: #dc3545;
        }

        .top-buttons .logout:hover {
            background-color: #a71d2a;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s ease;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #1e7e34;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="top-buttons">
        <a href="index.php">⬅️ Back to Dashboard</a>
        <a href="exit.php" class="logout">🚪 Logout</a>
    </div>

    <h2>📋 All Course Enrollments</h2>

    <!-- Display message -->
    <?php if (!empty($message)): ?>
        <div class="<?= strpos($message, "✅") !== false ? 'message' : 'error' ?>"><?= $message ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Semester</th>
            <th>Grade</th>
            <th>Action</th>
        </tr>
        <?php
        // Fetch enrollments from the database
        $sql = "SELECT * FROM course_enrollments ORDER BY id DESC";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['course_code']) ?></td>
            <td><?= htmlspecialchars($row['course_title']) ?></td>
            <td><?= htmlspecialchars($row['semester']) ?></td>
            <td><?= htmlspecialchars($row['grade']) ?: 'N/A' ?></td>
            <td>
                <a href="edit_enrollments.php?id=<?= $row['id'] ?>" class="btn edit-btn">✏️ Edit</a>
                <a href="delete_enrollments.php?id=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this record?');">🗑️ Delete</a>
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
            <td colspan="6">No enrollments found.</td>
        </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
