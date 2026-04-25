<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include '../global.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Username = $_POST['username'];
        $Name = $_POST['name'];
        $Program = $_POST['program'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Enrollment = $_POST['enroll'];
        $Gender = $_POST['gender'];
        $Role = "Student";
        $Password = "defaultPWD";

        $Userstmt = $conn->prepare("INSERT INTO user_login (Username, Password, Role) VALUES (?, ?, ?)");
        if (!$Userstmt) {
            die("Prepare failed (user_login): " . $conn->error);
        }
        $Userstmt->bind_param("sss", $Username, $Password, $Role);
        $Userstmt->execute();
        $USERID = $conn->insert_id;
        $Userstmt->close();

        $Studstmt = $conn->prepare("INSERT INTO student (User_ID, Full_Name, Prog_Code, Contact_No, Email_Addr, Enroll_Date, Gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$Studstmt) {
            die("Prepare failed (student): " . $conn->error);
        }
        $Studstmt->bind_param("issssss", $USERID, $Name, $Program, $Contact, $Email, $Enrollment, $Gender);
        $Studstmt->execute();
        $Studstmt->close();
        
        // Redirect back to the form after successful insert
        header("Location: Add_student.html");
        exit();
    }
?>