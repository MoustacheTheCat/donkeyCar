<?php 
require('../action/action.php');
$pageTitle = "Create profil";
include('../layout/header.php');
?>
<?php if (empty($_GET['role'])):?>
    <div class="container mt-5">
    <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/actionCreateProfil.php" method="POST">
            <div class="form-group">
                <label for="customerFirstName">First Name:</label>
                <input type="text" class="form-control" id="customerFirstName" name="customerFirstName" placeholder="Enter first name">
            </div>
            <?php printMessageresponseEmpty('customerFirstName')?>
            <div class="form-group">
                <label for="customerLastName">Last Name:</label>
                <input type="text" class="form-control" id="customerLastName" name="customerLastName" placeholder="Enter last name">
            </div>
            <?php printMessageresponseEmpty('customerLastName')?>
            <div class="form-group">
                <label for="customerBirthDay">Date of Birth:</label>
                <input type="date" class="form-control" id="customerBirthDay" name="customerBirthDay" value="<?= date('Y-m-d',strtotime('-18 Years'));?>" max="<?=date('Y-m-d',strtotime('-18 Years'));?>">
            </div>
            <?php printMessageresponseEmpty('customerBirthDay')?>
            <div class="form-group">
                <label for="customerEmail">Email:</label>
                <?php if(!empty($_SESSION['dataRents']['email'])) :?>
                    <input type="email" class="form-control" id="customerEmail" name="customerEmail" value="<?= $_SESSION['dataRents']['email'] ?>">
                <?php else:?>
                    <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Enter email">
                <?php endif;?>
            </div>
            <?php printMessageresponseEmpty('customerEmail')?>
            <div class="form-group">
                <label for="customerNumber">Phone Number:</label>
                <input type="tel" class="form-control" id="customerNumber" name="customerNumber" placeholder="Enter phone number" max="10">
            </div>
            <?php printMessageresponseEmpty('customerNumber')?>
            <div class="form-group">
                <label for="customerNumberPermit">Driving License Number:</label>
                <input type="text" class="form-control" id="customerNumberPermit" name="customerNumberPermit" max="12"placeholder="Enter driving license number">
            </div>
            <?php printMessageresponseEmpty('customerNumberPermit')?>
            <div class="form-group">
                <label for="customerAddress">Address:</label>
                <input type="text" class="form-control" id="customerAddress" name="customerAddress" placeholder="Enter address">
            </div>
            <?php printMessageresponseEmpty('customerAddress')?>
            <div class="form-group">
                <label for="customerZip">Zip Code:</label>
                <input type="text" class="form-control" id="customerZip" name="customerZip" placeholder="Enter zip code">
            </div>
            <?php printMessageresponseEmpty('customerZip')?>
            <div class="form-group">
                <label for="customerCity">City:</label>
                <input type="text" class="form-control" id="customerCity" name="customerCity" placeholder="Enter city">
            </div>
            <?php printMessageresponseEmpty('customerCity')?>
            <div class="form-group">
                <label for="customerCountry">Country:</label>
                <select class="form-control" id="customerCountry" name="customerCountry">
                    <option value="country">Country</option>
                    <?php selectCountry();?>
                </select>
            </div>
            <?php printMessageresponseEmpty('customerCountry')?>
            <div class="form-group">
                <label for="customerPassword">Password:</label>
                <input type="password" class="form-control" id="customerPassword" name="customerPassword" placeholder="Enter password">
            </div>
            <?php printMessageresponseEmpty('customerPassword')?>
            <div class="form-group">
                <label for="customerPasswordConfirm">Password Confirme:</label>
                <input type="password" class="form-control" id="customerPassword" name="customerPasswordConfirm" placeholder="Enter password Confirm">
            </div>
            <?php printMessageresponseEmpty('customerPasswordConfirm')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Create Profile" class="btn btn-primary" name="createProfil">
                </div>
            </div>
        </form>
    </div>
<?php elseif ($_GET['role'] == "admin"):?>
    <?php $markets = getAllData('markets');?>
    <div class="container mt-5">
        <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/actionCreateProfil.php?role=<?= $_GET['role']?>" method="POST">
            <div class="form-group">
                <label for="adminFirstName">First Name:</label>
                <input type="text" class="form-control" id="adminFirstName" name="adminFirstName" placeholder="Enter first name">
            </div>
            <?php printMessageresponseEmpty('adminFirstName')?>
            <div class="form-group">
                <label for="adminLastName">Last Name:</label>
                <input type="text" class="form-control" id="adminLastName" name="adminLastName" placeholder="Enter last name" >
            </div>
            <?php printMessageresponseEmpty('adminLastName')?>
            <div class="form-group">
                <label for="adminEmail">Email:</label>
                <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="Enter email">
            </div>
            <?php printMessageresponseEmpty('adminEmail')?>
            <div class="form-group">
                <label for="adminMarket">Market :</label>
                <select class="form-control" id="adminPassword" name="adminMarket">
                    <option value="all">All</option>
                    <?php foreach($markets as $market):?>
                        <option value="<?= $market['marketId']?>"><?= $market['marketCity']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <?php printMessageresponseEmpty('adminMarket')?>
            <div class="form-group">
                <label for="adminPassword">Password :</label>
                <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Enter password">
            </div>
            <?php printMessageresponseEmpty('adminPassword')?>
            <div class="form-group">
                <label for="adminPasswordConfirm">New Password Confirme:</label>
                <input type="password" class="form-control" id="adminPassword" name="adminPasswordConfirm" placeholder="Enter password Confirm">
            </div>
            <?php printMessageresponseEmpty('adminPasswordConfirm')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Create Profile" class="btn btn-primary" name="createProfil">
                </div>
            </div>
    </form>
</div>
<?php endif;?>
<?php include('../layout/footer.php'); ?>