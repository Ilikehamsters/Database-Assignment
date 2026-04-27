<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    session_start();

    //check if the user is logged in and they're the right role.
    if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
        //if no then bring the user to the login page.
        header("Location: ../Login_Page.php");
        exit();
    }

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $StaffID = $_GET['staffID'];
        $fetchstaff = $conn->prepare("SELECT Position_Code, Full_Name, Contact_No, Email_Addr, Gender, Employ_Date FROM uni_staff WHERE Staff_ID = ?");
        if (!$fetchstaff) {
            die("Prepare failed (staff): " . $conn->error);
        }
        $fetchstaff->bind_param("i", $StaffID);
        $fetchstaff->execute();
        $fetchstaff->bind_result($PostionCode, $Name, $Contact, $Email, $Gender, $Employ);
        $fetchstaff->fetch();
        $fetchstaff->close();

        $fetchPositionName = $conn->prepare("SELECT Position_Name FROM position WHERE Position_Code = ?");
        $fetchPositionName->bind_param("s", $PostionCode);
        $fetchPositionName->execute();
        $fetchPositionName->bind_result($PositionName);
        $fetchPositionName->fetch();
        $fetchPositionName->close();

        $response = [
            "staff" => [
                "Position_Name" => $PositionName,
                "Full_Name" => $Name,
                "Contact_No" => $Contact,
                "Email_Addr" => $Email,
                "Gender" => $Gender,
                "Employ_Date" => $Employ
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        $conn->close();
        exit();
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $StaffID = $_POST['staffID'];
        $Name = $_POST['name'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Gender = $_POST['gender'];
        $Employ = $_POST['employment'];
        $Position = $_POST['role'];

        $PositionStmt = $conn->prepare("SELECT Position_Code FROM position where Position_Name = ?");
        if (!$PositionStmt) {
            die("Prepare failed (Position_Name): " . $conn->error);
        }
        $PositionStmt->bind_param("s", $Position);
        $PositionStmt->execute();
        $PositionStmt->bind_result($PostionCode);
        $PositionStmt->fetch();
        $PositionStmt->close();

        $updateStaff = $conn->prepare("UPDATE uni_staff SET Full_Name = ?, Position_Code = ?, Contact_No = ?, Email_Addr = ?, Gender = ?, Employ_Date = ? WHERE Staff_ID = ?");
        if (!$updateStaff) {
            die("Prepare failed (supervisor): " . $conn->error);
        }
        $updateStaff->bind_param("ssssssi", $Name, $PostionCode, $Contact, $Email, $Gender, $Employ, $StaffID);
        $updateStaff->execute();
        $updateStaff->close();
        header("Location: Staff_manage.html?modify=success");
        exit();
    }
?>