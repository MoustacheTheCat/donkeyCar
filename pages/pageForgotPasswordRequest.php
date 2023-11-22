<?php 
require('../action/action.php');
$pageTitle = "Forgot Password";
include('../layout/header.php');
?>
<div class="container mt-5">
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <form action="http://donkeycar.com/action/actionForgotPasswordRequest.php" method="POST">
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="email">Email:</label>
                                        <input type="text" class="form-control form-control-lg" id="email" placeholder="Enter your email" name="email">
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="sendForgotPassword">Forgot password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../layout/footer.php'); ?>