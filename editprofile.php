<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display edit form, from profile.php 
-->


<?php
session_start(); // Start the session
include 'db_connect.php';  // Include the database connection file

if (isset($_SESSION['username'])) {
    // User is logged in
    $username = $_SESSION['username']; // Get the username from the session

    // Prepare the database query to fetch the user by username
    $query = "SELECT user_id, name, username, email, phone_number, address, country FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    
    // Execute the statement and get the result
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch user information
    } else {
        echo "User not found.";
        exit(); // Stop further execution
    }
    
    // Close the statement
    $stmt->close();
} else {
    // User is not logged in
    echo "Please log in to edit your profile.";
    exit();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    
    // Check if the username or password fields are set for updates
    if (!empty($_POST['new_username'])) {
        $new_username = $_POST['new_username'];
        // Prepare the update query for the username
        $updateUsernameQuery = "UPDATE users SET username = ? WHERE username = ?";
        $updateUsernameStmt = $conn->prepare($updateUsernameQuery);
        $updateUsernameStmt->bind_param("ss", $new_username, $username);
        $updateUsernameStmt->execute();
        $username = $new_username; // Update the session username
        $updateUsernameStmt->close();
    }

    if (!empty($_POST['new_password'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the new password
        // Prepare the update query for the password
        $updatePasswordQuery = "UPDATE users SET password = ? WHERE username = ?";
        $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
        $updatePasswordStmt->bind_param("ss", $new_password, $username);
        $updatePasswordStmt->execute();
        $updatePasswordStmt->close();
    }

    // Prepare the update query for other information
    $updateQuery = "UPDATE users SET name = ?, email = ?, phone_number = ?, address = ?, country = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssssss", $name, $email, $phone_number, $address, $country, $username);
    
    // Execute the update statement
    if ($updateStmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
    
    // Close the statement
    $updateStmt->close();
}

// Display the edit profile form with current user information
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - E-Commerce</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Link to custom CSS file for additional styles -->
    <link rel="stylesheet" href="include/css/style.css">
        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pj3TA2+2+3Cxydk1Gb7FwNiIgI9V8DGIcZBWn1z9U9D7BCLco7hJFr0P75/6rU1K" crossorigin="anonymous"></script>

</head>
<body>
<div class="profile-page">
<div class="container cust_form_container">
    <h1>Edit Profile</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required>
        </div>
        <div class="form-group">
            <button type="submit">Update Profile</button>
        </div>
    </form>
</div>
</div>

</body>
</html>
