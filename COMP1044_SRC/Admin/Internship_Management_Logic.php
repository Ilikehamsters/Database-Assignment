<?php
//continue the session.
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}

//connect to the database.
require_once '../global.php';

//for the form aka assigning new internship.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'assign_internship') {
    //get ready to set all the data entered.
    //split the ids and names of the data lists.
    $student_id = explode(" - ", $_POST['student_id'])[0];
    $staff_id   = explode(" - ", $_POST['staff_id'])[0];
    $company_id = explode(" - ", $_POST['company_id'])[0];
    $supvr_id   = explode(" - ", $_POST['supervisors_id'])[0];

    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];
    $status     = 'Ungraded';

    $error_msg = null;
    //check if the student/lecturer/company/supervisor id actually exists in the database.
    //the reason why there's so many "if (!$error_msg)" instead of just one is because i was thinking of the logic where since one error is found, no need to check the other fields anymore.
    //saves time and let the user fix their error first.
    if (!$error_msg) {
        $chk = $conn->prepare("SELECT Student_ID FROM student WHERE Student_ID = ?");
        $chk->bind_param("i", $student_id);
        $chk->execute();
        if ($chk->get_result()->num_rows === 0) {
            $error_msg = "Error! The student does not exist! Please select one from the dropdown list.";
        }
        $chk->close();
    }
    if (!$error_msg) {
        $chk = $conn->prepare("SELECT Staff_ID FROM uni_staff WHERE Staff_ID = ? AND Position_Code = 'UASS'");
        $chk->bind_param("i", $staff_id);
        $chk->execute();
        if ($chk->get_result()->num_rows === 0) {
            $error_msg = "Error! The lecturer does not exist! Please select one from the dropdown list.";
        }
        $chk->close();
    }
    if (!$error_msg) {
        $chk = $conn->prepare("SELECT Company_ID FROM company WHERE Company_ID = ?");
        $chk->bind_param("i", $company_id);
        $chk->execute();
        if ($chk->get_result()->num_rows === 0) {
            $error_msg = "Error! The company does not exist! Please select one from the dropdown list.";
        }
        $chk->close();
    }
    if (!$error_msg) {
        $chk = $conn->prepare("SELECT Supvr_ID FROM inds_supervisor WHERE Supvr_ID = ?");
        $chk->bind_param("i", $supvr_id);
        $chk->execute();
        if ($chk->get_result()->num_rows === 0) {
            $error_msg = "Error! The industry supervisor does not exist! Please select one from the dropdown list.";
        }
        $chk->close();
    }
    //checks if the end date is earlier than the start date.
    if (!$error_msg && strtotime($end_date) < strtotime($start_date)) {
        $error_msg = "Error! The end date cannot be earlier than the start date!";
    }
    //checks if this current student already has an internship.
    //as here, one student can only have one internship.
    if (!$error_msg) {
        $check_stmt = $conn->prepare("SELECT Internship_ID FROM internship WHERE Student_ID = ?");
        $check_stmt->bind_param("i", $student_id);
        $check_stmt->execute();

        if ($check_stmt->get_result()->num_rows > 0) {
            $error_msg = "Error! This student already has an assigned internship! A student can only have one internship.";
        }
        $check_stmt->close();
    }

    //all the error checks are done so prepare to submit the form if no error.
    if (!$error_msg) {
        //get the first three letters of the start date month.
        //because the way the id is structured is [first 3 letters of month][random numbers]
        //like FEB12345.
        $month_prefix = strtoupper(date('M', strtotime($start_date)));
        $random_nums = rand(10000, 99999);
        //set all the ids.
        $internship_id = $month_prefix . $random_nums;
        $inds_ass_id   = $month_prefix . 'INDS' . $random_nums;
        $uni_ass_id    = $month_prefix . 'UNI'  . $random_nums;

        //start preparing to insert the form data into the database.
        $stmt_intern = $conn->prepare("INSERT INTO internship (Internship_ID, Student_ID, Staff_ID, Company_ID, Supvr_ID, Start_Intern, End_Intern, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_intern->bind_param("siiiisss", $internship_id, $student_id, $staff_id, $company_id, $supvr_id, $start_date, $end_date, $status);

        if ($stmt_intern->execute()) {
            $stmt_ass = $conn->prepare("INSERT INTO assessment (Assessment_ID, Internship_ID) VALUES (?, ?)");
            $stmt_ass->bind_param("ss", $inds_ass_id, $internship_id);
            $stmt_ass->execute();
            $stmt_ass->bind_param("ss", $uni_ass_id, $internship_id);
            $stmt_ass->execute();

            //save the message to the session for Internship_Management.php to show.
            $_SESSION['success_msg'] = "The internship has been assigned!";
            //refresh the page.
            header("Location: Internship_Management.php");
            exit();
        } else {
            //else something went wrong with the database.
            $error_msg = "Error! Something is wrong with the database. The form has not been saved.";
        }
    }

    //if there's an error, save the message to the session for Internship_Management.php to show.
    if ($error_msg) {
        $_SESSION['error_msg'] = $error_msg;
        header("Location: Internship_Management.php");
        exit();
    }
}

//get the data for the form data lists.
$students_list = $conn->query("SELECT Student_ID, Full_Name FROM student");
$staff_list = $conn->query("SELECT Staff_ID, Full_Name FROM uni_staff WHERE Position_Code = 'UASS'");
$companies_list = $conn->query("SELECT Company_ID, Reg_Comp_Name FROM company");
$supervisors_list = $conn->query("SELECT Supvr_ID, Full_Name FROM inds_supervisor");

//the number of rows that can be shown per page.
$limit = 5;
//get the current page number from the url. Or set the page to 1 if there's none.
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
//sets where to start getting the rows from.
//so like if the page is 2, then (2-1)*5=5. So start fetching from 5.
$offset = ($page - 1) * $limit;

$search_query = "";
//check if there's anything in the search bar (for filtering).
if (isset($_GET['search']) && !empty($_GET['search'])) {
    //if yes then split the string in the search bar.
    $search_term = explode(" - ", $_GET['search'])[0];
    //search for the student ids or names that contain the snippet of the searched text.
    //whether it's in the middle of a word or whatever.
    $search_query = " WHERE s.Student_ID LIKE '%$search_term%' OR s.Full_Name LIKE '%$search_term%' ";
}

//get the total number of all the matching records.
$count_sql = "SELECT COUNT(*) as total
              FROM internship i
              JOIN student s ON i.Student_ID = s.Student_ID" . $search_query;
$total_result = $conn->query($count_sql)->fetch_assoc();
//get the total number of pages. Rounds up.
$total_pages = ceil($total_result['total'] / $limit);

//get the data for the record table.
$table_sql = "SELECT i.Internship_ID, s.Full_Name AS StudentName, st.Full_Name AS StaffName,
              c.Reg_Comp_Name AS CompanyName, su.Full_Name AS SupvrName,
              i.Start_Intern, i.End_Intern, i.Status
              FROM internship i
              JOIN student s ON i.Student_ID = s.Student_ID
              JOIN uni_staff st ON i.Staff_ID = st.Staff_ID
              JOIN company c ON i.Company_ID = c.Company_ID
              JOIN inds_supervisor su ON i.Supvr_ID = su.Supvr_ID
              $search_query
              ORDER BY i.Start_Intern DESC
              LIMIT $limit OFFSET $offset";
$table_data = $conn->query($table_sql);
?>