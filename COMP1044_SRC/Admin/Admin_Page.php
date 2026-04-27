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
                        <!-- from top to bottom: main page, internship management, student management, staff aka lecturer/admin management, supervisor management, reset user password, result viewing -->
                        <li><a href="Admin_Page.php" class="active">Home</a></li>
                        <li><a href="Internship_Management.php">Manage Internship</a></li>
                        <li><a href="Student_prof_manage.html">Manage Student</a></li>
                        <li><a href="Staff_manage.html">Manage Staff</a></li>
                        <li><a href="Supervisor_manage.html">Manage Supervisor</a></li>
                        <li><a href="User_Access.html">Reset User Password</a></li>
                        <li><a href="../Main_Result_Viewing.php">View Results</a></li>
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

                <!-- card to view manage student -->
                <a href="Student_prof_manage.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/StudentProfile.png" alt="Manage Student">
                    </div>
                    <div class="card-text">
                        <h3>Manage Student Profiles</h3>
                        <p>Manage the student's profiles.</p>
                    </div>
                </a>

                <!-- card to view manage staff -->
                <a href="Staff_manage.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/StudentProfile.png" alt="Manage Staff">
                    </div>
                    <div class="card-text">
                        <h3>Manage Staff Profiles</h3>
                        <p>Manage the lecturer's and admin's profiles.</p>
                    </div>
                </a>

                <!-- card to view manage supervisor -->
                <a href="Supervisor_manage.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/StudentProfile.png" alt="Manage Supervisor">
                    </div>
                    <div class="card-text">
                        <h3>Manage Supervisor Profiles</h3>
                        <p>Manage the supervisor's profiles.</p>
                    </div>
                </a>

                <!-- card to lead to reset password -->
                <a href="User_Access.html" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/ManageUsers.png" alt="Reset User Password">
                    </div>
                    <div class="card-text">
                        <h3>Reset User Password</h3>
                        <p>Manage student and assessor accounts.</p>
                    </div>
                </a>

                <!-- card to view internship results -->
                <a href="../Main_Result_Viewing.php" class="feature-card">
                    <div class="card-image">
                        <img src="../Assets/ViewResults.png" alt="View Results">
                    </div>
                    <div class="card-text">
                        <h3>View Results</h3>
                        <p>View the internship marks for students.</p>
                    </div>
                </a>

            </div>
        </main>
        <script>
            //show an alert greeting the user based on either a login success or redirection.
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