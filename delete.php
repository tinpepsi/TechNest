<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page handle logic of deleting product
-->

<?php
// Include the database connection file
include 'db_connect.php';

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the SQL statement to delete the product
    $sql = "DELETE FROM Product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();

// Redirect to the display page after deletion
header("Location: admin_dashboard.php");
exit();
?>
