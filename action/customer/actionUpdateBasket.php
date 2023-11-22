<?php
require('../action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $idBasket = $_GET['id'];
    $newDataRent = array();
    if(!empty($_GET['type'])){
        if($_GET['type'] == "email"){
            $_SESSION['allDataRents'][$idBasket]['email'] = $_POST['email'];
            header('Location: ../../pages/customer/pageEditBasket.php?id='.$idBasket);
            exit;
        }
        elseif($_GET['type'] == 'car'){
            $datasrents = $_SESSION['allDataRents'][$idBasket];
            $car = getOneRowCarWithTypeAndBrand($_GET['car']);
            $_SESSION['allDataRents'][$idBasket]['carId'] = $_GET['car'];
            $_SESSION['allDataRents'][$idBasket]['carModel'] = $_POST['updateCar'];
            $_SESSION['allDataRents'][$idBasket]['carImmatriculation'] = $car['carImmatriculation'];
            if($_SESSION['allDataRents'][$idBasket]['typeRental'] == 'hourly'){
                $totalHC = $datasrents['carTarifHourHT'] * $datasrents['nbDays'];
                $totalTTC = $datasrents['carTarifHourHT'] * 1.2 * $datasrents['nbDays'];
                $caution = $datasrents['carCaution'];
                $_SESSION['tabTotal']['totalHT'] -= $totalHT;
                $_SESSION['tabTotal']['totalTTC'] -= $totalTTC;
                $_SESSION['tabTotal']['totalCaution'] -= $caution;
                $total = $totalTTC+$caution;
                $_SESSION['tabTotal']['total'] -= $total;
                $_SESSION['allDataRents'][$idBasket]['carTarifHourHT'] = $car['carTarifHourHT'];
                $totalHC = $car['carTarifHourHT'] * $_SESSION['allDataRents'][$idBasket]['nbHours'];
                $totalTTC = $car['carTarifHourHT'] * 1.2 * $_SESSION['allDataRents'][$idBasket]['nbHours'];
            }
            elseif($_SESSION['allDataRents'][$idBasket]['typeRental'] == 'daily'){
                $totalHC = $datasrents['carTarifDayHT'] * $datasrents['nbDays'];
                $totalTTC = $datasrents['carTarifDayHT'] * 1.2 * $datasrents['nbDays'];
                $caution = $datasrents['carCaution'];
                $_SESSION['tabTotal']['totalHT'] -= $totalHT;
                $_SESSION['tabTotal']['totalTTC'] -= $totalTTC;
                $_SESSION['tabTotal']['totalCaution'] -= $caution;
                $total = $totalTTC+$caution;
                $_SESSION['tabTotal']['total'] -= $total;
                $_SESSION['allDataRents'][$idBasket]['carTarifDayHT'] = $car['carTarifDayHT'];
                $totalHC = $car['carTarifDayHT'] * $_SESSION['allDataRents'][$idBasket]['nbDays'];
                $totalTTC = $car['carTarifDayHT'] * 1.2 * $_SESSION['allDataRents'][$idBasket]['nbDays'];
            }
            $_SESSION['tabTotal']['totalHT'] += $totalHT;
            $_SESSION['tabTotal']['totalTTC'] += $totalTTC;
            $_SESSION['tabTotal']['totalCaution'] += $car['carCaution'];
            $total = $totalTTC+$car['carCaution'];
            $_SESSION['tabTotal']['total'] += $total;
            $_SESSION['allDataRents'][$idBasket]['carCaution'] = $car['carCaution'];
            header('Location: ../../pages/customer/pageEditBasket.php?id='.$idBasket);
            exit;
        }
        elseif($_GET['type'] == 'daily'){
            $_SESSION['tabTotal'] = $_SESSION['tabTotal'];
            $datasrents = $_SESSION['allDataRents'][$_GET['id']];
            $totalHT = $datasrents['carTarifDayHT'] * $datasrents['nbDays'];
            $totalTTC = $datasrents['carTarifDayHT'] * 1.2 * $datasrents['nbDays'];
            $_SESSION['tabTotal']['totalHT'] -= $totalHT;
            $_SESSION['tabTotal']['totalTTC'] -= $totalTTC;
            $_SESSION['tabTotal']['total'] -= $totalTTC;
            $_SESSION['allDataRents'][$idBasket]['reservationDateStart'] = $_POST['reservationDateStart'];
            $_SESSION['allDataRents'][$idBasket]['reservationDateEnd'] = $_POST['reservationDateEnd'];
            if(verifDateValid ($_POST['reservationDateStart'], $_POST['reservationDateEnd']) != false){
                $_SESSION['allDataRents'][$idBasket]['nbDays'] = verifDateValid($_POST['reservationDateStart'], $_POST['reservationDateEnd']);
            }
            $nbDays = verifDateValid($_POST['reservationDateStart'], $_POST['reservationDateEnd']);
            $totalHT = $datasrents['carTarifDayHT'] * $nbDays;
            $totalTTC = $datasrents['carTarifDayHT'] * 1.2 * $nbDays;
            $_SESSION['tabTotal']['totalHT'] += $totalHT;
            $_SESSION['tabTotal']['totalTTC'] += $totalTTC;
            $_SESSION['tabTotal']['total'] += $total;
            header('Location: ../../pages/customer/pageEditBasket.php?id='.$idBasket);
            exit();
        }
        elseif($_GET['type'] == 'hourly'){
            $_SESSION['tabTotal'] = $_SESSION['tabTotal'];
            $datasrents = $_SESSION['allDataRents'][$_GET['id']];
            $totalHT = $datasrents['carTarifHourHT'] * $datasrents['nbHours'];
            $totalTTC = $datasrents['carTarifHourHT'] * 1.2 * $datasrents['nbHours'];
            $_SESSION['tabTotal']['totalHT'] -= $totalHT;
            $_SESSION['tabTotal']['totalTTC'] -= $totalTTC;
            $_SESSION['tabTotal']['total'] -= $totalTTC;
            $_SESSION['allDataRents'][$idBasket]['reservationDate'] = $_POST['reservationDate'];
            $_SESSION['allDataRents'][$idBasket]['reservationHourStart'] = $_POST['reservationHourStart'];
            $_SESSION['allDataRents'][$idBasket]['reservationHourEnd'] = $_POST['reservationHourEnd'];
            $nbHour = intval(substr($_POST['reservationHourEnd'], 0, 2)) - intval(substr($_POST['reservationHourStart'], 0, 2));
            if($nbHour < 0){
                $_SESSION['messageError'] =  "The end time must be greater than the start time";
            }else {
                $_SESSION['messageResponce'] =  "You have Update a hourly rental";
                $_SESSION['allDataRents'][$idBasket]['nbHours'] = $nbHour;
                $totalHC = $datasrents['carTarifHourHT'] * $nbHour;
                $totalTTC = $datasrents['carTarifHourHT'] * 1.2 * $nbHour;
                $_SESSION['tabTotal']['totalHT'] += $totalHT;
                $_SESSION['tabTotal']['totalTTC'] += $totalTTC;
                $_SESSION['tabTotal']['total'] += $totalTTC;
            
            header('Location: ../../pages/customer/pageEditBasket.php?id='.$idBasket);
            exit;
            }
        }
        elseif($_GET['type'] == 'typerent'){
            $_SESSION['allDataRents'][$idBasket]['typeRental'] = $_POST['typeRental'];
            header('Location: ../../pages/customer/pageEditBasket.php?id='.$idBasket.'&type='.$_POST['typeRental']);
            exit;
        }
        else {
            $_SESSION['messageError'] =  "type not found";
            header('Location: ../404.php');
        }
    }else {
        $_SESSION['messageResponce'] =  "not type selected";
        header('Location: ../404.php');
    }
}else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}