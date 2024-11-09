<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display adding product form
-->

<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Get the admin username from the session
$adminUsername = htmlspecialchars($_SESSION['username']); // Sanitize the username for output

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="include/css/style.css">
</head>
<body>

<div class="add-product-page"> <!-- Add the encapsulating class here -->
    <div class="admin-dashboard">
        <div class="sidebar">
            <h2><?php echo $adminUsername; ?></h2>       
            <hr>    
            <div class="">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="add_form.php">Add Product</a>
            <a href="display_ofs.php">Our Of Stock</a>
            <a href="shop.php">Shop</a>
            <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Add Product</h1>
            </div>

            <div class="add-product-container">
            <form action="add.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Tech Accessories">Tech Accessories</option>
                        <option value="Gaming Consoles">Gaming Consoles</option>
                        <option value="Smartphone">Smartphone</option>
                        <option value="Smart Device">Smart Device</option>
                        <option value="Drone & Camera">Drone & Camera</option>
                        <option value="Electric Bikes">Electric Bikes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price (RM)</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required> 
                </div>
                <button type="submit" value="Add Product" >Add Product</button>
            </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
