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
    $query = $pdo->prepare('SELECT cars.*,typeCar.typeCarName, brands.brandName FROM cars INNER JOIN typeCar ON cars.typeCarId = typeCar.typeCarId INNER JOIN brands ON cars.brandId = brands.brandId WHERE cars.carId = :id');
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


// function print (index.php)


function printTableHome($city, $cars){
    echo ('
    <div class="row mt-4">
        <div class="col">
            <table class="table">
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

function verifImat($data){
    $cars = getAllData('cars');
    foreach ($cars as $car) {
        if($car['carImmatriculation'] == $data){
            return false;
        }
    }
    return true;
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
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <div class="alert alert-success" role="alert">
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

function printBasket($datas, $nbs){
    $typeRents = array();
    echo ('
    <div class="row mt-4">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Date Start</th>
                        <th>Date End</th>
                        ');
                        if($nbs == 1){
                            if($datas[0]['typeRental'] == "hourly"){
                                echo '<th>Number Hour</th>';
                                echo '<th>Price Hour HT</th>';
                                echo '<th>Price Hour TTC</th>';
                            }
                            elseif($datas[0]['typeRental'] == "daily") {
                                echo '<th>Number Day</th>';
                                echo '<th>Price Day HT</th>';
                                echo '<th>Price Day TTC</th>';
                            }
                        }elseif ($nbs != 1){
                            foreach($datas as $data){
                                if(!array_search($data['typeRental'], $typeRents , true)){
                                    $typeRents[] = $data['typeRental'];
                                }
                            }
                        
                            if(count($typeRents)==1){
                                if($typeRents[0] == "hourly"){
                                    echo '<th>Number Hour</th>';
                                    echo '<th>Price Hour HT</th>';
                                    echo '<th>Price Hour TTC</th>';
                                }
                                elseif($typeRents[0] == "daily") {
                                    echo '<th>Number Day</th>';
                                    echo '<th>Price Day HT</th>';
                                    echo '<th>Price Day TTC</th>';
                                }
                            }
                            else {
                                echo '<th>Number Hour</th>';
                                echo '<th>Price Hour HT</th>';
                                echo '<th>Price Hour TTC</th>';
                                echo '<th>Number Day</th>';
                                echo '<th>Price Day HT</th>';
                                echo '<th>Price Day TTC</th>';
                            }
                        }
                        echo ('
                            <th>TOTAL price HT</th>
                            <th>TOTAL price TTC</th>
                            <th>Caution price</th>
                            
                    </tr>
                </thead>
                <tbody>
    ');
            if($nbs == 1){
                foreach($datas as $data){
                    echo ('
                    <tr>
                        <td>'.$data['carModel'].'</td>
                        <td>'.$data['reservationDateStart'].'</td>
                        <td>'.$data['reservationDateEnd'].'</td>
                    ');
                    if($data['typeRental'] == "hourly"){
                        echo '<td>'.$data['nbHours'].'</td>';
                        echo '<td>'.$data['carTarifHourHT'].'</td>';
                        echo '<td>'.$data['carTarifHourHT']*1.2.'</td>';
                        echo '<td>'.$data['carTarifHourHT']* $data['nbHours'].'</td>';
                        echo '<td>'.($data['carTarifHourHT']* $data['nbHours']) *1.2.'</td>';                  
                    }
                    elseif($data['typeRental'] == "daily") {                   
                        echo '<td>'.$data['nbDays'].'</td>';
                        echo '<td>'.$data['carTarifDayHT'].'</td>';
                        echo '<td>'.$data['carTarifDayHT']*1.2.'</td>';
                        echo '<td>'.$data['carTarifDayHT']* $data['nbDays'].'</td>';
                        echo '<td>'.($data['carTarifDayHT']* $data['nbDays']) *1.2.'</td>';
                    }
                    echo ('
                        <td>'.$data['carCaution'].'</td>
                    </tr>
                    ');
                }
            }
            else {
                foreach($datas as $data){
                    if($data['typeRental'] == "daily") {
                        echo ('
                        <tr>
                            <td>'.$data['carModel'].'</td>
                            <td>'.$data['reservationDateStart'].'</td>
                            <td>'.$data['reservationDateEnd'].'</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>'.$data['nbDays'].'</td>
                            <td>'.$data['carTarifDayHT'].'</td>
                            <td>'.$data['carTarifDayHT']*1.2.'</td>
                            <td>'.$data['carTarifDayHT']* $data['nbDays'].'</td>
                            <td>'.($data['carTarifDayHT']* $data['nbDays']) *1.2.'</td>
                            <td>'.$data['carCaution'].'</td>
                        </tr>
                        ');
                    }
                    elseif($data['typeRental'] == "hourly") {
                        echo ('
                        <tr>
                            <td>'.$data['carModel'].'</td>
                            <td>'.$data['reservationDateStart'].'</td>
                            <td>'.$data['reservationDateEnd'].'</td>
                            <td>'.$data['nbHours'].'</td>
                            <td>'.$data['carTarifHourHT'].'</td>
                            <td>'.$data['carTarifHourHT']*1.2.'</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>'.$data['carTarifHourHT']* $data['nbHours'].'</td>
                            <td>'.($data['carTarifHourHT']* $data['nbHours']) *1.2.'</td>
                            <td>'.$data['carCaution'].'</td>
                        </tr>
                        ');
                    }
                    
                }
            }
            if(empty($_SESSION['tabTotal'])){
                $totalHT = 0;
                $totalTTC = 0;
                $totalCaution = 0;
                foreach($datas as $data){
                    if($data['typeRental'] == "hourly"){
                        $totalHT += ($data['carTarifHourHT']* $data['nbHours']);
                        $totalTTC += ($data['carTarifHourHT']* $data['nbHours']) *1.2;
                    }
                    elseif($data['typeRental'] == "daily") {
                        $totalHT += ($data['carTarifDayHT']* $data['nbDays']);
                        $totalTTC += ($data['carTarifDayHT']* $data['nbDays']) *1.2;
                    }
                    $totalCaution += $data['carCaution'];
                }
                $total = $totalTTC + $totalCaution;
            }
            else {
                $totalHT = $_SESSION['tabTotal']['totalHT'];
                $totalTTC = $_SESSION['tabTotal']['totalTTC'];
                $totalCaution = $_SESSION['tabTotal']['totalCaution'];
                $total = $_SESSION['tabTotal']['total'];
            }
            
    echo ('
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="11">TOTAL HT</td>');
                        echo "<td>".$totalHT."</td>";
                echo ('
                    </tr>
                    <tr>
                        <td colspan="11">TOTAL TTC</td>');
                        echo "<td>".$totalTTC."</td>";
                echo ('
                    </tr>
                    <tr>
                        <td colspan="11">TOTAL CAUTION</td>');
                        echo "<td>".$totalCaution."</td>";
                echo ('
                    </tr>
                    <tr>
                        <td colspan="11">TOTAL TTC + CAUTION</td>');
                        echo "<td>".$total."</td>";
                echo ('
                    </tr>
            </table>
        </div>
    </div>
    ');
    $tabTotal = array();
    $tabTotal['totalHT'] = $totalHT;
    $tabTotal['totalTTC'] = $totalTTC;
    $tabTotal['totalCaution'] = $totalCaution;
    $tabTotal['total'] = $total;
    $_SESSION['tabTotal'] = $tabTotal;
    echo ('
    <div class="col-md-12">
            <form action="http://donkeycar.com/action/customer/actionSendRent.php" method="POST"> 
                <div class="row justify-content-center mt-3">
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary btn-block" value="Valide my basket" name="sendAskRent">
                    </div>
                    </div>
                </div>
        </form>
    </div>
    ');
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

