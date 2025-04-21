<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Enrollment</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('bg21.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .form-container {
            max-width: 600px;
            margin: 80px auto;
            background-color: rgba(255, 255, 255, 0.97);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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

        input[type="text"], select {
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

        .btn-logout {
            background-color: #dc3545;
            color: white;
        }

        .btn-back:hover {
            background-color: #146c43;
        }

        .btn-submit:hover {
            background-color: #1f256f;
        }

        .btn-logout:hover {
            background-color: #bd2130;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateForm() {
            const form = document.forms["enrollForm"];
            const id = form["id"].value.trim();
            const code = form["course_code"].value.trim();
            const title = form["course_title"].value.trim();
            const semester = form["semester"].value.trim();

            if (!id || !code || !title || !semester) {
                alert("❗ Please fill in all required fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>📘 Course Enrollment Form</h2>
    <form name="enrollForm" method="POST" action="manage_enrollments.php" onsubmit="return validateForm();">
        <label for="id">ID *</label>
        <input type="text" name="id" required>

        <label for="course_code">Course Code *</label>
        <input type="text" name="course_code" required>

        <label for="course_title">Course Title *</label>
        <input type="text" name="course_title" required>

        <label for="semester">Semester *</label>
        <input type="text" name="semester" required>

        <label for="grade">Grade (optional)</label>
        <input type="text" name="grade" placeholder="Leave blank if not available">

        <div class="button-group">
            <button class="btn-back" type="button" onclick="window.location.href='index.php'">⬅️ Back</button>
            <button class="btn-submit" type="submit">✅ Enroll</button>
            <button class="btn-logout" type="button" onclick="window.location.href='exit.php'">🚪 Logout</button>
        </div>
    </form>
</div>

</body>
</html>
