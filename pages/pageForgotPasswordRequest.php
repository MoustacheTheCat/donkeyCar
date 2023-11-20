<?php 
require('../action/action.php');
$pageTitle = "Forgot Password";
include('../layout/header.php');
?>
<div class="container mt-5">
    <form action="http://donkeycar.com/action/actionForgotPasswordRequest.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email">
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <input type="submit" value="Send" class="btn btn-primary" name="sendForgotPassword">
            </div>
        </div>
        
    </form>
</div>
<?php include('../layout/footer.php'); ?>