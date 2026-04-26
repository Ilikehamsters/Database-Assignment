<?php
//resume the current session
session_start();

//check if the user is logged in and they're the right role.
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'University Assessor') {
    //if no then bring the user to the login page.
    header("Location: ../Login_Page.php");
    exit();
}

//connect to the database.
require_once '../global.php';

//prepare to get the lecturer data.
$user_id = $_SESSION['User_ID'];
$query = "SELECT u.*, p.Position_Name
          FROM uni_staff u
          JOIN position p ON u.Position_Code = p.Position_Code
          WHERE u.User_ID = ?";

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