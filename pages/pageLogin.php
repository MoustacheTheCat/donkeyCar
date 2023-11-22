<?php 
require('../action/action.php');
$pageTitle = "Login";
include('../layout/header.php');
?>
<style><?php include('../css/layout.css');?></style>
<div class="container-fluid cont">
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <?php printMessageresponse()?>
                                <form action="http://donkeycar.com/action/actionLogin.php" method="POST">
                                    <div class="form-outline form-white mb-4">
                                        <label for="email" class="form-label">Email:</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email" class="form-control form-control-lg">
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" id="password" placeholder="Enter password" name="password" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <p class="small mb-5 pb-lg-2">
                                        <a class="text-white-50" href="pageForgotPasswordRequest.php">Forgot password?</a>
                                    </p>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
                                </form>
                            </div>
                            <div>
                                <p class="mb-0">Don't have an account? <a href="pageCreateProfil.php" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('../layout/footer.php'); ?>