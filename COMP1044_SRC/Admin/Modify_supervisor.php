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
        $SupervID = $_GET['supervID'];
        $fetchsuperv = $conn->prepare("SELECT Company_ID, Full_Name, Contact_No, Email_Addr, Gender FROM inds_supervisor WHERE Supvr_ID = ?");
        if (!$fetchsuperv) {
            die("Prepare failed (supervisor): " . $conn->error);
        }
        $fetchsuperv->bind_param("i", $SupervID);
        $fetchsuperv->execute();
        $fetchsuperv->bind_result($CompID, $Name, $Contact, $Email, $Gender);
        $fetchsuperv->fetch();
        $fetchsuperv->close();

        $fetchcompName = $conn->prepare("SELECT Reg_Comp_Name FROM company WHERE Company_ID = ?");
        $fetchcompName->bind_param("s", $CompID);
        $fetchcompName->execute();
        $fetchcompName->bind_result($CompName);
        $fetchcompName->fetch();
        $fetchcompName->close();

        $fetchComps = $conn->prepare("SELECT Reg_Comp_Name FROM company");
        if (!$fetchComps) {
            die("Prepare failed (Reg_Comp_Name): " . $conn->error);
        }
        $fetchComps->execute();
        $CompNames = $fetchComps->get_result();

        if ($CompNames->num_rows > 0) {
            $complist = $CompNames->fetch_all(MYSQLI_ASSOC);
        } else {
            $complist = [["Reg_Comp_Name" => "No companies registered!"]];
        }

        $response = [
            "supervisor" => [
                "Reg_Comp_Name" => $CompName,
                "Full_Name" => $Name,
                "Contact_No" => $Contact,
                "Email_Addr" => $Email,
                "Gender" => $Gender
            ],
            "companies" => $complist
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        $conn->close();
        exit();
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $SupervID = $_POST['supervID'];
        $Name = $_POST['name'];
        $Company = $_POST['company'];
        $Contact = $_POST['contact'];
        $Email = $_POST['email'];
        $Gender = $_POST['gender'];

        $compStmt = $conn->prepare("SELECT Company_ID FROM company where Reg_Comp_Name = ?");
        if (!$compStmt) {
            die("Prepare failed (Company_ID): " . $conn->error);
        }
        $compStmt->bind_param("s", $Company);
        $compStmt->execute();
        $compStmt->bind_result($CompID);
        $compStmt->fetch();
        $compStmt->close();

        $updateSuperv = $conn->prepare("UPDATE inds_supervisor SET Full_Name = ?, Company_ID = ?, Contact_No = ?, Email_Addr = ?, Gender = ? WHERE Supvr_ID = ?");
        if (!$updateSuperv) {
            die("Prepare failed (supervisor): " . $conn->error);
        }
        $updateSuperv->bind_param("sssssi", $Name, $CompID, $Contact, $Email, $Gender, $SupervID);
        $updateSuperv->execute();
        $updateSuperv->close();
        header("Location: Supervisor_manage.html?modify=success");
        exit();
    }
?>