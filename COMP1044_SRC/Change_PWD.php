<?php
    session_start();
    require_once 'global.php';

    if (!isset($_SESSION['User_ID'])) {
        //if no then bring the user to the login page.
        header("Location: ../Login_Page.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Password = $_POST['password'];
        $ConfirmPWD = $_POST['confirmPWD'];

        if ($Password === $ConfirmPWD && $Password != "defaultPWD") {
            $userstmt = $conn->prepare("UPDATE user_login SET Password = ? WHERE User_ID = ?");
            $userstmt->bind_param("ss", $Password, $_SESSION['User_ID']);
            $userstmt->execute();
            $userstmt->close();

            match($_SESSION['Role']) {
                'Student'     => header("Location: Student/Student_Page.php?login=success"),
                'Admin'       => header("Location: Admin/Admin_Page.php?login=success"),
                'uniAssessor' => header("Location: Assessor/Lecturer_Page.php?login=success"),
                'indSuperv'   => header("Location: Assessor/Supervisor_Page.php?login=success"),
            };
            exit();
        } else {
            header("Location: Change_PWD.html");
            echo "Detected default password. Please create a new unique password.";
            exit();
        }

    }
?>