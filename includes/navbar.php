<!DOCTYPE html>
<html>
    <head>
        <?php include_once 'includes/header.php'; ?>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="index.php" style="margin-left: 20px;">Home</a>
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#PageNavBar">
                <!-- Toggler Icon -->
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible Navbar -->
            <div class="collapse navbar-collapse" id="PageNavBar">
                <!-- Navbar Links -->
                <ul class="navbar-nav">
                    <?php
                    # Checks if the user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="enrol.php">Enrol</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </body>
</html>

