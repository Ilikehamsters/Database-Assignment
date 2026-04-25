<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include '../global.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Username = $_POST['username'];
        $Name = $_POST['name'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Employment = $_POST['employment'];
        $Gender = $_POST['gender'];
        $Role = $_POST['role'];
        $Password = "defaultPWD";

        // 1. Insert into user login first to get new user ID
        $Userstmt = $conn->prepare("INSERT INTO user_login (Username, Password, Role) VALUES (?, ?, ?)");
        if (!$Userstmt) {
            die("Prepare failed (User): " . $conn->error);
        }
        $Userstmt->bind_param("sss", $Username, $Password, $Role);
        $Userstmt->execute();
        $USERID = $conn->insert_id;
        $Userstmt->close();

        // 2. Get the position code
        $positionstmt = $conn->prepare("SELECT Position_Code FROM position where Position_Name = ?");
        if (!$positionstmt) {
            die("Prepare failed (Position_Code): " . $conn->error);
        }
        $positionstmt->bind_param("s", $Role);
        $positionstmt->execute();
        $positionstmt->bind_result($PostCode);
        $positionstmt->fetch();
        $positionstmt->close();


        // 3. Add all the values to staff table
        $Staffstmt = $conn->prepare("INSERT INTO uni_staff (User_ID, Position_Code, Full_Name, Email_Addr, Contact_No, Employ_Date, Gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$Staffstmt) {
            die("Prepare failed (Staff): " . $conn->error);
        }
        $Staffstmt->bind_param("issssss", $USERID, $PostCode, $Name, $Email, $Contact, $Employment, $Gender);
        $Staffstmt->execute();
        $Staffstmt->close();

        // Redirect back to the form after successful insert
        header("Location: Add_staff.html");
        exit();
    }
?>