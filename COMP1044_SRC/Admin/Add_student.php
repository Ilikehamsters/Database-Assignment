<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include '../global.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $UserID = $_POST['userID'];
        $Username = $_POST['username'];
        $Password = $_POST['password'];
        $Name = $_POST['student_name'];
        $Program = $_POST['program'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Enrollment = $_POST['Enroll'];
        $Gender = $_POST['student_gender'];
        $Role = "Student";

        $Studstmt = $conn->prepare("INSERT INTO student (User_ID, Full_Name, Prog_Code, Contact_No, Email_Addr, Enroll_Date, Gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$Studstmt) {
            die("Prepare failed (student): " . $conn->error);
        }
        $Studstmt->bind_param("issssss", $UserID, $Name, $Program, $Contact, $Email, $Enrollment, $Gender);

        $Userstmt = $conn->prepare("INSERT INTO user_login (User_ID, Username, Password, Role) VALUES (?, ?, ?, ?)");
        if (!$Userstmt) {
            die("Prepare failed (user_login): " . $conn->error);
        }
        $Userstmt->bind_param("isss", $UserID, $Username, $Password, $Role);

        $Studstmt->execute();
        $Userstmt->execute();

        // Redirect back to the form after successful insert
        header("Location: Add_student.html");
        exit();
    }
?>