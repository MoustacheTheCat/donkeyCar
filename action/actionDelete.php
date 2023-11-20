<?php
require('action.php');
$id = $_GET['id'];
if(!empty($_GET['role'] && !empty($_GET['id']))){
    if($_GET['step'] == 1){
        header('Location: http://donkeycar.com/pages/pageConfirmDelete.php?role='.$_GET['role'].'&id='.$_GET['id'].'');
        exit();
    }
    elseif($_GET['step'] == 2){
        $messageEmpty = array();
        if(!empty($_POST['email'])){
            $messageEmpty['email'] =  "You have not provided your email";
        }
        elseif(!empty($_POST['password'])){
            $messageEmpty['password'] =  "You have not provided your password";
        }
        if(!empty($messageEmpty)){
            $_SESSION['messageResponceEmpty'] =  $messageEmpty;
            header('Location: ../pages/pageConfirmDelete.php?role=admin'.$_GET['role'].'&id='.$_GET['id'].'');
            exit();
        }
        if($_GET['role'] == 'admin'){
            $query = "DELETE FROM admins WHERE adminId = :id";
            $data = getOneRow('admins', 'adminId', $id);
            if($data['adminEmail'] == $_POST['email']){
                if(password_verify($_POST['password'], $data['adminPassword'])){
                    deletUser($id, $query);
                }else{
                    $_SESSION['messageResponce'] =  "password incorrect";
                    header('Location: ../pages/pageConfirmDelete.php?role=admin'.$_GET['role'].'&id='.$_GET['id'].'');
                    exit();
                }
            }else{
                $_SESSION['messageResponce'] =  "Email incorrect";
                header('Location: ../pages/pageConfirmDelete.php?role=admin'.$_GET['role'].'&id='.$_GET['id'].'');
                exit();
            }
            
        }
        elseif($_GET['role'] == 'customer'){
            $query = "DELETE FROM customers WHERE customerId = :id";
            $data = getOneRow('customers', 'customerId', $id);
            if($data['customerEmail'] == $_POST['email']){
                if(password_verify($_POST['password'], $data['customerPassword'])){
                    deletUser($id, $query);
                }else{
                    $_SESSION['messageResponce'] =  "password incorrect";
                    header('Location: ../pages/pageConfirmDelete.php?role=admin'.$_GET['role'].'&id='.$_GET['id'].'');
                    exit();
                }
            }else{
                $_SESSION['messageResponce'] =  "Email incorrect";
                header('Location: ../pages/pageConfirmDelete.php?role=admin'.$_GET['role'].'&id='.$_GET['id'].'');
                exit();
            }
        }
    }else {
        $_SESSION['messageResponce'] =  "Step not allowed";
        header('Location: ../404.php');
    }
    
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}