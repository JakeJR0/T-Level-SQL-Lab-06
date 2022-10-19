<?php
# Sets the page name
define("PAGE_NAME", "Confirmation");

$connection;
# Includes the storage file
require_once('includes/storage.php');

# Starts the session
session_start();

# This function adds the data to the database
function save_user($connection) {
    # Gets first name from session
    $first_name = $_SESSION['first_name'];
    # Gets last name from session
    $last_name = $_SESSION['last_name'];
    # Gets email from session
    $email = $_SESSION['email'];
    # Gets password from session
    $password = $_SESSION['password'];
    # Gets course from session
    $phone = $_SESSION['phone'];
    # Gets course from session
    $selected_course = $_SESSION['course_selected'];
    # Gets course level from session
    $feedback = $_SESSION['feedback'];

    # Seperates the course level from the course
    [$course, $course_level] = explode(" - ", $selected_course);
    
    # Filters the first name
    $first_name = mysqli_real_escape_string($connection, $first_name);
    # Filters the last name
    $last_name = mysqli_real_escape_string($connection, $last_name);
    # Filters the email
    $email = mysqli_real_escape_string($connection, $email);
    # Filters the password
    $password = mysqli_real_escape_string($connection, $password);
    # Filters the phone number
    $phone = mysqli_real_escape_string($connection, $phone);
    # Filters the feedback
    $course_selected = mysqli_real_escape_string($connection, $course);
    # Filters the feedback
    $course_level = mysqli_real_escape_string($connection, $course_level);
    # Filters the feedback
    $feedback = mysqli_real_escape_string($connection, $feedback);
    
    # Gets the course id and course level id using the course and course level from the form.

    $course_query = "
        SELECT
            c.ID AS 'Course',
            cl.ID AS 'Level'
        FROM
            courses c
        INNER JOIN
            course_levels cl ON c.ID = cl.course_id
        WHERE c.course_name = '".$course_selected."' AND cl.course_level = '". $course_level ."';
    ";
    
    # Executes the query
    $result = $connection -> query($course_query);
    # Gets the result into an array
    $course_info = $result -> fetch_row();
    # Gets the course id
    $course = $course_info[0];
    # Gets the course level id
    $level = $course_info[1];
    
    # Inserts the student data into the database
    $student_query = "
        INSERT INTO students(first_name, last_name, email, password, course_id, course_level)
        VALUES(
            '{$first_name}',
            '{$last_name}',
            '{$email}',
            '{$password}',
            '{$course}',
            '{$level}'
        );
    ";

    # Executes the query
    $result = $connection -> query($student_query);
    # Gets the student id from the database
    $student_id = $connection -> insert_id;

    # Inserts the feedback into the database
    $feedback_query = "
        INSERT INTO feedback(student_id, feedback)
        VALUES(
            '{$connection -> insert_id}',
            '{$feedback}'
        );
    ";

    # Executes the query
    $result = $connection -> query($feedback_query);
    return $student_id;
}

function require_string($item) {
    if ($item == "") {
        header("Location: index.php"); # Redirects to the index page
        exit(); # Stops the script
    } else {
        if (!is_string($item)) {
            header("Location: index.php"); # Redirects to the index page
            exit(); # Stops the script
        }
    }
}

# Checks if the form is missing required fields
if ($_SESSION['first_name'] == "" || $_SESSION['last_name'] == "" || $_SESSION['email'] == "" || $_SESSION['phone'] == "" || $_SESSION['course_selected'] == "") {
    # Redirects to the form page
    header("Location: index.php");
    # Stops the script
    exit();
} else {

    # Data Validation

    # Checks if the first name is valid
    require_string($_SESSION['first_name']);
    # Checks if the last name is valid
    require_string($_SESSION['last_name']);
    # Checks if the email is valid
    require_string($_SESSION['email']);
    # Checks if the phone number is valid
    require_string($_SESSION['phone']);
    # Checks if the course is valid
    require_string($_SESSION['course_selected']);
    # Checks if the feedback is valid
    require_string($_SESSION['feedback']);
    # Saves the user to the database
    $student_id = save_user($connection);
    # Displays the confirmation page
    DisplayConfirmation($student_id);
}

function DisplayConfirmation($student_id) {
# Used to store the HTML for the page
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "includes/header.php"; ?>
    <body>
        <div class="container">
            <div class="row">
                <!-- Header -->
                <div class="col-md-12 text-center">
                    <h1 class="display-4" style="margin-top: 30px;">Enrolment Details</h1>
                    <?php 
                        # Gets the timestamp from the session
                        $timestamp = $_SESSION['timestamp'];
                        # Filters the timestamp
                        $timestamp = strip_tags($timestamp);
                        require_string($timestamp);

                        # Replaces the underscore with a '/'
                        $timestamp = str_replace("-", "/", $timestamp);
                    ?>
                    <p class="lead">Thank you for registering for the <?php echo $_SESSION['course_selected']; ?> course on <?php echo $timestamp ?></lead>
                </div>
                <!-- Student Details -->
                <div class="col-md-12 text-center" style="margin-top: 50px;">
                    <h2 class="display-5" style="margin-top:25px; margin-bottom: 50px;">Your Details</h2>
                    <!-- Student ID -->
                    <p>Student ID: <strong><?php echo $student_id; ?></strong></p>
                    <!-- Name -->
                    <p>Name: <strong><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></strong></p>
                    <!-- Email -->
                    <p>Email: <strong><?php echo $_SESSION['email']; ?></strong></p>
                    <!-- Phone -->
                    <p>Phone: <strong><?php echo $_SESSION['phone']; ?></strong></p>
                    <!-- Login -->
                    <a class="btn btn-primary" href="login.php" style="margin-top: 50px;">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
session_unset();
}
?>