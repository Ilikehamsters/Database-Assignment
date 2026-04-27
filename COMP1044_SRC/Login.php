<?php
session_start();
//connect to the server.
//had to separate because i also needed said connection for verification.
require_once 'global.php';

// 2. Handle POST Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 3. Use Prepared Statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT User_ID, Password, Role FROM user_login WHERE Username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // 4. Verify Password
        if ($pass === $row['Password'] && $pass != "defaultPWD") {
            // Success! Create session variables
            $_SESSION['User_ID'] = $row['User_ID'];
            $_SESSION['Username'] = $user;
            $_SESSION['Role'] = $row['Role'];

            match($row['Role']) {
            'Student'     => header("Location: Student/Student_Page.php?login=success"),
            'Admin'       => header("Location: Admin/Admin_Page.php?login=success"),
            'University Assessor' => header("Location: Assessor/Lecturer_Page.php?login=success"),
            'Industrial Supervisor'   => header("Location: Assessor/Supervisor_Page.php?login=success"),
        };
            exit();
        } elseif ($pass === $row['Password'] && $pass == "defaultPWD") {
            $_SESSION['User_ID'] = $row['User_ID'];
            $_SESSION['Username'] = $user;
            $_SESSION['Role'] = $row['Role'];

            header("Location: Change_PWD.html?login=success");
            exit();
        } else {
            //save the error to the session for Login_Page.php to show.
            $_SESSION['login_error'] = "Invalid username or password!";
            //redirect back to the login page instead of being stuck on this login.php
            header("Location: Login_Page.php");
        }
    } else {
        //save the error to the session for Login_Page.php to show.
        $_SESSION['login_error'] = "Invalid username or password!";
        //redirect back to the login page.
        header("Location: Login_Page.php");
    }
    $stmt->close();
}
$conn->close();
?>