<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display receipt after user successfuly check out
-->

<?php
session_start(); // Start the session to access session variables

// Include database connection
include 'db_connect.php'; 

// Check if the cart_id is available in the URL
if (!isset($_GET['cart_id'])) {
    echo "No receipt found.";
    exit(); // Stop execution if there's no cart ID
}

// Get the cart_id from the URL
$cartId = intval($_GET['cart_id']);

// Prepare the SQL query using INNER JOIN to get receipt data including total_amount and user details
$sql = "SELECT r.receipt_id, r.total_amount, p.name AS product_name, c.quantity, p.price, 
               u.address AS user_address, u.country AS user_country, u.phone_number AS user_phone
        FROM receipt r
        INNER JOIN cart c ON r.cart_id = c.cart_id
        INNER JOIN product p ON c.product_id = p.product_id
        INNER JOIN users u ON c.user_id = u.user_id
        WHERE r.cart_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cartId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the receipt data
$receiptData = $result->fetch_all(MYSQLI_ASSOC);

// If no results, handle it
if (empty($receiptData)) {
    echo "No receipt items found.";
    exit();
}

// Get the first item to retrieve receipt_id, total_amount, and user details
$receiptId = $receiptData[0]['receipt_id'];
$totalAmount = $receiptData[0]['total_amount']; // Fetch the total amount from the first item
$userAddress = htmlspecialchars($receiptData[0]['user_address']);
$userCountry = htmlspecialchars($receiptData[0]['user_country']);
$userPhone = htmlspecialchars($receiptData[0]['user_phone']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="include/css/style.css">
</head>
<body>

<div class="container receipt_cont">
    <div class="receipt-wrapper">
        <div class="receipt-header">
            <h1>TechNest</h1>
            <p>Address: <?php echo $userAddress; ?></p>
            <p>Country: <?php echo $userCountry; ?></p>
            <p>Phone: <?php echo $userPhone; ?></p>
        </div>

        <div class="receipt-info">
            <p><strong>Receipt ID:</strong> <span id="receipt-id"><?php echo htmlspecialchars($receiptId); ?></span></p>
            <p><strong>Date:</strong> <span id="receipt-date"><?php echo date('Y-m-d'); ?></span></p>
        </div>

        <div class="receipt-items">
            <table>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price (unit)</th>
                </tr>
                <?php
                // Display items
                foreach ($receiptData as $row) {
                    $itemName = htmlspecialchars($row['product_name']);
                    $quantity = (int)$row['quantity'];
                    $price = (float)$row['price'];

                    echo "<tr>
                            <td>$itemName</td>
                            <td>$quantity</td>
                            <td>RM" . number_format($price, 2) . "</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <div class="receipt-total">
            <p>Total: RM<?php echo number_format($totalAmount, 2); ?></p>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
        </div>
    </div>
</div>

<a href="shop.php" class="shop-button">Continue Shopping</a>

</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
