<?php
require('../action.php');
if($_SESSION['user']['role'] == 'admin'){
    $idGet = $_GET['id'];
    $type =$_GET['type'];
    if($type == "car"){
        $queryDeleteCar = "DELETE FROM donkeyCar.car WHERE carId=:id";
        $stmt = $pdo->prepare($queryDeleteCar);
        $stmt->bindValue(':id', $idGet);
        $queryDeletGarageCar = "DELETE FROM donkeyCar.garageCar WHERE carId=:id";
        $stmtGc = $pdo->prepare($queryDeletGarageCar);
        $stmtGc->bindValue(':id', $idGet);
        if($stmtGc->execute() && $stmt->execute()){
            $_SESSION['messageResponse'] = 'Car deleted';
            header('Location: ../../index.php');
            exit();
        }
    }
    elseif($type == "market"){
        $queryDeleteMarket = "DELETE FROM donkeyCar.market WHERE marketId=:id";
        $stmt = $pdo->prepare($queryDeleteMarket);
        $stmt->bindValue(':id', $idGet);
        if($stmt->execute()){
            $queryDeleteGarage = "DELETE FROM donkeyCar.garage WHERE marketId=:id";
            $stmtG = $pdo->prepare($queryDeleteGarage);
            $stmtG->bindValue(':id', $idGet);
            if($stmtG->execute()){
                $_SESSION['messageResponse'] = 'Market deleted';
                header('Location: ../../index.php');
                exit();
            }
        }

    }
    elseif($type == "garage"){
        $queryDeleteGarage = "DELETE FROM donkeyCar.garage WHERE marketId=:id";
        $stmtG = $pdo->prepare($queryDeleteGarage);
        $stmtG->bindValue(':id', $idGet);
        if($stmtG->execute()){
            $_SESSION['messageResponse'] = 'Market deleted';
            header('Location: ../../index.php');
            exit();
        }
    }
}else {
    $_SESSION['messageError'] = "You don't have the permission to access this page";
    header('Location: ../../index.php');
    exit();
}