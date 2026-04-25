<?php
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'uniAssessor') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}
?>
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
                    <li><a href="Lecturer_Page.php">Home</a></li>
                    <!-- "active" class to get some additional styling for clarity to know this is the current page -->
                    <li><a href="Lecturer_Internship_Grading.php" class="active">Grade Internship</a></li>
                    <li><a href="../Result_Viewing.html">View Results</a></li>
                </ul>
            </div>

            <!-- righthand side of the nav bar -->
            <div class="nav-right">
                <ul class="nav-links">
                    <!-- for profile information -->
                    <li><a href="Lecturer_Profile.php">Profile</a></li>
                    <!-- for user to log out -->
                    <li><a href="../Logout.php" class="logout-text"><button type="button" class="logoutbtn"><img src="../Assets/Logout.png" class="logoutIcon">Logout</button></a></li>
                </ul>
            </div>
        </nav>
    </header>
        <h1 id="title">Internship Result Entry</h1>
        <form id="searchbar" method="post">
            <h3 id="Searchtitle">Search (Student ID/Name):</h3>
            <input list="student_ID" class="inputbox" autocomplete="off" placeholder="Type ID or Name to Search">
            <datalist id="student_ID">
                <option value="20716333 - Yee Grace Shuang">
                <option value="1111111 - Ian Yap">
            </datalist>
            <button class="searchbtn">Search</button>
            <button class="searchbtn">Clear</button>
        </form>
        <main>
            <section class="infoContainer">
                <h2 class="infoTitle">Internship Details</h2>
                <table>
                    <tr>
                        <td>Student ID</td>
                        <td>Empty</td>
                        <td class="secondHalf">Student Name</td>
                        <td>Empty</td>
                    </tr>
                    <tr>
                        <td>Internship ID</td>
                        <td>None</td>
                        <td class="secondHalf">Company Code</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td>Unknown</td>
                        <td class="secondHalf">End Date</td>
                        <td>Unknown</td>
                    </tr>
                    <tr>
                        <td>Industry Marks</td>
                        <td>0</td>
                        <td class="secondHalf">University Marks</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Final Internship Marks</td>
                        <td>0</td>
                    </tr>
                </table>
            </section>
            <section class="infoContainer">
                <h2 class="infoTitle">Industrial Supervisor Marks</h2>

                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Marks</th>
                            <th class="tsecondHalf">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>UTP:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>HSR:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>CUTK:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>PR:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>CLI:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>LLA:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>PM:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                        <tr>
                            <td>TM:</td>
                            <td class="indMark">0</td>
                            <td class="tsecondHalf">N/A</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="infoContainer">
                <h2 class="infoTitle">Marking Submission</h2>
                <form method="post">
                    <table>
                        <tr>
                            <td>UTP</td>
                            <td><input class="inputMark" type="number" name="UTP" value="0" min="0" max="10" required></td>
                            <td><textarea name="UTPfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>HSR</td>
                            <td><input class="inputMark" type="number" name="HSR" value="0" min="0" max="10" required></td>
                            <td><textarea name="HSRfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>CUTK</td>
                            <td><input class="inputMark" type="number" name="CUTK" value="0" min="0" max="10" required></td>
                            <td><textarea name="CUTKfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>PR</td>
                            <td><input class="inputMark" type="number" name="PR" value="0" min="0" max="15" required></td>
                            <td><textarea name="PRfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>CLI</td>
                            <td><input class="inputMark" type="number" name="CLI" value="0" min="0" max="10" required></td>
                            <td><textarea name="CLIfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>LLA</td>
                            <td><input class="inputMark" type="number" name="LLA" value="0" min="0" max="15" required></td>
                            <td><textarea name="LLAfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>PM</td>
                            <td><input class="inputMark" type="number" name="PM" value="0" min="0" max="15" required></td>
                            <td><textarea name="PMfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td>TM</td>
                            <td><input class="inputMark" type="number" name="TM" value="0" min="0" max="15" required></td>
                            <td><textarea name="TMfeedback" rows="15" cols="100" maxlength="1000" placeholder="Enter feedback here (optional)..."></textarea></td>
                        </tr>
                        <tr>
                            <td><input class="formbtn" type="submit" value="Submit"></td>
                            <td><input class="formbtn" type="reset" value="Clear"></td>
                        </tr>
                    </table>
                </form>
            </section>
            <article>
                <table id="navposition">
                    <tr>
                        <td><button type="button" class="navbtn"><img src="../Assets/LeftArrow.svg" alt="Previous button" id="prevNAV"></button></td>
                        <td id="recordCount">1</td>
                        <td><button type="button" class="navbtn"><img src="../Assets/RightArrow.svg" alt="Next button" id="nextNAV"></button></td>
                    </tr>
                    <tr>
                        <td class="navlabel">Previous</td>
                        <td></td>
                        <td class="navlabel">Next</td>
                    </tr>
                </table>
            </article>
        </main>
        <script>
            const params = new URLSearchParams(window.location.search);
            if (params.get("login") == "success") {
                alert("Login successful! Welcome!");
                // Clean the URL so refreshing doesn't re-trigger the alert
                window.history.replaceState({}, document.title, window.location.pathname);
            }
            let count = 1;
            const leftnav = document.getElementById("prevNAV");
            const rightnav = document.getElementById("nextNAV");
            const counter = document.getElementById("recordCount");
            function DECrecordNum() {
                count--;
                if (count < 1) {
                    count = 1;
                    counter.textContent = count;
                }
                else {
                    counter.textContent = count;
                }
            }
            function ADDrecordNum() {
                count++;
                counter.textContent = count;
            }

            leftnav.addEventListener("click", DECrecordNum);
            rightnav.addEventListener("click", ADDrecordNum);


        </script>
    </body>
</html>