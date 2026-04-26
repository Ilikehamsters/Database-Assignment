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

//if the user is a student, then redirect them since they aren't supposed to be here.
if ($role === 'Student') {
    header("Location: Result_Viewing.php");
    exit();
}

$role_filter = "";
$param_type = "";
$param_val = null;
//check if the user is a lecturer.
if ($role === 'University Assessor') {
    //if yes then get their staff id.
    $stmt = $conn->prepare("SELECT Staff_ID FROM uni_staff WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $param_val = $stmt->get_result()->fetch_assoc()['Staff_ID'];
    $stmt->close();
    //also set up the filter flag as lecturers can only view students assigned to them
    $role_filter = " AND i.Staff_ID = ? ";
    $param_type = "i";
//else check if the user is a supervisor.
} elseif ($role === 'Industrial Supervisor') {
    //if yes then get their staff id.
    $stmt = $conn->prepare("SELECT Supvr_ID FROM inds_supervisor WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $param_val = $stmt->get_result()->fetch_assoc()['Supvr_ID'];
    $stmt->close();
    //also set up the filter flag as supervisors can only view students assigned to them
    $role_filter = " AND i.Supvr_ID = ? ";
    $param_type = "i";
}
//admins can view all the students so if $role_filter is empty then all students are shown.

//the number of rows that can be shown per page.
$limit = 25;
//get the current page number from the url. Or set the page to 1 if there's none.
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
//sets where to start getting the rows from.
//so like if the page is 2, then (2-1)*25=25. So start fetching from 25.
$offset = ($page - 1) * $limit;

$search_query = "";
$search_val = null;
//check if there's anything in the search bar (for filtering).
if (isset($_GET['search']) && !empty($_GET['search'])) {
    //if yes then split the string in the search bar.
    $search_val = explode(" - ", $_GET['search'])[0];
    //set the condition to only have student ids or names that matches the search term.
    $search_query = " AND (s.Student_ID LIKE ? OR s.Full_Name LIKE ?) ";
}

//build the query for the total number of all the matching records that meets the role filter and search query.
//the 1+1 is basically to make the appending of the role and search filter easier.
//because otherwise we also need to have another variable as the first condition to be appended.
//since currently $role_filter and $search_query starts with AND.
//and we can't do WHERE AND <condition>
$count_sql = "SELECT COUNT(*) as total
              FROM internship i
              JOIN student s ON i.Student_ID = s.Student_ID
              WHERE 1=1" . $role_filter . $search_query;
$stmt_count = $conn->prepare($count_sql);

//check if the user is not an admin and searched something.
if ($role !== 'Admin' && $search_val) {
    //if yes then create the actual search term
    //like if the search is "grace" then $search_term is "%grace%"
    $search_term = "%$search_val%";
    //bind the role filter and the searched term
    $stmt_count->bind_param($param_type . "ss", $param_val, $search_term, $search_term);
//else check if the user is not an admin.
} elseif ($role !== 'Admin') {
    //bind only the role filter since nothing was searched
    $stmt_count->bind_param($param_type, $param_val);
//else this means the user is an admin. Check if the admin searched something.
} elseif ($search_val) {
    //bind only the search term since admin doesn't need a role filter as they can view everything.
    $search_term = "%$search_val%";
    $stmt_count->bind_param("ss", $search_term, $search_term);
}
//run the query
$stmt_count->execute();
$total_result = $stmt_count->get_result()->fetch_assoc();
//get the total number of pages. Rounds up.
$total_pages = ceil($total_result['total'] / $limit);
$stmt_count->close();

//build the query to get the actual data and also average the marks
$table_sql = "
    SELECT
        i.Internship_ID,
        s.Student_ID,
        s.Full_Name AS StudentName,
        st.Full_Name AS StaffName,
        c.Reg_Comp_Name AS CompanyName,
        su.Full_Name AS SupvrName,
        i.Status,

        -- calculate the average of each assessment. Aka (lecturer+supervisor mark)/2
        -- COALESCE returns the first value that isn't null
        -- so if any of the fields are null aka ungraded, then to avoid error, COALESCE will make it 0
        (COALESCE(a_inds.UTP, 0) + COALESCE(a_uni.UTP, 0)) / 2 AS avg_UTP,
        (COALESCE(a_inds.HSR, 0) + COALESCE(a_uni.HSR, 0)) / 2 AS avg_HSR,
        (COALESCE(a_inds.CUTK, 0) + COALESCE(a_uni.CUTK, 0)) / 2 AS avg_CUTK,
        (COALESCE(a_inds.PR, 0) + COALESCE(a_uni.PR, 0)) / 2 AS avg_PR,
        (COALESCE(a_inds.CLI, 0) + COALESCE(a_uni.CLI, 0)) / 2 AS avg_CLI,
        (COALESCE(a_inds.LLA, 0) + COALESCE(a_uni.LLA, 0)) / 2 AS avg_LLA,
        (COALESCE(a_inds.PM, 0) + COALESCE(a_uni.PM, 0)) / 2 AS avg_PM,
        (COALESCE(a_inds.TM, 0) + COALESCE(a_uni.TM, 0)) / 2 AS avg_TM,

        -- calculate the final mark via adding all the averages.
        ((COALESCE(a_inds.UTP, 0) + COALESCE(a_uni.UTP, 0)) / 2) +
        ((COALESCE(a_inds.HSR, 0) + COALESCE(a_uni.HSR, 0)) / 2) +
        ((COALESCE(a_inds.CUTK, 0) + COALESCE(a_uni.CUTK, 0)) / 2) +
        ((COALESCE(a_inds.PR, 0) + COALESCE(a_uni.PR, 0)) / 2) +
        ((COALESCE(a_inds.CLI, 0) + COALESCE(a_uni.CLI, 0)) / 2) +
        ((COALESCE(a_inds.LLA, 0) + COALESCE(a_uni.LLA, 0)) / 2) +
        ((COALESCE(a_inds.PM, 0) + COALESCE(a_uni.PM, 0)) / 2) +
        ((COALESCE(a_inds.TM, 0) + COALESCE(a_uni.TM, 0)) / 2) AS FinalMark

    FROM internship i
    JOIN student s ON i.Student_ID = s.Student_ID
    JOIN uni_staff st ON i.Staff_ID = st.Staff_ID
    JOIN company c ON i.Company_ID = c.Company_ID
    JOIN inds_supervisor su ON i.Supvr_ID = su.Supvr_ID
    -- LEFT JOIN for students who only got graded by either the lecturer or supervisor. Not both.
    -- since JOIN will remove them
    LEFT JOIN assessment a_inds ON i.Internship_ID = a_inds.Internship_ID AND a_inds.Assessment_ID LIKE '___INDS%'
    LEFT JOIN assessment a_uni ON i.Internship_ID = a_uni.Internship_ID AND a_uni.Assessment_ID LIKE '___UNI%'
    WHERE 1=1 $role_filter $search_query
    -- sort by graded to ungraded, with names in ascending order
    ORDER BY i.Status DESC, s.Full_Name ASC
    -- the page offset
    LIMIT ? OFFSET ?
";

$stmt_table = $conn->prepare($table_sql);

//similar to the COUNT version, bind the parameters based on the role and the search bar.
//if the user is not an admin and searched something
if ($role !== 'Admin' && $search_val) {
    $search_term = "%$search_val%";
    $stmt_table->bind_param($param_type . "ssii", $param_val, $search_term, $search_term, $limit, $offset);
//if the user is not an admin (and didn't search anything due to the previous if condition)
} elseif ($role !== 'Admin') {
    $stmt_table->bind_param($param_type . "ii", $param_val, $limit, $offset);
//if the user searched something (and is admin due to the previous elseif condition)
} elseif ($search_val) {
    $search_term = "%$search_val%";
    $stmt_table->bind_param("ssii", $search_term, $search_term, $limit, $offset);
//if the user is an admin and did not search anything
} else {
    $stmt_table->bind_param("ii", $limit, $offset);
}
//execute the query and get the results.
$stmt_table->execute();
$table_data = $stmt_table->get_result();

//get the students for the search data list aka the dropdown list.
//with the role filter as the condition for if the user is a lecturer/supervisor
$search_list_sql = "SELECT DISTINCT s.Student_ID, s.Full_Name
                    FROM internship i
                    JOIN student s ON i.Student_ID = s.Student_ID
                    WHERE 1=1" . $role_filter;
$stmt_list = $conn->prepare($search_list_sql);
//bind the staff id for the role filter if the user isn't an admin
if ($role !== 'Admin') { $stmt_list->bind_param($param_type, $param_val); }
$stmt_list->execute();
$valid_students = $stmt_list->get_result();
?>