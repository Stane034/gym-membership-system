<?php

require_once 'config.php';
require_once 'logs.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") { 

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


    if (isset($_POST['brisanje'])) { 
        $member_id = (int)$_POST['member_id'];

        SendLog("Administrator " . $adminusername . ' je obrisao korisnika sa ID-om : ' . $member_id);
        $sql = 'DELETE FROM members WHERE member_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param("i", $member_id);
        $run->execute();
        header("Location: dashboard.php");

    }else if (isset($_POST['cuvanje'])) { 
       if ($_POST['email'] != '') { 
        $member_id = (int)$_POST['member_id'];
        SendLog("Administrator " . $adminusername . ' je updatovao mejl korisnika sa ID-om : ' . $member_id . PHP_EOL . 'Novi mejl : ' . $_POST['email']);
        $sql = 'UPDATE members SET email = ? WHERE member_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param("si", $_POST['email'], $member_id);
        $run->execute();
       }
       if ($_POST['phone_number'] != '') { 
        $member_id = (int)$_POST['member_id'];
        SendLog("Administrator " . $adminusername . ' je updatovao kontakt korisnika sa ID-om : ' . $member_id . PHP_EOL . 'Novi kontakt : ' . $_POST['phone_number']);
        $sql = 'UPDATE members SET phone_number = ? WHERE member_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param("si", $_POST['phone_number'], $member_id);
        $run->execute();
       }

       if ($_POST['plan_id']) { 
        $member_id = (int)$_POST['member_id'];
        $session;
        $plan_id = (int)$_POST['plan_id'];

        $sql2 = "SELECT * FROM training_plans WHERE plan_id = ?";
        $run2 = $conn->prepare($sql2);
        $run2->bind_param("i", $plan_id);
        $run2->execute();
        $result = $run2->get_result();
        if ($result->num_rows == 1) { 
          $mainres = $result->fetch_assoc();
          $session = (int)$mainres['sessions'];
        }

        SendLog("Administrator " . $adminusername . ' je updatovao plan korisnika sa ID-om : ' . $member_id . PHP_EOL . 'Novi plan : ' . $session . ' prolaza.');

        $sql = 'UPDATE members SET training_plan_id = ? WHERE member_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param("ii", $plan_id,$member_id);
        $run->execute();

        $sql3 = 'UPDATE members SET sessions = ? WHERE member_id = ?';
        $run3 = $conn->prepare($sql3);
        $run3->bind_param("ii", $session,$member_id);
        $run3->execute();
       }
       header("Location: dashboard.php");
    }else if (isset($_POST['odustao'])) { 
        header("Location: dashboard.php");
    }

}
?>