<?php require_once 'Get_Student_Profile.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../Global.css">
    <link rel="stylesheet" href="../Profile_Page.css">
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
                <!-- from top to bottom: main page, result viewing -->
                <li><a href="Student_Page.php">Home</a></li>
                <li><a href="../Result_Viewing.html">View Results</a></li>
            </ul>
        </div>

        <!-- righthand side of the nav bar -->
        <div class="nav-right">
            <ul class="nav-links">
                <!-- for profile information -->
                <li><a href="Student_Profile.php" class="active">Profile</a></li>
                <!-- for user to log out -->
                <a href="../Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a>
            </ul>
        </div>
    </nav>
</header>

<main>
    <h1 id="title">User Profile</h1>

    <div class="infoContainer">

        <h2 class="profile-name"><?= htmlspecialchars($profile['Full_Name']) ?></h2>

        <!-- all the account info -->
        <div class="form-grid">
            <div class="detail-group">
                <span class="detail-label">Student ID</span>
                <!-- get the Student_ID field from the $profile array -->
                <div class="detail-value"><?= htmlspecialchars($profile['Student_ID']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Full Name</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Full_Name']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Email Address</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Email_Addr']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Contact Number</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Contact_No.']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Enrolled Programme</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Programme_Name']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Enrollment Date</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Enroll_Date']) ?></div>
            </div>
        </div>

    </div>
</main>

</body>
</html>