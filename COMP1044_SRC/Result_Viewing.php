<?php require_once 'Get_Result_Viewing.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detailed Result Breakdown</title>
    <link rel="stylesheet" href="Global.css">

</head>

<body>
<header>
    <nav class="navbar">
        <!-- lefthand side of the nav bar -->
        <div class="nav-left">
            <!-- show the umn logo -->
            <img src="Assets/UNMLogo.png" alt="UMN Logo" class="nav-logo">
            <ul class="nav-links">
                <!-- show the correct navigation links based on which role is the user -->
                <?php if ($_SESSION['Role'] == 'Admin') { ?>
                    <li><a href="Admin/Admin_Page.php">Home</a></li>
                    <li><a href="Admin/Internship_Management.php">Manage Internship</a></li>
                    <li><a href="Admin/Student_prof_manage.html">Manage Student</a></li>
                    <li><a href="Admin/Staff_manage.html">Manage Staff</a></li>
                    <li><a href="Admin/Supervisor_manage.html">Manage Supervisor</a></li>
                    <li><a href="Admin/User_Access.html">Reset User Password</a></li>
                <?php } elseif ($_SESSION['Role'] == 'University Assessor') { ?>
                    <li><a href="Assessor/Lecturer_Page.php">Home</a></li>
                    <li><a href="Assessor/Lecturer_Profile.php">Profile</a></li>
                    <li><a href="Assessor/Lecturer_Internship_Grading.php">Grade Internship</a></li>
                <?php } elseif ($_SESSION['Role'] == 'Industrial Supervisor') { ?>
                    <li><a href="Assessor/Supervisor_Page.php">Home</a></li>
                    <li><a href="Assessor/Supervisor_Profile.php">Profile</a></li>
                    <li><a href="Assessor/Supervisor_Internship_Grading.php">Grade Internship</a></li>
                <?php } elseif ($_SESSION['Role'] == 'Student') { ?>
                    <li><a href="Student/Student_Page.php">Home</a></li>
                    <li><a href="Student/Student_Profile.php">Profile</a></li>
                <?php } ?>

                <li><a href="Result_Viewing.php" class="active">View Results</a></li>
            </ul>
        </div>
        <!-- righthand side of the nav bar -->
        <div class="nav-right">
            <ul class="nav-links">
                <!-- for user to log out -->
                <a href="Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="Assets/Logout.png" class="logoutIcon">Logout</button></a>
            </ul>
        </div>
    </nav>
</header>

<main>
    <h1 id="title">Detailed Result Breakdown</h1>

    <!-- for the internship details -->
    <!-- htmlspecialchars() is used so special characters are read as just text -->
    <!-- in case for some reason the data has characters that'll affect the code -->
    <section class="infoContainer">
        <h2 class="infoTitle">Internship Details</h2>
        <table>
            <!-- each row will display two field information -->
            <!-- firstHalf contains no padding so it aligns with the others. secondHalf has padding for more space -->
            <tr>
                <td class="firstHalf">Student ID</td>
                <td><?= htmlspecialchars($details['Student_ID']) ?></td>
                <td class="secondHalf">Student Name</td>
                <td><?= htmlspecialchars($details['StudentName']) ?></td>
            </tr>
            <tr>
                <td class="firstHalf">Internship ID</td>
                <td><?= htmlspecialchars($details['Internship_ID']) ?></td>
                <td class="secondHalf">Company Name</td>
                <td><?= htmlspecialchars($details['CompanyName']) ?></td>
            </tr>
            <tr>
                <td class="firstHalf">Start Date</td>
                <td><?= htmlspecialchars($details['Start_Intern']) ?></td>
                <td class="secondHalf">End Date</td>
                <td><?= htmlspecialchars($details['End_Intern']) ?></td>
            </tr>
            <tr>
                <td class="firstHalf">Status</td>
                <!-- displays in green or red text depending on whether status is graded or not -->
                <td style="color: <?= $details['Status'] == 'Graded' ? 'green' : 'red' ?>; font-weight:bold;">
                    <?= htmlspecialchars($details['Status']) ?>
                </td>
            </tr>
        </table>
    </section>

        <!-- supervisor marks/feedback -->
        <section class="infoContainer">
            <h2 class="infoTitle">Industrial Supervisor Assessment</h2>
            <?php
               //check if supervisor has graded via making sure that their mark results aren't empty
               //and that the utp mark is not the default 0.00 or that the feedback is not null.
               //as when a form is submitted, the empty feedback field will become "" instead of null.
               //the logic is basically that since all the mark fields are compulsory, if one mark isn't graded, then it means the form hasn't been submitted yet.
               //the feedback is in case the user just decides to mark the utp as 0.00.
                $inds_has_graded = $inds_marks && ($inds_marks['UTP'] != 0.00 || $inds_marks['UTP_Feedback'] !== null);
                if ($inds_has_graded) {
            ?>
                <table class="markTable">
                    <thead>
                        <!-- headers -->
                        <tr style="border-bottom: 2px solid #ddd;">
                            <th style="width: 100px;"></th>
                            <th style="width: 120px; text-align: center;">Marks</th>
                            <th style="text-align: left; padding-left: 30px;">Feedback</th>
                        </tr>
                    </thead>
                    <!-- all the mark and feedback -->
                    <tbody>
                        <!-- utp -->
                        <tr>
                            <td class="firstHalf">UTP</td>
                            <td class="textfirstHalf"><?= $inds_marks['UTP'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['UTP_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- hsr -->
                        <tr>
                            <td class="firstHalf">HSR</td>
                            <td class="textfirstHalf"><?= $inds_marks['HSR'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['HSR_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- cutk -->
                        <tr>
                            <td class="firstHalf">CUTK</td>
                            <td class="textfirstHalf"><?= $inds_marks['CUTK'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['CUTK_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- pr -->
                        <tr>
                            <td class="firstHalf">PR</td>
                            <td class="textfirstHalf"><?= $inds_marks['PR'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['PR_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- cli -->
                        <tr>
                            <td class="firstHalf">CLI</td>
                            <td class="textfirstHalf"><?= $inds_marks['CLI'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['CLI_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- lla -->
                        <tr>
                            <td class="firstHalf">LLA</td>
                            <td class="textfirstHalf"><?= $inds_marks['LLA'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['LLA_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- pm -->
                        <tr>
                            <td class="firstHalf">PM</td>
                            <td class="textfirstHalf"><?= $inds_marks['PM'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['PM_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- tm -->
                        <tr>
                            <td class="firstHalf">TM</td>
                            <td class="textfirstHalf"><?= $inds_marks['TM'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($inds_marks['TM_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- else tell the user they're waiting for the marking submission -->
                <?php } else { ?>
                    <p class="error">
                        Marks pending. The industry supervisor has not submitted their marking yet.
                    </p>
                <?php } ?>
        </section>

        <!-- lecturer marks/feedback -->
        <section class="infoContainer">
            <h2 class="infoTitle">University Assessor Assessment</h2>
            <?php
                //check if lecturer has graded. Same checking logic as the supervisor's.
                $uni_has_graded = $uni_marks && ($uni_marks['UTP'] != 0.00 || $uni_marks['UTP_Feedback'] !== null);
                if ($uni_has_graded) {
            ?>
                <table class="markTable">
                    <thead>
                        <tr style="border-bottom: 2px solid #ddd;">
                            <th style="width: 100px;"></th>
                            <th style="width: 120px; text-align: center;">Marks</th>
                            <th style="text-align: left; padding-left: 30px;">Feedback</th>
                        </tr>
                    </thead>
                    <!-- all the mark and feedback -->
                    <tbody>
                        <!-- utp -->
                        <tr>
                            <td class="firstHalf">UTP</td>
                            <td class="textfirstHalf"><?= $uni_marks['UTP'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['UTP_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- hsr -->
                        <tr>
                            <td class="firstHalf">HSR</td>
                            <td class="textfirstHalf"><?= $uni_marks['HSR'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['HSR_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- cutk -->
                        <tr>
                            <td class="firstHalf">CUTK</td>
                            <td class="textfirstHalf"><?= $uni_marks['CUTK'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['CUTK_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- pr -->
                        <tr>
                            <td class="firstHalf">PR</td>
                            <td class="textfirstHalf"><?= $uni_marks['PR'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['PR_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- cli -->
                        <tr>
                            <td class="firstHalf">CLI</td>
                            <td class="textfirstHalf"><?= $uni_marks['CLI'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['CLI_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- lla -->
                        <tr>
                            <td class="firstHalf">LLA</td>
                            <td class="textfirstHalf"><?= $uni_marks['LLA'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['LLA_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- pm -->
                        <tr>
                            <td class="firstHalf">PM</td>
                            <td class="textfirstHalf"><?= $uni_marks['PM'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['PM_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                        <!-- tm -->
                        <tr>
                            <td class="firstHalf">TM</td>
                            <td class="textfirstHalf"><?= $uni_marks['TM'] ?></td>
                            <td class="textsecondHalf"><?= htmlspecialchars($uni_marks['TM_Feedback'] ?: 'N/A') ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- else tell the user they're waiting for the marking submission -->
                <?php } else { ?>
                    <p class="error">
                        Marks pending. The university accessor/lecturer has not submitted their marking yet.
                    </p>
                <?php } ?>
        </section>

        <!-- the final aka average mark -->
        <!-- make sure the status is graded aka both supervisor and lecturer has marked -->
        <!-- since we need their average -->
        <?php if ($details['Status'] === 'Graded') {
            //calculate the average for each assessment
            $avg_UTP = ($inds_marks['UTP'] + $uni_marks['UTP']) / 2;
            $avg_HSR = ($inds_marks['HSR'] + $uni_marks['HSR']) / 2;
            $avg_CUTK = ($inds_marks['CUTK'] + $uni_marks['CUTK']) / 2;
            $avg_PR = ($inds_marks['PR'] + $uni_marks['PR']) / 2;
            $avg_CLI = ($inds_marks['CLI'] + $uni_marks['CLI']) / 2;
            $avg_LLA = ($inds_marks['LLA'] + $uni_marks['LLA']) / 2;
            $avg_PM = ($inds_marks['PM'] + $uni_marks['PM']) / 2;
            $avg_TM = ($inds_marks['TM'] + $uni_marks['TM']) / 2;
            //add up all the average for the total.
            $final_total = $avg_UTP + $avg_HSR + $avg_CUTK + $avg_PR + $avg_CLI + $avg_LLA + $avg_PM + $avg_TM;
        ?>
            <section class="infoContainer">
                <h2 class="infoTitle">Final Internship Score Calculation</h2>
                <table class="markTable">
                    <thead>
                        <!-- headers -->
                        <tr style="border-bottom: 2px solid #ddd;">
                            <th style="width: 20%;">Assessment Weightage</th>
                            <th style="width: 30%; text-align: center;">Industrial Supervisor</th>
                            <th style="width: 30%; text-align: center;">University Assessor</th>
                            <th style="width: 30%; text-align: center;">Average Score</th>
                        </tr>
                    </thead>
                    <!-- all the marks -->
                    <tbody>
                        <!-- utp -->
                        <tr>
                            <td class="firstHalf">UTP (10%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['UTP'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['UTP'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_UTP, 1) ?>%</td>
                        </tr>
                        <!-- hsr -->
                        <tr>
                            <td style="font-weight: bold;">HSR (10%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['HSR'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['HSR'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_HSR, 1) ?>%</td>
                        </tr>
                        <!-- cutk -->
                        <tr>
                            <td style="font-weight: bold;">CUTK (10%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['CUTK'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['CUTK'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_CUTK, 1) ?>%</td>
                        </tr>
                        <!-- pr -->
                        <tr>
                            <td style="font-weight: bold;">PR (15%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['PR'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['PR'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_PR, 1) ?>%</td>
                        </tr>
                        <!-- cli -->
                        <tr>
                            <td style="font-weight: bold;">CLI (10%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['CLI'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['CLI'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_CLI, 1) ?>%</td>
                        </tr>
                        <!-- lla -->
                        <tr>
                            <td style="font-weight: bold;">LLA (15%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['LLA'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['LLA'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_LLA, 1) ?>%</td>
                        </tr>
                        <!-- pm -->
                        <tr>
                            <td style="font-weight: bold;">PM (15%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['PM'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['PM'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_PM, 1) ?>%</td>
                        </tr>
                        <!-- tm -->
                        <tr>
                            <td style="font-weight: bold;">TM (15%)</td>
                            <td class="textfirstHalf"><?= $inds_marks['TM'] ?>%</td>
                            <td class="textfirstHalf"><?= $uni_marks['TM'] ?>%</td>
                            <td class="textfirstHalf"><?= number_format($avg_TM, 1) ?>%</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold; font-size: 24px;">Total Final Score:</td>
                            <td class="textfirstHalf" style="font-weight: bold; font-size: 24px;"><?= number_format($final_total, 1) ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        <!-- else tell the user they're waiting for the marking submission -->
        <?php } else { ?>
            <p class="error" style="text-align: center;">
                The final internship score will be calculated once the university assessor/lecturer completes their grading.
            </p>
        <?php } ?>

</main>
</body>
</html>