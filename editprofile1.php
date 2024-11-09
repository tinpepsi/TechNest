<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display edit form, from profile.php (username, password)
-->

<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare the database query to fetch the user by username
    $query = "SELECT user_id, username FROM users WHERE username = ?";
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
        exit();
    }
    
    $stmt->close();
} else {
    echo "Please log in to edit your profile.";
    exit();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new_username'])) {
        $new_username = $_POST['new_username'];
        // Update the username
        $updateUsernameQuery = "UPDATE users SET username = ? WHERE username = ?";
        $updateUsernameStmt = $conn->prepare($updateUsernameQuery);
        $updateUsernameStmt->bind_param("ss", $new_username, $username);
        $updateUsernameStmt->execute();
        $_SESSION['username'] = $new_username; // Update the session username
        $username = $new_username;
        $updateUsernameStmt->close();
    }

    if (!empty($_POST['new_password'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the new password
        // Update the password
        $updatePasswordQuery = "UPDATE users SET password = ? WHERE username = ?";
        $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
        $updatePasswordStmt->bind_param("ss", $new_password, $username);
        $updatePasswordStmt->execute();
        $updatePasswordStmt->close();
    }

    // Redirect to login.php after updates
    header("Location: login.php");
    exit();
}
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
    <script>
        function confirmUpdate(event) {
            event.preventDefault(); // Prevent form submission
            var newUsername = document.getElementById('new_username').value;
            var newPassword = document.getElementById('new_password').value;

            // Confirm only if new username is being updated
            if (newUsername) {
                var confirmChange = confirm('Changing username will log you out. Do you want to proceed?');
                if (confirmChange) {
                    document.getElementById('updateForm').submit(); // Submit form if confirmed
                }
            } else {
                // If no username change, directly submit the form
                document.getElementById('updateForm').submit();
            }
        }
    </script>
</head>
<body>
<div class="profile-page">
<div class="container cust_form_container">
    <h1>Edit Profile</h1>
    <form method="POST" action="" id="updateForm" onsubmit="confirmUpdate(event);">
        <div class="form-group">
            <label for="new_username">New Username:</label>
            <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">
        </div>
        <div class="form-group">
            <button type="submit">Update Profile</button>
        </div>
    </form>
</div>
</div>
</body>
</html>
