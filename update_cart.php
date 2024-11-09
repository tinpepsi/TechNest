<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: update cart quantity, calculate subtotal of cart
-->

<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    // Update the quantity in the Cart table
    $update_sql = "UPDATE Cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("iii", $quantity, $cart_id, $user_id);
    $update_stmt->execute();

    // Calculate new subtotal
    $stmt = $conn->prepare("SELECT price FROM Cart WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();

    $newSubtotal = number_format($price * $quantity, 2);
    
    // Return the new subtotal as a JSON response
    echo json_encode(['newSubtotal' => $newSubtotal]);

    // Close the statement
    $update_stmt->close();
    $stmt->close();
    $conn->close();
}
?>
