<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display edit form for product
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
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="include/css/style.css">
</head>
<body>
<div class="edit-product-page"> <!-- Encapsulating class for the edit product form -->
    <div class="admin-dashboard">
        <div class="sidebar">
            <h2><?php echo $adminUsername; ?></h2>
            <hr>
            <div class="">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="#">Add Product</a>
                <a href="#">Edit Product</a> <!-- Link to the edit product page -->
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Edit Product</h1>
            </div>

            <div class="edit-product-container"> <!-- Container for the edit product form -->
                <form action="edit.php?id=<?php echo $product['product_id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="" disabled>Select Category</option>
                            <option value="Tech Accessories" <?php if ($product['category'] == 'Tech Accessories') echo 'selected'; ?>>Tech Accessories</option>
                            <option value="Gaming Consoles" <?php if ($product['category'] == 'Gaming Consoles') echo 'selected'; ?>>Gaming Consoles</option>
                            <option value="Smartphone" <?php if ($product['category'] == 'Smartphone') echo 'selected'; ?>>Smartphone</option>
                            <option value="Smart Device" <?php if ($product['category'] == 'Smart Device') echo 'selected'; ?>>Smart Device</option>
                            <option value="Drone & Camera" <?php if ($product['category'] == 'Drone & Camera') echo 'selected'; ?>>Drone & Camera</option>
                            <option value="Electric Bikes" <?php if ($product['category'] == 'Electric Bikes') echo 'selected'; ?>>Electric Bikes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price (RM)</label>
                        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" id="image" name="image" accept="image/*"> 
                    </div>
                    <button type="submit" value="Update Product">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
