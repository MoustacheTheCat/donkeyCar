<?php
require('action/action.php');
$pageTitle = '404';
include('layout/header.php');
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center"><?= $_SESSION['messageResponce']?></h2>
    </div>
</div>
<?php include('layout/footer.php'); ?>