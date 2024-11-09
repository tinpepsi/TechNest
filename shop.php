<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display all product 
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
        <link rel="stylesheet" href="include/css/shop.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pj3TA2+2+3Cxydk1Gb7FwNiIgI9V8DGIcZBWn1z9U9D7BCLco7hJFr0P75/6rU1K" crossorigin="anonymous"></script>
    </head>
    
<body>

<?php
// Include the PHP file that fetches products
list($products, $totalProducts) = include 'fetch_products.php'; // Capture returned values as an array
?>

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

<!-- Hero Section -->
<section class="py-5 hero-section">
    <div class="container">
        <div class="row align-items-center gx-4">
            <div class="col-md-7 image-content"> 
                <div class="ms-md-2 ms-lg-5">
                    <img src="include/pic/headphone.png" alt="Tech Innovations" class="img-fluid rounded-3" />
                </div>
            </div>
            <div class="col-md-5 text-content text-md-end text-center">
                <div class="ms-md-2 ms-lg-5">
                    <h1>Discover Endless Possibilities with Advanced Technology</h1>
                    <h2>Innovation at Your Fingertips</h2>
                    <div class="wrapper custom_wrap">
                        <!-- Search Form -->
                        <form id="search-form" action="#" method="GET" class="d-flex align-items-center justify-content-center justify-content-md-end">
                            <input type="text" id="search-bar" onkeyup="filterProducts()" placeholder="Search for products...">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Section -->

<!--Infinite slideshow-->
<div class="slider">
    <div class="slides-track">
        <div class="slide">
            <img src="include/pic/slide/1.png" alt="Smartphone" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/2.png" alt="Laptop" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/3.png" alt="Smartwatch" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/4.png" alt="Tablet" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/5.png" alt="Headphones" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/6.png" alt="Smart Speaker" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/7.png" alt="Drone" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/1.png" alt="Smartphone" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/2.png" alt="Laptop" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/3.png" alt="Smartwatch" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/4.png" alt="Tablet" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/5.png" alt="Headphones" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/6.png" alt="Smart Speaker" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/7.png" alt="Drone" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/1.png" alt="Smartphone" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/2.png" alt="Laptop" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/3.png" alt="Smartwatch" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/4.png" alt="Tablet" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/5.png" alt="Headphones" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/6.png" alt="Smart Speaker" />
        </div>
        <div class="slide">
            <img src="include/pic/slide/7.png" alt="Drone" />
        </div>
    </div>
</div>
<!--End Infinite slideshow-->

<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <!-- container -->
    <div class="container">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <div class="hot-deal">
            <ul class="hot-deal-countdown">
              <li>
                <div>
                  <h3 id="days">0</h3>
                  <span>Days</span>
                </div>
              </li>
              <li>
                <div>
                  <h3 id="hours">0</h3>
                  <span>Hours</span>
                </div>
              </li>
              <li>
                <div>
                  <h3 id="minutes">0</h3>
                  <span>Mins</span>
                </div>
              </li>
              <li>
                <div>
                  <h3 id="seconds">0</h3>
                  <span>Secs</span>
                </div>
              </li>
            </ul>
            <h2 class="text-uppercase">hot deal this week</h2>
            <p>New Collection Up to 50% OFF</p>
            <a class="primary-btn cta-btn shop-now-btn" href="#">Shop now</a>
          </div>
        </div>
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
<!-- /HOT DEAL SECTION -->
  
<!-- /TOP SELLING SECTION -->
<div id="topSelling" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="top-selling-title">TOP SELLING</h2>
            </div>
            <div class="col-md-12">
                <div id="topSellingCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row d-flex justify-content-center">
                                <!-- Product 1 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product01.png" alt="">
                                            <div class="product-label">
                                                <span class="new">EXCLUSIVE OFFER</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Tech Accessories</p>
                                            <h3 class="product-name"><a href="#">Ultra Laptop Max</a></h3>
                                            <h4 class="product-price">RM500.00 <del class="product-old-price">RM600.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product 2 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product02.png" alt="">
                                            <div class="product-label">
                                                <span class="new">LIMITED STOCK</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Smart Device</p>
                                            <h3 class="product-name"><a href="#">Smartwatch Pro</a></h3>
                                            <h4 class="product-price">RM250.00 <del class="product-old-price">RM300.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 3 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product03.png" alt="">
                                            <div class="product-label">
                                                <span class="new">BEST SELLER</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Gaming Consoles</p>
                                            <h3 class="product-name"><a href="#">GameStation Ultra</a></h3>
                                            <h4 class="product-price">RM1,200.00 <del class="product-old-price">RM1,500.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 4 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product04.png" alt="">
                                            <div class="product-label">
                                                <span class="new">HOT ITEM</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Drone & Camera</p>
                                            <h3 class="product-name"><a href="#">Drone Master 3000</a></h3>
                                            <h4 class="product-price">RM800.00 <del class="product-old-price">RM1,000.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Slide 1 -->
                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row d-flex justify-content-center">
                                <!-- Product 1 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product03.png" alt="">
                                            <div class="product-label">
                                                <span class="new">NEW ARRIVAL</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Electronics, Smartwatch</p>
                                            <h3 class="product-name"><a href="#">Fitness Tracker Pro</a></h3>
                                            <h4 class="product-price">RM180.00 <del class="product-old-price">RM220.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 2 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product04.png" alt="">
                                            <div class="product-label">
                                                <span class="new">BARGAIN DEAL</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Gaming, Accessories</p>
                                            <h3 class="product-name"><a href="#">Gaming Mouse</a></h3>
                                            <h4 class="product-price">RM150.00 <del class="product-old-price">RM200.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 3 -->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product05.png" alt="">
                                            <div class="product-label">
                                                <span class="new">EXCLUSIVE DISCOUNT</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Tech, Laptops</p>
                                            <h3 class="product-name"><a href="#">Ultra Thin Laptop</a></h3>
                                            <h4 class="product-price">RM1,200.00 <del class="product-old-price">RM1,500.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 4-->
                                <div class="col-md-3">
                                    <div class="product">
                                        <div class="product-img">
                                            <img src="include/pic/slider1/product06.png" alt="">
                                            <div class="product-label">
                                                <span class="new">FLASH SALE</span>
                                            </div>
                                        </div>
                                        <div class="product-body">
                                            <p class="product-category">Photography, Drones</p>
                                            <h3 class="product-name"><a href="#">4K Drone</a></h3>
                                            <h4 class="product-price">RM1,000.00 <del class="product-old-price">RM1,200.00</del></h4>
                                            <div class="product-rating">
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                                <i class="fa-solid fa-star filled"></i>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                            <button class="add-to-cart-btn">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Product Cards can go here -->
                            </div>
                        </div>
                        <!-- End Slide 2 -->
                    </div>
                <!-- Carousel Controls -->
                <a class="carousel-control-prev" href="#topSellingCarousel" role="button" data-bs-slide="prev">
                    <i class="fa-solid fa-arrow-left carousel-control-prev-icon" aria-hidden="true"></i>
                    <span class="visually-hidden">Previous</span>
                </a>
                
                <a class="carousel-control-next" href="#topSellingCarousel" role="button" data-bs-slide="next">
                    <i class="fa-solid fa-arrow-right carousel-control-next-icon" aria-hidden="true"></i>
                    <span class="visually-hidden">Next</span>
                </a>
                
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /TOP SELLING SECTION -->


<!-- Product -->
<div class="container-fluid custom_product_container">
    <div class="product-title">
        <h1>View Our Products</h1>
    </div>
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
                                    <form action="cart.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <input type="hidden" name="quantity" value="1"> <!-- Default quantity -->
                                        <button type="submit" class="btn-shop-item mt-auto shop-item-button">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
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

    <!--Pagination-->
    <div class="pagination mt-4">
        <button id="prev" class="btn btn-secondary" onclick="changePage(-1)">Previous</button>
        <span id="page-info">Page 1</span>
        <button id="next" class="btn btn-secondary" onclick="changePage(1)">Next</button>
    </div>
</div>
<!-- end Product -->




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
<!--Bootsrap JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
crossorigin="anonymous"></script>    



</body>
</html>