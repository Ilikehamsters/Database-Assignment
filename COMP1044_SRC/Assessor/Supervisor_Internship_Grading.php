<?php require_once 'Supervisor_Grading_Logic.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Internship Grading</title>
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
                    <!-- from top to bottom: main page, internship result entry, result viewing -->
                    <li><a href="Supervisor_Page.php">Home</a></li>
                    <!-- "active" class to get some additional styling for clarity to know this is the current page -->
                    <li><a href="Supervisor_Internship_Grading.php" class="active">Grade Internship</a></li>
                    <li><a href="../Main_Result_Viewing.php">View Results</a></li>
                </ul>
            </div>

            <!-- righthand side of the nav bar -->
            <div class="nav-right">
                <ul class="nav-links">
                    <!-- for profile information -->
                    <li><a href="Supervisor_Profile.php">Profile</a></li>
                    <!-- for user to log out -->
                    <a href="../Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a>
                </ul>
            </div>
        </nav>
    </header>
        <h1 id="title">Internship Result Entry</h1>
                <form id="searchbar" method="post">
                    <!-- hidden field just to use in the logic php to tell the post method is for this search -->
                    <input type="hidden" name="action" value="search">

                    <h3 id="Searchtitle">Search (Student ID/Name):</h3>
                    <input list="student_ID" name="student_search" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search" required>
                    <datalist id="student_ID">
                        <?php
                            //get the students to be shown on the data list.
                            while ($row = $assigned_students->fetch_assoc()) { ?>
                                <!-- will be shown as "[id] - [name]" -->
                                <option value="<?= $row['Student_ID'] ?> - <?= $row['Full_Name'] ?>">
                        <?php } ?>
                    </datalist>
                    <button type="submit" class="searchbtn">Search</button>
                    <a href="Supervisor_Internship_Grading.php"><button type="button" class="searchbtn" style="background-color: #555;">Clear</button></a>
                </form>

        <main>
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

            <!-- for the internship details -->
            <section class="infoContainer">
                <h2 class="infoTitle">Internship Details</h2>
                <!-- make sure a student is found first -->
                <!-- also, the way this works is that the first student to be found will be what is shown on this page when you first cick on it -->
                <!-- other students can still be graded via the search bar -->
                <?php if ($current_student) { ?>
                <table>
                    <!-- each row will display two field information -->
                    <!-- firstHalf contains no padding so it aligns with the others. secondHalf has padding for more space -->
                    <!-- htmlspecialchars() is used so special characters are read as just text -->
                    <!-- in case for some reason the data has characters that'll affect the code -->
                    <tr>
                        <td class="firstHalf">Student ID</td>
                        <td><?= htmlspecialchars($current_student['Student_ID']) ?></td>
                        <td class="secondHalf">Student Name</td>
                        <td><?= htmlspecialchars($current_student['Full_Name']) ?></td>
                    </tr>
                    <tr>
                        <td class="firstHalf">Internship ID</td>
                        <td><?= htmlspecialchars($current_student['Internship_ID']) ?></td>
                        <td class="secondHalf">Company Name</td>
                        <td><?= htmlspecialchars($current_student['Reg_Comp_Name']) ?></td>
                    </tr>
                    <tr>
                        <td class="firstHalf">Start Date</td>
                        <td><?= htmlspecialchars($current_student['Start_Intern']) ?></td>
                        <td class="secondHalf">End Date</td>
                        <td><?= htmlspecialchars($current_student['End_Intern']) ?></td>
                    </tr>
                    <tr>
                        <td class="firstHalf">Status</td>
                        <!-- displays in green or red text depending on whether status is graded or not -->
                        <td style="color: <?= $is_graded ? 'green' : 'red' ?>; font-weight:bold;">
                            <?= htmlspecialchars($current_student['Status']) ?>
                        </td>
                    </tr>
                </table>
                <!-- if $currentstudent is false then it means there's no students. So send a message -->
                <?php } else { echo "<p>No results found.<br><br>Either you currently have no students assigned to you, or the search term had no match. Please only choose an option from the dropdown list in the search bar if possible.</p>"; } ?>
            </section>

            <!-- for the marking form -->
            <!-- check again since we still need to display the rest of the page -->
            <?php if ($current_student) { ?>
                <section class="infoContainer">
                    <h2 class="infoTitle">Marking Submission</h2>
                    <form method="post">
                        <!-- hidden field just to use in the logic php to tell the post method is for this form -->
                        <input type="hidden" name="action" value="submit_marks">
                        <!-- to tell the php which internship id to update for the form submission -->
                        <input type="hidden" name="internship_id" value="<?= $current_student['Internship_ID'] ?>">

                        <table style="width: 100%;">
                            <!-- each two row contains the mark and feedback input -->
                            <!-- the max values and sizes are also declared here for validation -->
                            <!-- fields/input which were previously graded cannot be edited, thus the $has_graded check -->
                            <!-- if available, the field/input will show marks/feedback the supervisor has previous entered -->
                            <!-- the inputs will be disabled if $has_graded is true -->
                            <!-- utp -->
                            <tr>
                                <td style="width: 80px;"><input class="inputMark" type="number" name="UTP" value="<?= $current_student['UTP'] ?>" min="0" max="10" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Undertaking Tasks/Projects (10%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="UTPfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['UTP_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- hsr -->
                            <tr>
                                <td><input class="inputMark" type="number" name="HSR" value="<?= $current_student['HSR'] ?>" min="0" max="10" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Health and Safety Requirements at the Workplace (10%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="HSRfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['HSR_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- cutk -->
                            <tr>
                                <td><input class="inputMark" type="number" name="CUTK" value="<?= $current_student['CUTK'] ?>" min="0" max="10" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Connectivity and Use of Theoretical Knowledge (10%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="CUTKfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['CUTK_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- pr -->
                            <tr>
                                <td><input class="inputMark" type="number" name="PR" value="<?= $current_student['PR'] ?>" min="0" max="15" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Presentation of the Report as a Written Document (15%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="PRfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['PR_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- cli -->
                            <tr>
                                <td><input class="inputMark" type="number" name="CLI" value="<?= $current_student['CLI'] ?>" min="0" max="10" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Clarity of Language and Illustration (10%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="CLIfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['CLI_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- lla -->
                            <tr>
                                <td><input class="inputMark" type="number" name="LLA" value="<?= $current_student['LLA'] ?>" min="0" max="15" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Lifelong Learning Activities (15%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="LLAfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['LLA_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- pm -->
                            <tr>
                                <td><input class="inputMark" type="number" name="PM" value="<?= $current_student['PM'] ?>" min="0" max="15" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Project Management (15%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="PMfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['PM_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- tm -->
                            <tr>
                                <td><input class="inputMark" type="number" name="TM" value="<?= $current_student['TM'] ?>" min="0" max="15" required <?= $has_graded ? 'disabled' : '' ?>></td>
                                <td>Time Management (15%)</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="TMfeedback" maxlength="254" rows="3" style="width: 100%; box-sizing: border-box;" placeholder="Enter feedback here (optional)..." <?= $has_graded ? 'disabled' : '' ?>><?= htmlspecialchars($current_student['TM_Feedback'] ?? '') ?></textarea>
                                </td>
                            </tr>

                            <!-- only show the form buttons if this internship hasn't been graded previously  -->
                            <?php if (!$has_graded) { ?>
                            <tr>
                                <td style="padding-top: 10px;"><button type="submit" class="formbtn">Submit</button></td>
                                <td style="padding-top: 10px;"><button type="reset" class="formbtn" style="background-color: #555;">Clear</button></td>
                            </tr>
                            <!-- else tell the user that this internship is graded already -->
                            <?php } else { ?>
                            <tr>
                                <td colspan="2" class="success">
                                    You have already submitted the marks for this student, the marks cannot be changed. The internship status will change to graded if the university assessor/lecturer has also graded this internship.
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </form>
                </section>
                <?php } ?>
            </section>
        </main>
    </body>
</html>