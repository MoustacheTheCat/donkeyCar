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
            $_SESSION['messageRental'] = "You have not chosen a rental type";
            $step = "type";
        }
        header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step='.$step);
    }
    elseif(isset($_POST['validerentalDate'])){
        $datasRents = $_SESSION['dataRents'];
        $datasRents['reservationDateStart'] = $_POST['reservationDateStart'];
        if($_GET['step'] == "hourly"){
            $datasRents['reservationDateEnd'] = $_POST['reservationDateStart'];
            $datasRents['carTarifHourHT'] = $_POST['carTarifHourHT'];
            $datasRents['reservationHourStart'] = $_POST['reservationHourStart'];
            $datasRents['reservationHourEnd'] = $_POST['reservationHourEnd'];
            $hourStart = intval(substr($_POST['reservationHourStart'], 0, 2));
            $hourEnd = intval(substr($_POST['reservationHourEnd'], 0, 2));
            $nbHours = $hourEnd - $hourStart;
            if($nbHours < 0){
                $_SESSION['messageRental'] = "The end time must be greater than the start time";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=hourly');
                exit();
            }
            $datasRents['nbHours'] = $nbHours;

        }else {
            $datasRents['reservationDateEnd'] = $_POST['reservationDateEnd'];
            $datasRents['carTarifDayHT'] = $_POST['carTarifDayHT'];
            $yearStart = substr($_POST['reservationDateStart'], 0, 4);
            $yearEnd = substr($_POST['reservationDateEnd'], 0, 4);
            $monthStart = substr($_POST['reservationDateStart'], 5, 2);
            $monthEnd = substr($_POST['reservationDateEnd'], 5, 2);
            $dayStart = substr($_POST['reservationDateStart'], 8, 2);
            $dayEnd = substr($_POST['reservationDateEnd'], 8, 2);
            $nbDays = null;
            if($yearStart > $yearEnd){
                $_SESSION['messageRental'] = "The end date must be greater than the start date";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=daily');
                exit();
            }
            elseif($yearStart == $yearEnd && $monthStart > $monthEnd){
                $_SESSION['messageRental'] = "The end date must be greater than the start date";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=daily');
                exit();
            }
            elseif($yearStart == $yearEnd && $monthStart == $monthEnd && $dayStart > $dayEnd){
                $_SESSION['messageRental'] = "The end date must be greater than the start date";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=daily');
                exit();
            }
            elseif($yearStart == $yearEnd && $monthStart == $monthEnd && $dayStart == $dayEnd){
                $_SESSION['messageRental'] = "The end date must be greater than the start date";
                header('Location: ../../pages/customer/pageAskRental.php?id='.$id.'&step=daily');
                exit();
            }
            elseif($yearStart == $yearEnd && $monthStart == $monthEnd && $dayStart < $dayEnd){
                $days = $dayEnd - $dayStart;
                $nbDays = $days;
            }
            elseif($yearStart == $yearEnd && $monthStart < $monthEnd && $dayStart < $dayEnd){
                $daysInMounth = null;
                if($monthStart == 1 || $monthStart == 3 || $monthStart == 5 || $monthStart == 7 || $monthStart == 8 || $monthStart == 10 || $monthStart == 12){
                    $daysInMounth = 31;
                }
                elseif($monthStart == 4 || $monthStart == 6 || $monthStart == 9 || $monthStart == 11){
                    $daysInMounth = 30 ;
                }
                elseif($monthStart == 2){
                    $daysInMounth = 28 ;
                }
                $months = $monthEnd - $monthStart;
                $days = $dayEnd - $dayStart;
                $nbDays = $days + ($months * $daysInMounth);
            }
            elseif($yearStart < $yearEnd && $monthStart < $monthEnd && $dayStart < $dayEnd){
                $daysInMounth = null;
                if($monthStart == 1 || $monthStart == 3 || $monthStart == 5 || $monthStart == 7 || $monthStart == 8 || $monthStart == 10 || $monthStart == 12){
                    $daysInMounth = 31;
                }
                elseif($monthStart == 4 || $monthStart == 6 || $monthStart == 9 || $monthStart == 11){
                    $daysInMounth = 30 ;
                }
                elseif($monthStart == 2){
                    $daysInMounth = 28 ;
                }
                $years = $yearEnd - $yearStart;
                $months = $monthEnd - $monthStart ;
                $days =  $dayStart + $dayEnd;
                $nbDays = $days + ($months * $daysInMounth) + ($years * 365);
            }
            $datasRents['nbDays'] = $nbDays;
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
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}

