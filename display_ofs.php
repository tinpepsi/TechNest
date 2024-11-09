<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display out of stock product
-->

<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Get the admin username from the session
$adminUsername = htmlspecialchars($_SESSION['username']); // Sanitize the username for output

// Include the database connection
include 'db_connect.php'; // Ensure this path is correct

// Query to get out of stock products
$sql = "SELECT product_id, name, category, description, price, image, quantity 
        FROM Product 
        WHERE quantity = 0";
$result = $conn->query($sql);
$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="include/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="admin-dashboard">
    <div class="sidebar">
        <h2><?php echo $adminUsername; ?></h2>
        <hr>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_form.php">Add Product</a>
        <a href="display_ofs.php">Our Of Stock</a>
        <a href="shop.php">Shop</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>OUT OF STOCK</h1>
        </div>

        <!-- Product Table -->
        <div class="card">
            <!-- Flex container for title and search bar -->
            <div class="card-header">
                <h2>Product List</h2>
                <!-- Search Bar -->
                <div class="search-container">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search products...">
                </div>
            </div>

            <?php
            // Check if there are out-of-stock products
            if (!empty($products)) {
                echo '<table class="product-table" id="productTable">';
                echo "<thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price (RM)</th>
                                <th>Quantity</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>"; // Open tbody here

                // Output each product row
                foreach ($products as $product) {
                    echo "<tr>
                            <td>" . htmlspecialchars($product['product_id']) . "</td>
                            <td><img src='" . htmlspecialchars($product['image']) . "' alt='Product Image' class='product-image'></td>
                            <td>" . htmlspecialchars($product['name']) . "</td>
                            <td>" . htmlspecialchars($product['category']) . "</td>
                            <td>" . htmlspecialchars($product['description']) . "</td>
                            <td>" . htmlspecialchars($product['price']) . "</td>
                            <td>" . htmlspecialchars($product['quantity']) . "</td>
                            <td><a href='edit.php?id=" . htmlspecialchars($product['product_id']) . "'><i class='fa-regular fa-pen-to-square'></i></a></td>
                            <td><a href='delete.php?id=" . htmlspecialchars($product['product_id']) . "' onclick=\"return confirm('Are you sure you want to delete this product?');\"><i class='fa-solid fa-trash'></i></a></td>
                        </tr>";
                }

                echo "</tbody></table>"; // Close tbody and table here

            } else {
                echo "<table class='product-table' id='productTable'>
                        <thead>
                            <tr>
                                <th colspan='7' style='text-align:center;'>No out-of-stock products available</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan='7' style='text-align:center;'>No out-of-stock products available</td>
                            </tr>
                        </tbody>
                    </table>";
            }
            ?>
        </div>

        <!-- Pagination Controls -->
        <ul class="pagination" id="pagination">
            <!-- Pagination buttons will be generated by JavaScript -->
        </ul>
    </div>
</div>

<!-- JS file -->
<script src="include/js/script.js"></script>

</body>
</html>
