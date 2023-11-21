<?php
require('action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST['sendMessage']) && $_POST['sendMessage'] == "Send your message"){
        $messageEmpty = array();
        if(empty($_POST['fisrtName']) ){
            $messageEmpty['customerFirstName'] =  "You have not provided your first name";
        }elseif(empty($_POST['lastname']) ){
            $messageEmpty['customerLastName'] =  "You have not provided your last name";
        }elseif(empty($_POST['email']) ){
            $messageEmpty['customerEmail'] =  "You have not provided your email";
        }elseif(empty($_POST['number']) ){
            $messageEmpty['customerNumber'] =  "You have not provided your phone number";
        }elseif(empty($_POST['subject'])){
            $messageEmpty['subject'] =  "You have not provided your subject";  
        }elseif(empty($_POST['message'])){
            $messageEmpty['message'] =  "You have not provided your message";  
        }
        if(count($messageEmpty) != 0){
            $_SESSION['messageResponceEmpty'] =  $messageEmpty;
            header('Location: ../pages/pageCreateProfil.php?role=customer');
            exit();
        }
        else {
            if($_POST['sendCopie'] == "on"){
                $to=$_POST['email'];
                $subject="Copy of your message to Donkey Car";
                $message = "Message from ".$_POST['fisrtName']." ".$_POST['lastname']."\n";
                $dataMessage.="\n";
                $message.=$_POST['subject']."\n";
                $dataMessage.="\n";
                $message.=$_POST['message']."\n";
                $dataMessage.="\n";
                $headers="From: ".$_POST['email'];
                mail($to, $subject, $message, $headers);
            }
            $dataMessage = "Message from ".$_POST['fisrtName']." ".$_POST['lastname']."\n";
            $dataMessage.="\n";
            $dataMessage.=$_POST['subject'];
            $dataMessage.="\n";
            $dataMessage.=$_POST['message'];
            $dataMessage.="\n";
            $dataMessage.=$_POST['email'];
            $dataMessage.="\n";
            $dataMessage.=$_POST['number'];
            $pdo = connect_bd();
            $query = $pdo->prepare('INSERT INTO donkeyCar.messages (messageFrom, messageSubjet, messageTo, messageText) VALUES(:messageFrom, :messageSubjet, :messageTo, :messageText)');
            $query->bindValue(':messageFrom', $_POST['email']);
            $query->bindValue(':messageSubjet', $_POST['subject']); 
            $query->bindValue(':messageTo', 'admin@donckeycar.com');  
            $query->bindValue(':messageText', $dataMessage); 
            $query->execute();
            $messageId = $pdo->lastInsertId();
            $data = verifEmail($_POST['email']);
            if(!empty($data)){
                $id = $data[0];
                $query = $pdo->prepare('INSERT INTO donkeyCar.messageCustomer (messageId, customerId) VALUES(:messageId, :customerId)');
                $query->bindValue(':messageId', $messageId);
                $query->bindValue(':customerId', $id);
                $query->execute();
            }
            $_SESSION['messageResponce'] =  "Your message has been sent";
            header('Location: ../index.php');
            exit();
        }
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}