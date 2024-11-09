<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page handle the logic of editing form of product
-->

<?php
// Include the database connection file
include 'db_connect.php';

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM Product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    // Handle image upload (optional)
    $image = $product['image']; // Keep the existing image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Specify the directory to save the image
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file; // Update the image path for the database
        } else {
            echo "Error uploading file.";
        }
    }

    // Update the product in the database
    $update_sql = "UPDATE Product SET name = ?, category = ?, description = ?, price = ?, quantity = ?, image = ? WHERE product_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $name, $category, $description, $price, $quantity, $image, $product_id);

    // Execute the update statement
    if ($update_stmt->execute()) {
        header("Location: admin_dashboard.php"); // Redirect to the product list after updating
        exit();
    } else {
        echo "Error updating product: " . $update_stmt->error;
    }

    // Close the update statement
    $update_stmt->close();
}

// Close the connection
$conn->close();

// Include the form view to display the edit form
include 'edit_form.php';
?>
