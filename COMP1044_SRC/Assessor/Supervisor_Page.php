<?php
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'indSuperv') {
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
                <!-- from top to bottom: main page, internship result entry, result viewing -->
                <li><a href="Supervisor_Page.html" class="active">Home</a></li>
                <li><a href="Supervisor_Internship_Grading.php">Grade Internship</a></li>
                <li><a href="../Result_Viewing.html">View Results</a></li>
            </ul>
        </div>

        <!-- righthand side of the nav bar -->
        <div class="nav-right">
            <ul class="nav-links">
                <!-- for profile information -->
                <li><a href="Supervisor_Profile.php">Profile</a></li>
                <!-- for user to log out -->
                <li><a href="../Login_page.php"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a></li>
            </ul>
        </div>
    </nav>
</header>
<main>
    <h1 id="title">Welcome, Supervisor!</h1>

    <div class="card-container">

        <!-- card to lead to grading internships -->
        <a href="Supervisor_Internship_Grading.php" class="feature-card">
            <div class="card-image">
                <img src="../Assets/InternshipGrading.png" alt="Grade Internship">
            </div>
            <div class="card-text">
                <h3>Grade Internship</h3>
                <p>Enter the marks for the student's internships.</p>
            </div>
        </a>

        <!-- card to lead to view results -->
        <a href="Result_Viewing.html" class="feature-card">
            <div class="card-image">
                <img src="../Assets/ViewResults.png" alt="View Results">
            </div>
            <div class="card-text">
                <h3>View Results</h3>
                <p>View the internship marks for the students assigned to you.</p>
            </div>
        </a>

        <!-- card to lead to view profile -->
        <a href="Supervisor_Profile.php" class="feature-card">
            <div class="card-image">
                <img src="../Assets/Profile.jpg" alt="Profile">
            </div>
            <div class="card-text">
                <h3>Profile</h3>
                <p>View your profile information.</p>
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