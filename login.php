<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALLUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display login form, include validation 
-->

<?php
session_start(); // Start the session
include 'db_connect.php'; // Include the database connection file

// Initialize error messages
$usernameError = '';
$passwordError = '';
$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST['username'])) {
        $usernameError = "Username is required.";
    } else {
        $username = htmlspecialchars(trim($_POST['username']));
    }

    if (empty($_POST['pwd'])) {
        $passwordError = "Password is required.";
    } else {
        $password = htmlspecialchars(trim($_POST['pwd'])); 
    }

    // If no validation errors, proceed with the login
    if (empty($usernameError) && empty($passwordError)) {
        // Prepare a SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, username, role, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password 
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username']; // Store the username in session
                $_SESSION['role'] = $user['role']; // Store the role in session

                // Redirect based on the role
                if ($user['role'] == 1) { // Admin
                    header("Location: admin_dashboard.php"); // Redirect to admin page
                } else {
                    header("Location: index.php"); // Redirect to user page
                }
                exit(); // Make sure to exit after redirecting
            } else {
                $loginError = "Invalid username or password.";
            }
        } else {
            $loginError = "Invalid username or password.";
        }

        $stmt->close();  // Close the statement
    }
    
    $conn->close();  // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="include/css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Log In -->
    <div class="container" id="logIn">
        <h1 class="form-title">Login</h1>
        <form method="POST">
            <!-- Email -->
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" value="<?php echo isset($username) ? $username : ''; ?>">
                <label for="username">Username</label>
                <?php if ($usernameError): ?>
                    <div class="error"><?php echo $usernameError; ?></div>
                <?php endif; ?>
            </div>
            <!-- Password -->
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="pwd" id="password" placeholder="Password">
                <label for="password">Password</label>
                <?php if ($passwordError): ?>
                    <div class="error"><?php echo $passwordError; ?></div>
                <?php endif; ?>
            </div>
            <?php if ($loginError): ?>
                <div class="error-message"><?php echo $loginError; ?></div>
            <?php endif; ?>
            <input type="submit" class="btn" value="Login" name="logIn">
        </form>

        <div class="link">
            <p class="account-text">Don't have an account yet?</p>
            <a href="signup.php" class="btn custom-button">Sign Up</a>
        </div>
    </div>
</body>
</html>
