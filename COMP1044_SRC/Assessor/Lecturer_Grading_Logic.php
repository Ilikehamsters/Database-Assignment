<?php
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'University Assessor') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}

//connect to the database.
require_once '../global.php';

//get this lecturer's id based on their user id.
$user_id = $_SESSION['User_ID'];
$stmt = $conn->prepare("SELECT Staff_ID FROM uni_staff WHERE User_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$staff = $stmt->get_result()->fetch_assoc();
$staff_id = $staff['Staff_ID'];
$stmt->close();

//for the form aka grading.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'submit_marks') {
    //get the internship id of this student.
    $internship_id = $_POST['internship_id'];

    //only update the assessment row that belongs to the supervisor aka has "INDS" in the id.
    //since each internship id will have 2 assessments. one by lecturer and other by supervisor.
    $update_query = "UPDATE assessment SET
                     UTP=?, UTP_Feedback=?, HSR=?, HSR_Feedback=?, CUTK=?, CUTK_Feedback=?,
                     PR=?, PR_Feedback=?, CLI=?, CLI_Feedback=?, LLA=?, LLA_Feedback=?,
                     PM=?, PM_Feedback=?, TM=?, TM_Feedback=?
                     WHERE Internship_ID=? AND Assessment_ID LIKE '___UNI%'";
    //prepare to submit the data.
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("dsdsdsdsdsdsdsdss",
        $_POST['UTP'], $_POST['UTPfeedback'], $_POST['HSR'], $_POST['HSRfeedback'],
        $_POST['CUTK'], $_POST['CUTKfeedback'], $_POST['PR'], $_POST['PRfeedback'],
        $_POST['CLI'], $_POST['CLIfeedback'], $_POST['LLA'], $_POST['LLAfeedback'],
        $_POST['PM'], $_POST['PMfeedback'], $_POST['TM'], $_POST['TMfeedback'],
        $internship_id);

    if ($stmt_update->execute()) {
        //change the status of this internship to graded since the lecturer graded
        //and the lecturer being able to grade means the supervisor already graded too
        //so both assessors have graded.
        $status_update = $conn->prepare("UPDATE internship SET Status = 'Graded' WHERE Internship_ID = ?");
        $status_update->bind_param("s", $internship_id);
        $status_update->execute();
        //save the message to the session for Supervisor_Grading_Logic.php.php to show.
        //either a success or error message (see the else statement) depending on whether the execute is successful.
        $_SESSION['success_msg'] = "Marks submitted successfully! The internship is now officially graded.";
    } else {
        $_SESSION['error_msg'] = "Error! Something is wrong with the database. The marks have not been saved.";
    }

    //get the student id linked to this internship id.
    //needed so we can later put the id in the url for page refreshes.
    $get_stud = $conn->prepare("SELECT Student_ID FROM internship WHERE Internship_ID = ?");
    $get_stud->bind_param("s", $internship_id);
    $get_stud->execute();
    $stud_row = $get_stud->get_result()->fetch_assoc();
    $student_for_url = $stud_row['Student_ID'];
    $get_stud->close();

    //reload the page and also include the student id in the url.
    //so that after reloading, the internship being viewed is still the same student's.
    header("Location: Lecturer_Internship_Grading.php?student=" . urlencode($student_for_url));
    exit();
}

$target_student_id = null;
//determine which student to show based on whether the user used the search bar or not.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'search') {
    //if the search bar is used then the student id is based on the one in the search bar.
    $parts = explode(" - ", $_POST['student_search']);
    $target_student_id = $parts[0];
} elseif (isset($_GET['student'])) {
    //else it means the user probably just submitted grades and the page reloaded.
    //so just go with the current student.
    $target_student_id = $_GET['student'];
}

//get the student data. If it's empty then the first one will be selected, aka the else statement.
if ($target_student_id) {
    $details_query = "SELECT i.*, s.Full_Name, a.*, c.Reg_Comp_Name
                      FROM internship i
                      JOIN student s ON i.Student_ID = s.Student_ID
                      JOIN assessment a ON i.Internship_ID = a.Internship_ID
                      JOIN company c ON i.Company_ID = c.Company_ID
                      WHERE i.Staff_ID = ? AND s.Student_ID = ? AND a.Assessment_ID LIKE '___UNI%'";
    $stmt_details = $conn->prepare($details_query);
    $stmt_details->bind_param("ii", $staff_id, $target_student_id);
} else {
    $details_query = "SELECT i.*, s.Full_Name, a.*, c.Reg_Comp_Name
                      FROM internship i
                      JOIN student s ON i.Student_ID = s.Student_ID
                      JOIN assessment a ON i.Internship_ID = a.Internship_ID
                      JOIN company c ON i.Company_ID = c.Company_ID
                      WHERE i.Staff_ID = ? AND a.Assessment_ID LIKE '___UNI%' LIMIT 1";
    $stmt_details = $conn->prepare($details_query);
    $stmt_details->bind_param("i", $staff_id);
}
$stmt_details->execute();
$current_student = $stmt_details->get_result()->fetch_assoc();

$has_graded = false;
$supervisor_graded = false;
if ($current_student) {
    //check if this internship has already been graded.
    //as once graded, the grade cannot be edited
    //this is checked via seeing if the utp mark is not the default 0.00 or if the feedback is not null.
    //as when a form is submitted, the empty feedback field will become "" instead of null.
    //the logic is basically that since all the mark fields are compulsory, if one mark isn't graded, then it means the form hasn't been submitted yet.
    //the feedback is in case the user just decides to mark the utp as 0.00.
    if ($current_student['UTP'] != 0.00 || $current_student['UTP_Feedback'] !== null) {
        $has_graded = true;
    }

    //do the same check but check if the supervisor has already graded this internship.
    $check_inds = $conn->prepare("SELECT * FROM assessment WHERE Internship_ID = ? AND Assessment_ID LIKE '___INDS%'");
    $check_inds->bind_param("s", $current_student['Internship_ID']);
    $check_inds->execute();
    $inds_data = $check_inds->get_result()->fetch_assoc();
    if ($inds_data && ($inds_data['UTP'] != 0.00 || $inds_data['UTP_Feedback'] !== null)) {
        $supervisor_graded = true;
    }
    $check_inds->close();
}

//get the students assigned to this user for the data list aka the dropdown list.
$assigned_query = "SELECT s.Student_ID, s.Full_Name FROM internship i
                   JOIN student s ON i.Student_ID = s.Student_ID
                   WHERE i.Staff_ID = ?";
$stmt_list = $conn->prepare($assigned_query);
$stmt_list->bind_param("i", $staff_id);
$stmt_list->execute();
$assigned_students = $stmt_list->get_result();
?>