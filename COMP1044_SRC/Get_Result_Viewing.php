<?php
//continue the session.
session_start();

//check if the user is logged in.
if (!isset($_SESSION['User_ID']) || !isset($_SESSION['Role'])) {
    //if no then bring the user to the login page.
    header("Location: Login_Page.php");
    exit();
}

//connect to the database.
require_once 'global.php';

//get the role and id of the user
$role = $_SESSION['Role'];
$user_id = $_SESSION['User_ID'];

$internship_id = null;
//check if the user is a student.
if ($role === 'Student') {
    //if yes then get their own internship_id using the student id.
    //since students can only view their own internship.
    $stmt = $conn->prepare("SELECT i.Internship_ID
                            FROM internship i
                            JOIN student s ON i.Student_ID = s.Student_ID
                            WHERE s.User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    //check if the student does not have an internship.
    if ($res->num_rows === 0) {
        die("You do not have an internship assigned yet.");
    }
    $internship_id = $res->fetch_assoc()['Internship_ID'];
    $stmt->close();
} else {
    //else it means the user is either an admin or assessor.
    //check if the internship id doesn't exist in the url.
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        //if yes then redirect back to the main result page.
        header("Location: Main_Result_Viewing.php");
        exit();
    }
    //get the internship id from the url, since the user got redirected from Main_Result_Viewing.
    $internship_id = $_GET['id'];

    //check if the user is either a lecturer or a supervisor
    if ($role === 'University Assessor' || $role === 'Industrial Supervisor') {
        //based on which assessor the user is, set the correct tables and columns to check.
        if ($role === 'University Assessor') {
            $col_to_check = "Staff_ID";
            $table_to_check = "uni_staff";
        } else {
            $col_to_check = "Supvr_ID";
            $table_to_check = "inds_supervisor";
        }

        //to check if the user actually has access to view this student's internship.
        $chk_stmt = $conn->prepare("SELECT i.Internship_ID
                                    FROM internship i
                                    JOIN $table_to_check u ON i.$col_to_check = u.$col_to_check
                                    WHERE u.User_ID = ? AND i.Internship_ID = ?");
        $chk_stmt->bind_param("is", $user_id, $internship_id);
        $chk_stmt->execute();
        //if no result is found then it means the user doesn't have access. So inform the user.
        if ($chk_stmt->get_result()->num_rows === 0) {
            die("Access Denied: You are not authorized to view this student's results.");
        }
        $chk_stmt->close();
    }
}

//get the internship data.
$details_query = "SELECT i.*, s.Student_ID, s.Full_Name AS StudentName, c.Reg_Comp_Name AS CompanyName
                  FROM internship i
                  JOIN student s ON i.Student_ID = s.Student_ID
                  JOIN company c ON i.Company_ID = c.Company_ID
                  WHERE i.Internship_ID = ?";
$stmt_det = $conn->prepare($details_query);
$stmt_det->bind_param("s", $internship_id);
$stmt_det->execute();
$details = $stmt_det->get_result()->fetch_assoc();
//inform the user if the internship data is not found.
if (!$details) { die("Internship record not found."); }

//get the supervisor marks.
$inds_query = $conn->prepare("SELECT *
                              FROM assessment
                              WHERE Internship_ID = ? AND Assessment_ID LIKE '___INDS%'");
$inds_query->bind_param("s", $internship_id);
$inds_query->execute();
$inds_marks = $inds_query->get_result()->fetch_assoc();

//get the lecturer marks.
$uni_query = $conn->prepare("SELECT *
                             FROM assessment
                             WHERE Internship_ID = ? AND Assessment_ID LIKE '___UNI%'");
$uni_query->bind_param("s", $internship_id);
$uni_query->execute();
$uni_marks = $uni_query->get_result()->fetch_assoc();
?>