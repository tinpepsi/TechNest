<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page fetch product from database, in order to display later
-->

<?php
// Include the database connection file
include 'db_connect.php';

// Query to fetch products from the Product table with quantity greater than 1
$sql = "SELECT product_id, name, category, description, price, quantity, image FROM Product WHERE quantity > 0";
$result = $conn->query($sql);

// Prepare an array to hold products
$products = [];

// Check if there are products and fetch data
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Add each product to the array
    }
}

// Get the total number of products
$totalProducts = count($products);

// Close the database connection
$conn->close();

// Return both the products array and the total number of products
return [$products, $totalProducts]; 
?>
