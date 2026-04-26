<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['ID']) && empty($_GET['name'])) {
        $fetchcomp = $conn->prepare("SELECT * FROM student");
        if (!$fetchcomp) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchcomp->execute();
        $student = $fetchcomp->get_result();
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
        $fetchcomp = $conn->prepare("SELECT * FROM student WHERE Student_ID = ?");
        if (!$fetchcomp) {
            die("Prepare failed (Programme_Name): " . $conn->error);
        }
        $fetchcomp->bind_param("i", $StudID);
        $fetchcomp->execute();
        $student = $fetchcomp->get_result();

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
        
    } else {
        $name = "%" . $_GET['name'] . "%";
        $fetchcomp = $conn->prepare("SELECT * FROM student WHERE Full_Name LIKE ?");
        $fetchcomp->bind_param("s", $name);
        $fetchcomp->execute();
        $student = $fetchcomp->get_result();

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