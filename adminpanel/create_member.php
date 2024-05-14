<?php
    require_once 'config.php';
    require_once 'logs.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") { 

        $adminusername;

        $sql3 = "SELECT * FROM admins WHERE admin_id = ?";
        $run3 = $conn->prepare($sql3);
        $run3->bind_param("i", $_SESSION['adminId']);
        $run3->execute();
        $result = $run3->get_result();

        if ($result->num_rows == 1) { 
          $mainres = $result->fetch_assoc();
          $adminusername = $mainres['username'];
        }
        

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $plan_id = (int)$_POST['plan_id'];
        $session;

        if (trim($first_name) == "" || trim($last_name) == "" || trim($phone_number) == "" || trim($email) == "") { 
          $_SESSION['message'] = 'Nepravilno uneta forma';
          header("Location: dashboard.php");
          die();
        }


        $sql2 = "SELECT * FROM training_plans WHERE plan_id = ?";
        $run2 = $conn->prepare($sql2);
        $run2->bind_param("i", $plan_id);
        $run2->execute();
        $result = $run2->get_result();

        if ($result->num_rows == 1) { 
          $mainres = $result->fetch_assoc();
          $session = $mainres['sessions'];
        }
        
        $sql = "INSERT INTO members (first_name, last_name, email, phone_number, training_plan_id, sessions) VALUES (?,?,?,?,?,?)";
        $run = $conn->prepare($sql);
        $run->bind_param("ssssii", $first_name, $last_name, $email, $phone_number, $plan_id, $session);
        $run->execute();

        SendLog("Administrator " . $adminusername . ' je kreirao korisnika sa podacima' . PHP_EOL . "Ime : " . $first_name . PHP_EOL . "Prezime : " . $last_name . PHP_EOL . "Email : " . $email . PHP_EOL . "Broj Telefona : " . $phone_number . PHP_EOL . "Plan Treninga : " . $session . " prolaza.");
        header("Location: dashboard.php");

    }   
?>