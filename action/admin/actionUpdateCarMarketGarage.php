<?php
require('../action.php');

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $idGet = $_GET['id'];
    $type =$_GET['type'];
    if($type == "car"){
        $cars = getOneRowCarWithTypeAndBrand($idGet);
        if($_POST['carName'] != $cars['carName']){
            $carName = $_POST['carName'];
        }
        else{
            $carName = $cars['carName'];
        }
        if($_POST['newCarType'] != 'New Type' && $_POST['newCarType'] != $cars['typeCarName']){
            if(verifTypeBrand($_POST['newCarType'], 'type')){
                $typeId = verifTypeBrand($_POST['newCarType'], 'type');
            }
            else{
                $typeId = addType($_POST['newCarType']);
            }
        }
        else{
            $typeId = $cars['typeCarId'];
        }
        if($_POST['carType'] != $cars['typeCarName']){
            $typeId = $_POST['carType'];
        }
        else{
            $typeId = $cars['typeCarId'];
        }
        if($_POST['newCarBrand'] != 'New Brand' && $_POST['newCarBrand'] != $cars['brandName']){
            if(verifTypeBrand($data, $type)){
                $brandId = verifTypeBrand($_POST['newCarBrand'], 'brand');
            }
            else{
                $barndId = addBrand($_POST['newCarBrand']);
            }
        }
        else{
            $barndId = $cars['brandId'];
        }
        if($_POST['carBrand'] != $cars['brandName']){
            $barndId = $_POST['carBrand'];
        }
        else{
            $barndId = $cars['brandId'];
        }
        if($_POST['carTarifHourHT'] != $cars['carTarifHourHT']){
            $carTarifHourHT = $_POST['carTarifHourHT'];
        }
        else{
            $carTarifHourHT = $cars['carTarifHourHT'];
        }
        if($_POST['carTarifDayHT'] != $cars['carTarifDayHT']){
            $carTarifDayHT = $_POST['carTarifDayHT'];
        }
        else{
            $carTarifDayHT = $cars['carTarifDayHT'];
        }
        if($_POST['carImmatriculation'] != $cars['carImmatriculation']){
            $carImmatriculation = $_POST['carImmatriculation'];
        }
        else{
            $carImmatriculation = $cars['carImmatriculation'];
        }
        if($_POST['carCaution'] != $cars['carCaution']){
            $carCaution = $_POST['carCaution'];
        }
        else{
            $carCaution = $cars['carCaution'];
        }
        if($_POST['carYear'] != $cars['carYear']){
            $carYear = $_POST['carYear'];
        }
        else{
            $carYear = $cars['carYear'];
        }
        if($_POST['garage'] != $cars['garageName']){
            $queryUpdateCarGarage = "UPDATE donkeyCar.garageCar SET garageId=:garageId WHERE carId=:id";
            $stmtGc = $pdo->prepare($queryUpdateCarGarage);
            $stmtGc->bindValue(':garageId', $_POST['garage']);
            $stmtGc->bindValue(':id', $idGet);
            $stmtGc->execute();
        }
        $queryUpdateCar = "UPDATE donkeyCar.cars SET carName=:carName, carTypeId=:carTypeId, carBrandId=:carBrandId, carTarifHourHT=:carTarifHourHT, carTarifDayHT=:carTarifDayHT, carImmatriculation=:carImmatriculation, carCaution=:carCaution, carYear=:carYear, garageId=:garageId WHERE carId=:id";
        $stmt = $pdo->prepare($queryUpdateCar);
        $stmt->bindValue(':carName', $carName);
        $stmt->bindValue(':carTypeId', $typeId);
        $stmt->bindValue(':carBrandId', $barndId);
        $stmt->bindValue(':carTarifHourHT', $carTarifHourHT);
        $stmt->bindValue(':carTarifDayHT', $carTarifDayHT);
        $stmt->bindValue(':carImmatriculation', $carImmatriculation);
        $stmt->bindValue(':carCaution', $carCaution);
        $stmt->bindValue(':carYear', $carYear);
        $stmt->bindValue(':id', $idGet);
        if($stmt->execute()){
            $_SESSION['messageResponse'] = 'Car updated';
            header('Location: ../../pageDetailCar.php?id='.$idGet);
            exit();
        }
    }
    elseif($type == "market"){
        $market = getOneRow('markets', 'marketId', $idGet);
        if($_POST['marketName'] != $market['marketName']){
            $marketName = $_POST['marketName'];
        }
        else{
            $marketName = $market['marketName'];
        }
        if($_POST['marketAddress'] != $market['marketAddress']){
            $marketAddress = $_POST['marketAddress'];
        }
        else{
            $marketAddress = $market['marketAddress'];
        }
        if($_POST['marketZipCode'] != $market['marketZipCode']){
            $marketZipCode = $_POST['marketZipCode'];
        }
        else{
            $marketZipCode = $market['marketZipCode'];
        }
        if($_POST['marketCity'] != $market['marketCity']){
            $marketCity = $_POST['marketCity'];
        }
        else{
            $marketCity = $market['marketCity'];
        }
        if($_POST['marketCountry'] != $market['marketCountry']){
            $marketCountry = $_POST['marketCountry'];
        }
        else{
            $marketCountry = $market['marketCountry'];
        }
        $queryUpdateMarket = "UPDATE donkeyCar.markets SET marketName=:marketName, marketAddress=:marketAddress, marketZipCode=:marketZipCode, marketCity=:marketCity, marketCountry=:marketCountry WHERE marketId=:id";
        $stmt = $pdo->prepare($queryUpdateMarket);
        $stmt->bindValue(':marketName', $marketName);
        $stmt->bindValue(':marketAddress', $marketAddress);
        $stmt->bindValue(':marketZipCode', $marketZipCode);
        $stmt->bindValue(':marketCity', $marketCity);
        $stmt->bindValue(':marketCountry', $marketCountry);
        $stmt->bindValue(':id', $idGet);
        if($stmt->execute()){
            $_SESSION['messageResponse'] = 'Market updated';
            header('Location: ../../pageDetailMarket.php?id='.$idGet);
            exit();
        }
    }
    elseif($type == "garage"){
        $market = getOneRow('markets', 'marketId', $idGet);
        if($_POST['garageName'] != $market['garageName']){
            $garageName = $_POST['garageName'];
        }
        else{
            $garageName = $market['garageName'];
        }
        $queryUpdateGarage = "UPDATE donkeyCar.garages SET garageName=:garageName WHERE garageId=:id";
        $stmt = $pdo->prepare($queryUpdateGarage);
        $stmt->bindValue(':garageName', $garageName);
        $stmt->bindValue(':id', $idGet);
        if($stmt->execute()){
            $_SESSION['messageResponse'] = 'Garage updated';
            header('Location: ../../pageDetailGarage.php?id='.$idGet);
            exit();
        }
    }

}
else {
    $_SESSION['messageError'] = 'You are not allowed to access this page';
    header('Location: ../../index.php');
    exit();
}
?>