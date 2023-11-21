<?php
require('../../action/action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $messageEmpty = array();
    if(empty($_POST['carName'])){
        $messageEmpty['carName'] =  "You have not provided your car name";
    }
    elseif(empty($_POST['carBrand']) && empty($_POST['newCarBrand'])){
        $messageEmpty['carBrand'] =  "You have not provided your car brand";
    }
    elseif(empty($_POST['carType']) && empty($_POST['newCarType'])){
        $messageEmpty['carType'] =  "You have not provided your car type";
    }
    elseif(empty($_POST['carYear'])){
        $messageEmpty['carYear'] =  "You have not provided your car year";
    }
    elseif(empty($_POST['carImmatriculation'])){
        $messageEmpty['carImmatriculation'] =  "You have not provided your car immatriculation";
    }
    elseif(empty($_POST['carTarifHourHT'])){
        $messageEmpty['carTarifHourHT'] =  "You have not provided your car tarif hour HT";
    }
    elseif(empty($_POST['carTarifDayHT'])){
        $messageEmpty['carTarifDayHT'] =  "You have not provided your car tarif day HT";
    }
    elseif(empty($_POST['carCaution'])){
        $messageEmpty['carCaution'] =  "You have not provided your car Caution";
    }
    elseif(empty($_POST['garage'])){
        $messageEmpty['garage'] =  "You have not provided your car Caution";
    }
    if(count($messageEmpty) != 0){
        $_SESSION['messageResponceEmpty'] =  $messageEmpty;
        header('Location: ../../pages/admin/pageAddCar.php');
        exit();
    }
    else {
        $carType = null;
        $carBrand = null;
        $pdo = connect_bd();
        if(!empty($_POST['newCarType'])){
            if(verifTypeBrand($_POST['newCarType'], 'type')){
                $query = "INSERT INTO typeCar (typeCarName) VALUES (:typeCarName)";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':typeCarName', $_POST['newCarType']);
                $stmt->execute();
                $carType = $pdo->lastInsertId();
            }else{
                $carType = verifTypeBrand($_POST['newCarType'], 'type');
            }
        }
        else {
            $carType = $_POST['carType'];
        }
        if(!empty($_POST['newCarBrand'])){
            if(verifTypeBrand($_POST['newCarBrand'], 'brand')){
                $query = "INSERT INTO brands (brandName) VALUES (:brandName)";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':brandName', $_POST['newCarBrand']);
                $stmt->execute();
                $carBrand = $pdo->lastInsertId();
            }else{
                $carBrand = verifTypeBrand($_POST['newCarBrand'], 'brand');
            }
        }
        else {
            $carBrand = $_POST['carBrand'];
        }
        if(!verifImat($_POST['carImmatriculation'])){
            $messageEmpty['carImmatriculation'] =  "Immatriculation already exist";
            $_SESSION['messageResponceEmpty'] =  $messageEmpty;
            header('Location: ../../pages/admin/pageAddCar.php');
            exit();
        }
        $query = "INSERT INTO donkeyCar.cars (carName, carImmatriculation, carYear, carTarifHourHT, carTarifDayHT, carCaution, brandId, typeCarId) VALUES(:carName, :carImmatriculation, :carYear, :carTarifHourHT, :carTarifDayHT, :carCaution, :brandId, :typeCarId)";
        $addCar = $pdo->prepare($query);
        $addCar->bindValue(':carName', $_POST['carName']);
        $addCar->bindValue(':carImmatriculation', $_POST['carImmatriculation']);
        $addCar->bindValue(':carYear', $_POST['carYear']);
        $addCar->bindValue(':carTarifHourHT', $_POST['carTarifHourHT']);
        $addCar->bindValue(':carTarifDayHT', $_POST['carTarifDayHT']);
        $addCar->bindValue(':carCaution', $_POST['carCaution']);
        $addCar->bindValue(':brandId', $carBrand);
        $addCar->bindValue(':typeCarId', $carType);
        if($addCar->execute()){
            $carId = $pdo->lastInsertId();
            $query = "INSERT INTO donkeyCar.garageCar (carId, garageId) VALUES(:carId, :garageId)";
            $addGarage = $pdo->prepare($query);
            $addGarage->bindValue(':carId', $carId);
            $addGarage->bindValue(':garageId', $_POST['garage']);
            if($addGarage->execute()){
                $_SESSION['messageResponce'] =  "Car added";
                header('Location: ../../index.php');
                exit();
            }
            else {
                $_SESSION['messageResponce'] =  "Error add garage";
                header('Location: ../../index.php');
                exit();
            }
        }
        else {
            $_SESSION['messageResponce'] =  "Error add car";
            header('Location: ../../index.php');
            exit();
        }
    }

}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}