<?php
require('../action/action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $messageEmpty = array();
    if($_GET['role'] == 'customer' && !empty($_GET['userId'])){
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
            $customers = getOneRow('customers', 'customerId', $_GET['userId']);
            $password = $customers['customerPassword'];
            if(!empty($_POST['customerNewPassword']) && !empty($_POST['customerNewPasswordConfirm'])){
                if(password_verify($_POST['customerPassword'], $password)){
                    if($_POST['customerNewPassword'] == $_POST['customerNewPasswordConfirm']){
                        $password = password_hash($_POST['customerNewPassword'], PASSWORD_ARGON2I);
                    }
                    else {
                        $_SESSION['messageResponce'] =  "The passwords do not match";
                        header('Location: ../pages/pageCreateProfil.php?role=admin');
                        exit();
                    }
                }
                else {
                    $_SESSION['messageResponce'] =  "password incorrect";
                    header('Location: ../pages/pageLogin.php');
                    exit();
                }
            }
            
            $query = "UPDATE donkeyCar.customers SET customerFirstName=:customerFirstName, customerLastName=:customerLastName, customerBirthDay=:customerBirthDay, customerAddress=:customerAddress, customerZip=:customerZip, customerCity=:customerCity, customerCountry=:customerCountry, customerPassword=:customerPassword, customerEmail=:customerEmail, customerNumber=:customerNumber, customerNumberPermit=:customerNumberPermit WHERE customerId=:id";
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
            $addCustomer->bindValue(':id', $_GET['userId']);
            if($addCustomer->execute()){
                $_SESSION['messageResponce'] =  "Your account has been Updated";
            }
            else {
                $_SESSION['messageResponce'] = "Your account has not been Updated";
            }
            header('Location: ../pages/pageLogin.php');
            exit();
        } 
    }
    elseif($_GET['role'] == 'admin' && !empty($_GET['userId'])){
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
            $admin = getOneRow('admins' , 'adminId', $_GET['userId']);
            $password = $admin['adminPassword'];
            if(!empty($_POST['adminNewPassword']) && !empty($_POST['adminNewPasswordConfirm'])){
                if(password_verify($_POST['adminPassword'], $password)){
                    if($_POST['adminNewPassword'] == $_POST['adminNewPasswordConfirm']){
                        $password = password_hash($_POST['adminNewPassword'], PASSWORD_ARGON2I);
                    }
                    else {
                        $_SESSION['messageResponce'] =  "The passwords do not match";
                        header('Location: ../pages/pageCreateProfil.php?role=admin');
                        exit();
                    }
                }
                else {
                    $_SESSION['messageResponce'] =  "password incorrect";
                    header('Location: ../pages/pageLogin.php');
                    exit();
                }
            }
            $query = "UPDATE donkeyCar.admins SET adminFirstName=:adminFirstName, adminLastName= :adminLastName, adminPassword= :adminPassword, adminEmail=:adminEmail WHERE adminId=:id";
            $pdo = connect_bd();
            $addAdmin = $pdo->prepare($query);
            $addAdmin->bindValue(':adminFirstName', $_POST['adminFirstName']);
            $addAdmin->bindValue(':adminLastName', $_POST['adminLastName']);
            $addAdmin->bindValue(':adminEmail', $_POST['adminEmail']);
            $addAdmin->bindValue(':adminPassword', $password);
            $addAdmin->bindValue(':adminRole', 2);
            if($addAdmin->execute()){
                if($_POST['adminMarket'] != "market"){
                    $admin = $_SESSION['userId'];
                    $query = "UPDATE donkeyCar.marketAdmin SET marketId=NULL WHERE adminId=:id";
                    $addMarketAdmin = $pdo->prepare($query);
                    $addMarketAdmin->bindValue(':marketId', $_POST['adminMarket']);
                    $addMarketAdmin->bindValue(':id', $admin);
                    $addMarketAdmin->execute();
                }
                $_SESSION['messageResponce'] =  "Your account has been Updated";
            }
            else {
                $_SESSION['messageResponce'] = "Your account has not been Updated";
            }
            header('Location: ../pages/pageLogin.php');
            exit();
        }
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}