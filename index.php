<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display the homepage of the website
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
    <title>Homepage</title>
    <!-- Link to Font Awesome version 6.6.0 for vector icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Preconnect to Google Fonts for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Preconnect to Google Fonts for better performance -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Link to Bebas Neue font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- Preconnect to Google Fonts for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Preconnect to Google Fonts for better performance -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Link to Bebas Neue and Oswald fonts from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <!-- Link to Bootstrap CSS version 5.3.3 for responsive design and UI components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link to Bootstrap CSS Slider (version 5.3.0) for slider components -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to custom CSS file for additional styles -->
    <link rel="stylesheet" href="include/css/style.css">
    
    
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
                            <a class="nav-link active  mx-lg-2" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" href="about.php">About</a>
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

    <!--Hero Section-->
        <section class = "hero-section">
            <div class = "container d-flex align-items-center justify-content-center fs-1 text-white flex-column">
                <h1>Discover the Latest Tech Innovations</h1>
                <h2>Right at your fingertips</h2>
                <div class="wrapper custom_wrap">
                    <a href="shop.php" class="custom-shop-link"><span>SHOP NOW</span></a>

                  </div>
            </div>
        </section>
    <!--End Hero Section-->

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
        </div>
    </div>
    <!--End Infinite slideshow-->

    
    <!--Iklan section-->
    <div class="container ads_container">
        <!-- Left side with Image 1 -->
        <div class="left-side">
            <img src="include/pic/ads/3.png" alt="Image 1">
        </div>

        <!-- Right side with Image 2 and Image 3 -->
        <div class="right-side">
            <img src="include/pic/ads/1.png" alt="Image 2">
            <img src="include/pic/ads/2.png" alt="Image 3">
        </div>
    </div>
    <!--end  Iklan Section-->

    <!--Introduction Section-->
        <div class="row row1" id = "About">
            <div class = "imgWrapper">
                <img src ="include/pic/model.jpeg" alt ="">
            </div>
            <div class = "contentWrapper">
                <div class = "content">
                    <span class="textWrapper">
                        <span></span>Tech Made Accessible
                    </span>
                    <h2>Your One-Stop Shop for Smart Solutions</h2>
                    <p>TechNest was born from a passion for technology and a desire to make cutting-edge gadgets accessible to everyone. Founded by tech enthusiasts, we envisioned a haven for gadget lovers, offering a diverse selection of high-quality products ranging from the latest smartphones and laptops to smart home devices and gaming gear. At TechNest, we provide a seamless shopping experience with both online and in-store options, allowing customers to browse our extensive catalog or visit our store to test products and receive expert advice. We’re not just a store; we’re a community dedicated to innovation, where you can join workshops, product launches, and exclusive events that inspire creativity and connect tech enthusiasts.</p>
                    <a href = "https://www.facebook.com/apple/" class = "fb">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href = "https://www.instagram.com/samsungmalaysia/?hl=en" class = "ig"> 
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href = "https://x.com/Huawei?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" class = "twitter">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href = "https://www.youtube.com/@SolozClub" class = "yt">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    <!--End Introduction Section-->

    <!--Offer Section-->
    <div class = "container-fluid" id = "offer">
        <div class="text text-center">
            <div class="offer-card text-center">
                <div class="card-body">
                    <h1>What We Offer</h1>
                    <p>Your One-Stop Shop for Smart Devices: <span>Providing Everything You Need to Stay Ahead in the Tech Game</span></p>
                </div>
            </div>
        </div>       
        <div class="row g-5 offer">
            <!--card 1-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url('include/pic/offer/usb.jpg');">
                    <div class='info'>
                        <h1 class='title offer_title'>Tech Accessories</h1>
                        <p class='description'>USB hubs, external hard drives, memory cards, cables, adapters, and laptop stands.</p>
                        <a href="tech.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
            <!--card 2-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url('include/pic/offer/gaming console.jpg');">
                    <div class='info'>
                        <h1 class='title offer_title'>Gaming Consoles</h1>
                        <p class='description'>PS5, Xbox, Steam Deck, Nintendo Switch, along with controllers, headsets, and other peripherals.</p>
                        <a href="game.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
            <!--card 3-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url(include/pic/offer/phone.jpg);">
                    <div class='info'>
                        <h1 class='title offer_title'>Smartphones</h1>
                        <p class='description'>Latest models from popular brands, along with accessories like cases, screen protectors, and chargers.</p>
                        <a href="smartphone.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
            <!--card 4-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url('include/pic/offer/security_camera.jpg');">
                    <div class='info'>
                        <h1 class='title offer_title'>Smart Devices</h1>
                        <p class='description'>Products like smart speakers, security cameras, smart lighting, thermostats, and home assistants.</p>
                        <a href="smart.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
            <!--card 5-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url('include/pic/offer/drone.jpg');">
                    <div class='info'>
                        <h1 class='title offer_title'>Drones & Cameras</h1>
                        <p class='description'>Drones for photography and recreational use, action cameras, and professional camera equipment.</p>
                        <a href="drone.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
            <!--card 6-->
            <div class="col-12 col-md-6 col-lg-4"> 
                <div class='card custom_card_offer' style="background-image: url('include/pic/offer/ebike.jpg');">
                    <div class='info'>
                        <h1 class='title offer_title'>Electric Bikes</h1>
                        <p class='description'>Eco-friendly personal transportation devices for urban mobility.</p>
                        <a href="bike.php" class="button-30" role="button">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        
                
        
    </div>
    <!--End Offer Section-->

    <!--Why Us Section-->
    <section class="mt-5">
        <div class="WhyUS_card">
            <div class="container text-dark pt-3 my-custom-container">
                <header class="pt-4 pb-3">
                    <h2 class="image-text">Why choose us...</h2>
                </header>
                <div class="row us_row">
                    <div class="col-md-4 mb-4"> 
                        <div class="card us_card">
                            <div class="face face1">
                                <div class="content">
                                    <i class="fa-solid fa-money-bill alt" style="font-size: 2em; color: black;"></i>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                    <h1>Reasonable Prices</h1>
                                    <p>Our prices are competitive, giving you great value without sacrificing quality.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4"> 
                        <div class="card us_card">
                            <div class="face face1">
                                <div class="content">
                                    <i class="fas fa-star alt" style="font-size: 2em; color: black;"></i>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                    <h1>Best Quality</h1>
                                    <p>We ensure top-notch quality in all our products, exceeding your expectations.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4"> 
                        <div class="card us_card">
                            <div class="face face1">
                                <div class="content">
                                    <i class="fas fa-plane alt" style="font-size: 2em; color: black;"></i>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                    <h1>Worldwide Shipping</h1>
                                    <p>We offer reliable worldwide shipping, bringing our products right to your doorstep.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <!-- container end.// -->
    </section>
    <!--End Why Us Section-->

    <!-- Testimonial -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div id="testimonial-carousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Testimonial Section Title -->
                    <div class="text-center mb-4">
                        <h2 class="testimonial-title">Our Customers Love Us</h2>
                        <p class="testimonial-subtitle">Here's what they have to say about our products!</p>
                    </div>
                    <!-- Carousel Items -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="testimonial text-center">
                                <div class="pic">
                                    <img src="include/pic/testimonial/2.jpg" alt="Jessica" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                </div>
                                <p class="description">"As a student, having reliable gadgets is essential for my studies. TechNest offers a fantastic range of laptops and accessories that cater perfectly to my needs. The quality is outstanding, and the prices are student-friendly! I found the perfect laptop for my assignments, and the purchasing process was seamless. I highly recommend TechNest for anyone looking for top-notch gadgets!"</p>
                                <h3 class="title">Jessica</h3>
                                <small class="post">- Student</small>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="testimonial text-center">
                                <div class="pic">
                                    <img src="include/pic/testimonial/1.jpg" alt="Pearl" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                </div>
                                <p class="description">As a busy housewife, I rely on gadgets that simplify my daily tasks. TechNest has been a lifesaver! From smart kitchen appliances to efficient home gadgets, I found everything I needed to make my life easier. The shopping experience was hassle-free, and the delivery was quick. I love how TechNest offers quality products that truly enhance my home life. Highly recommended for anyone looking to upgrade their household gadgets!</p>
                                <h3 class="title">Pearl</h3>
                                <small class="post">- Housewife</small>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="testimonial text-center">
                                <div class="pic">
                                    <img src="include/pic/testimonial/3.jpg" alt="Kellie" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                </div>
                                <p class="description">As a teacher, I am always on the lookout for tools that can enhance my classroom experience and make learning more engaging. TechNest offers a fantastic selection of educational gadgets that have transformed the way I teach. From interactive tablets to smart projectors, each product has helped me connect with my students better. The shopping process was seamless, and I appreciate the fast delivery. I highly recommend TechNest to fellow educators looking to bring innovation into their classrooms!</p>
                                <h3 class="title">Sam</h3>
                                <small class="post">- Teacher</small>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators custom_carousel_index">
                        <button type="button" data-bs-target="#testimonial-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#testimonial-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#testimonial-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial -->

    <!-- Map-->
    <div class="container-fluid custom_contact_container" id = "location">
        <h3 class="mb-5 text-center contact_text">Contact us</h3>

        <div class="row justify-content-center">
            <div class="col-lg-6"> <!-- Changed from col-lg-5 to col-lg-6 -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12094.57348593182!2d-74.00599512526003!3d40.72586666928451!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2598f988156a9%3A0xd54629bdf9d61d68!2sBroadway-Lafayette%20St!5e0!3m2!1spl!2spl!4v1624523797308!5m2!1spl!2spl"
                    class="h-100 w-100" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-lg-6">
                <form class="form_contact">
                    <div class="row justify-content-center"> <!-- Use justify-content-center to center the inner row -->
                        <div class="col-md-8"> <!-- Adjusted column size for better centering -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form3Example1" class="form-control" placeholder="First name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" id="form3Example2" class="form-control" placeholder="Email Address" />
                                    </div>
                                </div>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="form3Example3" class="form-control" placeholder="Subject" />
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <textarea class="form-control" id="form4Example3" rows="4" placeholder="Message"></textarea>
                            </div>
                            <div class="text-center"> <!-- Center the button -->
                                <div class="custom-button-container">
                                    <p class="text-lg-start">
                                        <a href="#" class="button2">Submit</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>                
            </div>
            
        </div>
        
    </div>
    <!--End Map-->
    
    <!--Footer-->
    <footer class="bg-body-tertiary text-center">
        <!-- Grid container -->
        <div class="container-fluid p-4">
          <!-- Section: Images -->
          <section class="">
            <div class="row foot">
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                    <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/1.jpg" class="w-100"/>
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
                </div>
              <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/2.jpg" class="w-100" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
              </div>
              <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/3.jpg" class="w-100" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
              </div>
              <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/4.jpg" class="w-100" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
              </div>
              <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/5.jpg" class="w-100" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
              </div>
              <div class="col-lg-2 col-md-4 mb-4 mb-md-0 my-2">
                <div data-mdb-ripple-init
                        class="bg-image hover-overlay shadow-1-strong rounded"
                        data-ripple-color="light"
                    >
                        <img src="include/pic/footer/6.jpg" class="w-100" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                        </a>
                    </div>
              </div>
            </div>
          </section>
          <!-- Section: Images -->
        </div>
        <!-- Grid container -->
      
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
          © 2024 Copyright:
          <a class="text-body" href="index.php">TechNest</a>
        </div>
        <!-- Copyright -->
      </footer>
    <!--End Footer-->
    
    <!-- Owl Carousel JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!--JS-->
    <script src="include/js/script.js"></script>
    <!--Bootsrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    </body>  
</html>

