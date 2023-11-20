<?php
require('../action/action.php');
$id = $_GET['id'];
if($_GET['role'] == 'admin'){
    $admin = getOneRow ('admins', 'adminId', $id);
}elseif($_GET['role'] == 'customer'){
    $customer = getOneRow ('customers', 'customerId', $id);
}
$pageTitle = $_GET['role'].' Profil';
$dataUser = $_SESSION['user'];
include('../layout/header.php');
?>

<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="https://pluspng.com/img-png/user-png-icon-big-image-png-2240.png" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <?php if($_GET['role'] == 'admin'):?>
                                    <h5><?= $admin['adminFirstName'].' '.$admin['adminLastName']?></h5>
                                <?php elseif($_GET['role'] == 'customer'):?>
                                    <h5><?= $customer['customerFirstName'].' '.$customer['customerLastName']?></h5>
                                    <p><?= $customer['customerCity']?></p>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <?php if($_GET['role'] == $dataUser['role'] && $_GET['id'] == $dataUser['id']):?>
                                    <div>
                                        <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                            <a href="pageEditProfil.php?id=<?=$id?>&role=<?= $_GET['role']?>">Edit your Profil</a>
                                        </button>
                                    </div>
                                    <div class="px-3">
                                        <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                            <a href="http://donkeycar.com/action/actionDelete.php?id=<?=$id?>&role=<?= $_GET['role']?>&step=1">Delete your Porfile</a>
                                        </button>
                                    </div>  
                                <?php endif;?>
                            </div>
                        </div>
                        <?php if($_GET['role'] == "customer") :?>
                            <div class="card-body p-4 text-black">
                                <div class="mb-5">
                                    <h5 class="mb-3">Information about me</h5>
                                    <div class="p-4" style="background-color: #f8f9fa;">
                                        <h6>Birthday:</h6>
                                        <p class="font-italic mb-1"><?= $customer['customerBirthDay']?></p>
                                    </div>
                                    <div class="p-4" style="background-color: #f8f9fa;">
                                        <h6>Info:</h6>
                                        <p class="font-italic mb-1">@ : <?= $customer['customerEmail']?></p>
                                        <p class="font-italic mb-0"># : <?= $customer['customerNumber']?></p>
                                    </div>
                                    <div class="p-4" style="background-color: #f8f9fa;">
                                        <h6>Permis Number:</h6>
                                        <p class="font-italic mb-1"><?= $customer['customerNumberPermit']?></p>
                                    </div>
                                    <div class="p-4" style="background-color: #f8f9fa;">
                                        <h6>Address:</h6>
                                        <p class="font-italic mb-1"><?= $customer['customerAddress']?></p>
                                        <p class="font-italic mb-1"><?= $customer['customerZip'].' '.$customer['customerCity']?></p>
                                        <p class="font-italic mb-0"><?= $customer['customerCountry']?></p>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($_GET['role'] == "admin") :?>
                            <div class="card-body p-4 text-black">
                                <div class="mb-5">
                                    <div class="p-4" style="background-color: #f8f9fa;">
                                        <h6>Info:</h6>
                                        <p class="font-italic mb-1">@ : <?= $admin['adminEmail']?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../layout/footer.php');?>