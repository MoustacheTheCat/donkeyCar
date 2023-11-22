<?php
require('../../action/action.php');
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] == "customer"){
        $idCustomer = $_SESSION['user']['id'];
        $dataCustomers = getOneRow('customers', 'customerId', $idCustomer);
        $dataTotals = $_SESSION['tabTotal'];
        $nbDataRents = $_SESSION['nbDataRent'];
        $datasRents = $_SESSION['allDataRents'];
        $locationDuration = null;
        $pdo = connect_bd();
        $queryAddAskValidationAdmin = "INSERT INTO donkeyCar.locationValidationAdmin (locationValidationId, adminId) VALUES (:locationValidationId, :adminId)";
        $queryAddAskValidation = "INSERT INTO donkeyCar.locationValidation (locationId, locationValidationStatus) VALUES (:locationId, :locationValidationStatus)";
        $queryUpdateStatusCar = "UPDATE donkeyCar.garageCar SET garargeCarDisponibility=1 WHERE carId = :id";
        $tva = 1.2;
        if($nbDataRents == 1){
            $dataRents = $datasRents[0];
            $marketId = getMarketId($dataRents['garageId']);
            $carId = $dataRents['carId'];
            if($dataRents['typeRental'] == 'daily'){
                $qeuryAddLocation = "INSERT INTO donkeyCar.location (customerId, marketId, locationType ,locationDuration, locationDateStart, locationDateEnd, locationCostOfTVA, locationTotalHT, locationTotalTTC, locationCostCaution, locationStatus, locationResume) VALUES(:customerId, :marketId, :locationType, :locationDuration, :locationDateStart, :locationDateEnd, :locationCostOfTVA, :locationTotalHT, :locationTotalTTC, :locationCostCaution, :locationStatus, :locationResume)";
            }
            elseif($dataRents['typeRental'] == 'hourly'){
                $qeuryAddLocation = "INSERT INTO donkeyCar.location (customerId, marketId, locationType, locationDuration, locationDate, locationHourStart, locationHourEnd, locationCostOfTVA, locationTotalHT, locationTotalTTC, locationCostCaution, locationStatus, locationResume) VALUES(:customerId, :marketId, :locationType, :locationDuration, :locationDate, :locationHourStart, :locationHourEnd, :locationCostOfTVA, :locationTotalHT, :locationTotalTTC, :locationCostCaution, :locationStatus, :locationResume)";
            }
            $statementAddLocation = $pdo->prepare($qeuryAddLocation);
            $statementAddLocation->bindValue(':customerId', $idCustomer, PDO::PARAM_INT);
            $statementAddLocation->bindValue(':marketId', $marketId, PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationType', $dataRents['typeRental']);
            if($dataRents['typeRental'] == 'daily'){
                $statementAddLocation->bindValue(':locationDuration', $dataRents['nbDays'], PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationDateStart', $dataRents['reservationDateStart']);
                $statementAddLocation->bindValue(':locationDateEnd', $dataRents['reservationDateEnd']);
            }
            elseif($dataRents['typeRental'] == 'hourly'){
                $statementAddLocation->bindValue(':locationDuration', $dataRents['nbHours'], PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationDate', $dataRents['reservationDate'], PDO::PARAM_STR);
                $statementAddLocation->bindValue(':locationHourStart', $dataRents['reservationHourStart'], PDO::PARAM_STR);
                $statementAddLocation->bindValue(':locationHourEnd', $dataRents['reservationHourEnd'], PDO::PARAM_STR);
            }
            $statementAddLocation->bindValue(':locationCostOfTVA', $tva, PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationTotalHT', $dataTotals['totalHT'], PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationTotalTTC', $dataTotals['totalTTC'], PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationCostCaution', $dataTotals['totalCaution'], PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationStatus', 1, PDO::PARAM_INT);
            $statementAddLocation->bindValue(':locationResume', 'pending', PDO::PARAM_STR);
            $idAdmins = getAdminId($marketId);
            if($statementAddLocation->execute()){
                $idLocation = $pdo->lastInsertId();
                $statementAddCarLocation = $pdo->prepare("INSERT INTO donkeyCar.carLocation (carId, locationId) VALUES(:carId, :locationId)");
                $statementAddCarLocation->bindValue(':carId', $carId, PDO::PARAM_INT);
                $statementAddCarLocation->bindValue(':locationId', $idLocation, PDO::PARAM_INT);
                $statementAddCarLocation->execute();
                $statementAddAskValidation = $pdo->prepare($queryAddAskValidation);
                $statementAddAskValidation->bindValue(':locationId', $idLocation , PDO::PARAM_INT);
                $statementAddAskValidation->bindValue(':locationValidationStatus', '1', PDO::PARAM_STR);
                if($statementAddAskValidation->execute()){
                    $idLocationValidation = $pdo->lastInsertId();
                    $idAdmins = getAdminId($marketId);
                    $statementAddAskValidationAdmin = $pdo->prepare($queryAddAskValidationAdmin);
                    foreach ($idAdmins as $idAdmin) {
                        $statementAddAskValidationAdmin->bindValue(':locationValidationId', $idLocationValidation , PDO::PARAM_INT);
                        $statementAddAskValidationAdmin->bindValue(':adminId', $idAdmin['adminId'], PDO::PARAM_INT);
                        $statementAddAskValidationAdmin->execute();
                    }
                    $statementUpdateStatusCar = $pdo->prepare($queryUpdateStatusCar);
                    $statementUpdateStatusCar->bindValue(':id', $carId, PDO::PARAM_INT);
                    $statementUpdateStatusCar->execute();
                }
                $to = $dataCustomers['customerEmail'];
                $subject = "Ask Rental";
                $message = "Hello ".$dataCustomers['customerFirstName']." ".$dataCustomers['customerLastName'];
                $message .= "\n\n";
                $message .= "You have ask a rental for the car ".$dataRents['carModel'];
                $message .= "\n";
                $message .= "The rental start the ".$dataRents['reservationDateStart']." and end the ".$dataRents['reservationDateEnd'];
                $message .= "\n";
                if($dataRents['typeRental'] == 'daily'){
                    $locationDuration = $dataRents['nbDays'];
                    $message .= "The total duration is ".$locationDuration." days";
                    $message .= "\n";
                }
                elseif($dataRents['typeRental'] == 'hourly'){
                    $locationDuration = $dataRents['nbHours'];
                    $message .= "The total duration is ".$locationDuration." hours";
                    $message .= "\n";
                }
                $message .= "\n";
                $message .= "The total price is ".$dataTotals['totalTTC']." €";
                $message .= "\n";
                $message .= "The total caution is ".$dataTotals['totalCaution']." €";
                $message .= "\n";
                $message .= "The total price is ".$dataTotals['total']." €";
                $message .= "\n";
                $message .= "Your rental request has been received, it will be reviewed by our services and you will receive an email within 24 hours to inform you of our decision";
                $message .= "\n";
                $message .= "Thank you for your trust";
                $message .= "The Donkey Car Team";
                $headers = "From: Admin@donkeycar.com";
                if( mail($to, $subject, $message, $headers)){
                    unset($_SESSION['allDataRents']);
                    unset($_SESSION['nbDataRent']);
                    unset($_SESSION['tabTotal']);
                    $pdo = connect_bd();
                    $to2 = "admin@donkeycar.com";
                    $subject2 = "New rental request";
                    $message2 = "A new rental <a href='http://donkeycar.com/pages/pageDetailRental.php?id='".$idLocation."> location </a> has been made by a customer.\n\n Please check the list of rental requests.\n\n";
                    $headers2 = "From: ".$_SESSION['user']['email'];
                    $queryAM =  "INSERT INTO donkeyCar.messages (messageFrom, messageSubjet, messageTo, messageText) VALUES(:messageFrom, :messageSubjet, :messageTo, :messageText)";
                    $statementAM = $pdo->prepare($queryAM);
                    $statementAM->bindValue(':messageFrom', $_SESSION['user']['email'], PDO::PARAM_STR);
                    $statementAM->bindValue(':messageSubjet', $subject2, PDO::PARAM_STR);
                    $statementAM->bindValue(':messageTo', $to2, PDO::PARAM_STR);
                    $statementAM->bindValue(':messageText', $message2, PDO::PARAM_STR);
                    $statementAM->execute();
                    $idmessage = $pdo->lastInsertId();
                    $queryAM2 =  "INSERT INTO donkeyCar.messageCustomer (customerId, messageId) VALUES(:customerId, :messageId)";
                    $statementAM2 = $pdo->prepare($queryAM2);
                    $statementAM2->bindValue(':customerId', $idCustomer, PDO::PARAM_INT);
                    $statementAM2->bindValue(':messageId', $idmessage, PDO::PARAM_INT);
                    $statementAM2->execute();
                $_SESSION['messageRental'] = "Your rental is pending, you will receive an email when it is validated";
                header('Location: ../../index.php');
                exit();
                }
            }
        }else {
            foreach($datasRents as $datasRent){
                if($datasRent['typeRental'] == 'daily'){
                    $qeuryAddLocation = "INSERT INTO donkeyCar.location (customerId, marketId, locationType ,locationDuration, locationDateStart, locationDateEnd, locationCostOfTVA, locationTotalHT, locationTotalTTC, locationCostCaution, locationStatus, locationResume) VALUES(:customerId, :marketId, :locationDuration,:locationType, :locationDateStart, :locationDateEnd, :locationCostOfTVA, :locationTotalHT, :locationTotalTTC, :locationCostCaution, :locationStatus, :locationResume)";
                }
                elseif($datasRent['typeRental'] == 'hourly'){
                    $qeuryAddLocation = "INSERT INTO donkeyCar.location (customerId, marketId, locationType ,locationDuration, locationDate,locationHourtart, locationHourEnd, locationCostOfTVA, locationTotalHT, locationTotalTTC, locationCostCaution, locationStatus, locationResume) VALUES(:customerId, :marketId, :locationDuration,:locationType, :locationDate,:locationHourStart :locationHourEnd, :locationCostOfTVA, :locationTotalHT, :locationTotalTTC, :locationCostCaution, :locationStatus, :locationResume)";
                }
                $marketId = getMarketId($datasRent['garageId']);
                $carId = $datasRent['carId'];
                $statementAddLocation = $pdo->prepare($qeuryAddLocation);
                $statementAddLocation->bindValue(':customerId', $idCustomer, PDO::PARAM_INT);
                $statementAddLocation->bindValue(':marketId', $marketId, PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationType', $datasRent['typeRental'], PDO::PARAM_STR);
                if($datasRent['typeRental'] == 'daily'){
                    $statementAddLocation->bindValue(':locationDuration', $datasRent['nbDays'], PDO::PARAM_INT);
                    $statementAddLocation->bindValue(':locationDateStart', $datasRent['reservationDateStart'], PDO::PARAM_STR);
                    $statementAddLocation->bindValue(':locationDateEnd', $datasRent['reservationDateEnd'], PDO::PARAM_STR);
                }
                elseif($dataRent['typeRental'] == 'hourly'){
                    $statementAddLocation->bindValue(':locationDuration', $datasRent['nbHours'], PDO::PARAM_INT);
                    $statementAddLocation->bindValue(':locationDate', $datasRent['reservationDateStart'], PDO::PARAM_STR);
                    $statementAddLocation->bindValue(':locationHourstart', $datasRent['reservationHourStart'], PDO::PARAM_STR);
                    $statementAddLocation->bindValue(':locationHourEnd', $datasRent['reservationHourEnd'], PDO::PARAM_STR);
                }
                $statementAddLocation->bindValue(':locationCostOfTVA', $tva, PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationTotalHT', $dataTotals['totalHT'], PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationTotalTTC', $dataTotals['totalTTC'], PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationCostCaution', $dataTotals['totalCaution'], PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationStatus', 1, PDO::PARAM_INT);
                $statementAddLocation->bindValue(':locationResume', 'pending', PDO::PARAM_STR);
                $idAdmins = getAdminId($marketId);
                if($statementAddLocation->execute()){
                    $idLocation = $pdo->lastInsertId();
                    $statementAddCarLocation = $pdo->prepare("INSERT INTO donkeyCar.carLocation (carId, locationId) VALUES(:carId, :locationId)");
                    $statementAddCarLocation->bindValue(':carId', $carId, PDO::PARAM_INT);
                    $statementAddCarLocation->bindValue(':locationId', $idLocation, PDO::PARAM_INT);
                    $statementAddCarLocation->execute();
                    $statementAddAskValidation = $pdo->prepare($queryAddAskValidation);
                    $statementAddAskValidation->bindValue(':locationId', $idLocation , PDO::PARAM_INT);
                    $statementAddAskValidation->bindValue(':locationValidationStatus', '1', PDO::PARAM_STR);
                    if($statementAddAskValidation->execute()){
                        $idLocationValidation = $pdo->lastInsertId();
                        $idAdmins = getAdminId($marketId);
                        $statementAddAskValidationAdmin = $pdo->prepare($queryAddAskValidationAdmin);
                        foreach ($idAdmins as $idAdmin) {
                            $statementAddAskValidationAdmin->bindValue(':locationValidationId', $idLocationValidation , PDO::PARAM_INT);
                            $statementAddAskValidationAdmin->bindValue(':adminId', $idAdmin['adminId'], PDO::PARAM_INT);
                            $statementAddAskValidationAdmin->execute();
                        }
                        $statementUpdateStatusCar = $pdo->prepare($queryUpdateStatusCar);
                        $statementUpdateStatusCar->bindValue(':id', $carId, PDO::PARAM_INT);
                        $statementUpdateStatusCar->execute();
                    }
                }
            }
            $to = $dataCustomers['customerEmail'];
            $subject = "Ask Rental";
            $message = "Hello ".$dataCustomers['customerFirstName']." ".$dataCustomers['customerLastName'];
            $message .= "\n";
            foreach($datasRents as $datasRent){
                $message .= "You have ask a rental for the car ".$datasRent['carModel'];
                $message .= "\n";
                $message .= "The rental start the ".$datasRent['reservationDateStart']." and end the ".$datasRent['reservationDateEnd'];
                $message .= "\n";
                if($datasRent['typeRental'] == 'daily'){
                    $locationDuration = $datasRent['nbDays'];
                    $message .= "The total duration is ".$locationDuration." days";
                    $message .= "\n";
                }
                elseif($dataRent['typeRental'] == 'hourly'){
                    $locationDuration = $datasRent['nbHours'];
                    $message .= "The total duration is ".$locationDuration." hours";
                    $message .= "\n";
                }
            }
            $message .= "\n";
            $message .= "The total price is ".$dataTotals['totalTTC']." €";
            $message .= "\n";
            $message .= "The total caution is ".$dataTotals['totalCaution']." €";
            $message .= "\n";
            $message .= "The total price is ".$dataTotals['total']." €";
            $message .= "\n";
            $message .= "Your rental request has been received, it will be reviewed by our services and you will receive an email within 24 hours to inform you of our decision";
            $message .= "\n";
            $message .= "Thank you for your trust";
            $message .= "The Donkey Car Team";
            $headers = "From: Admin@donkeycar.com";
            if( mail($to, $subject, $message, $headers)){
                unset($_SESSION['allDataRents']);
                unset($_SESSION['nbDataRent']);
                unset($_SESSION['tabTotal']);
            $_SESSION['messageRental'] = "Your rental is pending, you will receive an email when it is validated";
            header('Location: ../../index.php');
            exit();
            }
            
        }
    }else{
        $_SESSION['messageRental'] = "Connect you to continue";
        header('Location: ../../pages/pageLogin.php');
        exit();
    }
}
else {
    $_SESSION['messageResponce'] =  "Method not allowed";
    header('Location: ../404.php');
}