<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display electric bike
-->

<?php
session_start(); // Start the session
include 'db_connect.php';  // Include the database connection file

// Include the fetching logic for smart devices
include 'fetch_category.php';


$category = 'Electric Bikes'; 
$products = fetchProductsByCategory($category);
$totalProducts = count($products); // Count the total products 

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
    <link rel="stylesheet" href="include/css/shop.css">
    <!-- Bootstrap v5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

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
                            <a class="nav-link  mx-lg-2" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
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

<!-- Start top-electric-bike Area -->
<section class="top-electric-bike-area section-gap">
    <div class="container custom_ebike_container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-10">
                <div class="title text-center">
                    <h1 class="mb-10">Top Electric Bikes Available Now</h1>
                    <p>Explore our range of electric bikes designed for efficiency, speed, and eco-friendly commuting.</p>
                </div>
            </div>
        </div>                    
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-3 feature-left"> <!-- LEFT SIDE -->
                <div class="single-feature mb-4"> <!-- TOP -->
                    <span class="lnr lnr-bicycle"></span>
                    <h4>High Performance Motors</h4>
                    <p>
                        Experience powerful motor systems that offer smooth acceleration and a boost for tackling hills with ease.
                    </p>
                </div>
                <div class="single-feature"> <!-- BOTTOM -->
                    <span class="lnr lnr-road"></span>
                    <h4>Enhanced Stability & Control</h4>
                    <p>
                        Equipped with advanced suspension and braking systems for a safe, comfortable ride on any terrain.
                    </p>
                </div>                            
            </div>
            <div class="col-lg-6 feature-middle"> <!-- CENTER -->
                <img class="img-fluid mx-auto d-block" src="include/pic/shop/bike/img-1 (1).png" alt="Electric Bike Image">
            </div>
            <div class="col-lg-3 feature-right"> <!-- RIGHT SIDE -->
                <div class="single-feature mb-4"> <!-- TOP -->
                    <span class="lnr lnr-battery-full"></span>
                    <h4>Long-Lasting Battery</h4>
                    <p>
                        Go the distance with high-capacity batteries, giving you a range of up to 50 miles on a single charge.
                    </p>
                </div>
                <div class="single-feature"> <!-- BOTTOM -->
                    <span class="lnr lnr-sun"></span>
                    <h4>Eco-Friendly Design</h4>
                    <p>
                        Enjoy a sustainable way to commute with zero emissions, reducing your carbon footprint with every ride.
                    </p>
                </div>                                                        
            </div>
        </div>
    </div>    
</section>
<!-- End top-electric-bike Area -->

<!-- Start Product Card Section -->
<section class="product-card-section py-5">
    <div class="container">
        <div class="row text-center mb-4">
            <h2>BEST SELLING</h2>
            <p>Find the best electric bikes tailored to your lifestyle</p>
        </div>
        <div class="row g-3 justify-content-center"> <!-- Use g-3 for gap -->
        <!-- Card 1 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="include/pic/shop/bike/1.png" class="card-img-top" alt="Electric Bike Thunder 3000">
                <div class="card-body">
                    <h5 class="card-title">Thunder 3000 E-Bike</h5>
                    <div class="product-rating">
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p class="card-text">RM1,600</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="include/pic/shop/bike/2.png" class="card-img-top" alt="Electric Bike Fusion X">
                <div class="card-body">
                    <h5 class="card-title">Fusion X Electric Bike</h5>
                    <div class="product-rating">
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p class="card-text">RM1,800</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="include/pic/shop/bike/3.png" class="card-img-top" alt="Electric Bike Eco Ride">
                <div class="card-body">
                    <h5 class="card-title">Eco Ride 500 E-Bike</h5>
                    <div class="product-rating">
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                    </div>
                    <p class="card-text">RM2,200</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <img src="include/pic/shop/bike/4.png" class="card-img-top" alt="Electric Bike City Cruiser">
                <div class="card-body">
                    <h5 class="card-title">City Cruiser E-Bike</h5>
                    <div class="product-rating">
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-solid fa-star filled"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p class="card-text">RM1,400</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>

        </div>
    </div>
</section>
<!-- End Product Card Section -->

<!--Product-->
<div class="container-fluid custom_product_container">
    <div class = "product-title">
        <h1>View Our Products</h1>
    </div>
            <div class="container-fluid custom_product_container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2" id="product-list">
                <?php if ($totalProducts > 0): // Check if there are products ?>
                    <?php foreach ($products as $product): // Loop through the products ?>
                        <div class="col product-card-wrapper">
                            <div class="product-card" data-id="<?php echo $product['product_id']; ?>" data-category="<?php echo htmlspecialchars($product['category']); ?>" data-price="<?php echo htmlspecialchars($product['price']); ?>">
                            <div class="badge">New</div>
                                <div class="product-tumb">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top shop-item-image">
                                </div>
                                <div class="product-details">
                                    <span class="product-catagory shop-item-categories"><?php echo htmlspecialchars($product['category']); ?></span>
                                    <h4><a href="#" class="card-title shop-item-title"><?php echo htmlspecialchars($product['name']); ?></a></h4>
                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                    <div class="product-bottom-details">
                                        <div class="product-price shop-item-price">RM<?php echo number_format($product['price'], 2); ?></div>
                                        <div class="product-links">
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <button class="btn-shop-item mt-auto shop-item-button">
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col">
                        <p>No products available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!--Pagination-->
        <div class="pagination mt-4">
            <button id="prev" class="btn btn-secondary" onclick="changePage(-1)">Previous</button>
            <span id="page-info">Page 1</span>
            <button id="next" class="btn btn-secondary" onclick="changePage(1)">Next</button>
        </div>
        
</div>
<!--END Product-->

<!-- Features Section Begin -->
<section class="features-section spad">
    <div class="tech-features-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single-box-item first-box">
                                <img src="include/pic/shop/bike/9.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="single-box-item second-box">
                                <img src="include/pic/shop/bike/10.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-box-item large-box">
                        <img src="include/pic/shop/bike/11.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features Section End -->

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


<!--JS-->
<script src="include/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap v5.3 JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
