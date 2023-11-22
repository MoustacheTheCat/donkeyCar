<?php
require('../action.php');
if($_SESSION['user']['role'] == 'admin'){
    $dataRents = validOneRent($_GET['id']);
    $idLoc = $_GET['id'];
    $idCusto = $dataRents['customerId'];
    $idMarket = $dataRents['marketId'];
    $idCar = $dataRents['carId'];
    $locationType = $dataRents['locationType'];
    $locationDuration = $dataRents['locationDuration'];
    $locationDate = $dataRents['locationDate'];
    $locationDateStart = $dataRents['locationDateStart'];
    $locationDateEnd = $dataRents['locationDateEnd'];
    $locationHourStart = intval(substr($dataRents['locationHourStart'], 0, 2));
    $locationHourEnd = intval(substr($dataRents['locationHourEnd'], 0, 2));
    $locationCostVAT = $dataRents['locationCostOfTVA'];
    $locationCostHT = $dataRents['locationTotalHT'];
    $locationCostTTC = $dataRents['locationTotalTTC'];
    $locationCautionCost = $dataRents['locationCostCaution'];
    $locationStatus = $dataRents['locationStatus'];
    $locationValid = $dataRents['locationResume'];
    $pdo = connect_bd();
    if($_GET['type'] == 'yes'){
        $valid = 0;
        $resume = "Rent accepted";
    }
    elseif($_GET['type'] == 'no'){
        $valid = 2;
        $resume = "Rent refused";
    }
    $date = date('Y-m-d');
    if ($locationType == 'hourly'){
        $queryUpdateGarageCar = "UPDATE donkeyCar.garageCar SET garargeCarDisponibility=:garargeCarDisponibility, locationDate=:locationDate, locationHourStart=:locationHourStart, locationHourEnd=:locationHourEnd, locationType=:locationType, locationDuration=:locationDuration WHERE carId=:id";
        $stmtGc = $pdo->prepare($queryUpdateGarageCar);
        $stmtGc->bindValue(':garargeCarDisponibility', 0);
        $stmtGc->bindValue(':locationDate', $locationDate);
        $stmtGc->bindValue(':locationHourStart', $locationHourStart);
        $stmtGc->bindValue(':locationHourEnd', $locationHourEnd);
        $stmtGc->bindValue(':locationType', $locationType);
        $stmtGc->bindValue(':locationDuration', $locationDuration);
        $stmtGc->bindValue(':id', $idCar);
        $stmtGc->execute();
    }
    elseif ($locationType == 'daily'){
        $queryUpdateGarageCar = "UPDATE donkeyCar.garageCar SET garargeCarDisponibility=:garargeCarDisponibility, garargeCarLocationDateStart=:garargeCarLocationDateStart, garargeCarLocationDateEnd=:garargeCarLocationDateEnd, locationType=:locationType, locationDuration=:locationDuration WHERE carId=:id";
        $stmtGc = $pdo->prepare($queryUpdateGarageCar);
        $stmtGc->bindValue(':garargeCarDisponibility', 0);
        $stmtGc->bindValue(':garargeCarLocationDateStart', $locationDateStart);
        $stmtGc->bindValue(':garargeCarLocationDateEnd', $locationDateEnd);
        $stmtGc->bindValue(':locationType', $locationType);
        $stmtGc->bindValue(':locationDuration', $locationDuration);
        $stmtGc->bindValue(':id', $idCar);
        $stmtGc->execute();
    }
    $queryUpdateLocationValidation = "UPDATE donkeyCar.locationValidation SET locationValidationStatus=$valid WHERE locationId=$idLoc";
    $stmtLV = $pdo->prepare($queryUpdateLocationValidation);
    $stmtLV->execute();
    $queryUpdateLocation = "UPDATE donkeyCar.location SET locationStatus=:locationStatuts, locationResume=:locationResume WHERE locationId=:id";
    $stmtL = $pdo->prepare($queryUpdateLocation);
    $stmtL->bindValue(':locationStatuts', $valid);
    $stmtL->bindValue(':locationResume', $resume);
    $stmtL->bindValue(':id', $idLoc);
    $stmtL->execute();
    $customer = getOneRow('customers', 'customerId', $idCusto);
    $toCusto = $customer['customerEmail'];
    $toAdmin = "admin@donkeycar.com";
    $subject = "Status from rent number ".$idLoc;
    $headers = "From : admin@donkeycar.com";
    if ($valid == 0){
        $messageCusto = "Your Rent as Valideted\n\n";
        $messageCusto .= "Thank you for your trust\n\n";
        $messageCusto .= "The Donkey Car Team";
        $messageAdmin = "Your are Validete Rend number ".$idLoc;
    }
    elseif($valid == 2){
        $messageCusto = "Your Rent as Refused\n\n";
        $messageCusto .= "Thank you for your trust\n\n";
        $messageCusto .= "The Donkey Car Team";
        $messageAdmin = "Your not Validete Rend number ".$idLoc;
    }
    mail($toCusto, $subject, $messageCusto, $headers);
    $stm = $pdo->prepare("INSERT INTO donkeyCar.messages (messageFrom, messageSubjet, messageTo, messageText) VALUES(:messageFrom, :messageSubjet, :messageTo,:messageText)");
    $stm->bindValue(':messageFrom', $toAdmin);
    $stm->bindValue(':messageSubjet', $subject);
    $stm->bindValue(':messageTo', $toCusto);
    $stm->bindValue(':messageText', $messageCusto);
    $stm->execute();
    $idMessage = $pdo->lastInsertId();
    $idAmin = $_SESSION['user']['id'];
    $stmA = $pdo->prepare("INSERT INTO donkeyCar.messageAdmin (adminId, messageId) VALUES($idAmin, $idMessage)");
    $stmA->execute();
    $_SESSION['messageResponce'] = "The rent number ".$idLoc." has been validated";
    header('Location: ../../index.php');
    exit();
}
else {
    $_SESSION['messageError'] = 'You are not allowed to access this page';
    header('Location: ../../index.php');
    exit();
}

