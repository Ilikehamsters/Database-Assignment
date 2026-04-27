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

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['staffID'])) {
        $StaffID = $_GET['staffID'];
        $deleteStmt = $conn->prepare("DELETE FROM uni_staff WHERE Staff_ID = ?");
        if (!$deleteStmt) {
            die("Prepare failed (Delete_staff): " . $conn->error);
        }
        $deleteStmt->bind_param("i", $StaffID);
        $deleteStmt->execute();
        $conn->close();
        header("Location: Staff_manage.html?delete=success");
        exit(); // Stop execution here so it doesn't try to "Search"
    } 

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['ID']) && empty($_GET['name'])) {
        $fetchstmt = $conn->prepare("SELECT * FROM uni_staff");
        if (!$fetchstmt) {
            die("Prepare failed (Staff_Name): " . $conn->error);
        }
        $fetchstmt->execute();
        $uni_staff = $fetchstmt->get_result();
        $uni_stafflist = $uni_staff->fetch_all(MYSQLI_ASSOC);


        if ($uni_staff->num_rows > 0) {
            header('Content-Type: application/json');
            echo json_encode($uni_stafflist);
            $conn->close();
            exit();
        } else {
            $error_response = [["Error_msg" => "No staff record in database!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name']) && !empty($_GET['ID'])) {
        $StaffID = $_GET['ID'];
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM uni_staff WHERE Full_Name LIKE ? AND Staff_ID = ?");
        $fetchstmt->bind_param("si", $Name, $StaffID);
        $fetchstmt->execute();
        $uni_staff = $fetchstmt->get_result();

        if ($uni_staff->num_rows > 0) {
            $uni_stafflist = $uni_staff->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($uni_stafflist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No staff found! Either staff ID or Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['ID'])) {
        $StaffID = $_GET['ID'];
        $fetchstmt = $conn->prepare("SELECT * FROM uni_staff WHERE Staff_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Staff): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $StaffID);
        $fetchstmt->execute();
        $uni_staff = $fetchstmt->get_result();

        if ($uni_staff->num_rows > 0) {
            $uni_stafflist = $uni_staff->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($uni_stafflist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "staff ID doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name'])) {
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM uni_staff WHERE Full_Name LIKE ?");
        $fetchstmt->bind_param("s", $Name);
        $fetchstmt->execute();
        $uni_staff = $fetchstmt->get_result();

        if ($uni_staff->num_rows > 0) {
            $uni_stafflist = $uni_staff->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($uni_stafflist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "staff name doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    }
?>