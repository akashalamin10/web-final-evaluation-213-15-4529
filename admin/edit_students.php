<?php
include('../config.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_data'])) {
    header('location: ../index.php');
    exit();
}

$user = $_SESSION['user_data'];
$id = $_GET['id'] ?? '';
if (empty($id)) {
    header("location: all_students.php");
    exit();
}

$id = intval($id);
$sql = "SELECT * FROM `students` WHERE id = '$id'";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($query);
if (!$result) {
    die("Student not found.");
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $roll = mysqli_real_escape_string($con, $_POST['roll']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $major = mysqli_real_escape_string($con, $_POST['major']);  // Added major field
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $shift = mysqli_real_escape_string($con, $_POST['shift']);
    $father_name = mysqli_real_escape_string($con, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($con, $_POST['mother_name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);

    $filename = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'jpeg', 'png'];

    if ($_FILES['file']['error'] !== 0 && $_FILES['file']['error'] !== 4) {
        die("File upload error: " . $_FILES['file']['error']);
    }

    if (!empty($filename)) {
        if (in_array($image_ext, $allow_type)) {
            if ($size <= 2 * 1024 * 1024) {
                $upload_path = "../upload/students/";
                $old_file = $upload_path . $result['file'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
                $new_file = uniqid() . "." . $image_ext;
                move_uploaded_file($tmp_name, $upload_path . $new_file);

                $update = "UPDATE `students` SET 
                    `name`='$name',
                    `roll`='$roll',
                    `department`='$department',
                    `major`='$major',  // Added major field
                    `semester`='$semester',
                    `shift`='$shift',
                    `father_name`='$father_name',
                    `mother_name`='$mother_name',
                    `address`='$address',
                    `number`='$number',
                    `email`='$email',
                    `dob`='$dob',
                    `file`='$new_file' 
                    WHERE id = '$id'";
            } else {
                die("Image size should not be greater than 2MB");
            }
        } else {
            die("Only JPG, JPEG, PNG files are allowed.");
        }
    } else {
        $update = "UPDATE `students` SET 
            `name`='$name',
            `roll`='$roll',
            `department`='$department',
            `major`='$major', 
            `semester`='$semester',
            `shift`='$shift',
            `father_name`='$father_name',
            `mother_name`='$mother_name',
            `address`='$address',
            `number`='$number',
            `email`='$email',
            `dob`='$dob' 
            WHERE id = '$id'";
    }

    if (mysqli_query($con, $update)) {
        header("location: all_students.php");
        exit();
    } else {
        echo "Failed to update data! Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
        }
        nav .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        form input, form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        form label {
            font-weight: bold;
        }
        form input[type="submit"] {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            padding: 10px;
            margin-top: 40px;
            background-color: #eee;
            color: #555;
        }
        @media(max-width: 600px){
            nav {
                flex-direction: column;
                align-items: center;
            }
            nav .nav-links {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<nav>
    <div><strong>DIU</strong></div>
    <div class="nav-links">
        <a href="register.php">Add Admin</a>
        <a href="#">My Profile</a>
        <a href="all_students.php">Back</a>
    </div>
</nav>

<div class="container">
    <h2>Update Student Information</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($result['name']) ?>" placeholder="Enter Your Name" required>
        <input type="text" name="roll" value="<?= htmlspecialchars($result['roll']) ?>" placeholder="Enter Your Roll" required>

        <select name="department" required>
            <?php
            $departments = ['CSE', 'SWE', 'EEE', 'NFE', 'ENG'];
            foreach ($departments as $dep) {
                $selected = $result['department'] === $dep ? 'selected' : '';
                echo "<option value='$dep' $selected>$dep</option>";
            }
            ?>
        </select>

        <input type="text" name="major" value="<?= htmlspecialchars($result['major']) ?>" placeholder="Enter Major" required>  <!-- Added major input field -->

        <select name="semester" required>
            <?php
            for ($i = 1; $i <= 8; $i++) {
                $selected = $result['semester'] == $i ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
        </select>

        <select name="shift" required>
            <option value="1st" <?= $result['shift'] == '1st' ? 'selected' : '' ?>>1st Shift</option>
            <option value="2nd" <?= $result['shift'] == '2nd' ? 'selected' : '' ?>>2nd Shift</option>
        </select>

        <input type="text" name="father_name" value="<?= htmlspecialchars($result['father_name']) ?>" placeholder="Enter Father's Name" required>
        <input type="text" name="mother_name" value="<?= htmlspecialchars($result['mother_name']) ?>" placeholder="Enter Mother's Name" required>
        <input type="text" name="address" value="<?= htmlspecialchars($result['address']) ?>" placeholder="Enter Address" required>
        <input type="number" name="number" value="<?= htmlspecialchars($result['number']) ?>" placeholder="Enter Phone Number" required>
        
        <!-- New fields for email and DOB -->
        <input type="email" name="email" value="<?= htmlspecialchars($result['email']) ?>" placeholder="Enter Email" required>
        <input type="date" name="dob" value="<?= htmlspecialchars($result['dob']) ?>" required>

        <label for="file">Select New Photo (optional):</label>
        <input type="file" name="file" id="file">

        <input type="submit" name="submit" value="Update">
    </form>
</div>

<div class="footer">
    © 2006-<?= date('Y') ?> All Rights Reserved. Daffodil International University
</div>
</body>
</html>
