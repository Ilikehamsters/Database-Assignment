<?php
$conn = new mysqli("localhost", "root", "root", "comp1044_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>