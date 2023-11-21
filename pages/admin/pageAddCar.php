<?php 
require('../../action/action.php');
$pageTitle = "Add Car";
include('../../layout/header.php');
?>
<?php if (!empty($_GET['role']) && $_GET['role'] == "admin"):?>
    <div class="container mt-5">
        <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/admin/actionAddCar.php" method="POST">
            <div class="form-group">
                <label for="carName">Car Name</label>
                <input type="text" class="form-control" id="carName" name="carName" placeholder="Enter first name">
            </div>
            <?php printMessageresponseEmpty('carName')?>      
            <div class="form-group">
                <div class="row justify-content-center">
                <label for="carBrand">Car Brand</label>
                    <div class="col-md-6 input-group">
                        <label for="newCarBrand"></label>
                        <input type="text" class="form-control" id="carBrand" name="newCarBrand" placeholder="Car Brand">
                        <select name="carBrand" id="carBrand" class="form-select" aria-label="Floating label select example">
                            <option value="">Brand</option>
                            <?php $carBrands = getAllData('brands');?>
                            <?php foreach ($carBrands as $carBrand )  :?>   
                                <option value="<?=$carBrand['brandId']?>"><?=$carBrand['brandName']?></option>   
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
                        <input type="text" class="form-control" id="carType" name="newCarType" placeholder="Car Type">
                        <select name="carType" id="carType" class="form-select" aria-label="Floating label select example">
                            <option value="">type</option>
                            <?php $carTypes = getAllData('typeCar');?>
                            <?php foreach ($carTypes as $carType )  :?>   
                                <option value="<?=$carType['typeCarId']?>"><?=$carType['typeCarName']?></option>   
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <?php printMessageresponseEmpty('carType')?>
            <div class="form-group">
                <label for="carYear">Car Year</label>
                <input type="date" class="form-control" id="carYear" name="carYear">
            </div>
            <?php printMessageresponseEmpty('carYear')?>
            <div class="form-group">
                <label for="carImmatriculation">Car Immatriculation</label>
                <input type="text" class="form-control" id="carImmatriculation" name="carImmatriculation" placeholder="Car Immatriculation">
            </div>
            <?php printMessageresponseEmpty('carImmatriculation')?>
            <div class="form-group">
                <label for="carTarifHourHT">Car Tarif Hour HT</label>
                <input type="text" class="form-control" id="carTarifHourHT" name="carTarifHourHT" placeholder="Car Tarif Hour HT">
            </div>
            <?php printMessageresponseEmpty('carTarifHourHT')?>
            <div class="form-group">
                <label for="carTarifDayHT">Car Tarif Dat HT</label>
                <input type="text" class="form-control" id="carTarifDayHT" name="carTarifDayHT" placeholder="Car Tarif Day HT">
            </div>
            <?php printMessageresponseEmpty('carTarifDayHT')?>
            <div class="form-group">
                <label for="carCaution">Car Caution</label>
                <input type="text" class="form-control" id="carCaution" name="carCaution" placeholder="Car Caution">
            </div>
            <?php printMessageresponseEmpty('carCaution')?>
            <div class="form-group">
                <div class="row justify-content-center">
                    <label for="garage">Garage</label>
                    <?php $garages = getAllData('garages');?>
                    <div class="col-md-6 input-group">
                        <select name="garage" id="garage" class="form-select" aria-label="Floating label select example">
                            <option value="">Garage</option>
                            <?php foreach ($garages as $garage )  :?>   
                                <option value="<?=$garage['garageId']?>"><?=$garage['garageName']?></option>   
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <?php printMessageresponseEmpty('garage')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Add Car" data-mdb-ripple-init class="btn btn-primary btn-block mb-4" name="addCar">
                </div>
            </div>
        </form>
    </div>
<?php endif;?>
<?php include('../../layout/footer.php'); ?>