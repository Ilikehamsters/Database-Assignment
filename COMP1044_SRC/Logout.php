<?php
//resume the current session
session_start();

//free all the variables stored in this session.
session_unset();
//destroy the session
session_destroy();

//go back to the login page.
header("Location: Login_Page.php?logout=success");
exit();
?>