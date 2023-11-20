<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST['sendForgotPasswordReset'])){
        require('action.php');
        $tabGet = $_SESSION['tabGet'];
        if($tabGet['email'] === $_POST['email']){
            if($_POST['customerPassword'] === $_POST['customerPasswordConfirm']){
                $dataVerifs = getEmailAndRole();
                foreach ($dataVerifs as $dataVerif) {
                    if(substr($dataVerif,2) == $_POST['email'] && substr($dataVerif,2) == $tabGet['email']){
                        $password = password_hash($_POST['customerPassword'], PASSWORD_ARGON2I);
                        $id = $tabGet['id'];
                        $query = "";
                        if(substr($dataVerif,0,1) == "a"){
                            $query = "UPDATE admins SET adminPassword=:passwordUpdate WHERE adminId = :id";
                        }
                        elseif(substr($dataVerif,0,1) == "c"){
                            $query = "UPDATE customers SET customerPassword=:passwordUpdate WHERE customerId = :id";
                        }
                        if($query != ""){
                            $pdo = connect_bd();
                            $statement = $pdo->prepare($query);
                            $statement->bindValue(':passwordUpdate', $password);
                            $statement->bindValue(':id', $id);
                            if($statement->execute()){
                                $to = $_POST['email'];
                                $subject = "Password Reset";
                                $message = "Your password has been reset. \n";
                                $message .= "If you did not request a password reset, please contact us.";
                                $headers = "From: admin@donkeycar.com";
                                if(mail($to,$subject,$message,$headers)){
                                    $_SESSION['messageResponce'] = "Your password has been reset";
                                    header('Location: ../pages/pageLogin.php');
                                    exit();
                                }
                            }
                        }
                        else {
                            $_SESSION['messageResponce'] = "Your password has not been reset";
                            header('Location: ../index.php');
                            exit();
                        }
                    }
                }
            }
            else {
                $_SESSION['messageResponce'] = "The passwords do not match";
                header('Location: ../index.php');
                exit();
            }
        }
        else {
            $_SESSION['messageResponce'] = "This email does not exist in our database";
            header('Location: ../index.php');
            exit();
        }
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
} 
