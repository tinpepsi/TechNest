<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display user cart
-->

<?php
session_start(); // Start the session
include 'db_connect.php';  // Include the database connection file

// Set authentication links
$authLink = isset($_SESSION['username']) ? "logout.php" : "login.php";
$authLabel = isset($_SESSION['username']) ? "Logout" : "Login";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page 
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if a form has been submitted to update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $cart_id => $quantity) {
        // Ensure the quantity is a positive integer
        $quantity = max(1, intval($quantity)); // Default to at least 1
        // Update the quantity in the Cart table
        $update_sql = "UPDATE Cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $quantity, $cart_id, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
}

// Query to get cart items along with product details, ensuring status_payment is 0
$sql = "SELECT Cart.cart_id, Cart.quantity, Product.name, Product.category, Product.price, Product.image 
        FROM Cart 
        JOIN Product ON Cart.product_id = Product.product_id 
        WHERE Cart.user_id = ? AND Cart.status_payment = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="include/css/style.css">
</head>
<body class="shopping-cart-page">

   <!--Navbar-->
   <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto md-" href="#">TechNest</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">TechNest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  mx-lg-2" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Product
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="shop.php">Shop</a></li>
                                <li><a class="dropdown-item" href="tech.php">Tech Accessories</a></li>
                                <li><a class="dropdown-item" href="game.php">Gaming Console</a></li>
                                <li><a class="dropdown-item" href="smartphone.php">Smartphone</a></li>
                                <li><a class="dropdown-item" href="smart.php">Smart Device</a></li>
                                <li><a class="dropdown-item" href="drone.php">Drones and Camera</a></li>
                                <li><a class="dropdown-item" href="bike.php">Electric Bikes</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- cart button, visible only to normal users -->
            <?php if (isset($_SESSION['username']) && $_SESSION['role'] != 1): ?>
                <a href="display_cart.php" class="cart-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            <?php endif; ?>

            <!-- login/logout button -->
            <?php if (isset($_SESSION['username'])): // Check if user is logged in ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($_SESSION['username']); // Display username ?></button>
                    <div class="dropdown-content">
                        <?php if ($_SESSION['role'] == 1): // Check if user is an admin ?>
                            <a class="dropdown-item" href="admin_dashboard.php">Admin Dashboard</a>
                        <?php else: // Regular user ?>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?php echo $authLink; ?>"><?php echo $authLabel; ?></a>
                    </div>
                </div>
            <?php else: // User is not logged in ?>
                <a class="login-button" href="login.php">Login</a>
            <?php endif; ?>

            <!--navbar button-->
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!--End Navbar-->

    <div class="container mt-5 container_cart">
    <h2>Your Shopping Cart</h2>
    <form action="process_purchase.php" method="POST" id="cartForm">
        <table class="table shopping-cart-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr data-cart-id="<?php echo $row['cart_id']; ?>">
                        <td><input type="checkbox" name="selected_products[]" value="<?php echo $row['cart_id']; ?>" class="product-checkbox"></td>
                            <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-image" style="width: 50px; height: auto;"></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td>RM <?php echo number_format($row['price'], 2); ?></td>
                            <td class="quantity-controls">
                                <input type="number" name="quantities[<?php echo $row['cart_id']; ?>]"
                                    value="<?php echo htmlspecialchars($row['quantity']); ?>"
                                    min="1" style="width: 60px;"
                                    onchange="updateCartQuantity(<?php echo $row['cart_id']; ?>, this.value); updateSubtotal(<?php echo $row['cart_id']; ?>, <?php echo $row['price']; ?>); updateTotalPrice();">
                            </td>
                            <td><span id="subtotal<?php echo $row['cart_id']; ?>">RM <?php echo number_format($row['price'] * $row['quantity'], 2); ?></span></td>
                            <td>
                                <button type="button" class="btn btn-sm" onclick="removeFromCart(<?php echo $row['cart_id']; ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="summary">
            <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
            <hr class="my-4">
            <div class="shipping_section">
                <h5 class="text-uppercase mb-3">Shipping</h5>
                <select class="form-select mb-4" id="shippingOptions" onchange="updateTotalPrice()">
                    <option value="5">Standard Delivery - RM5.00</option>
                    <option value="10">Express Delivery - RM10.00</option>
                    <option value="15">Next Day Delivery - RM15.00</option>
                </select>
            </div>
            <hr class="my-4">
            <div class="d-flex justify-content-between mb-5">
                <h5 class="text-uppercase">Total price</h5>
                <h5 class="cart-total-price" id="cartTotalPrice">RM 0.00</h5>
            </div>
            <input type="hidden" name="total_amount" id="totalAmountInput" value="0.00">

        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary checkout_btn" onclick="checkSelectedItems(event)">CHECK OUT</button>
        </div>

<script>
function checkSelectedItems(event) {
    // Prevent the form from submitting initially
    event.preventDefault();

    // Check if any product checkboxes are checked
    const selectedItems = document.querySelectorAll('.product-checkbox:checked');

    if (selectedItems.length === 0) {
        // Show alert if no items are selected
        alert("No selected items to be purchased.");
    } else {
        // If there are selected items, submit the form
        document.querySelector('form').submit(); // Adjust this if your form has a specific selector
    }
}
</script>

    </form>
</div>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>

<script>


// Update the total price function
function updateTotalPrice() {
    let total = 0;
    const shippingCost = parseFloat(document.getElementById('shippingOptions').value);
    
    // Calculate total from checked items
    document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
        const cartId = checkbox.closest('tr').dataset.cartId;
        const quantity = document.querySelector(`input[name="quantities[${cartId}]"]`).value;
        const price = parseFloat(document.querySelector(`#subtotal${cartId}`).textContent.replace('RM ', '').replace(',', ''));
        total += price;
    });

    // Add shipping cost
    total += shippingCost;

    // Update total price display
    document.getElementById('cartTotalPrice').textContent = 'RM ' + total.toFixed(2);

    // Update the hidden input field with the total amount
    document.getElementById('totalAmountInput').value = total.toFixed(2);
}


    // Update subtotal function
    function updateSubtotal(cartId, price) {
        const quantity = parseInt(document.querySelector(`input[name="quantities[${cartId}]"]`).value, 10);
        const subtotal = price * quantity;
        document.getElementById(`subtotal${cartId}`).textContent = `RM ${subtotal.toFixed(2)}`;
        updateTotalPrice(); // Update total price after subtotal change
    }



    // Initialize the total price on page load
    window.onload = updateTotalPrice;

    // Add event listeners to checkboxes for price updates on selection change
    document.querySelectorAll('.product-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    // Function to update cart quantity through AJAX
    function updateCartQuantity(cartId, quantity) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true); // Point to your update script
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                // Update subtotal based on the response
                document.getElementById(`subtotal${cartId}`).innerText = `RM ${response.newSubtotal}`;
                // Update total price after quantity change
                updateTotalPrice();
            }
        };

        xhr.send(`cart_id=${cartId}&quantity=${quantity}`);
    }



    //Update the JavaScript Function to Remove an Item from the Cart
    function removeFromCart(cartId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_cart.php", true); // Point to your delete script
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Remove the row from the table
                    const row = document.querySelector(`tr[data-cart-id="${cartId}"]`);
                    if (row) {
                        row.remove();
                        updateTotalPrice(); // Update the total price after deletion
                    }
                } else {
                    alert("Failed to delete item: " + response.error);
                }
            }
        };

        xhr.send(`cart_id=${cartId}`);
    }


    
</script>


</body>
</html>
