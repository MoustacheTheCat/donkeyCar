<?php 
require('../action/action.php');
$pageTitle = "Login";
include('../layout/header.php');
?>
<div class="container mt-5">
    <?php printMessageresponse()?>
    <form action="http://donkeycar.com/action/actionLogin.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <input type="submit" value="Login" class="btn btn-primary" name="login">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-3">
                <a href="pageForgotPasswordRequest.php">Forgot Password?</a>
            </div>
            <div class="col-md-3">
            <a href="pageCreateProfil.php">Create New Account</a>
            </div>
        </div>
    </form>
</div>
<?php include('../layout/footer.php'); ?>