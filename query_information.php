<?php
include('config.php');
include("header.php");

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $roll = mysqli_real_escape_string($con, $_POST['roll']);

    // Query with sanitized inputs
    $sql = "SELECT * FROM `students` WHERE department = '$department' AND roll = '$roll'";
    $query = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($query);

    if ($rows) {
        $result = mysqli_fetch_assoc($query);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Student Profile</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url('bg22.jpg') no-repeat center center;
                    background-size: cover;
                    background-attachment: fixed;
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .card {
                    background: rgba(255, 255, 255, 0.9);
                    border-radius: 20px;
                    padding: 30px;
                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 400px;
                    width: 90%;
                }

                .card .banner {
                    margin-bottom: 20px;
                }

                .card .profile {
                    width: 130px;
                    height: 130px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 4px solid #198754;
                }

                .card h2.name {
                    font-size: 24px;
                    margin: 15px 0 5px;
                    color: #333;
                }

                .title {
                    font-size: 16px;
                    margin-bottom: 8px;
                    color: #555;
                }

                .footer {
                    margin-top: 25px;
                }

                .footer a {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #dc3545;
                    color: #fff;
                    border-radius: 8px;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }

                .footer a:hover {
                    background-color: #bb2d3b;
                }

                .info-table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    font-size: 15px;
}

.info-table th,
.info-table td {
    text-align: left;
    padding: 8px 12px;
    border-bottom: 1px solid #ccc;
}

.info-table th {
    background-color: #f4f4f4;
    color: #333;
    width: 40%;
}

.info-table td {
    color: #444;
}


                @media (max-width: 500px) {
                    .card {
                        padding: 20px;
                    }

                    .card h2.name {
                        font-size: 20px;
                    }

                    .title {
                        font-size: 14px;
                    }


                
                }
            </style>
        </head>
        <body>
    <div class="card">
        <div class="banner">
            <img class="profile" src="upload/students/<?= htmlspecialchars($result['file']) ?>" alt="Student Photo">
        </div>
        <h2 class="name"><?= ucwords($result['name']) ?></h2>

        <table class="info-table">
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($result['roll']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($result['email']) ?></td>
            </tr>
            <tr>
                <th>Department</th>
                <td><?= htmlspecialchars($result['department']) ?></td>
            </tr>
            <tr>
                <th>Major</th>
                <td><?= htmlspecialchars($result['major']) ?></td>
            </tr>
            <tr>
                <th>Semester</th>
                <td><?= htmlspecialchars($result['semester']) ?></td>
            </tr>
            <tr>
                <th>Shift</th>
                <td><?= htmlspecialchars($result['shift']) ?></td>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td><?= ucwords($result['father_name']) ?></td>
            </tr>
            <tr>
                <th>Mother's Name</th>
                <td><?= ucwords($result['mother_name']) ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?= htmlspecialchars($result['dob']) ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= ucwords($result['address']) ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?= htmlspecialchars($result['number']) ?></td>
            </tr>
        </table>

        <div class="footer">
            <a href="exit.php">Logout</a>
        </div>
    </div>
</body>

        </html>
        <?php
    } else {
        $_SESSION['error'] = "Invalid Department/ID";
        header("location: index.php");
        exit();
    }
}
?>
