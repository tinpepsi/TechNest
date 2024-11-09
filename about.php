<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display about section
-->

<?php
session_start(); // Start the session
include 'db_connect.php';  // Include the database connection file

if (isset($_SESSION['username'])) {
    // User is logged in
    $authLink = "logout.php";
    $authLabel = "Logout";
} else {
    // User is not logged in
    $authLink = "login.php";
    $authLabel = "Login";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <!--Bootsrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="include/css/style.css">
</head>
<body>


    


<!-- Background image with overlay -->
<div class="bg-images1"></div>

<!-- Content inside the full-screen background -->
<div class="content-wrapper">

   <!--Navbar-->
   <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto md-" href="#">TechNest</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">TechNest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  active mx-lg-2" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Product
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="shop.php">Shop</a></li>
                                <li><a class="dropdown-item" href="tech.php">Tech Accessories</a></li>
                                <li><a class="dropdown-item" href="game.php">Gaming Console</a></li>
                                <li><a class="dropdown-item" href="smartphone.php">Smartphone</a></li>
                                <li><a class="dropdown-item" href="smart.php">Smart Device</a></li>
                                <li><a class="dropdown-item" href="drone.php">Drones and Camera</a></li>
                                <li><a class="dropdown-item" href="bike.php">Electric Bikes</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- cart button, visible only to normal users -->
            <?php if (isset($_SESSION['username']) && $_SESSION['role'] != 1): ?>
                <a href="display_cart.php" class="cart-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            <?php endif; ?>

            <!-- login/logout button -->
            <?php if (isset($_SESSION['username'])): // Check if user is logged in ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($_SESSION['username']); // Display username ?></button>
                    <div class="dropdown-content">
                        <?php if ($_SESSION['role'] == 1): // Check if user is an admin ?>
                            <a class="dropdown-item" href="admin_dashboard.php">Admin Dashboard</a>
                        <?php else: // Regular user ?>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?php echo $authLink; ?>"><?php echo $authLabel; ?></a>
                    </div>
                </div>
            <?php else: // User is not logged in ?>
                <a class="login-button" href="login.php">Login</a>
            <?php endif; ?>

            <!--navbar button-->
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!--End Navbar-->

    <!--About content-->
    <section class="py-5">       
        <div class="container-fluid">
            <div class="row gx-4 align-items-center justify-content-between">
                <div class="col-md-5 order-2 order-md-1">
                    <div class="mt-5 mt-md-0">
                        <span class="text-muted">Our Story</span>
                        <h2 class="display-5 fw-bold">Why Choose Us</h2>
                        <p class="lead">
                            At TechNest, we offer top-quality gadgets and reliable tech support, ensuring you get the best devices for your needs. From the latest smartphones to gaming consoles, we provide a seamless shopping experience and expert advice to help you stay ahead in the tech world.
                        </p>
                    </div>
                    <!--Media Social Button-->
                    
                    <a
                        data-mdb-ripple-init class="btn btn-primary btn-lg btn-floating IG"
                        href="https://www.instagram.com/samsungmalaysia/?hl=en"
                        role="button"
                        ><i class="fab fa-instagram"></i>
                    </a>
                    <a
                        data-mdb-ripple-init class="btn btn-primary btn-lg btn-floating FB"
                        href="https://www.facebook.com/apple/"
                        role="button"
                        ><i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a
                        data-mdb-ripple-init class="btn btn-primary btn-lg btn-floating YT"                       
                        href="https://www.youtube.com/@SolozClub"
                        role="button"
                        ><i class="fa-brands fa-youtube"></i>
                    </a>
                    <a
                        data-mdb-ripple-init class="btn btn-primary btn-lg btn-floating TT"                       
                        href="https://x.com/Huawei?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"
                        role="button"
                        ><i class="fa-brands fa-twitter"></i>
                    </a>
                         
                </div>
                <div class="col-md-6 offset-md-1 order-1 order-md-2">
                    <div class="row gx-2 gx-lg-3">
                        <div class="col-6">
                            <div class="mb-2"><img class="img-fluid rounded-3" src="include/pic/footer/2.jpg"></div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2"><img class="img-fluid rounded-3" src="include/pic/footer/4.jpg"></div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2"><img class="img-fluid rounded-3" src="include/pic/footer/5.jpg"></div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2"><img class="img-fluid rounded-3" src="include/pic/footer/6.jpg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
    </section>
    <!--End About content-->

<!--FOOTER-->
<div class="footer-basic">
    <footer>
        <div class="social">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="index.php">Home</a></li>
            <li class="list-inline-item"><a href="about.php">About</a></li>
            <li class="list-inline-item"><a href="contact.php">Contact</a></li>
            <li class="list-inline-item"><a href="product.php">Product</a></li>
        </ul>
        <p class="copyright">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="ion-ios-heart" aria-hidden="true"></i> by <span class="neon-text"><a href="#" target="_blank">TechNest</a></span>
        </p>
    </footer>
</div>
<!--END FOOTER-->
</div>

    
    <!--JS-->
    <script src="include/js/script.js"></script>
    <!--Bootsrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
crossorigin="anonymous"></script>   
</body>
</html>