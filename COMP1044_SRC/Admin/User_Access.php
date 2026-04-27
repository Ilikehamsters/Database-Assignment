<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    session_start();

    //check if the user is logged in and they're the right role.
    if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
        //if no then bring the user to the login page.
        header("Location: ../Login_Page.php");
        exit();
    }

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userID'])) {
        $UserID = $_GET['userID'];
        $DefaultPass = "defaultPWD";
        if (!empty($UserID)) {
            $userReset = $conn->prepare("UPDATE user_login SET Password = ? WHERE User_ID = ?");
            if (!$userReset) {
                die("Prepare failed (Update_Password): " . $conn->error);
            }
            $userReset->bind_param("si", $DefaultPass, $UserID);
            $userReset->execute();
            $conn->close();
            header("Location: User_Access.html?reset=success");
            exit(); // Stop execution here so it doesn't try to "Search"
        } else {
            $conn->close();
            header("Location: User_Access.html?reset=failed");
            exit(); // Stop execution here so it doesn't try to "Search"
        }
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['studID']) && !empty($_GET['studName'])) {
        $StudentID = $_GET['studID'];
        $StudentName = "%" . $_GET['studName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM student WHERE Full_Name LIKE ? AND Student_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Student): " . $conn->error);
        }
        $fetchstmt->bind_param("si", $StudentName, $StudentID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Student): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No student found! Either student ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['studID'])) {
        $StudentID = $_GET['studID'];
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM student WHERE Student_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Student): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $StudentID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Student): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No student found! Either student ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['studName'])) {
        $StudentName = "%" . $_GET['studName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM student WHERE Full_Name LIKE ?");
        if (!$fetchstmt) {
            die("Prepare failed (Student): " . $conn->error);
        }
        $fetchstmt->bind_param("s", $StudentName);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Student): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No student found! Either student ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['staffID']) && !empty($_GET['staffName'])) {
        $StaffID = $_GET['staffID'];
        $StaffName = "%" . $_GET['staffName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM uni_staff WHERE Full_Name LIKE ? AND Staff_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Staff): " . $conn->error);
        }
        $fetchstmt->bind_param("si", $StaffName, $StaffID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Staff): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No staff found! Either staff ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['staffID'])) {
        $StaffID = $_GET['staffID'];
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM uni_staff WHERE Staff_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Staff): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $StaffID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Staff): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No staff found! Either staff ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['staffName'])) {
        $StaffName = "%" . $_GET['staffName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM uni_staff WHERE Full_Name LIKE ?");
        if (!$fetchstmt) {
            die("Prepare failed (Staff): " . $conn->error);
        }
        $fetchstmt->bind_param("s", $StaffName);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Staff): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No staff found! Either staff ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['supervID']) && !empty($_GET['supervName'])) {
        $SupervID = $_GET['supervID'];
        $SupervName = "%" . $_GET['supervName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM inds_supervisor WHERE Full_Name LIKE ? AND Supvr_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Supervisor): " . $conn->error);
        }
        $fetchstmt->bind_param("si", $SupervName, $SupervID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Supervisor): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No supervisor found! Either supervisor ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['supervID'])) {
        $SupervID = $_GET['supervID'];
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM inds_supervisor WHERE Supvr_ID = ?");
        if (!$fetchstmt) {
            die("Prepare failed (Supervisor): " . $conn->error);
        }
        $fetchstmt->bind_param("i", $SupervID);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Supervisor): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No supervisor found! Either supervisor ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['supervName'])) {
        $SupervName = "%" . $_GET['supervName'] . "%";
        $fetchstmt = $conn->prepare("SELECT User_ID, Full_Name FROM inds_supervisor WHERE Full_Name LIKE ?");
        if (!$fetchstmt) {
            die("Prepare failed (Supervisor): " . $conn->error);
        }
        $fetchstmt->bind_param("s", $SupervName);
        $fetchstmt->execute();
        $fetchstmt->bind_result($UserID, $Name);
        $fetchstmt->fetch();
        $fetchstmt->close();

        if (!empty($UserID) && !empty($Name)) {
            $fetchUser = $conn->prepare("SELECT Username FROM user_login WHERE User_ID = ?");
            if (!$fetchUser) {
                die("Prepare failed (Supervisor): " . $conn->error);
            }
            $fetchUser->bind_param("i", $UserID);
            $fetchUser->execute();
            $fetchUser->bind_result($Username);
            $fetchUser->fetch();
            $fetchUser->close();

            $response = [
                [
                    "User_ID" => $UserID,
                    "Full_Name" => $Name,
                    "Username" => $Username,
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();

        } else {
            $error_response = [["Error_msg" => "No supervisor found! Either supervisor ID/Name are wrong!"]];
            header('Content-Type: application/json');
            echo json_encode($error_response);
            $conn->close();
            exit();
        }
    } else {
        $response = [
                [
                    "User_ID" => "",
                    "Full_Name" => "",
                    "Username" => "",
                ],
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            $conn->close();
            exit();
    }
?>