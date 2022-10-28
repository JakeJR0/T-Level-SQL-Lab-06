<?php
# Starts the session
session_start();

# Checks if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    # Destroys the session
    session_destroy();
    # Redirects the user to the home page
    header('Location: index.php');
} else {
    # Redirects the user to the home page
    header('Location: index.php');
}

?>