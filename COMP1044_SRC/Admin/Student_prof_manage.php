<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userID'])) {
        $UserID = $_GET['userID'];

        // Start a transaction to ensure both deletes happen or neither does
        $conn->begin_transaction();

        try {
            // Delete from student table
            $deleteStmt1 = $conn->prepare("DELETE FROM student WHERE User_ID = ?");
            $deleteStmt1->bind_param("i", $UserID);
            $deleteStmt1->execute();

            // Delete from login table
            $deleteStmt2 = $conn->prepare("DELETE FROM user_login WHERE User_ID = ?");
            $deleteStmt2->bind_param("i", $UserID);
            $deleteStmt2->execute();

            $conn->commit();
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $conn->rollback();
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
        
        $conn->close();
        exit(); // Stop execution here so it doesn't try to "Search"
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['ID']) && empty($_GET['name'])) {
        $fetchstmt = $conn->prepare("SELECT * FROM student");
        if (!$fetchstmt) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchstmt->execute();
        $student = $fetchstmt->get_result();
        $studentlist = $student->fetch_all(MYSQLI_ASSOC);


        if ($student->num_rows > 0) {
            header('Content-Type: application/json');
            echo json_encode($studentlist);
            $conn->close();
            exit();
        } else {
            $error_response = [["Error_msg" => "No student record in database!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['ID'])) {
        $StudID = $_GET['ID'];
        $fetchstmt = $conn->prepare("SELECT * FROM student WHERE Student_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $StudID);
        $fetchstmt->execute();
        $student = $fetchstmt->get_result();

        if ($student->num_rows > 0) {
            $studentlist = $student->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($studentlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "Student ID doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
        
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name'])) {
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM student WHERE Full_Name LIKE ?");
        $fetchstmt->bind_param("s", $Name);
        $fetchstmt->execute();
        $student = $fetchstmt->get_result();

        if ($student->num_rows > 0) {
            $studentlist = $student->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($studentlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "Student name doesn't exist!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } else {
        $StudID = $_GET['ID'];
        $Name = "%" . $_GET['name'] . "%";
        $fetchstmt = $conn->prepare("SELECT * FROM student WHERE Full_Name LIKE ? AND Student_ID = ?");
        $fetchstmt->bind_param("si", $Name, $StudID);
        $fetchstmt->execute();
        $student = $fetchstmt->get_result();

        if ($student->num_rows > 0) {
            $studentlist = $student->fetch_all(MYSQLI_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($studentlist);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No student found! Either student ID or Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    }
?>