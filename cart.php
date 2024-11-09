<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display the logic of cart display status_payment 0 only 
-->

<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the product already exists in the cart
    $sql = "SELECT quantity, status_payment FROM cart WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($existing_quantity, $status_payment);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        if ($status_payment == 0) {
            // If the product is in the cart with status_payment = 0, update the quantity
            $new_quantity = $existing_quantity + $quantity;

            $update_sql = "UPDATE cart SET quantity = ?, added_at = NOW() WHERE product_id = ? AND user_id = ? AND status_payment = 0";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("iii", $new_quantity, $product_id, $user_id);

            if ($update_stmt->execute()) {
                header("Location: shop.php"); // Redirect to shop.php
                exit();
            } else {
                echo "Error updating product quantity in cart: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            // If the product is in the cart with status_payment = 1, insert it as a new entry with status_payment = 0
            $insert_sql = "INSERT INTO cart (product_id, user_id, quantity, added_at, status_payment) VALUES (?, ?, ?, NOW(), 0)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iii", $product_id, $user_id, $quantity);

            if ($insert_stmt->execute()) {
                header("Location: shop.php"); // Redirect to shop.php
                exit();
            } else {
                echo "Error adding product to cart: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        }
    } else {
        // If the product is not in the cart, insert it as a new entry with status_payment = 0
        $insert_sql = "INSERT INTO cart (product_id, user_id, quantity, added_at, status_payment) VALUES (?, ?, ?, NOW(), 0)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $product_id, $user_id, $quantity);

        if ($insert_stmt->execute()) {
            header("Location: shop.php"); // Redirect to shop.php
            exit();
        } else {
            echo "Error adding product to cart: " . $insert_stmt->error;
        }
        $insert_stmt->close();
    }

    $stmt->close();
}

$conn->close();
?>
