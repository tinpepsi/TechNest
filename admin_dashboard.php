<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display admin dashboard
-->

<?php
session_start();

// Include database connection
include 'db_connect.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php"); // Redirect to login if not an admin
    exit();
}

// Get the admin username from the session
$adminUsername = htmlspecialchars($_SESSION['username']); // Sanitize the username for output

// Query to sum total sales from the receipt table
$totalSalesQuery = "SELECT SUM(total_amount) AS total_sales FROM receipt";
$totalSalesResult = $conn->query($totalSalesQuery);

$totalSales = 0; // Default total sales
if ($totalSalesResult) {
    $row = $totalSalesResult->fetch_assoc();
    $totalSales = $row['total_sales'] ?? 0; // Get total sales, default to 0 if null
}

// Query to count total users with role 0
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users WHERE role = 0";
$totalUsersResult = $conn->query($totalUsersQuery);

$totalUsers = 0; // Default total users
if ($totalUsersResult) {
    $row = $totalUsersResult->fetch_assoc();
    $totalUsers = $row['total_users'] ?? 0; // Get total users, default to 0 if null
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
            <h1>Admin Dashboard</h1>
        </div>

        <?php
        // Include the PHP file that fetches products
        list($products, $totalProducts) = include 'fetch_products.php'; // Capture returned values as an array
        ?>

        <!-- Card Row for Statistics -->
        <div class="card-row">
            <div class="card">
                <h2>Total Users</h2>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="card">
                <h2>Total Products</h2>
                <p><?php echo htmlspecialchars($totalProducts); ?></p>
            </div>
            <div class="card">
                <h2>Total Sell</h2>
                <p>RM <?php echo number_format($totalSales, 2); ?></p>
            </div>
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
            // Check if there are products
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
                                <th colspan='7' style='text-align:center;'>No products available</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan='7' style='text-align:center;'>No products available</td>
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
