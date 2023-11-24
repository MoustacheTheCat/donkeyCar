<?php
require('../../action/action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $messageEmpty = array();
    if(empty($_POST['marketName'])){
        $messageEmpty['marketName'] =  "You have not provided your market name";
    }
    elseif(empty($_POST['garageName'])){
        $messageEmpty['garageName'] =  "You have not provided your garage name";
    }
    elseif(empty($_POST['marketAddress'])){
        $messageEmpty['marketAddress'] =  "You have not provided your market address";
    }
    elseif(empty($_POST['marketZip'])){
        $messageEmpty['marketZip'] =  "You have not provided your market postal code";
    }
    elseif(empty($_POST['marketCity'])){
        $messageEmpty['marketCity'] =  "You have not provided your market city";
    }
    elseif(empty($_POST['marketCountry'])){
        $messageEmpty['marketCountry'] =  "You have not provided your market Country";
    }
    if(count($messageEmpty) != 0){
        $_SESSION['messageResponceEmpty'] =  $messageEmpty;
        header('Location: ../../pages/admin/pageAddGarageMarket.php?id='.$_SESSION['user']['id'].'&role='.$_SESSION['user']['role']);
        exit();
    }
    else {
        $pdo = connect_bd();
        $query = "INSERT INTO markets (marketName, marketAdress, marketZip, marketCity, marketCountry) VALUES (:marketName, :marketAddress, :marketZip, :marketCity, :marketCountry)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':marketName', $_POST['marketName']);
        $stmt->bindValue(':marketAddress', $_POST['marketAddress']);
        $stmt->bindValue(':marketZip', $_POST['marketZip']);
        $stmt->bindValue(':marketCity', $_POST['marketCity']);
        $stmt->bindValue(':marketCountry', $_POST['marketCountry']);
        $stmt->execute();
        $marketId = $pdo->lastInsertId();
        $query = "INSERT INTO garages (garageName, marketId) VALUES (:garageName, :marketId)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':garageName', $_POST['garageName']);
        $stmt->bindValue(':marketId', $marketId);
        $stmt->execute();
        $_SESSION['messageResponce'] =  "Market and Garage added";
        header('Location: ../../index.php');
        exit();
    }

}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}