<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page is the process after user click checkout button
-->

<?php
// Include database connection
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the total amount from the submitted form
    $totalAmount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0.00;

    // Get the selected products from the form
    $selectedProducts = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];

    // Begin a database transaction
    $conn->begin_transaction();

    try {
        // Prepare a statement for updating product quantities
        $updateProductStmt = $conn->prepare("UPDATE product SET quantity = quantity - ? WHERE product_id = ?");
        if (!$updateProductStmt) {
            throw new Exception("Failed to prepare product update statement: " . $conn->error);
        }

        // Prepare a statement for updating cart status
        $updateCartStmt = $conn->prepare("UPDATE cart SET status_payment = 1 WHERE cart_id = ?");
        if (!$updateCartStmt) {
            throw new Exception("Failed to prepare cart update statement: " . $conn->error);
        }

        // Prepare a statement for inserting into receipts
        $insertReceiptStmt = $conn->prepare("INSERT INTO receipt (cart_id, receipt_date, total_amount) VALUES (?, NOW(), ?)");
        if (!$insertReceiptStmt) {
            throw new Exception("Failed to prepare receipt insert statement: " . $conn->error);
        }

        $cartId = null; // Initialize cartId for later use

        // Execute the update and insert statements
        foreach ($selectedProducts as $cartId) {
            // Get the current quantity from the cart
            $quantity = (int)$_POST['quantities'][$cartId];

            // Get the product_id from the cart
            $productQuery = $conn->prepare("SELECT product_id FROM cart WHERE cart_id = ?");
            $productQuery->bind_param("i", $cartId);
            $productQuery->execute();
            $productResult = $productQuery->get_result();
            $product = $productResult->fetch_assoc();

            if ($product) {
                $productId = $product['product_id'];

                // Update product quantity
                $updateProductStmt->bind_param("ii", $quantity, $productId);
                if (!$updateProductStmt->execute()) {
                    throw new Exception("Failed to update product quantity: " . $updateProductStmt->error);
                }

                // Mark the cart as paid
                $updateCartStmt->bind_param("i", $cartId);
                if (!$updateCartStmt->execute()) {
                    throw new Exception("Failed to update cart status: " . $updateCartStmt->error);
                }

                // Insert into receipts for the current cart
                $insertReceiptStmt->bind_param("id", $cartId, $totalAmount);
                if (!$insertReceiptStmt->execute()) {
                    throw new Exception("Failed to insert receipt: " . $insertReceiptStmt->error);
                }
            }
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to receipt.php with cart_id
        header("Location: receipt.php?cart_id=" . $cartId);
        exit(); // Make sure to call exit after header redirection

    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "Error processing your purchase: " . $e->getMessage();
    } finally {
        // Close statements if they were prepared
        if (isset($updateProductStmt)) {
            $updateProductStmt->close();
        }
        if (isset($updateCartStmt)) {
            $updateCartStmt->close();
        }
        if (isset($insertReceiptStmt)) {
            $insertReceiptStmt->close();
        }
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method.";
}
