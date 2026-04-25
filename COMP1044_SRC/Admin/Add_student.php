<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $fetchcomp = $conn->prepare("SELECT Programme_Name FROM programme");
        if (!$fetchcomp) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchcomp->execute();
        $progName = $fetchcomp->get_result();
        $proglist = $progName->fetch_all(MYSQLI_ASSOC);


        if ($progName->num_rows > 0) {
            // 4. Loop through the result set and push into the array
            while($row = $progName->fetch_assoc()) {
                $proglist[] = $row;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($proglist);
        $conn->close();
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Username = $_POST['username'];
        $Name = $_POST['name'];
        $Programme = $_POST['programme'];
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

        $progstmt = $conn->prepare("SELECT Prog_Code FROM programme where Programme_Name = ?");
        if (!$progstmt) {
            die("Prepare failed (Company_ID): " . $conn->error);
        }
        $progstmt->bind_param("s", $Programme);
        $progstmt->execute();
        $progstmt->bind_result($progCode);
        $progstmt->fetch();
        $progstmt->close();

        $Studstmt = $conn->prepare("INSERT INTO student (User_ID, Full_Name, Prog_Code, Contact_No, Email_Addr, Enroll_Date, Gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$Studstmt) {
            die("Prepare failed (student): " . $conn->error);
        }
        $Studstmt->bind_param("issssss", $USERID, $Name, $progCode, $Contact, $Email, $Enrollment, $Gender);
        $Studstmt->execute();
        $Studstmt->close();
        
        // Redirect back to the form after successful insert
        header("Location: Add_student.html");
        exit();
    }
?>