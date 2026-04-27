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

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['supervID'])) {
        $SupervID = $_GET['supervID'];
        $deleteStmt = $conn->prepare("DELETE FROM inds_supervisor WHERE Supvr_ID = ?");
        if (!$deleteStmt) {
            die("Prepare failed (Delete_supervisor): " . $conn->error);
        }
        $deleteStmt->bind_param("i", $SupervID);
        $deleteStmt->execute();
        $conn->close();
        header("Location: Supervisor_manage.html?delete=success");
        exit(); // Stop execution here so it doesn't try to "Search"
    } 

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['ID']) && empty($_GET['name'])) {
        $fetchstmt = $conn->prepare("SELECT * FROM inds_supervisor");
        if (!$fetchstmt) {
            die("Prepare failed (Supervisor_Name): " . $conn->error);
        }
        $fetchstmt->execute();
        $inds_supervisor = $fetchstmt->get_result();
        $inds_supervisorlist = $inds_supervisor->fetch_all(MYSQLI_ASSOC);


        if ($inds_supervisor->num_rows > 0) {
            header('Content-Type: application/json');
            echo json_encode($inds_supervisorlist);
            $conn->close();
            exit();
        } else {
            $error_response = [["Error_msg" => "No inds_supervisor record in database!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name']) && !empty($_GET['ID'])) {
        $SupervID = $_GET['ID'];
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM inds_supervisor WHERE Full_Name LIKE ? AND Supvr_ID = ?");
        $fetchstmt->bind_param("si", $Name, $SupervID);
        $fetchstmt->execute();
        $inds_supervisor = $fetchstmt->get_result();

        if ($inds_supervisor->num_rows > 0) {
            $inds_supervisorlist = $inds_supervisor->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($inds_supervisorlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No supervisor found! Either inds_supervisor ID or Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['ID'])) {
        $SupervID = $_GET['ID'];
        $fetchstmt = $conn->prepare("SELECT * FROM inds_supervisor WHERE Supvr_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Supervisor_Name): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $SupervID);
        $fetchstmt->execute();
        $inds_supervisor = $fetchstmt->get_result();

        if ($inds_supervisor->num_rows > 0) {
            $inds_supervisorlist = $inds_supervisor->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($inds_supervisorlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "supervisor ID doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name'])) {
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM inds_supervisor WHERE Full_Name LIKE ?");
        $fetchstmt->bind_param("s", $Name);
        $fetchstmt->execute();
        $inds_supervisor = $fetchstmt->get_result();

        if ($inds_supervisor->num_rows > 0) {
            $inds_supervisorlist = $inds_supervisor->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($inds_supervisorlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "supervisor name doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    }
?>