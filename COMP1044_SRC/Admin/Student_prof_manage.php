<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['studID'])) {
        $StudID = $_GET['studID'];
        $deleteStmt = $conn->prepare("DELETE FROM student WHERE Student_ID = ?");
        if (!$deleteStmt) {
            die("Prepare failed (Delete_student): " . $conn->error);
        }
        $deleteStmt->bind_param("i", $StudID);
        $deleteStmt->execute();
        $conn->close();
        header("Location: Student_prof_manage.html?delete=success");
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
        

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name']) && !empty($_GET['ID'])) {
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
    }
?>