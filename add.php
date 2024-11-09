<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page handle the logic off adding product to the database
-->

<?php
include 'db_connect.php';  // Include the database connection file

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Specify the directory to save the image
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file; // Save the image path for database
        } else {
            die("Error uploading file.");
        }
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Product (name, category, description, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $category, $description, $price, $quantity, $image);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the admin dashboard after success
        header("Location: admin_dashboard.php");
        exit(); // Always call exit after header redirection
    } else {
        echo "Error: " . $stmt->error;
    }


    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
