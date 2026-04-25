<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $fetchcomp = $conn->prepare("SELECT Prog_Code, Full_Name, Contact_No, Enroll_Date, Email_Addr, Gender FROM student");
        if (!$fetchcomp) {
            die("Prepare failed (student): " . $conn->error);
        }
        $fetchcomp->execute();
        $student = $fetchcomp->get_result();
        $studentlist = $student->fetch_all(MYSQLI_ASSOC);


        if ($student->num_rows > 0) {
            // 4. Loop through the result set and push into the array
            while($row = $student->fetch_assoc()) {
                $studentlist[] = $row;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($studentlist);
        $conn->close();
        exit();
    }
?>