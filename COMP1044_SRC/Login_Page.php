<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "internship_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        if ($pass === $row['Password']) {
            // Success! Create session variables
            $_SESSION['User_ID'] = $row['User_ID'];
            $_SESSION['Username'] = $user;
            $_SESSION['Role'] = $row['Role'];

            match($row['Role']) {
            'Student' => header("Location: Result_Viewing.html?login=success"),
            'Admin'   => header("Location: Admin_page.html?login=success"),
            default   => header("Location: teacher.html?login=success"),
        };
            exit();
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "Invalid username or password!";
    }
    $stmt->close();
}
$conn->close();
?>