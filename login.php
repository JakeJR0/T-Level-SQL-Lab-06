<?php
# Starts the session
session_start();

# Checks if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    # Redirects the user to the home page
    header('Location: index.php');
}

# Checks if the user has submitted the form
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    # Checks if the user has entered a username
    if (!isset($_POST['student_id'])) {
        # Redirects the user to the login page
        header('Location: login.php');
    } elseif (!isset($_POST['password'])) {
        # Redirects the user to the login page
        header('Location: login.php');
    }

    # Gets the username and password from the form
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    # Strips the username and password of any html tags

    $student_id = strip_tags($student_id);
    $password = strip_tags($password);

    # Requires the database connection
    require_once 'includes/storage.php';

    # Excapes the username and password
    $student_id = mysqli_real_escape_string($connection, $student_id);
    $password = mysqli_real_escape_string($connection, $password);

    # Gets the user from the database
    $login_query = "
        SELECT 
            student.ID,
            student.password,
            student.first_name
        FROM students AS student
        WHERE ID = '$student_id'
    ";

    # Runs the query
    $login_result = mysqli_query($connection, $login_query);

    # Checks if the query was successful
    if (!$login_result) {
        die("Error: " . mysqli_error($connection));
    }

    # Gets the user from the result
    $row = mysqli_fetch_assoc($login_result);

    # Checks if the password is correct
    if (password_verify($password, $row['password'])) {
        # Assigns the user to the session
        $_SESSION['logged_in'] = true;
        $_SESSION['student_id'] = $row['ID'];
        $_SESSION['first_name'] = $row['first_name'];

        # Redirects the user to the home page
        header('Location: index.php');
    } else {
        # Redirects the user to the login page
        header('Location: login.php');
    }
} else {
    # Displays the login form
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