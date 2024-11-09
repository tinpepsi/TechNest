<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page handle logic of deleting product from user cart
-->

<?php
session_start();
include 'db_connect.php'; // Ensure your DB connection is included

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    // Prepare and execute the deletion statement
    $delete_sql = "DELETE FROM Cart WHERE cart_id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $cart_id, $user_id);

    if ($delete_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    // Close the statement and connection
    $delete_stmt->close();
    $conn->close();
}
?>
