<?php
include('../config.php');
session_start();
if(isset($_SESSION['user_data'])){
    $user = $_SESSION['user_data'];
}else{
    header('location: ../index.php');
}

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $Cpassword = mysqli_real_escape_string($con, $_POST['Cpassword']);
    $filename = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $size = $_FILES['photo']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'png', 'jpeg'];
    
    if(strlen($password) > 7){
        if($password == $Cpassword){
            $sql = "SELECT * FROM `users` WHERE email = '$email'";
            $query = mysqli_query($con, $sql);
            $rows = mysqli_num_rows($query);
            if($rows){
                $email_exit = "Email already in use";
            }else{
                if(in_array($image_ext, $allow_type)){
                    if($size <= 10000000){
                        move_uploaded_file($tmp_name, "../upload/users/" . $filename);
                        $insert = "INSERT INTO `users`(`name`, `email`, `password`, `c_password`, `photo`) VALUES ('$name','$email','$password','$Cpassword','$filename')";
                        $insquery = mysqli_query($con, $insert);
                        if($insquery){
                            $successfull = "Data inserted successfully!";
                        }else{
                            echo $failed = "Failed!";
                        }
                    }else{
                        echo $photo_error = "Image size should not be greater than 2MB";
                    }
                }else{
                    echo $photo_error = "Image file type is not allowed (Only jpg, png & jpeg)";
                }
            }
        }else{
            $pass_match = "Passwords do not match";
        }
    }else{
        $pass_lenght = "Password must be at least 8 characters";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIU</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <?php if(isset($successfull)) { ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $successfull; ?>
        </div>
        <?php } ?>
        
        <h2 class="form-title">Admin Registration Form</h2>

        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Your Name" maxlength="30" minlength="4" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="30" minlength="4" required>
                <?php if(isset($email_exit)) { ?>
                    <div class="error-message"><?php echo $email_exit; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Your Password" maxlength="30" minlength="8" required>
                <?php if(isset($pass_lenght)) { ?>
                    <div class="error-message"><?php echo $pass_lenght; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <input type="password" name="Cpassword" class="form-control" placeholder="Confirm Your Password" maxlength="30" minlength="8" required>
                <?php if(isset($pass_match)) { ?>
                    <div class="error-message"><?php echo $pass_match; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="file" class="file-label">Select Your Photo</label>
                <input type="file" name="photo" id="file" class="form-control" required>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="form-submit-btn" value="Submit">
            </div>
        </form>

        <!-- Back and Logout Buttons -->
        <div class="form-actions">
            <a href="index.php" class="back-btn">Back</a>
            <a href="login.php" class="logout-btn">Log Out</a>
        </div>

        <footer>
            <p class="footer-text">2006-<?php echo date('Y'); ?> All Rights Reserved. DIU</p>
        </footer>
    </div>
</body>
</html>

<style>
body {
    font-family: 'Arial', sans-serif;
    background: #f4f7fc;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group input {
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: 0.3s;
}

.form-group input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.form-submit-btn {
    background-color: #007BFF;
    color: white;
    padding: 14px;
    font-size: 1.1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.form-submit-btn:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    font-size: 0.9rem;
}

.file-label {
    font-size: 1rem;
    color: #007BFF;
}

.form-actions {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}

.back-btn, .logout-btn {
    padding: 12px 20px;
    background-color: #28a745;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.back-btn:hover, .logout-btn:hover {
    background-color: #218838;
}

footer {
    text-align: center;
    margin-top: 30px;
    font-size: 0.9rem;
    color: #777;
}
</style>
