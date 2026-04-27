<?php require_once 'Internship_Management_Logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Internship Management</title>
    <link rel="stylesheet" href="../Global.css">
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
                <li><a href="Admin_Page.php">Home</a></li>
                <!-- "active" class to get some additional styling for clarity to know this is the current page -->
                <li><a href="Internship_Management.php" class="active">Manage Internship</a></li>
                <li><a href="Student_prof_manage.html">Manage Student</a></li>
                <li><a href="Staff_manage.html">Manage Lecturer</a></li>
                <li><a href="Supervisor_manage.html">Manage Supervisor</a></li>
                <li><a href="User_Access.html">Reset User Password</a></li>
                <li><a href="../Main_Result_Viewing.php">View Results</a></li>
            </ul>
        </div>

        <!-- righthand side of the nav bar -->
        <div class="nav-right">
            <ul class="nav-links">
                <!-- for user to log out -->
                <a href="../Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a>
            </ul>
        </div>
    </nav>
</header>
<main>
    <h1 id="title">Internship Management</h1>

    <!-- search bar -->
    <form id="searchbar" method="GET" action="Internship_Management.php">
        <h3 id="Searchtitle">Search (Student ID/Name):</h3>
        <!-- autocomplete="off" so that the user inputs don't get added to the bottom of the data list -->
        <!-- get the search term from the url if it's available. Basically so that if the user goes to the next page for a searched term, then it won't reset back to an empty search -->
        <input list="student_search_list" name="search" class="inputbox" autocomplete="off" placeholder="Type ID or Name" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <datalist id="student_search_list">
            <?php
                //get the students to be shown on the data list.
                $search_list = $conn->query("SELECT Student_ID, Full_Name FROM student");
                while ($row = $search_list->fetch_assoc()) { ?>
                    <!-- will be shown as "[id] - [name]" -->
                    <option value="<?= $row['Student_ID'] ?> - <?= $row['Full_Name'] ?>">
            <?php } ?>
        </datalist>
        <button type="submit" class="searchbtn">Search</button>
        <a href="Internship_Management.php"><button type="button" class="searchbtn">Clear</button></a>
    </form>

    <?php
        //show success or error messages if they exist.
        //unset to remove them after page refreshing.
        if(isset($_SESSION['success_msg'])) {
            echo "<div class='success'>" . $_SESSION['success_msg'] . "</div>";
            unset($_SESSION['success_msg']);
        }
        if(isset($_SESSION['error_msg'])) {
            echo "<div class='error'>" . $_SESSION['error_msg'] . "</div>";
            unset($_SESSION['error_msg']);
        }
    ?>

    <div class="infoContainer">
        <h2 class="infoTitle">Assign New Internship</h2>

        <!-- form to assign internship -->
        <form action="Internship_Management.php" method="POST">
            <!-- hidden field just to use in the logic php to tell the post method is for this form -->
            <input type="hidden" name="action" value="assign_internship">
            <input type="hidden" name="student_id" value="<?= $current_student['Student_ID'] ?>">

            <div class="form-grid">
                <!-- each form group is for one input field. the logic for each are more or less the same -->
                <!-- select student -->
                <div class="form-group">
                    <label>Select Student</label>
                    <input list="students" name="student_id" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search" required>
                    <!-- get the student's ids and names to be shown on the data list -->
                    <datalist id="students">
                        <?php while ($row = $students_list->fetch_assoc()) { ?>
                            <!-- will be shown as "[id] - [name]" -->
                            <option value="<?= $row['Student_ID'] ?> - <?= $row['Full_Name'] ?>">
                        <?php } ?>
                    </datalist>
                </div>

                <!-- select lecturer -->
                <div class="form-group">
                    <label>Select Lecturer</label>
                    <input list="assessors" name="staff_id" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search" required>
                    <datalist id="assessors">
                        <?php while ($row = $staff_list->fetch_assoc()) { ?>
                            <option value="<?= $row['Staff_ID'] ?> - <?= $row['Full_Name'] ?>">
                        <?php } ?>
                    </datalist>
                </div>

                <!-- select company -->
                <div class="form-group">
                    <label>Select Company</label>
                    <input list="companies" name="company_id" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search" required>
                    <datalist id="companies">
                        <?php while ($row = $companies_list->fetch_assoc()) { ?>
                            <option value="<?= $row['Company_ID'] ?> - <?= $row['Reg_Comp_Name'] ?>">
                        <?php } ?>
                    </datalist>
                </div>

                <!-- select supervisor -->
                <div class="form-group">
                    <label>Select Supervisor</label>
                    <input list="supervisors" name="supervisors_id" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search" required>
                    <datalist id="supervisors">
                        <?php while ($row = $supervisors_list->fetch_assoc()) { ?>
                            <option value="<?= $row['Supvr_ID'] ?> - <?= $row['Full_Name'] ?>">
                        <?php } ?>
                    </datalist>
                </div>

                <!-- select start and end date -->
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="inputbox" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="inputbox" required>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="searchbtn" style="width: 150px;">Assign Student</button>
            </div>
        </form>
    </div>

    <div class="infoContainer">
        <h2 class="infoTitle">Current Assignments</h2>
        <!-- will show all the internship records -->
        <table class="records-table">
            <thead>
            <tr>
                <!-- headings -->
                <th>Student Name</th>
                <th>Lecturer</th>
                <th>Company</th>
                <th>Supervisor</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                <!-- get all the needed data -->
                <!-- htmlspecialchars() is used so special characters are read as just text -->
                <!-- in case for some reason the data has characters that'll affect the code -->
                <?php if ($table_data->num_rows > 0) {
                    while ($row = $table_data->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['StudentName']) ?></td>
                            <td><?= htmlspecialchars($row['StaffName']) ?></td>
                            <td><?= htmlspecialchars($row['CompanyName']) ?></td>
                            <td><?= htmlspecialchars($row['SupvrName']) ?></td>
                            <td><?= $row['Start_Intern'] ?> to <?= $row['End_Intern'] ?></td>
                            <!-- colour is either green or red depending on whether the status field is graded or not -->
                            <td style="color: <?= $row['Status'] == 'Graded' ? 'green' : 'red' ?>; font-weight: bold;">
                                <?= $row['Status'] ?>
                            </td>
                        </tr>
                <?php } } else { ?>
                    <!-- text to show if no matches are found -->
                    <tr><td colspan="6" style="text-align: center;">No internship records found.</td></tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- buttons will show up if the table record has more than 1 page aka has more records -->
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
                    <a href="Internship_Management.php?page=<?= $page - 1 ?><?= $search_param ?>" class="page-btn">Previous</a>
                <?php } else { ?>
                    <!-- if currently on page 1, then show a disabled grey button -->
                    <span class="page-btn disabled">Previous</span>
                <?php } ?>

                <!-- page number -->
                <!-- will show up as "Page [current page] of [total pages]""-->
                <span class="page-indicator">Page <?= $page ?> of <?= $total_pages ?></span>

                <!-- next button -->
                <?php if ($page < $total_pages) { ?>
                    <!-- pass on the next page number and search term to the php file -->
                    <a href="Internship_Management.php?page=<?= $page + 1 ?><?= $search_param ?>" class="page-btn">Next</a>
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