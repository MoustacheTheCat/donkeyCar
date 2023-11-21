<?php

require('action.php');
unset($_SESSION['messageResponce']);
unset($_SESSION['cars']);
unset($_SESSION['nbMarkets']);
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST['filterCountryCity']) && $_POST['filterCountryCity'] == "search"){
        if($_POST['selectCity'] == "city" && $_POST['selectCountry'] == "country"){
            $_SESSION['messageResponce'] =  "You have not chosen a country or a city , please choose a country or a city";
            header('Location: ../index.php');
            exit();
        }
        else {
            if($_POST['selectCountry'] == "country" && $_POST['selectCity'] != "city"){
                echo "Yes city";
                $marketId = $_POST['selectCity'];
                $cars = getAllCarInGarageByMarketIdWithMarketDetail($marketId);
                $_SESSION['cars'] = $cars;
                $_SESSION['messageResponce'] = "Here are the cars available in the city you have chosen";
            }
            elseif($_POST['selectCity'] == "city" && $_POST['selectCountry'] != "country"){
                echo "Yes country";
                $marketName = $_POST['selectCountry'];
                $markets = getAllData('markets');
                $countrys = array();
                foreach ($markets as $market) {
                    if($market['marketCountry'] == $marketName){
                        $countrys[] = $market['marketId'];
                    }
                }
                $tabresult = array();
                foreach ($countrys as $country) {
                    $cars = getAllCarInGarageByMarketIdWithMarketDetail($country);
                    foreach ($cars as $car) {
                        $tabresult[] = $car;
                    }
                }
                $_SESSION['cars'] = $tabresult;
                $_SESSION['nbMarkets'] = count($countrys);
                $_SESSION['marketCity'] = $countrys;
                $_SESSION['messageResponce'] =  "Here is the list of cities offering car rental services, as well as the cars available in the country of your choice";
            }
        }
    }
    elseif (isset($_POST['filterTypeYear']) && $_POST['filterTypeYear'] == "search"){
        if($_POST['selectYear'] == "year" && $_POST['selectType'] == "type"){
            $_SESSION['messageResponce'] =  "You have not chosen a type or a Year, please choose a year or a type of car or";
            header('Location: ../index.php');
            exit();
        }
        else {
            if($_POST['selectType'] == "type" && $_POST['selectYear'] != "year"){
                $datas = $_SESSION['cardatas'];
                unset($_SESSION['cardatas']);
                $year = $_POST['selectYear'];
                $cars = array();
                foreach ($datas as $data) {
                    if($data['carYear'] == $year){
                        $cars[] = $data;
                    }
                }
                $_SESSION['cars'] = $cars;
                $_SESSION['messageResponce'] =  "Here are the cars available in the year you have chosen";
            }
            if($_POST['selectYear'] == "year"&& $_POST['selectType'] != "type"){
                $datas = $_SESSION['cardatas'];
                unset($_SESSION['cardatas']);
                $typeCar = $_POST['selectType'];
                $cars = array();
                foreach ($datas as $data) {
                    if($data['typeCarName'] == $typeCar){
                        $cars[] = $data;
                    }
                }
                $_SESSION['cars'] = $cars;
                $_SESSION['messageResponce'] =  "Here are the cars available in the type you have chosen";
            }
        }
    }
    if(!empty($_SESSION['cars'])){
        header('Location: ../index.php');
        exit();
    }
    else {
        $_SESSION['messageResponce'] =  "No car available";
        header('Location: ../index.php');
        exit();
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}
