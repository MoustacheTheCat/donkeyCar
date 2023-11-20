<?php 
require('../action/action.php');
$pageTitle = "Edit Profil";
include('../layout/header.php');
$id = $_SESSION['userId'];
if($_SESSION['role'] == 'admin'){
    $admin = getOneRow ('admins', 'adminId', $id);
    $markets = getMarket();
    $marketAdminName = null;
    $marketAdminId = null;
    $adminRole = 'onlyMarket';
    if($admin['adminRole'] == 1){
        $adminRole = 'all';
    }else {
        foreach($markets as $market){
            if($market['marketId'] == $id){
                $marketAdminName = $market['marketName'];
                $marketAdminId = $market['marketId'];
            }
        }
    }
}elseif($_SESSION['role'] == 'customer'){
    $customer = getOneRow ('customers', 'customerId', $id);
}
?>
<?php if ($_SESSION['role'] == "customer"):?>
    <div class="container mt-5">
        <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/actionEditProfil.php?role=<?= $_SESSION['role']?>&id=<?=$id?>" method="POST">
            <div class="form-group">
                <label for="customerFirstName">First Name:</label>
                <input type="text" class="form-control" id="customerFirstName" name="customerFirstName" value="<?= $customer['customerFirstName']?>">
            </div>
            <?php printMessageresponseEmpty('customerFirstName')?>
            <div class="form-group">
                <label for="customerLastName">Last Name:</label>
                <input type="text" class="form-control" id="customerLastName" name="customerLastName" value="<?= $customer['customerLastName']?>" >
            </div>
            <?php printMessageresponseEmpty('customerLastName')?>
            <div class="form-group">
                <label for="customerBirthDay">Date of Birth:</label>
                <input type="date" class="form-control" id="customerBirthDay" name="customerBirthDay" value="<?= $customer['customerBirthDay']?>" max="<?=date('Y-m-d',strtotime('-18 Years'));?>">
            </div>
            <?php printMessageresponseEmpty('customerBirthDay')?>
            <div class="form-group">
                <label for="customerEmail">Email:</label>
                <input type="email" class="form-control" id="customerEmail" name="customerEmail" value="<?= $customer['customerEmail']?>">
            </div>
            <?php printMessageresponseEmpty('customerEmail')?>
            <div class="form-group">
                <label for="customerNumber">Phone Number:</label>
                <input type="tel" class="form-control" id="customerNumber" name="customerNumber" value="<?= $customer['customerNumber']?>" min="10" max="10">
            </div>
            <?php printMessageresponseEmpty('customerNumber')?>
            <div class="form-group">
                <label for="customerNumberPermit">Driving License Number:</label>
                <input type="text" class="form-control" id="customerNumberPermit" name="customerNumberPermit" max="12"value="<?= $customer['customerNumberPermit']?>">
            </div>
            <?php printMessageresponseEmpty('customerNumberPermit')?>
            <div class="form-group">
                <label for="customerAddress">Address:</label>
                <input type="text" class="form-control" id="customerAddress" name="customerAddress" value="<?= $customer['customerAddress']?>" >
            </div>
            <?php printMessageresponseEmpty('customerAddress')?>
            <div class="form-group">
                <label for="customerZip">Zip Code:</label>
                <input type="text" class="form-control" id="customerZip" name="customerZip" value="<?= $customer['customerZip']?>">
            </div>
            <?php printMessageresponseEmpty('customerZip')?>
            <div class="form-group">
                <label for="customerCity">City:</label>
                <input type="text" class="form-control" id="customerCity" name="customerCity" value="<?= $customer['customerCity']?>">
            </div>
            <?php printMessageresponseEmpty('customerCity')?>
            <div class="form-group">
                <label for="customerCountry">Country:</label>
                <select class="form-control" id="customerCountry" name="customerCountry">
                    <option value="<?= $customer['customerCountry']?>">Country</option>
                    <?php selectCountry();?>
                </select>
            </div>
            <?php printMessageresponseEmpty('customerCountry')?>
            <div class="form-group">
                <label for="customerPassword">Password:</label>
                <input type="password" class="form-control" id="customerPassword" name="customerPassword" placeholder="*********">
            </div>
            <?php printMessageresponseEmpty('customerPassword')?>
            <div class="form-group">
                <label for="customerNewPassword">New Password:</label>
                <input type="password" class="form-control" id="customerNewPassword" name="customerNewPassword" placeholder="New password">
            </div>
            <?php printMessageresponseEmpty('customerNewPassword')?>
            <div class="form-group">
                <label for="customerNewPasswordConfirm">New Password Confirme:</label>
                <input type="password" class="form-control" id="customerNewPassword" name="customerNewPasswordConfirm" placeholder="New password Confirm">
            </div>
            <?php printMessageresponseEmpty('customerNewPasswordConfirm')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Edit Profile" class="btn btn-primary" name="editProfil">
                </div>
            </div>
        </form>
    </div>
<?php elseif ($_SESSION['role'] == "admin"):?>
    <div class="container mt-5">
        <?php printMessageresponse()?>
        <form action="http://donkeycar.com/action/actionEditProfil.php?role=<?= $_SESSION['role']?>&id=<?=$id?>" method="POST">
            <div class="form-group">
                <label for="adminFirstName">First Name:</label>
                <input type="text" class="form-control" id="adminFirstName" name="adminFirstName" value="<?= $admin['adminFirstName']?>">
            </div>
            <?php printMessageresponseEmpty('adminFirstName')?>
            <div class="form-group">
                <label for="adminLastName">Last Name:</label>
                <input type="text" class="form-control" id="adminLastName" name="adminLastName" value="<?= $admin['adminLastName']?>" >
            </div>
            <?php printMessageresponseEmpty('adminLastName')?>
            <div class="form-group">
                <label for="adminEmail">Email:</label>
                <input type="email" class="form-control" id="adminEmail" name="adminEmail" value="<?= $admin['adminEmail']?>">
            </div>
            <?php printMessageresponseEmpty('adminEmail')?>
            <div class="form-group">
                <label for="adminMarket">Market :</label>
                <select class="form-control" id="adminPassword" name="adminMarket">
                    <?php if($adminRole == 'all'):?>
                        <option value="all">All</option>
                    <?php else:?>
                        <option value="<?=$marketAdminId?>"><?=$marketAdminName?></option>
                        <option value="all">All</option>
                    <?php endif;?>
                    <?php foreach($markets as $market):?>
                        <option value="<?= $market['marketId']?>"><?= $market['marketName']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <?php printMessageresponseEmpty('adminMarket')?>
            <div class="form-group">
                <label for="adminPassword">Password :</label>
                <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="*********">
            </div>
            <?php printMessageresponseEmpty('adminPassword')?>
            <div class="form-group">
                <label for="adminNewPassword">New Password :</label>
                <input type="password" class="form-control" id="adminNewPassword" name="adminNewPassword" placeholder="New password">
            </div>
            <?php printMessageresponseEmpty('adminNewPassword')?>
            <div class="form-group">
                <label for="adminNewPasswordConfirm">New Password Confirme:</label>
                <input type="password" class="form-control" id="adminNewPassword" name="adminNewPasswordConfirm" placeholder="New password Confirme">
            </div>
            <?php printMessageresponseEmpty('adminNewPasswordConfirm')?>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Edit Profile" class="btn btn-primary" name="editProfil">
                </div>
            </div>
    </form>
</div>
<?php endif;?>
<?php include('../layout/footer.php'); ?>