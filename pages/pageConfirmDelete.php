<?php
require('../action/action.php');
$pageTitle = 'Confirm delet profil';
include('../layout/header.php');
$id = $_GET['id'];
$role = $_GET['role'];
?>
<div class="container mt-5">
    <?php printMessageresponse()?>
    <form action="http://donkeycar.com/action/actionDelete.php?role=<?=$role?>&id=<?=$id?>&step=2" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email">
        </div>
        <?php printMessageresponseEmpty('email')?>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="***********" name="password">
        </div>
        <?php printMessageresponseEmpty('password')?>
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <input type="submit" value="Delete" class="btn btn-primary" name="deleteConfirm">
            </div>
        </div>
    </form>
</div>
<?php include('../layout/footer.php'); ?>