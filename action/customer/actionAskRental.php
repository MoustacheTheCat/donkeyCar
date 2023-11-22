<?php 
require('../action.php');
unset($_SESSION['messageRental']);
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_GET['id'];
    if(isset($_POST['validerental'])){
        $_SESSION['dataRents'] = $_POST;
        $step = null;
        if(isset($_POST['typeRental']) && $_POST['typeRental'] == "daily"){
            $_SESSION['messageRental'] = "You have chosen a daily rental";
            $step = "daily";
        }
        elseif(isset($_POST['typeRental']) && $_POST['typeRental'] == "hourly"){
            $_SESSION['messageRental'] = "You have chosen a hourly rental";
            $step = "hourly";
        }
        else {
            $_SESSION['messageError'] = "You have not chosen a rental type";
            $step = "type";
        }
        header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step='.$step);
    }
    elseif(isset($_POST['validerentalDate'])){
        $datasRents = $_SESSION['dataRents'];
        if($_GET['step'] == "hourly"){
            $datasRents['reservationDate'] = $_POST['reservationDate'];
            $datasRents['carTarifHourHT'] = $_POST['carTarifHourHT'];
            $datasRents['reservationHourStart'] = $_POST['reservationHourStart'];
            $datasRents['reservationHourEnd'] = $_POST['reservationHourEnd'];
            $hourStart = intval(substr($_POST['reservationHourStart'], 0, 2));
            $hourEnd = intval(substr($_POST['reservationHourEnd'], 0, 2));
            $nbHours = $hourEnd - $hourStart;
            if($nbHours < 0){
                $_SESSION['messageError'] = "The end time must be greater than the start time";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=hourly');
                exit();
            }
            $datasRents['nbHours'] = $nbHours;

        }else {
            $datasRents['reservationDateStart'] = $_POST['reservationDateStart'];
            $datasRents['reservationDateEnd'] = $_POST['reservationDateEnd'];
            $datasRents['carTarifDayHT'] = $_POST['carTarifDayHT'];
            if(verifDateValid ($_POST['reservationDateStart'], $_POST['reservationDateEnd']) != false){
                $datasRents['nbDays'] = verifDateValid($_POST['reservationDateStart'], $_POST['reservationDateEnd']);
            }
            else {
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=daily');
                exit();
            }
            
        }
        unset($_SESSION['dataRents']);
        $saveDatasRents = $_SESSION['allDataRents'];
        $saveDatasRents[] = $datasRents;
        $_SESSION['allDataRents'] = $saveDatasRents;
        $_SESSION['messageRental'] = "You have chosen a rental from ".$datasRents['reservationDateStart']." to ".$datasRents['reservationDateEnd'];
        $_SESSION['nbDataRent'] +=1;
        header('Location: ../../index.php');    
    }
}else {
    $_SESSION['messageError'] =  "Method not allowed";
    header('Location: ../404.php');
}

