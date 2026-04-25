<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once '../global.php';

    if ($conn->connect_error) {
        // Return an error message in JSON format so JS can handle it
        header('Content-Type: application/json');
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $fetchcomp = $conn->prepare("SELECT Reg_Comp_Name FROM company");
        if (!$fetchcomp) {
            die("Prepare failed (Company_Name): " . $conn->error);
        }
        $fetchcomp->execute();
        $compName = $fetchcomp->get_result();
        $complist = $compName->fetch_all(MYSQLI_ASSOC);


        if ($compName->num_rows > 0) {
            // 4. Loop through the result set and push into the array
            while($row = $compName->fetch_assoc()) {
                $complist[] = $row;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($complist);
        $conn->close();
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Username = $_POST['username'];
        $Name = $_POST['name'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Gender = $_POST['gender'];
        $Company = $_POST['company'];
        $Password = "defaultPWD";
        $Role = "Industrial Supervisor";

        // 1. Insert into user login first to get new user ID
        $Userstmt = $conn->prepare("INSERT INTO user_login (Username, Password, Role) VALUES (?, ?, ?)");
        if (!$Userstmt) {
            die("Prepare failed (User): " . $conn->error);
        }
        $Userstmt->bind_param("sss", $Username, $Password, $Role);
        $Userstmt->execute();
        $USERID = $conn->insert_id;
        $Userstmt->close();


        $companystmt = $conn->prepare("SELECT Company_ID FROM company where Reg_Comp_Name = ?");
        if (!$companystmt) {
            die("Prepare failed (Company_ID): " . $conn->error);
        }
        $companystmt->bind_param("s", $Company);
        $companystmt->execute();
        $companystmt->bind_result($companyID);
        $companystmt->fetch();
        $companystmt->close();



        $Supvrstmt = $conn->prepare("INSERT INTO inds_supervisor (User_ID, Company_ID, Full_Name, Email_Addr, Contact_No, Gender) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$Supvrstmt) {
            die("Prepare failed (Supervisor): " . $conn->error);
        }
        $Supvrstmt->bind_param("isssss", $USERID, $companyID, $Name, $Email, $Contact, $Gender);
        $Supvrstmt->execute();
        $Supvrstmt->close();

        // Redirect back to the form after successful insert
        header("Location: Add_Supervisor.html");
        exit();
    }
?>