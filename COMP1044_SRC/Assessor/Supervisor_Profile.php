<?php require_once 'Get_Supervisor_Profile.php'; ?>
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
                <!-- from top to bottom: main page, internship result entry, result viewing and profile information -->
                <li><a href="Supervisor_Page.php">Home</a></li>
                <li><a href="Supervisor_Profile.php" class="active">Profile</a></li>
                <li><a href="Supervisor_Internship_Grading.php">Grade Internship</a></li>
                <li><a href="../Main_Result_Viewing.php">View Results</a></li>
            </ul>
        </div>

        <!-- righthand side of the nav bar -->
        <div class="nav-right">
            <ul class="nav-links">
                <!-- for user to log out -->
                <li><a href="../Logout.php"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a></li>
            </ul>
        </div>
    </nav>
</header>

<main>
    <h1 id="title">User Profile</h1>

    <div class="infoContainer">
        <!-- htmlspecialchars() is used so special characters are read as just text -->
        <!-- in case for some reason the data has characters that'll affect the code -->
        <h2 class="profile-name"><?= htmlspecialchars($profile['Full_Name']) ?></h2>

        <!-- all the account info -->
        <div class="form-grid">
            <div class="detail-group">
                <span class="detail-label">Supervisor ID</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Supvr_ID']) ?></div>
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
                <div class="detail-value"><?= htmlspecialchars($profile['Contact_No']) ?></div>
            </div>

            <div class="detail-group">
                <span class="detail-label">Company Name</span>
                <div class="detail-value"><?= htmlspecialchars($profile['Reg_Comp_Name']) ?></div>
            </div>
        </div>

    </div>
</main>

</body>
</html>