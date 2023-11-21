<?php
require('../action/action.php');
$id = $_GET['id'];

$pageTitle ="Detail rental";
$rental = getRent($id);
include('../layout/header.php');
?>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <!-- Ici, vous pouvez mettre une image ou un logo lié à la location -->
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="https://www.donkeycar.com/uploads/7/8/1/7/7817903/published/donkeycar-logo-sideways.png?1557205931" alt="Image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5>Rental Details</h5>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6 class="font-italic mb-1">Location ID : <?= $rental['locationId']?></h6>
                                    <h6 class="font-italic mb-1">Car : <?= $rental['brandName'].' '.$rental['carName']?></h6>
                                    <h6>Rental Type : <?= $rental['locationType']?> </h6>
                                    <h6>Duration : <?= $rental['locationDuration']?> hours </h6>
                                    <h6>Start Date and Time : <?= $rental['locationDate']?> at <?= $rental['locationHourStart']?></h6>
                                    <h6>End Date and Time : <?= $rental['locationDateEnd']?> at <?= $rental['locationHourEnd']?> </h6>
                                    <h6>Total Cost (excl. VAT) : <?= $rental['locationTotalHT']?> € </h6>
                                    <h6>Total Cost (incl. VAT) : <?= $rental['locationTotalTTC']?> € </h6>
                                    <h6>Caution : <?= $rental['locationCostCaution']?> € </h6>
                                    <h6>Status : <?= $rental['locationStatus'] == 1 ? 'Active' : 'Inactive'?> </h6>
                                    <h6>Summary : <?= $rental['locationResume']?> </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php include('../layout/footer.php');?>