<?php
include('../config.php');
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location: ../index.php');
}
$user = $_SESSION['user_data'];

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($con, $_POST['name'] ?? '');
  $roll = mysqli_real_escape_string($con, $_POST['roll'] ?? '');
  $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
  $department = mysqli_real_escape_string($con, $_POST['department'] ?? '');
  $major = mysqli_real_escape_string($con, $_POST['major'] ?? '');
  $semester = mysqli_real_escape_string($con, $_POST['semester'] ?? '');
  $shift = mysqli_real_escape_string($con, $_POST['shift'] ?? '');
  $father_name = mysqli_real_escape_string($con, $_POST['father_name'] ?? '');
  $mother_name = mysqli_real_escape_string($con, $_POST['mother_name'] ?? '');
  $dob = mysqli_real_escape_string($con, $_POST['dob'] ?? '');
  $address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
  $number = mysqli_real_escape_string($con, $_POST['number'] ?? '');

    $filename = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'jpeg', 'png'];

    if (in_array($image_ext, $allow_type)) {
        if ($size <= 5000000) {
            $unique_name = time() . '_' . $filename;
            move_uploaded_file($tmp_name, "../upload/students/" . $unique_name);

            $insert = "INSERT INTO `students`(`name`, `roll`, `department`, `major`, `semester`, `shift`, `father_name`, `mother_name`, `dob`, `address`, `number`, `file`, `email`) 
            VALUES ('$name','$roll','$department','$major','$semester','$shift','$father_name','$mother_name','$dob','$address','$number','$unique_name', '$email')";
            
            $insquery = mysqli_query($con, $insert);
            if ($insquery) {
                $successfull = "✅ Data inserted successfully!";
            } else {
                $failed = "❌ Failed to insert data!";
            }
        } else {
            $photo_error = "⚠️ Image size should not be more than 5MB.";
        }
    } else {
        $photo_error = "⚠️ Only JPG, PNG & JPEG files are allowed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f8;
    }
    .navbar {
        background-color: #2f80ed;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }
    .navbar a {
        color: white;
        background-color: #1c6ed2;
        padding: 0.5rem 1rem;
        text-decoration: none;
        border-radius: 8px;
        margin-left: 0.5rem;
        font-weight: bold;
        transition: background 0.3s ease;
    }
    .navbar a:hover {
        background-color: #145cb3;
    }
    .container {
        max-width: 700px;
        margin: 2rem auto;
        background-color: #fff;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #2f80ed;
        outline: none;
    }
    .btn-submit {
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 0.8rem;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
    }
    .btn-submit:hover {
        background-color: #219150;
    }
    .alert {
        padding: 1rem;
        background-color: #d4edda;
        border-left: 5px solid #28a745;
        margin-bottom: 1rem;
        color: #155724;
    }
    .error { color: red; font-size: 0.9em; }
  </style>
</head>
<body>

<div class="navbar">
  <div><strong>Add Student</strong></div>
  <div>
    <a href="index.php">🔙 Back</a>
    <a href="../login.php">🚪 Logout</a>
  </div>
</div>

<div class="container">
  <h2>Add Student Information</h2>

  <?php if(isset($successfull)) echo "<div class='alert'>$successfull</div>"; ?>
  <?php if(isset($failed)) echo "<div class='alert' style='background:#f8d7da;color:#721c24;border-left:5px solid #f44336;'>$failed</div>"; ?>
  <?php if(isset($photo_error)) echo "<div class='alert' style='background:#fff3cd;color:#856404;border-left:5px solid #ff9800;'>$photo_error</div>"; ?>

  <form id="registrationForm" method="post" enctype="multipart/form-data" action="">
    <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
    <input type="text" name="roll" class="form-control" placeholder="Enter Your ID" required>
    <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required>

    <select name="department" class="form-control" required>
      <option value="">Select Department</option>
      <option value="CSE">CSE</option>
      <option value="SWE">SWE</option>
      <option value="EEE">EEE</option>
      <option value="NFE">NFE</option>
      <option value="ENG">ENG</option>
      <option value="THM">THM</option>
    </select>

    <select name="major" class="form-control" required>
      <option value="">Select Major</option>
      <option value="Software Engineering">Software Engineering</option>
      <option value="Electrical Engineering">Electrical Engineering</option>
      <option value="Mechanical Engineering">Mechanical Engineering</option>
      <option value="Civil Engineering">Civil Engineering</option>
      <option value="Business Administration">Business Administration</option>
    </select>

    <select name="semester" class="form-control" required>
      <option value="">Select Semester</option>
      <?php for ($i = 1; $i <= 10; $i++) echo "<option value='{$i}th'>{$i}th</option>"; ?>
    </select>

    <select name="shift" class="form-control" required>
      <option value="">Select Shift</option>
      <option value="Morning">Morning</option>
      <option value="Evening">Evening</option>
    </select>

    <input type="text" name="father_name" class="form-control" placeholder="Enter Father's Name" required>
    <input type="text" name="mother_name" class="form-control" placeholder="Enter Mother's Name" required>
    <input type="date" name="dob" class="form-control" required>
    <input type="text" name="address" class="form-control" placeholder="Enter Upazila & Zila Name" required>
    <input type="text" name="number" class="form-control" placeholder="Enter Your Number" required>

    <label for="file">📷 Upload Photo</label>
    <input type="file" name="file" class="form-control" required>

    <label><input type="checkbox" required> I agree to the terms and conditions</label><br><br>

    <input type="submit" name="submit" value="SUBMIT" class="btn-submit">
  </form>
</div>

</body>
</html>
