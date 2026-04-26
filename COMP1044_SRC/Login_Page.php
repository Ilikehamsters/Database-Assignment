<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//start the session.
session_start();
//connect to the database.
require_once 'global.php';

//check if the user is already logged in.
if (isset($_SESSION['Role'])) {
    //if yes then redirect them to the homepage based on the role.
    match($_SESSION['Role']) {
        'Student'     => header("Location: Student/Student_Page.php?redirect=success"),
        'Admin'       => header("Location: Admin/Admin_Page.php?redirect=success"),
        'University Assessor' => header("Location: Assessor/Lecturer_Page.php?redirect=success"),
        'Industrial Supervisor'   => header("Location: Assessor/Supervisor_Page.php?redirect=success"),
    };
    //exit and stop this page from loading.
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="Login_Page.css">
    </head>
    <body>
        <header>
            <h1 id="welcome">Welcome to the <br>Internship <br>Management <br>System!</h1>
        </header>
        <main>
            <section id="login_form">
                <form action="Login.php" method="post" id="login_content">
                    <h2 id="login">Login</h2>
                    <input class="textbox" type="text" id="username" name="username" placeholder="Username" required><br><br>
                    <input class="textbox" type="password" id="password" name="password" placeholder="Password" required>
                    <img src="Assets/Eye.png" alt="Show" id="togglePWD"><br><br>
                    <input id="login_button" type="submit" value="Log in"><br>
                </form>
            </section>
        </main>
        <script>
            // Get references to the password input and the toggle button
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePWD');

            // Add a click event listener to the toggle button
            togglePassword.addEventListener('click', function () {
                // Check the current type of the input field
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    
                // Set the new type
                passwordInput.setAttribute('type', type);
    
                // Change the button text based on the type
                (type == 'text') ? document.getElementById('togglePWD').src = "Assets/HiddenEye.png" : document.getElementById('togglePWD').src = "Assets/Eye.png";
            });

            const params = new URLSearchParams(window.location.search);
            if (params.get("logout") == "success") {
                alert("Logout successful!");
                // Clean the URL so refreshing doesn't re-trigger the alert
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        </script>
    </body>
</html>