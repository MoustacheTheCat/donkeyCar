
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title><?php echo $pageTitle;?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php" >DonkeyCar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <?php if(empty($_SESSION)):?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Register</a>
                            </li>
                    <?php endif;?>      
                    <?php if(empty($_SESSION)|| $_SESSION['role'] != 'adminRole'):?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Panier <i class="bi bi-cart"></i></a>
                        </li>
                    <?php endif;?>  
                    <?php if(!empty($_SESSION['role']) && $_SESSION['role'] == 'adminRole'):?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCar" role="button" data-bs-toggle="dropdown" aria-expanded="false">Car</a>
                            <ul class="dropdown-me nu" aria-labelledby="navbarDropdownCar">
                                <li><a class="dropdown-item" href="#">Add Car</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Market</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                <li><a class="dropdown-item" href="#">Add Market</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Garage</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                <li><a class="dropdown-item" href="#">Add Garage</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Customer</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                <li><a class="dropdown-item" href="#">Add Customer</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Rental</a>
                        </li>
                    <?php elseif(!empty($_SESSION['role']) && $_SESSION['role'] == 'adminRole' && $_SESSION['adminRole'] == 1):?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                <li><a class="dropdown-item" href="#">Add Admin</a></li>
                            </ul>
                        </li>
                    <?php endif;?> 
                    <?php if(!empty($_SESSION['role']) && ($_SESSION['role'] == 'adminRole' ||$_SESSION['role'] == 'customer')):?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                <li><a class="dropdown-item" href="#">DashBoard</a></li>
                                <li><a class="dropdown-item" href="#">List Rental</a></li>
                                <li><a class="dropdown-item" href="#">Follow rental</a></li>
                                <li><a class="dropdown-item" href="#">Message</a></li>
                                <li><a class="dropdown-item" href="#">Edit Profil</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif;?>  
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1><?php echo $pageTitle;?></h1>
       
 

   
    