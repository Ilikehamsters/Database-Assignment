<?php require_once 'Get_Main_Result_Viewing.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Result Viewing</title>
    <link rel="stylesheet" href="Global.css">
    <link rel="stylesheet" href="Result_Viewing.css">
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
                <?php } ?>
                <li><a href="Main_Result_Viewing.php" class="active">View Results</a></li>
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
    <h1 id="title">Result Viewing</h1>

    <!-- the search bar -->
    <form id="searchbar" method="GET" action="Main_Result_Viewing.php">
        <h3 id="Searchtitle">Search (Student ID/Name):</h3>
        <!-- autocomplete="off" so that the user input don't get added to the bottom of the data list -->
        <!-- get the search term from the url if it's available. Basically so that if the user goes to the next page for a searched term, then it won't reset back to an empty search -->
        <input list="student_search_list" name="search" class="inputbox" autocomplete="off" placeholder="Type ID or Name" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <datalist id="student_search_list">
            <?php
                //get the students to be shown on the data list.
                while ($row = $valid_students->fetch_assoc()) { ?>
                    <!-- will be shown as "[id] - [name]" -->
                    <option value="<?= $row['Student_ID'] ?> - <?= $row['Full_Name'] ?>">
            <?php } ?>
        </datalist>
        <!-- search and clear button-->
        <button type="submit" class="searchbtn">Search</button>
        <a href="Main_Result_Viewing.php"><button type="button" class="searchbtn">Clear</button></a>
    </form>

    <!-- the result table -->
    <div class="infoContainer">
        <h2 class="infoTitle">Results Dashboard</h2>
        <!-- records-table for the colours. results-table for formatting -->
        <table class="records-table results-table">
            <!-- headers -->
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>UTP</th>
                    <th>HSR</th>
                    <th>CUTK</th>
                    <th>PR</th>
                    <th>CLI</th>
                    <th>LLA</th>
                    <th>PM</th>
                    <th>TM</th>
                    <th style="background-color: #0b0b45;">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- start to add the result rows if there's at least one result found -->
                <?php if ($table_data->num_rows > 0) {
                    while ($row = $table_data->fetch_assoc()) { ?>
                        <!-- the mouse will change to the pointing symbol when hovering -->
                        <!-- the row colour will also change on hover -->
                        <!-- clicking on a row will bring the user to the detailed/single internship view of the chosen student -->
                        <!-- i thought inline style would be better for this instead of the css since it's a one-time thing anyway-->
                        <tr style="cursor: pointer;" onmouseover="this.style.backgroundColor='#e6f0ff';" onmouseout="this.style.backgroundColor='';" onclick="window.location.href='Result_Viewing.php?id=<?= $row['Internship_ID'] ?>'">
                            <!-- show the student and company name -->
                            <td><?= htmlspecialchars($row['StudentName']) ?></td>
                            <td><?= htmlspecialchars($row['CompanyName']) ?></td>
                            <!-- show the grading status. The text colour is green if the status is graded, read otherwise -->
                            <td style="color: <?= $row['Status'] == 'Graded' ? 'green' : 'red' ?>; font-weight: bold;">
                                <?= $row['Status'] ?>
                            </td>

                            <!-- show the average assessment marks if the internship status is graded -->
                            <!-- along with the final total mark in bold -->
                            <?php if ($row['Status'] == 'Graded') { ?>
                                <!-- also add a % at the end -->
                                <td><?= number_format($row['avg_UTP'], 1) ?>%</td>
                                <td><?= number_format($row['avg_HSR'], 1) ?>%</td>
                                <td><?= number_format($row['avg_CUTK'], 1) ?>%</td>
                                <td><?= number_format($row['avg_PR'], 1) ?>%</td>
                                <td><?= number_format($row['avg_CLI'], 1) ?>%</td>
                                <td><?= number_format($row['avg_LLA'], 1) ?>%</td>
                                <td><?= number_format($row['avg_PM'], 1) ?>%</td>
                                <td><?= number_format($row['avg_TM'], 1) ?>%</td>
                                <td style="font-weight: bold;">
                                    <?= number_format($row['FinalMark'], 1) ?>%
                                </td>
                            <!-- else the grading isn't finished, so tell the user -->
                            <?php } else { ?>
                                <td colspan="9" style="color: #888;">Still waiting for the grading to be done...</td>
                            <?php } ?>
                        </tr>
                <!-- else no results are found, so tell the user -->
                <?php } } else { ?>
                    <tr><td colspan="12" style="text-align: center; padding: 20px;">No results found.</td></tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- buttons will show up if the table record has more than 1 page aka has more results -->
        <?php if ($total_pages > 1) {
            //keep the search term in the url when changing pages
            //so that users can go through the pages of the searched term without it resetting back to everyone.
            $search_param = isset($_GET['search']) ? "&search=" . urlencode($_GET['search']) : "";
        ?>
            <div class="page">

                <!-- previous button -->
                <!-- makes sure this isn't the first page so that the user can go back -->
                <?php if ($page > 1) { ?>
                    <!-- pass on the previous page number and search term to the php file -->
                    <!-- so that the correct rows can be selected -->
                    <a href="Main_Result_Viewing.php?page=<?= $page - 1 ?><?= $search_param ?>" class="page-btn">Previous</a>
                <?php } else { ?>
                    <!-- else it's the first page, so disable the button -->
                    <span class="page-btn disabled">Previous</span>
                <?php } ?>

                <!-- page number -->
                <!-- will show up as "Page [current page] of [total pages]""-->
                <span class="page-indicator">Page <?= $page ?> of <?= $total_pages ?></span>

                <!-- next button -->
                <?php if ($page < $total_pages) { ?>
                    <!-- pass on the next page number and search term to the php file -->
                    <a href="Main_Result_Viewing.php?page=<?= $page + 1 ?><?= $search_param ?>" class="page-btn">Next</a>
                <?php } else { ?>
                    <!-- if on last page, then show a disabled grey button -->
                    <span class="page-btn disabled">Next</span>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
</main>
</body>
</html>