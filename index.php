<?php
define('PAGE_NAME', 'Home');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'includes/header.php'; ?>
    </head>
    <body>
        <!-- Navigation Bar -->
        <?php include 'includes/navbar.php' ?>
        <!-- Main -->
        <main>
            <!-- Header -->
            <header class="text-center" style="margin-top: 10px;">
                <?php
                    # Checks if the user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                ?>
                <!-- User Message -->
                <h1 class="display-4">
                    Welcome <?php echo $_SESSION['first_name']; ?>
                </h1>
                <lead class="lead">
                    You are logged in.
                </lead>
                <?php 
                } else {
                ?>
                <!-- Guest Message -->
                <h1 class="display-4">
                    Welcome to the Student Portal
                </h1>
                <lead class="lead">
                    Please login or enrol to continue.
                </lead>
                <?php
                
                }

                ?>
            </header>
        </main>
        <!-- End Main -->

    </body>
</html>