<?php 
require('action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $messageEmpty = array();
    if(empty($_POST['email'])){
        $messageEmpty['email'] =  "You have not provided your email";
    }
    elseif(empty($_POST['password'])){
        $messageEmpty['password'] =  "You have not provided your password";
    }
    if(count($messageEmpty) != 0){
        $_SESSION['messageResponceEmpty'] =  $messageEmpty;
        header('Location: ../pages/pageLogin.php');
        exit();
    }
    else {
        $idLogin = null;
        $emailLogin = null;
        $role = null;
        $allEmails = getAllEmail();
        foreach($allEmails as $key1 => $values){
            
            foreach($values as $key2 => $value){
                if($value == $_POST['email']){
                    if($key2 == 'customerEmail'){
                        $idLogin = $allEmails[$key1]['customerId'];
                        $emailLogin = $allEmails[$key1]['customerEmail'];
                        $role = 'customer';
                    }
                    elseif($key2 == 'adminEmail'){
                        $idLogin = $allEmails[$key1]['adminId'];
                        $emailLogin = $allEmails[$key1]['adminEmail'];
                        $role = 'admin';
                        
                    }
                }
            }
        }
        if(!empty($idLogin) && !empty($emailLogin) && !empty($role)){
            $password = null;
            $roleType = null;
            if($role == 'admin'){
                $admin = getOneRow('admins', 'adminId', $idLogin);
                $password = $admin['adminPassword'];
                if($admin['adminRole'] == 1){
                    $roleType = 'superAdmin';
                }else{
                    $roleType = 'admin';
                }
            }
            elseif($role == 'customer'){
                $customer = getOneRow('customers', 'customerId', $idLogin);
                $password = $customer['customerPassword'];
                $roleType = 'customer';
            }
            if(password_verify($_POST['password'], $password)){
                $user = array();
                $user['id'] = $idLogin;
                $user['email'] = $emailLogin;
                $user['role'] = $role;
                $user['roleType'] = $roleType;
                $_SESSION['user'] = $user;
                $_SESSION['messageResponce'] =  "You are connected";
                header('Location: ../index.php');
                exit();
            }
            $_SESSION['messageResponce'] =  "password incorrect";
            header('Location: ../pages/pageLogin.php');
            exit();
        }
        $_SESSION['messageResponce'] =  "Email incorrect";
        header('Location: pagesLogin.php');
        exit();
    }
}else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}