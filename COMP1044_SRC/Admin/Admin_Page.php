<?php
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="../Global.css">
        <link rel="stylesheet" href="../Home_page.css">
    </head>

    <body>
        <header>
            <nav class="navbar">
                <!-- lefthand side of the nav bar -->
                <div class="nav-left">
                    <!-- show the umn logo -->
                    <img src="../Assets/UNMLogo.png" alt="UMN Logo" class="nav-logo">
                    <!-- all the lefthand side links -->
                    <ul class="nav-links">
                        <!-- from top to bottom: main page, user management, internship management, result viewing, student profiles -->
                        <li><a href="Admin_Page.php" class="active">Home</a></li>
                        <li><a href="User_Access.html">Manage User</a></li>
                        <li><a href="Internship_Management.php">Manage Internship</a></li>
                        <li><a href="../Result_Viewing.html">View Results</a></li>
                        <li><a href="Student_Profile.html">Student Profiles</a></li>
                    </ul>
                </div>

                <!-- righthand side of the nav bar -->
                <div class="nav-right">
                    <!-- for user to log out -->
                    <a href="../Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a>
                </div>
            </nav>
        </header>
        <main>
            <h1 id="title">Welcome, Admin!</h1>

            <div class="card-container">

                <!-- card to lead to manage users -->
                <a href="User_Access.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/ManageUsers.png" alt="Manage Users">
                    </div>
                    <div class="card-text">
                        <h3>Manage Users</h3>
                        <p>Manage student and assessor accounts.</p>
                    </div>
                </a>

                <!-- card to manage internships -->
                <a href="Internship_Management.php" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/ManageInternship.png" alt="Manage Internships">
                    </div>
                    <div class="card-text">
                        <h3>Manage Internships</h3>
                        <p>Assign students to internships.</p>
                    </div>
                </a>

                <!-- card to view internship results -->
                <a href="result_viewing.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/ViewResults.png" alt="View Results">
                    </div>
                    <div class="card-text">
                        <h3>View Results</h3>
                        <p>View the internship marks for students.</p>
                    </div>
                </a>

                <!-- card to view student profiles -->
                <a href="Student_Profile.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/StudentProfile.png" alt="Student Profiles">
                    </div>
                    <div class="card-text">
                        <h3>View Student Profiles</h3>
                        <p>View the student's profiles.</p>
                    </div>
                </a>

            </div>
        </main>
        <script>
            const params = new URLSearchParams(window.location.search);
            if (params.get("login") == "success") {
                alert("Login successful! Welcome!");
                // Clean the URL so refreshing doesn't re-trigger the alert
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (params.get("redirect") == "success") {
                alert("You're being redirected to the home page as you are currently logged into an account. Please ensure you are logged into the correct role if you were previously trying to access a different page.");
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        </script>
    </body>
</html>