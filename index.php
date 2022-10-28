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
        <!-- Header -->
        <?php include 'includes/navbar.php' ?>
        <!-- End Header -->

        <!-- Main -->
        <main>
            <header class="text-center" style="margin-top: 10px;">
                <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                ?>
                <h1 class="display-4">
                    Welcome <?php echo $_SESSION['first_name']; ?>
                </h1>
                <lead>
                    You are logged in.
                </lead>
                <?php 
                } else {
                ?>
                <h1 class="display-4">
                    Welcome to the Student Portal
                </h1>
                <lead>
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