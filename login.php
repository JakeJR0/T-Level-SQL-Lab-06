<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (!isset($_POST['student_id'])) {
        header('Location: login.php');
        echo "Student ID not set";
    } elseif (!isset($_POST['password'])) {
        header('Location: login.php');
        echo "Password not set";
    }

    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    $student_id = strip_tags($student_id);
    $password = strip_tags($password);

    require_once 'includes/storage.php';

    $student_id = mysqli_real_escape_string($connection, $student_id);
    $password = mysqli_real_escape_string($connection, $password);

    $login_query = "
        SELECT 
            student.ID,
            student.password,
            student.first_name
        FROM students AS student
        WHERE ID = '$student_id'
    ";

    $login_result = mysqli_query($connection, $login_query);

    if (!$login_result) {
        die("Error: " . mysqli_error($connection));
    }

    $row = mysqli_fetch_assoc($login_result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['student_id'] = $row['ID'];
        $_SESSION['first_name'] = $row['first_name'];
        header('Location: index.php');
    } else {
        header('Location: login.php');
    }
    
} else {
    DisplayLogin();
}

function DisplayLogin() {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            # Sets the page name 
            define("PAGE_NAME", "Login");
            # Includes the header
            include "includes/header.php"; 
        ?>
    </head>
    <body>
        <?php include_once 'includes/navbar.php'; ?>
        <!-- Header -->
        <div class="text-center" style="margin-top: 50px;">
            <h1 class="display-4">Student Login</h1>
            <p class="lead">Please fill out the form below to login.</p>
        </div>
        <!-- Form Container -->
        <div class="container form-container">
            <form action="" method="POST">
                <!-- Student ID -->
                <div class="form-group mb-3">
                    <label for="student_id">Student ID:</label>
                    <input pattern="[0-9]{7}" class="form-control" type="text" name="student_id" id="student_id">
                </div>
                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <!-- Submit Button -->
                <button class="btn btn-primary" style="width:100%; margin-top:30px;" type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>
<?php
}
?>