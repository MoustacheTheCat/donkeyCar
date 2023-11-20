<?php
require('../action/action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $messageEmpty = array();
    if(empty($_GET['role'])){
        if(empty($_POST['customerFirstName'])){
            $messageEmpty['customerFirstName'] =  "You have not provided your first name";
        }
        elseif(empty($_POST['customerLastName'])){
            $messageEmpty['customerLastName'] =  "You have not provided your last name";
        }
        elseif(empty($_POST['customerBirthDay'])){
            $messageEmpty['customerBirthDay'] =  "You have not provided your date of birth";
        }
        elseif(empty($_POST['customerEmail'])){
            $messageEmpty['customerEmail'] =  "You have not provided your email";
        }
        elseif(empty($_POST['customerNumber'])){
            $messageEmpty['customerNumber'] =  "You have not provided your phone number";
        }
        elseif(empty($_POST['customerNumberPermit'])){
            $messageEmpty['customerNumberPermit'] =  "You have not provided your driving license number";
        }
        elseif(empty($_POST['customerAddress'])){
            $messageEmpty['customerAddress'] =  "You have not provided your address";
        }
        elseif(empty($_POST['customerZip'])){
            $messageEmpty['customerZip'] =  "You have not provided your zip code";
        }
        elseif(empty($_POST['customerCity'])){
            $messageEmpty['customerCity'] =  "You have not provided  your city";
        }
        elseif(empty($_POST['customerCountry'])){
            $messageEmpty['customerCountry'] =  "You have not provided your country";
        }
        elseif(empty($_POST['customerPassword'])){
            $messageEmpty['customerPassword'] =  "You have not provided your password";
        }
        elseif(empty($_POST['customerPasswordConfirm'])){
            $messageEmpty['customerPasswordConfirm'] =  "You have not provided your password confirmation";
        }
        if(count($messageEmpty) != 0){
            $_SESSION['messageResponceEmpty'] =  $messageEmpty;
            header('Location: ../pages/pageCreateProfil.php?role=customer');
            exit();
        }
        else {
            $customers = getAllData('customers');
            $messageEmpty = array();
            foreach($customers as $customer){
                if($customer['customerEmail'] == $_POST['customerEmail']){
                    $_SESSION['messageResponce'] =  "This email is already used";
                    header('Location: ../pages/pageLogin.php');
                    exit();
                }
                elseif($customer['customerNumber'] == $_POST['customerNumber']){
                    $_SESSION['messageResponce'] =  "This phone number is already used";
                    header('Location: ../pages/pageLogin.php');
                    exit();
                }
            }
            if($_POST['customerPassword'] == $_POST['customerPasswordConfirm']){
                $password = password_hash($_POST['customerPassword'], PASSWORD_ARGON2I);
                $query = "INSERT INTO customers (customerFirstName, customerLastName, customerBirthDay, customerEmail, customerNumber, customerNumberPermit, customerAddress, customerZip, customerCity, customerCountry, customerPassword) VALUES (:customerFirstName, :customerLastName, :customerBirthDay, :customerEmail, :customerNumber, :customerNumberPermit, :customerAddress, :customerZip, :customerCity, :customerCountry, :customerPassword)";
                $pdo = connect_bd();
                $addCustomer = $pdo->prepare($query);
                $addCustomer->bindValue(':customerFirstName', $_POST['customerFirstName']);
                $addCustomer->bindValue(':customerLastName', $_POST['customerLastName']);
                $addCustomer->bindValue(':customerBirthDay', $_POST['customerBirthDay']);
                $addCustomer->bindValue(':customerEmail', $_POST['customerEmail']);
                $addCustomer->bindValue(':customerNumber', $_POST['customerNumber']);
                $addCustomer->bindValue(':customerNumberPermit', $_POST['customerNumberPermit']);
                $addCustomer->bindValue(':customerAddress', $_POST['customerAddress']);
                $addCustomer->bindValue(':customerZip', $_POST['customerZip']);
                $addCustomer->bindValue(':customerCity', $_POST['customerCity']);
                $addCustomer->bindValue(':customerCountry', $_POST['customerCountry']);
                $addCustomer->bindValue(':customerPassword', $password);
                if($addCustomer->execute()){
                    $_SESSION['messageResponce'] =  "Your account has been created";
                }
                else {
                    $_SESSION['messageResponce'] = "Your account has not been created";
                }
                header('Location: ../pages/pageLogin.php');
                exit();
            }
            else {
                $_SESSION['messageResponce'] =  "The passwords do not match";
                header('Location: ../pages/pageCreateProfil.php?role=customer');
                exit();
            }
        } 
    }
    elseif($_GET['role'] == 'admin'){
        if(empty($_POST['adminFirstName'])){
            $messageEmpty['adminFirstName'] =  "You have not provided your first name";
        }
        elseif(empty($_POST['adminLastName'])){
            $messageEmpty['adminLastName'] =  "You have not provided your last name";
        }
        elseif(empty($_POST['adminEmail'])){
            $messageEmpty['adminEmail'] =  "You have not provided your email";
        }
        elseif(empty($_POST['adminPassword'])){
            $messageEmpty['adminPassword'] =  "You have not provided your password";
        }
        elseif(empty($_POST['adminPasswordConfirm'])){
            $messageEmpty['adminPasswordConfirm'] =  "You have not provided your password confirmation";
        }
        elseif(empty($_POST['adminMarket'])){
            $messageEmpty['adminMarket'] =  "You have not provided your market";
        }
        if(count($messageEmpty) != 0){
            $_SESSION['messageResponceEmpty'] =  $messageEmpty;
            header('Location: ../pages/pageCreateProfil.php?role=admin');
            exit();
        }
        else {
            $admins = getAllData('admins');
            $messageEmpty = array();
            foreach($admins as $admin){
                if($admin['adminEmail'] == $_POST['adminEmail']){
                    $_SESSION['messageResponce'] =  "This email is already used";
                    header('Location: ../pages/pageLogin.php');
                    exit();
                }
            }
            if($_POST['adminPassword'] == $_POST['adminPasswordConfirm']){
                if($_POST['adminMarket'] == 'all'){
                    $adminRole = 1;
                }
                else {
                    $adminRole = 2;
                }
                $password = password_hash($_POST['adminPassword'], PASSWORD_ARGON2I);
                $query = "INSERT INTO admins (adminFirstName, adminLastName, adminEmail, adminPassword , adminRole) VALUES (:adminFirstName, :adminLastName, :adminEmail, :adminPassword , :adminRole)";
                $pdo = connect_bd();
                $addAdmin = $pdo->prepare($query);
                $addAdmin->bindValue(':adminFirstName', $_POST['adminFirstName']);
                $addAdmin->bindValue(':adminLastName', $_POST['adminLastName']);
                $addAdmin->bindValue(':adminEmail', $_POST['adminEmail']);
                $addAdmin->bindValue(':adminPassword', $password);
                $addAdmin->bindValue(':adminRole', $adminRole);
                $addAdmin->execute();
                if($_POST['adminMarket'] != 'all'){
                    $admin = $pdo->lastInsertId();
                    $query = "INSERT INTO marketAdmin (marketId, adminId) VALUES (:marketId, :adminId)";
                    $addMarketAdmin = $pdo->prepare($query);
                    $addMarketAdmin->bindValue(':marketId', $_POST['adminMarket']);
                    $addMarketAdmin->bindValue(':adminId', $admin);
                    $addMarketAdmin->execute();
                }elseif($_POST['adminMarket'] == 'all'){
                    $admin = $pdo->lastInsertId();
                    $markets = getAllData('markets');
                    foreach($markets as $market){
                        $query = "INSERT INTO marketAdmin (marketId, adminId) VALUES (:marketId, :adminId)";
                        $addMarketAdmin = $pdo->prepare($query);
                        $addMarketAdmin->bindValue(':marketId', $market['marketId']);
                        $addMarketAdmin->bindValue(':adminId', $admin);
                        $addMarketAdmin->execute();
                    }
                }
                $_SESSION['messageResponce'] =  "Your account has been created";
                header('Location: ../pages/pageLogin.php');
                exit();
            }
            // else {
            //     $_SESSION['messageResponce'] =  "The passwords do not match";
            //     header('Location: ../pages/pageCreateProfil.php?role=admin');
            //     exit();
            // }
        }
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}