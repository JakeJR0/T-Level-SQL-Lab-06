<?php
# Starts the connection to the database
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "T-Level-Lab-SQL-06");

# Creates the connection to the database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

# Checks if the connection is successful
if (!$connection) {
    die("Error: " . mysqli_connect_error());
} else {
    echo "<script type='text/javascript'>console.log('Connected to database')</script>";
}

# Ensures that the required tables exist

$courses = "
    CREATE TABLE IF NOT EXISTS courses(
        ID INT PRIMARY KEY AUTO_INCREMENT,
        course_name VARCHAR(255) NOT NULL
    );
";

$levels = "
    CREATE TABLE IF NOT EXISTS course_levels(
        ID INT PRIMARY KEY AUTO_INCREMENT,
        course_id INT NOT NULL,
        course_level VARCHAR(255) NOT NULL,
        FOREIGN KEY (course_id) REFERENCES courses(ID)
    );
";

$students = "
    CREATE TABLE IF NOT EXISTS students(
        ID INT PRIMARY KEY AUTO_INCREMENT,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        course_id INT NOT NULL,
        course_level INT NOT NULL,
        registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(ID),
        FOREIGN KEY (course_level) REFERENCES course_levels(ID)
    ) AUTO_INCREMENT=1000000;
";

$feedback = "
    CREATE TABLE IF NOT EXISTS feedback(
        ID INT PRIMARY KEY AUTO_INCREMENT,
        student_id INT NOT NULL,
        feedback VARCHAR(255) NOT NULL,
        FOREIGN KEY (student_id) REFERENCES students(ID)
    );
";

# Executes the queries
$course_result = mysqli_query($connection, $courses);
$level_result = mysqli_query($connection, $levels);
$students_result = mysqli_query($connection, $students);
$feedback_result = mysqli_query($connection, $feedback);

# Checks if the queries were successful

if (!$course_result) {
    die("Error: " . mysqli_error($connection));
}

if (!$level_result) {
    die("Error: " . mysqli_error($connection));
}

if (!$students_result) {
    die("Error: " . mysqli_error($connection));
}

if (!$feedback_result) {
    die("Error: " . mysqli_error($connection));
}

?>