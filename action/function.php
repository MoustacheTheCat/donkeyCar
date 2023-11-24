<?php


// function conect_bd() and request GET to database

function connect_bd() : PDO {
    require_once '/var/www/html/donkeyCar/config/_connect.php';
    try {
        $pdo = new \PDO(DSN, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
    }
}


function getEmail(){
    $pdo = connect_bd();
    $queryA = $pdo->prepare('SELECT adminId,adminEmail FROM admins ');
    $queryA->execute();
    $emailAdmins = $queryA->fetchAll(PDO::FETCH_ASSOC);
    $queryC = $pdo->prepare('SELECT customerId, customerEmail FROM customers ');
    $queryC->execute();
    $emailCustomers = $queryC->fetchAll(PDO::FETCH_ASSOC);
    $tabEmails = array();
    foreach ($emailAdmins as $key => $emailAdmin) {
        if ($emailAdmin['adminId'] < 10){
            $emailAdmin['adminId'] = '0'.$emailAdmin['adminId'];
        }
        $tabEmails[] = $emailAdmin['adminId'].'_'.$emailAdmin['adminEmail'];
    }
    foreach ($emailCustomers as $key => $emailCustomer) {
        if ($emailCustomer['customerId'] < 10){
            $emailCustomer['customerId'] = '0'.$emailCustomer['customerId'];
        }
        $tabEmails[] = $emailCustomer['customerId'].'_'.$emailCustomer['customerEmail'];
    }
    return $tabEmails;
}
function getEmailCustomer(){
    $pdo = connect_bd();
    $queryC = $pdo->prepare('SELECT customerId, customerEmail FROM customers ');
    $queryC->execute();
    $emailCustomers = $queryC->fetchAll(PDO::FETCH_ASSOC);
    $tabEmails = array();
    foreach ($emailCustomers as $key => $emailCustomer) {
        if ($emailCustomer['customerId'] < 10){
            $emailCustomer['customerId'] = '0'.$emailCustomer['customerId'];
        }
        $tabEmails[] = $emailCustomer['customerId'].'_'.$emailCustomer['customerEmail'];
    }
    return $tabEmails;
}
function verifEmail($email){
    $dataUsers = getEmailCustomer();
    $data = array();
    foreach($dataUsers as $dataUser){
        if(substr($dataUser,3) == $email){
            if(substr($dataUser,0,2) < 10){
                $data[] = substr($dataUser,1,1);
            }
            else{
                $data[] = substr($dataUser,0,2);
            }
        }
    }
    return $data;
}
function getEmailAndRole(){
    $pdo = connect_bd();
    $queryA = $pdo->prepare('SELECT adminEmail FROM admins ');
    $queryA->execute();
    $emailAdmins = $queryA->fetchAll(PDO::FETCH_ASSOC);
    $queryC = $pdo->prepare('SELECT customerEmail FROM customers ');
    $queryC->execute();
    $emailCustomers = $queryC->fetchAll(PDO::FETCH_ASSOC);
    $tabEmails = array();
    foreach ($emailAdmins as $key => $emailAdmin) {
        $tabEmails[] = 'a_'.$emailAdmin['adminEmail'];
    }
    foreach ($emailCustomers as $key => $emailCustomer) {
        $tabEmails[] = 'c_'.$emailCustomer['customerEmail'];
    }
    return $tabEmails;
}

//fucntion get one or two data in a table defined in the function

function getMarketCitys(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT marketId, marketCity FROM markets ORDER BY markets.marketCity' );
    $query->execute();
    $markets = $query->fetchAll(PDO::FETCH_ASSOC);
    return $markets;
}

function getMarketsCountry(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT marketId, marketCountry FROM markets ORDER BY markets.marketCountry' );
    $query->execute();
    $markets = $query->fetchAll(PDO::FETCH_ASSOC);
    $listMarketCountrys = array();
    foreach ($markets as $market) {
        if(!in_array($market['marketCountry'], $listMarketCountrys)){
            $listMarketCountrys[] = $market['marketCountry'];
        }
            
    }
    return $listMarketCountrys;
}

function getTypeCarModel(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT typeCarName FROM typeCar ORDER BY typeCar.typeCarName' );
    $query->execute();
    $typeCars = $query->fetchAll(PDO::FETCH_ASSOC);
    $listTypeCars = array();
    foreach ($typeCars as $typeCar) {
        if(!in_array($typeCar['typeCarName'], $listTypeCars)){
            $listTypeCars[] = $typeCar['typeCarName'];
        }
            
    }
    return  $listTypeCars;

}

function getMarketId($id){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT  g.marketId FROM garages g  WHERE g.garageId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $marketId = $query->fetch(PDO::FETCH_ASSOC);
    return $marketId;
}

function getMarket(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT  ma.*, m.marketName FROM marketAdmin ma JOIN markets m ON m.marketId = ma.marketId');
    $query->execute();
    $market = $query->fetchAll(PDO::FETCH_ASSOC);
    return $market;
}

function getAdminId($id){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT * FROM marketAdmin WHERE marketAdmin.marketId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $adminId = $query->fetchAll(PDO::FETCH_ASSOC);
    return $adminId;
}

function getAllEmail(){
    $pdo = connect_bd();
    $queryA = $pdo->prepare('SELECT a.adminEmail, a.adminId FROM admins a ');
    $queryA->execute();
    $dataAdmins = $queryA->fetchAll(PDO::FETCH_ASSOC);
    $queryC = $pdo->prepare('SELECT  c.customerEmail, c.customerId FROM customers c' );
    $queryC->execute();
    $dataCus = $queryC->fetchAll(PDO::FETCH_ASSOC);
    $tabDatas = array();
    foreach ($dataAdmins as $dataAdmin) {
        $tabDatas[] = $dataAdmin;
    }
    foreach ($dataCus as $dataCu) {
        $tabDatas[] = $dataCu;
    }
    return $tabDatas;
}

function getCarYear(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT carYear FROM cars ORDER BY cars.carYear' );
    $query->execute();
    $carYears = $query->fetchAll(PDO::FETCH_ASSOC);
    $listCarYears = array();
    foreach ($carYears as $carYear) {
        if(!in_array(substr($carYear['carYear'],0,4), $listCarYears)){
            $listCarYears[] = substr($carYear['carYear'],0,4);
        }
    }
    return $listCarYears;
}

// function Get All 

function getAllData($table) : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT * FROM '.$table);
    $query->execute();
    $cars = $query->fetchAll(PDO::FETCH_ASSOC);
    return $cars;
}

function getAllConfim (){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT * FROM locationValidation');
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}



function getAllCarWithTypeAndBrand() : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT cars.*,typeCar.typeCarName, brands.brandName FROM cars INNER JOIN typeCar ON cars.typeCarId = typeCar.typeCarId INNER JOIN brands ON cars.brandId = brands.brandId ORDER BY c.carModel ASC');
    $query->execute();
    $cars = $query->fetchAll(PDO::FETCH_ASSOC);
    return $cars;
}

function getAllCarInGarageWithDetail() : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT cars.carId ,cars.carName ,cars.carImmatriculation ,cars.carYear ,cars.carTarifHourHT ,cars.carTarifDayHT ,cars.carCaution , garageCar.garargeCarDisponibility, garageCar.garargeCarLocationDateStart, garageCar.garargeCarLocationDateEnd ,typeCar.typeCarName ,brands.brandName , garages.garageName FROM garageCar  JOIN cars  ON cars.carId = garageCar.carId JOIN typeCar  ON cars.typeCarId = typeCar.typeCarId JOIN brands  ON cars.brandId  = brands.brandId join garages ON garages.garageId = garageCar.garageId ORDER BY c.carModel ASC');
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

function getAllCarWithDetailGarageAndMarketDetail() : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT c.carId,c.carName,c.carImmatriculation,c.carYear,c.carTarifHourHT,c.carTarifDayHT,c.carCaution,gc.garargeCarDisponibility,gc.garargeCarLocationDateStart,gc.garargeCarLocationDateEnd,tc.typeCarName,b.brandName,g.garageName,m.marketId,m.marketName,m.marketCity,m.marketAdress,m.marketZip,m.marketCountry FROM garageCar gc JOIN cars c ON c.carId = gc.carId  JOIN typeCar tc ON c.typeCarId = tc.typeCarId JOIN brands b ON c.brandId  = b.brandId JOIN garages g ON g.garageId = gc.garageId JOIN markets m ON m.marketId = g.marketId ORDER BY c.carName ASC');
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
} 

function getAllMarketWithGarage(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT m.*, g.garageName, g.garageId FROM garages g JOIN markets m ON g.marketId = m.marketId ORDER BY m.marketCity ASC');
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

function getAllValidRent(){
    $pdo = connect_bd();
    $query = $pdo->prepare( "SELECT l.*, c.carName,c.carId, b.brandName FROM locationValidationAdmin lva JOIN locationValidation lv ON lv.locationValidationId = lva.locationValidationId JOIN location l ON l.locationId = lv.locationId JOIN carLocation cl ON cl.locationId = l.locationId JOIN cars c ON c.carId = cl.carId JOIN brands b ON c.brandId = b.brandId");
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

// function Get datas with condition

function getOneRow ($table, $col, $id) :array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT * FROM '.$table.' WHERE '.$col.' = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $car = $query->fetch(PDO::FETCH_ASSOC);
    return $car;
}

function getOneRowCarWithTypeAndBrand($id) : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT cars.*,typeCar.typeCarName, brands.brandName, g.garageName, g.garageId FROM cars  JOIN typeCar ON cars.typeCarId = typeCar.typeCarId  JOIN brands ON cars.brandId = brands.brandId JOIN garageCar gc ON gc.carId = cars.carId JOIN garages g ON gc.garageId = g.garageId WHERE cars.carId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $cars = $query->fetch(PDO::FETCH_ASSOC);
    return $cars;
}



function getAllCarInGarageByMarketId($id) : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT cars.carId ,cars.carName ,cars.carImmatriculation ,cars.carYear ,cars.carTarifHourHT ,cars.carTarifDayHT ,cars.carCaution , garageCar.garargeCarDisponibility, garageCar.garargeCarLocationDateStart, garageCar.garargeCarLocationDateEnd ,typeCar.typeCarName ,brands.brandName , garages.garageName FROM garageCar  JOIN cars  ON cars.carId = garageCar.carId JOIN typeCar  ON cars.typeCarId = typeCar.typeCarId JOIN brands  ON cars.brandId  = brands.brandId join garages ON garages.garageId = garageCar.garageId  WHERE garages.marketId = :id ORDER BY c.carModel ASC');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
} 

function getOnCarInGarageByCarId($id) : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT cars.carId ,cars.carName ,cars.carImmatriculation ,cars.carYear ,cars.carTarifHourHT ,cars.carTarifDayHT ,cars.carCaution , garageCar.garageId, garageCar.garargeCarDisponibility, garageCar.garargeCarLocationDateStart, garageCar.garargeCarLocationDateEnd ,typeCar.typeCarName ,brands.brandName , garages.garageName FROM garageCar  JOIN cars  ON cars.carId = garageCar.carId JOIN typeCar  ON cars.typeCarId = typeCar.typeCarId JOIN brands  ON cars.brandId  = brands.brandId join garages ON garages.garageId = garageCar.garageId  WHERE cars.carId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetch(PDO::FETCH_ASSOC);
    return $datas;
} 

function getAllCarInGarageByMarketIdWithMarketDetail($id) : array {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT c.carId,c.carName,c.carImmatriculation,c.carYear,c.carTarifHourHT,c.carTarifDayHT,c.carCaution,gc.garargeCarDisponibility,gc.garargeCarLocationDateStart,gc.garargeCarLocationDateEnd,tc.typeCarName,b.brandName,g.garageName,m.marketId,m.marketName,m.marketCity,m.marketAdress,m.marketZip,m.marketCountry FROM garageCar gc JOIN cars c ON c.carId = gc.carId  JOIN typeCar tc ON c.typeCarId = tc.typeCarId JOIN brands b ON c.brandId  = b.brandId JOIN garages g ON g.garageId = gc.garageId JOIN markets m ON m.marketId = g.marketId WHERE m.marketId = :id ORDER BY c.carName ASC');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
} 

function getValidRent($id){
    $pdo = connect_bd();
    $query = $pdo->prepare( "SELECT l.*, c.carName,c.carId, b.brandName FROM locationValidationAdmin lva JOIN locationValidation lv ON lv.locationValidationId = lva.locationValidationId JOIN location l ON l.locationId = lv.locationId JOIN carLocation cl ON cl.locationId = l.locationId JOIN cars c ON c.carId = cl.carId JOIN brands b ON c.brandId = b.brandId  WHERE lva.adminId = :id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

function validOneRent($id){
    $pdo = connect_bd();
    $query = $pdo->prepare( "SELECT l.*,c.carId FROM locationValidationAdmin lva JOIN locationValidation lv ON lv.locationValidationId = lva.locationValidationId JOIN location l ON l.locationId = lv.locationId JOIN carLocation cl ON cl.locationId = l.locationId JOIN cars c ON c.carId = cl.carId  WHERE l.locationId = :id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetch(PDO::FETCH_ASSOC);
    return $datas;
}


function getRent($id){
    $pdo = connect_bd();
    $query = $pdo->prepare( "SELECT l.*, c.carName,c.carId, b.brandName FROM locationValidationAdmin lva JOIN locationValidation lv ON lv.locationValidationId = lva.locationValidationId JOIN location l ON l.locationId = lv.locationId JOIN carLocation cl ON cl.locationId = l.locationId JOIN cars c ON c.carId = cl.carId JOIN brands b ON c.brandId = b.brandId  WHERE l.locationId = :id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetch(PDO::FETCH_ASSOC);
    return $datas;
}

function printCustomerName($id)  {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT customerFirstName, customerLastName FROM customers WHERE customerId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $customer = $query->fetch(PDO::FETCH_ASSOC);
    $name = $customer['customerFirstName'].' '.$customer['customerLastName'];
    return $name;
}

function printMarketName($id)  {
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT marketName FROM markets WHERE marketId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    $name = $data['marketName'];    
    return $name;
}

function getMarketsGarages(){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT m.*, g.garageName, g.garageId FROM garages g JOIN markets m ON g.marketId = m.marketId ORDER BY m.marketCity ASC');
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

function getOneMarketsGarages($id, $col){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT m.*, g.garageName, g.garageId FROM garages g JOIN markets m ON g.marketId = m.marketId WHERE g.'.$col.'=:id ORDER BY m.marketCity ASC');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $datas = $query->fetch(PDO::FETCH_ASSOC);
    return $datas;
}

function messageRead($id, $idAdmin){
    $message = getOneRow('messages', 'messageId', $id);
    if($message['messageStatus'] == 0){
        $pdo = connect_bd();
        $query = $pdo->prepare('UPDATE donkeyCar.messages SET messageStatus = 1 WHERE messageId = :messageId');
        $query->bindValue(':messageId', $id);
        $query->execute();
        $query = $pdo->prepare('INSERT INTO donkeyCar.messageAdmin (messageId, adminId) VALUES(:messageId, :adminId)');
        $query->bindValue(':messageId', $id);
        $query->bindValue(':adminId', $idAdmin);
        $query->execute();
    }
    return $message;
}

function countMessageNoRead(){
    $dataM = getAllData('messages');
    $countNotread = 0;
    foreach ($dataM as $data) {
        if($data['messageStatus'] == 0){
            $countNotread++;
        }
    }
    return $countNotread;
}




function getCarGarageMarketNameWhereId($id){
    $pdo = connect_bd();
    $stmt = $pdo->prepare('SELECT c.carName,c.carId, b.brandName, g.garageName, m.marketId, m.marketName FROM garageCar gc JOIN garages g ON gc.garageId = g.garageId JOIN cars c ON gc.carId = c.carId JOIN  markets m ON g.marketId = m.marketId JOIN brands b ON b.brandId = c.brandId WHERE g.garageId = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetch(PDO::FETCH_ASSOC);
    return $datas;
    
}

function selectAllCarInGarage($id){
    $pdo = connect_bd();
    $stmt = $pdo->prepare('SELECT  c.*, b.brandName ,t.typeCarName FROM garageCar gc JOIN garages g ON gc.garageId = g.garageId JOIN cars c ON gc.carId = c.carId JOIN  markets m ON g.marketId = m.marketId JOIN brands b ON b.brandId = c.brandId JOIN typeCar t ON t.typeCarId = c.typeCarId WHERE g.garageId = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

function selectAllCarInGarageByGId($id){
    $pdo = connect_bd();
    $stmt = $pdo->prepare('SELECT c.*, b.brandName ,t.typeCarName FROM garageCar gc JOIN garages g ON gc.garageId = g.garageId JOIN cars c ON gc.carId = c.carId JOIN  markets m ON g.marketId = m.marketId JOIN brands b ON b.brandId = c.brandId JOIN typeCar t ON t.typeCarId = c.typeCarId WHERE m.marketId = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $datas;
}

// function print (index.php)


function printTableHome($city, $cars){
    echo ('
    <div class="row mt-4 mb-4">
        <div class="col">
            <table class="table m-5 b-5">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Year</th>
                        <th>Daily rate</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
    ');
    foreach ($cars as $car) {
        if($car['marketCity'] == $city){
            echo ('
            <tr>
                <td><a href="http://donkeycar.com/pages/pageDetailCar.php?id='.$car['carId'].'">'.$car['brandName'].'</a></td>
                <td>'.$car['carName'].'</td>
                <td>'.$car['typeCarName'].'</td>
                <td>'.$car['carYear'].'</td>
                <td>'.$car['carTarifDayHT']*1.2.'</td>
            ');
                if($car['garargeCarDisponibility'] == 0){
                    echo ('<td>Available</td>');
                }
                elseif ($car['garargeCarDisponibility'] == 1){
                    echo ('<td>Unavailable</td>');
                }
            echo ('
            </tr>
            ');
        }
    }
    echo ('
                </tbody>
            </table>
        </div>
    </div>
    ');
}

function verifTypeBrand($data, $type){
    if($type == 'brand'){
        $brands = getAllData('brands');
        foreach ($brands as $brand) {
            if($brand['brandName'] == $data){
                return $brand['brandId'];
            }
        }
    }
    elseif ($type == 'type') {
        $types = getAllData('typeCar');
        foreach ($types as $type) {
            if($type['typeCarName'] == $data){
                return $type['typeCarId'];
            }
        }
    }
    return true;
}

function addType($data){
    $pdo = connect_bd();
    $query = $pdo->prepare('INSERT INTO typeCar (typeCarName) VALUES (:typeCarName)');
    $query->bindValue(':typeCarName', $data);
    $query->execute();
    $typeId = $pdo->lastInsertId();
    return $typeId;
}

function addBrand($data){
    $pdo = connect_bd();
    $query = $pdo->prepare('INSERT INTO brands (brandName) VALUES (:brandName)');
    $query->bindValue(':brandName', $data);
    $query->execute();
    $brandId = $pdo->lastInsertId();
    return $brandId;
}

function verifImat($data){
    $cars = getAllData('cars');
    foreach ($cars as $car) {
        if($car['carImmatriculation'] == $data){
            return false;
        }
    }
    return true;
}

function getCarDispo($id){
    $pdo = connect_bd();
    $query = $pdo->prepare('SELECT l.locationDate, l.locationDateEnd, l.locationHourStart, l.locationDateStart, l.locationHourEnd FROM carLocation cl JOIN location l ON l.locationId = cl.locationId  JOIN cars c ON c.carId = cl.carId WHERE c.carId = :id');
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $car = $query->fetch(PDO::FETCH_ASSOC);
    return $car;
}

function verifIsDaily($start, $end, $id){
    $car = getCarDispo($id);
    if(!empty($car)){
        if($start != $car['locationDateStart'] && $end != $car['locationDateEnd'] && $end != $car['locationDateStart'] && $start != $car['locationDateEnd']){
            return true;
        }
    }elseif (empty($car)) {
        return true;
    }
    return false;
    
}

function verifIsHourly($date, $start, $end, $id){
    $car = getCarDispo($id);
    if(!empty($car)){
        if($date != $car['locationDate']){
            return true;
            
        }elseif ($start != $car['locationHourStart'] && $start != $car['locationHourEnd'] && $end != $car['locationHourStart'] && $end != $car['locationHourEnd']) {
            return true;
        }
    }
    elseif (empty($car)) {
        return true;
    }
    return false;
}

// function print filter 

function filterCityCountry(){
    $marketCitys = getMarketCitys();
    $marketCountrys = getMarketsCountry();
    echo ('
        <div class="col-md-8">
            <form action="action/actionFilter.php" method="POST">   
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <label for="selectCity"></label>
                            <select name="selectCity" id="selectCity" class="form-select" aria-label="Floating label select example">
                                <option value="city">'.ucfirst('city').'</option> ');
                                foreach ($marketCitys as $marketCity){
                                    echo ' <option value="'.$marketCity['marketId'].'">'.$marketCity['marketCity'].'</option>';
                                }
                            echo ('
                            </select>
                            <label for="selectCountry"></label>
                            <select name="selectCountry" id="selectCountry" class="form-select" aria-label="Floating label select example">
                                <option value="country">'.ucfirst('country').'</option> ');
                                foreach ($marketCountrys as $marketCountry ){
                                    echo ' <option value="'.$marketCountry.'">'.$marketCountry.'</option>';
                                }
                        echo ('
                            </select>
                            <input type="submit" class="btn btn-outline-primary" value="search" name="filterCountryCity">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    ');
}



function filterTypeYear(){
    $dataTypes = getTypeCarModel();
    $dataYears = getCarYear();
    echo ('
        <div class="col-md-8">
            <form action="action/actionFilter.php" method="POST">  
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <label for="selectType"></label>
                            <select name="selectType" id="selectType" class="form-select" aria-label="Floating label select example">
                                <option value="type">'.ucfirst('type').'</option> ');
                                foreach ($dataTypes as $dataType ){
                                    echo ' <option value="'.$dataType.'">'.$dataType.'</option>';
                                }
                        echo ('
                            </select>
                            <label for="selectYear"></label>
                            <select name="selectYear" id="selectYear" class="form-select" aria-label="Floating label select example">
                                <option value="year">'.ucfirst('year').'</option> ');
                                foreach ($dataYears as $dataYear){
                                    echo ' <option value="$dataYear">'.$dataYear.'</option>';
                                }
                        echo ('
                            </select>
                            <input type="submit" class="btn btn-outline-primary" value="search" name="filterTypeYear">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    ');
}



function printMessageresponse(){
    if(!empty($_SESSION['messageResponce']) || !empty($_SESSION['messageRental'])){
        $message = null;
        if(!empty($_SESSION['messageRental'])){
            $message = $_SESSION['messageRental'];
            unset($_SESSION['messageRental']);
        }
        elseif(!empty($_SESSION['messageResponce'])){
            $message = $_SESSION['messageResponce'];
            unset($_SESSION['messageResponce']);
        }
        
        echo ('
        <div class="row justify-content-center m-3 p-3">
            <div class="col-md-2">
                <div class="alert alert-success" role="alert" m-3 p-3>
                    <p class="text-center">'.$message.'</p>
                </div>
            </div>
        </div>');
    }elseif(!empty($_SESSION['messageError'])){
        $message = $_SESSION['messageError'];
        unset($_SESSION['messageError']);
        echo ('
        <div class="row justify-content-center m-3 p-3">
            <div class="col-md-2">
                <div class="alert alert-danger" role="alert" m-3 p-3>
                    <p class="text-center">'.$message.'</p>
                </div>
            </div>
        </div>');
    }
    
}

function printMessageresponseEmpty($datas){
    if( !empty($_SESSION['messageResponceEmpty'])){
        $messages = $_SESSION['messageResponceEmpty'];
        unset($_SESSION['messageResponceEmpty']);
        foreach($messages as $key => $message){
            if($key == $datas){
                echo ('
                div class="row justify-content-center mt-3">
                    <div class="col-md-2">
                        <div class="alert alert-danger" role="alert">
                            <p class="text-center">'.$message.'</p>
                        </div>
                    </div>
                </div>');
            }
        }
        
    }
}

function selectCountry(){
    $pays = array(
        "France", "États-Unis", "Canada", "Australie", "Allemagne",
        "Royaume-Uni", "Japon", "Chine", "Inde", "Brésil",
        "Russie", "Mexique", "Italie", "Espagne", "Afrique du Sud",
        "Corée du Sud", "Nouvelle-Zélande", "Argentine", "Nigeria", "Égypte",
        "Turquie", "Suède", "Norvège", "Danemark", "Finlande",
        "Pologne", "Indonésie", "Thaïlande", "Vietnam", "Philippines",
        "Allemagne", "Espagne", "Italie", "Royaume-Uni", "Russie", 
        "Australie"
    );
    foreach ($pays as $pays) {
        echo '<option value="'.$pays.'">'.$pays.'</option>';
    }
}

function printColumnHeaders($typeRental) {
    if ($typeRental == "hourly") {
        echo '<th>Number Hour</th><th>Price Hour HT</th><th>Price Hour TTC</th>';
    } elseif ($typeRental == "daily") {
        echo '><th>Date End</th><th>Number Day</th><th>Price Day HT</th><th>Price Day TTC</th>';
    }
}

function printRentalData($data,$key, $typeRental) {
    $html = function($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); };

    if ($typeRental == "hourly") {
        echo '<td>'.$html($data['reservationDate']).'</td>';
        echo '<td>'.$html($data['nbHours']).'</td>';
        echo '<td>'.$html($data['carTarifHourHT']).'</td>';
        echo '<td>'.$html($data['carTarifHourHT']*1.2).'</td>';
        echo '<td>'.$html($data['carTarifHourHT']* $data['nbHours']).'</td>';
        echo '<td>'.($html($data['carTarifHourHT']* $data['nbHours']) *1.2).'</td>';
    } elseif ($typeRental == "daily") {
        echo '<td>'.$html($data['reservationDateStart']).'</td>';
        echo '<td>'.$html($data['reservationDateEnd']).'</td>';               
        echo '<td>'.$html($data['nbDays']).'</td>';
        echo '<td>'.$html($data['carTarifDayHT']).'</td>';
        echo '<td>'.$html($data['carTarifDayHT']*1.2).'</td>';
        echo '<td>'.$html($data['carTarifDayHT']* $data['nbDays']).'</td>';
        echo '<td>'.($html($data['carTarifDayHT']* $data['nbDays']) *1.2).'</td>';
    }
    // Affichage des données communes
    echo '<td>'.$html($data['carCaution']).'</td>';
    echo '<td><a href="http://donkeycar.com/pages/customer/pageEditBasket.php?id='.urlencode($key).'">EDIT</a></td>';
    echo '<td><a href="http://donkeycar.com/action/customer/actionDeleteBasket.php?id='.urlencode($key).'">DELETE</a></td>';
}

function printBasket($datas, $nbs){

    if (!isset($_SESSION)) session_start(); // Démarre la session si ce n'est pas déjà fait

    $typeRents = array_unique(array_column($datas, 'typeRental'));

    echo '<div class="row mt-4 p-4 container-fluid "><div class="col"><table class="table">';

    // Affichage des en-têtes
    echo '<thead><tr><th>Model</th><th>Date Start</th>';
    foreach ($typeRents as $type) {
        printColumnHeaders($type);
    }
    echo '<th>TOTAL price HT</th><th>TOTAL price TTC</th><th>Caution price</th><th>EDIT</th><th>DELETE</th></tr></thead><tbody>';

    // Affichage des données
    foreach ($datas as $key => $data) {
        echo '<tr><td>'.htmlspecialchars($data['carModel'], ENT_QUOTES, 'UTF-8').'</td>';
        printRentalData($data,$key, $data['typeRental']);
    }

    $totalHT = $totalTTC = $totalCaution = 0;
    foreach ($datas as $data) {
        if ($data['typeRental'] == "hourly") {
            $totalHT += $data['carTarifHourHT'] * $data['nbHours'];
            $totalTTC += ($data['carTarifHourHT'] * $data['nbHours']) * 1.2;
        } elseif ($data['typeRental'] == "daily") {
            $totalHT += $data['carTarifDayHT'] * $data['nbDays'];
            $totalTTC += ($data['carTarifDayHT'] * $data['nbDays']) * 1.2;
        }
        $totalCaution += $data['carCaution'];
    }

    // Affichage des totaux
    echo '</tbody></table></div></div>';
    echo '<div class="row mt-4 p-4 container-fluid justify-content-center">
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>TOTAL HT</th>
                            <th>TOTAL TTC</th>
                            <th>TOTAL CAUTION</th>
                            <th>TOTAL TTC + CAUTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.htmlspecialchars($totalHT, ENT_QUOTES, 'UTF-8').'</td>
                            <td>'.htmlspecialchars($totalTTC, ENT_QUOTES, 'UTF-8').'</td>
                            <td>'.htmlspecialchars($totalCaution, ENT_QUOTES, 'UTF-8').'</td>
                            <td>'.htmlspecialchars($totalTTC + $totalCaution, ENT_QUOTES, 'UTF-8').'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

    // Mise à jour de la session
    $_SESSION['tabTotal'] = array(
        'totalHT' => $totalHT,
        'totalTTC' => $totalTTC,
        'totalCaution' => $totalCaution,
        'total' => $totalTTC + $totalCaution
    );

    // Formulaire de validation du panier
    echo '<div class="col-md-12">
            <form action="http://donkeycar.com/action/customer/actionSendRent.php" method="POST"> 
                <div class="row justify-content-center mt-3 mb-5">
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary btn-block" value="Valide my basket" name="sendAskRent">
                    </div>
                </div>
            </form>
        </div>';


    echo '</tbody></table></div></div>';
}


// function delete User

function deletUser($id, $query){
    $pdo = connect_bd();
    $query = $pdo->prepare($query);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    if( $query->execute()){
        $_SESSION = array();
        session_destroy();
        header('Location: ../index.php');
        $_SESSION['messageResponce'] = 'Your profil has been deleted';
        exit();
    }
}


//function verif date is valid 

function verifDateValid ($start, $end){
    $yearStart = substr($start, 0, 4);
    $yearEnd = substr($end, 0, 4);
    $monthStart = substr($start, 5, 2);
    $monthEnd = substr($end, 5, 2);
    $dayStart = substr($start, 8, 2);
    $dayEnd = substr($end, 8, 2);
    $nbDays = null;
    if($yearStart > $yearEnd){
        $_SESSION['messageError'] = "The start year is > at  the end year";
    }
    elseif($yearStart == $yearEnd && $monthStart > $monthEnd){
        $_SESSION['messageError'] = "The start month is > at the end month";
    }
    elseif($yearStart == $yearEnd && $monthStart == $monthEnd && $dayStart > $dayEnd){
        $_SESSION['messageError'] = "The start day is > at the end day";
    }
    elseif($yearStart == $yearEnd && $monthStart == $monthEnd && $dayStart == $dayEnd){
        $_SESSION['messageError'] = "The start date and the end date are the same";
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

    if($nbDays != null){
        return $nbDays;
    }
    else {
        return false;
    }
}

