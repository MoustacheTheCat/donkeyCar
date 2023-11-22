<?php
require('../../action/action.php');
$pageTitle = 'DonkeyCar ';
if(!empty($_GET['type']) &&  !empty($_GET['id'])){
    $idGet = $_GET['id'];
    if($_GET['type'] == 'market'){
        $market = getOneRow('markets', 'marketId', $idGet);
    }elseif($_GET['type'] == 'garage'){
        $garage = getOneRow('garages', 'garageId', $idGet);
    }elseif($_GET['type'] == 'car'){
        echo "car";
        $car = getOneRowCarWithTypeAndBrand($idGet);
        print_r($car);
    }

}
include('../../layout/header.php');
?>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="row-cols-1 row-cols-md-3 g-4 d-flex justify-content-around align-self-center flex-row text-center align-items-stretch" >
            <div class="col m-5">
                <div class="card h-100">
                    <div class="card-img-top d-flex justify-content-center text-center flex-column align-self-center  p-3" style="background-color: #f8f9fa;">
                        <img src="https://www.donkeycar.com/uploads/7/8/1/7/7817903/published/donkeycar-logo-sideways.png?1557205931"  alt="...">
                        <?php if(!empty($market)):?>
                            <h2><?= $market['marketName']?></h2>
                        <?php elseif(!empty($garage)):?>
                            <h2><?= $garage['garageName']?></h2>
                        <?php elseif(!empty($car)):?>
                            <h2><?= $car['brandName']?></h2>
                            <h2><?= $car['carName']?></h2>
                        <?php endif;?>
                    </div>
                    <div class="card-body">
                        <h2 class="font-italic mb-3" style="background-color: #f8f9fa;">Upadate</h2>
                        <form action="../../action/admin/actionUpdateCarMarketGarage.php?id=<?=$idGet?>&type=<?=$_GET['type']?>" method="POST">
                            <?php if(!empty($market)):?>
                                <div class="form-group">
                                    <label for="marketName">Market Name</label>
                                    <input type="text" class="form-control" id="marketName" name="marketName" value="<?= $market['marketName']?>">
                                </div>
                                <?php printMessageresponseEmpty('marketName')?>          
                                <div class="form-group">
                                    <label for="marketAddress">Address:</label>
                                    <input type="text" class="form-control" id="marketAddress" name="marketAddress" value="<?= $market['marketAdress']; ?>">
                                </div>
                                <?php printMessageresponseEmpty('marketAddress')?>
                                <div class="form-group">
                                    <label for="marketZip">Zip Code:</label>
                                    <input type="text" class="form-control" id="marketZip" name="marketZip" value="<?= $market['marketZip']; ?><">
                                </div>
                                <?php printMessageresponseEmpty('marketZip')?>
                                <div class="form-group">
                                    <label for="marketCity">City:</label>
                                    <input type="text" class="form-control" id="marketCity" name="marketCity" value="<?= $market['marketCity']; ?>">
                                </div>
                                <?php printMessageresponseEmpty('marketCity')?>
                                <div class="form-group">
                                    <label for="marketCountry">Country:</label>
                                    <select class="form-control" id="marketCountry" name="marketCountry">
                                        <option value="<?= $market['marketCountry']; ?>"><?= $market['marketCountry']; ?></option>
                                        <?php selectCountry();?>
                                    </select>
                                </div>
                                <?php printMessageresponseEmpty('marketCountry')?>
                            <?php elseif(!empty($garage)):?>
                                <div class="form-group">
                                    <label for="garageName">Garage Name</label>
                                    <input type="text" class="form-control" id="garageName" name="garageName" value="<?= $garage['garageName']?>">
                                </div>
                                <?php printMessageresponseEmpty('garageName')?>
                            <?php elseif(!empty($car)):?>
                                <div class="form-group">
                                    <label for="carName">Car Name</label>
                                    <input type="text" class="form-control" id="carName" name="carName" value="<?=$car['carName']?>">
                                </div>
                                <?php printMessageresponseEmpty('carName')?>      
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                    <label for="carBrand">Car Brand</label>
                                        <div class="col-md-6 input-group">
                                            <label for="newCarBrand"></label>
                                            <input type="text" class="form-control" id="carBrand" name="newCarBrand" value="New Brand">
                                            <select name="carBrand" id="carBrand" class="form-select" aria-label="Floating label select example">
                                                <option value="<?=$car['brandId']?>"><?=$car['brandName']?></option>
                                                <?php $brands = getAllData('brands');?>
                                                <?php foreach ($cars as $brand )  :?>   
                                                    <option value="<?=$brand['brandId']?>"><?=$brand['brandName']?></option>   
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php printMessageresponseEmpty('carBrand')?>
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                    <label for="carType">Car Type</label>
                                        <div class="col-md-6 input-group">
                                            <label for="newCarType"></label>
                                            <input type="text" class="form-control" id="carType" name="newCarType" value="New Type">
                                            <select name="carType" id="carType" class="form-select" aria-label="Floating label select example">
                                                <option value="<?=$car['typeCarId']?>"><?= $car['typeCarName']?></option>
                                                <?php $carTypes = getAllData('typeCar');?>
                                                <?php foreach ($carTypes as $carType) :?>   
                                                    <option value="<?=$carType['typeCarId']?>"><?=$carType['typeCarName']?></option>   
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php printMessageresponseEmpty('carType')?>
                                <div class="form-group">
                                    <label for="carYear">Car Year</label>
                                    <input type="date" class="form-control" id="carYear" name="carYear" value="<?=$car['carYear']?>">
                                </div>
                                <?php printMessageresponseEmpty('carYear')?>
                                <div class="form-group">
                                    <label for="carImmatriculation">Car Immatriculation</label>
                                    <input type="text" class="form-control" id="carImmatriculation" name="carImmatriculation" value="<?=$car['carImmatriculation']?>">
                                </div>
                                <?php printMessageresponseEmpty('carImmatriculation')?>
                                <div class="form-group">
                                    <label for="carTarifHourHT">Car Tarif Hour HT</label>
                                    <input type="text" class="form-control" id="carTarifHourHT" name="carTarifHourHT" value="<?=$car['carTarifHourHT']?>">
                                </div>
                                <?php printMessageresponseEmpty('carTarifHourHT')?>
                                <div class="form-group">
                                    <label for="carTarifDayHT">Car Tarif Dat HT</label>
                                    <input type="text" class="form-control" id="carTarifDayHT" name="carTarifDayHT" value="<?=$car['carTarifDayHT']?>">
                                </div>
                                <?php printMessageresponseEmpty('carTarifDayHT')?>
                                <div class="form-group">
                                    <label for="carCaution">Car Caution</label>
                                    <input type="text" class="form-control" id="carCaution" name="carCaution" value="<?=$car['carCaution']?>">
                                </div>
                                <?php printMessageresponseEmpty('carCaution')?>
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <label for="garage">Garage</label>
                                        <?php $garages = getAllData('garages');?>
                                        <div class="col-md-6 input-group">
                                            <select name="garage" id="garage" class="form-select" aria-label="Floating label select example">
                                                <option value=""><?=$car['garageName']?></option>
                                                <?php foreach ($garages as $garage )  :?>   
                                                    <option value="<?=$garage['garageId']?>"><?=$garage['garageName']?></option>   
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php printMessageresponseEmpty('garage')?>
                            <?php endif;?>
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-4">
                                    <input type="submit" value="Update" data-mdb-ripple-init class="btn btn-outline-dark" name="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../../layout/footer.php');?>

