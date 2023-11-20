<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    require('action.php');
    if(isset($_POST['sendForgotPassword'])){
        $emailVerifs = getEmail();
        foreach ($emailVerifs as $emailVerif) {
            if($_POST['email'] == substr($emailVerif, 3)){
                if(substr($emailVerif,0,2)<10){
                    $id = substr($emailVerif,1,1);
                    print_r($id);
                }
                else {
                    $id = substr($emailVerif,0,2);
                    print_r($id);
                }
                $to = $_POST['email'];
                $subject = "Forgot Password";
                $message = "Click on the link below to reset your password: \n";
                $message .= "http://donkeycar.com/pages/pageForgotPasswordReset.php?email=".$_POST['email'].'&id='.$id.' \n';
                $message .= "If you did not request a password reset, please ignore this email.";
                $headers = "From: admin@donkeycar.com";
                mail($to,$subject,$message,$headers);
                $_SESSION['messageResponce'] = "An email has been sent to you to reset your password";
                header('Location: ../index.php');
                exit();
            }
            else {
                $_SESSION['messageResponce'] = "This email does not exist in our database";
                header('Location: ../index.php');
                exit();
            }
        }
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}    