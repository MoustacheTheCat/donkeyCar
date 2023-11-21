<?php 
require('../../action/action.php');
$pageTitle = "Add Market and Garage";
include('../../layout/header.php');
?>
<?php if (!empty($_GET['role']) && $_GET['role'] == "admin"):?>
    <div class="container mt-5">
        <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/admin/actionAddGarageMarket.php" method="POST">
            <div class="form-group">
                <label for="marketName">Market Name</label>
                <input type="text" class="form-control" id="marketName" name="marketName" placeholder="Enter Market Name">
            </div>
            <?php printMessageresponseEmpty('marketName')?> 
            <div class="form-group">
                <label for="garageName">Garage Name</label>
                <input type="text" class="form-control" id="garageName" name="garageName" placeholder="Enter first name">
            </div>
            <?php printMessageresponseEmpty('garageName')?>         
            <div class="form-group">
                <label for="marketAddress">Address:</label>
                <input type="text" class="form-control" id="marketAddress" name="marketAddress" placeholder="Enter address">
            </div>
            <?php printMessageresponseEmpty('marketAddress')?>
            <div class="form-group">
                <label for="marketZip">Zip Code:</label>
                <input type="text" class="form-control" id="marketZip" name="marketZip" placeholder="Enter zip code">
            </div>
            <?php printMessageresponseEmpty('marketZip')?>
            <div class="form-group">
                <label for="marketCity">City:</label>
                <input type="text" class="form-control" id="marketCity" name="marketCity" placeholder="Enter city">
            </div>
            <?php printMessageresponseEmpty('marketCity')?>
            <div class="form-group">
                <label for="marketCountry">Country:</label>
                <select class="form-control" id="marketCountry" name="marketCountry">
                    <option value="country">Country</option>
                    <?php selectCountry();?>
                </select>
            </div>
            <?php printMessageresponseEmpty('marketCountry')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Add Market and Garage" data-mdb-ripple-init class="btn btn-primary btn-block mb-4" name="addMarketGarage">
                </div>
            </div>
        </form>
    </div>
<?php endif;?>
<?php include('../../layout/footer.php'); ?>