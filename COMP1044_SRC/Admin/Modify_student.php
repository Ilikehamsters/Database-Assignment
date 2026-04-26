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
        $StudID = $_GET['studID'];
        $fetchprog = $conn->prepare("SELECT Prog_Code, Full_Name, Contact_No, Enroll_Date, Email_Addr, Gender FROM student WHERE Student_ID = ?");
        if (!$fetchprog) {
            die("Prepare failed (student): " . $conn->error);
        }
        $fetchprog->bind_param("i", $StudID);
        $fetchprog->execute();
        $fetchprog->bind_result($ProgCode, $Name, $Contact, $Enroll, $Email, $Gender);
        $fetchprog->fetch();
        $fetchprog->close();

        $fetchprogName = $conn->prepare("SELECT Programme_Name FROM programme WHERE Prog_Code = ?");
        $fetchprogName->bind_param("s", $ProgCode);
        $fetchprogName->execute();
        $fetchprogName->bind_result($ProgName);
        $fetchprogName->fetch();
        $fetchprogName->close();

        $fetchprogs = $conn->prepare("SELECT Programme_Name FROM programme");
        if (!$fetchprogs) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchprogs->execute();
        $progName = $fetchprogs->get_result();

        if ($progName->num_rows > 0) {
            $proglist = $progName->fetch_all(MYSQLI_ASSOC);
        } else {
            $proglist = [["Programme_Name" => "No programmes registered!"]];
        }

        $response = [
            "student" => [
                "Programme_Name" => $ProgName,
                "Full_Name" => $Name,
                "Contact_No" => $Contact,
                "Enroll_Date" => $Enroll,
                "Email_Addr" => $Email,
                "Gender" => $Gender
            ],
            "programmes" => $proglist
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        $conn->close();
        exit();
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $StudID = $_POST['studID'];
        $Name = $_POST['name'];
        $Programme = $_POST['programme'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Enrollment = $_POST['enroll'];
        $Gender = $_POST['gender'];

        $progstmt = $conn->prepare("SELECT Prog_Code FROM programme where Programme_Name = ?");
        if (!$progstmt) {
            die("Prepare failed (Prog_Code): " . $conn->error);
        }
        $progstmt->bind_param("s", $Programme);
        $progstmt->execute();
        $progstmt->bind_result($progCode);
        $progstmt->fetch();
        $progstmt->close();

        $updateStud = $conn->prepare("UPDATE student SET Full_Name = ?, Prog_Code = ?, Contact_No = ?, Enroll_Date = ?, Email_Addr = ?, Gender = ? WHERE Student_ID = ?");
        if (!$updateStud) {
            die("Prepare failed (student): " . $conn->error);
        }
        $updateStud->bind_param("ssssssi", $Name, $progCode, $Contact, $Enrollment, $Email, $Gender, $StudID);
        $updateStud->execute();
        $updateStud->close();
        header("Location: Student_prof_manage.html?modify=success");
        exit();
    }
?>