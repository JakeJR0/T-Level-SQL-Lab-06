<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    
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