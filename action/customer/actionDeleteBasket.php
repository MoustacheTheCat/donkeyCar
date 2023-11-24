<?php
require('../action.php');
$id = $_GET['id'];
$nbData = count($_SESSION['allDataRents']);
$datasrents = $_SESSION['allDataRents'][$id];
if(isset($_GET['id'])){
    if($nbData === 1){
        unset($_SESSION['allDataRents']);
        unset($_SESSION['nbDataRent']);
        unset($_SESSION['tabTotal']);
        $_SESSION['messageRental'] = "Your your basket is empty";
        header('Location: ../../index.php');
        exit();
    }else {
        $caution = $datasrents['carCaution'];
        if($datasrents['typeRental'] == "hourly"){
            $totalHT = $datasrents['carTarifHourHT'] * $datasrents['nbHours'];
            $totalTTC = $datasrents['carTarifHourHT'] * 1.2 * $datasrents['nbHours'];
            
        }
        elseif($datasrents['typeRental'] == "daily"){
            $totalHC = $datasrents['carTarifDayHT'] * $datasrents['nbDays'];
            $totalTTC = $datasrents['carTarifDayHT'] * 1.2 * $datasrents['nbDays'];
        }
        $total = $totalTTC+$caution;
        $_SESSION['tabTotal']['totalHT'] -= $totalHT;
        $_SESSION['tabTotal']['totalTTC'] -= $totalTTC;
        $_SESSION['tabTotal']['totalCaution'] -= $caution;
        $_SESSION['tabTotal']['total'] -= $total;
        unset($_SESSION['allDataRents'][$id]);
        $_SESSION['nbDataRent'] -= 1;
        if($_SESSION['nbDataRent'] == 0){
            unset($_SESSION['allDataRents']);
            unset($_SESSION['nbDataRent']);
            unset($_SESSION['tabTotal']);
            $_SESSION['messageRental'] = "Your your basket is empty";
            header('Location: ../../index.php');
            exit();
        }
    }
    $_SESSION['messageRental'] = "You have delete a rental";
    header('Location: ../../pages/pagesBasket.php');
    exit();
}else {
    $_SESSION['messageError'] = "You have not delete a rental";
    header('Location: ../../pages/pagesBasket.php');
    exit();
}