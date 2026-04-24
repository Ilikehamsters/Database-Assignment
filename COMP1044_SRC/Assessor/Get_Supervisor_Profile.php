<?php
//resume the current session
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'indSuperv') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}

//connect to the database.
require_once '../global.php';

//prepare to get the supervisor data.
$user_id = $_SESSION['User_ID'];
$query = "SELECT s.*, c.Reg_Comp_Name
          FROM inds_supervisor s
          JOIN company c ON s.Company_ID = c.Company_ID
          WHERE s.User_ID = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

//checks and makes sure there's only one row aka no duplicate results.
if ($result->num_rows === 1) {
    //save all the data into the $profile array
    $profile = $result->fetch_assoc();
} else {
    die("Error! Profile not found!");
}
$stmt->close();
?>