<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page fetch category from database, in order to display later
-->


<?php
// Include the database connection file
include 'db_connect.php';

/**
 * Fetch products by category from the database.
 *
 * @param string $category The category to filter products.
 * @return array An array of products in the specified category.
 */
function fetchProductsByCategory($category) {
    global $conn; // Use the global connection variable

    // Prepare the SQL query
    $sql = "SELECT product_id, name, category, description, price, quantity, image FROM Product WHERE category = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error); // Handle prepare error
    }

    // Bind the category parameter
    $stmt->bind_param("s", $category);

    // Execute the statement
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error); // Handle execution error
    }
    
    // Get result
    $result = $stmt->get_result();

    // Prepare an array to hold products
    $products = [];

    // Check if there are products and fetch data
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Add each product to the array
    }

    // Close statement
    $stmt->close();

    return $products;
}
