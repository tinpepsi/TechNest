<!-- 
 * This code is written by NUR ATHIRAH BINTI HILALUDDIN
 * Student ID: AM2307013911
 * Date: 11/9/2024
 * Purpose: This page display signup form with validation. Data insert to database
-->

<?php
include 'db_connect.php';  // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUp'])) {
    // Retrieve and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validate username (not empty and length between 3 and 15)
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    } elseif (strlen($username) < 3 || strlen($username) > 15) {
        $errors['username'] = "Username must be between 3 and 15 characters.";
    } else {
        // Check if username is unique
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['username'] = "Username is already taken.";
        }
        $stmt->close();
    }

    // Validate email (not empty and valid format)
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    } else {
        // Check if email is unique
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = "Email is already registered.";
        }
        $stmt->close();
    }

    // Validate password (not empty and minimum length of 6)
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    } else {
        // Hash password for storage
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    // If there are no errors, insert the new user into the database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at, role) VALUES (?, ?, ?, NOW(), 'user')");
        $stmt->bind_param("sss", $username, $email, $passwordHash);
        if ($stmt->execute()) {
            echo "<p class='success'>Sign-up successful!</p>";
        } else {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="include/css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<!-- Sign Up -->
<div class="container" id="signup">
    <h1 class="form-title">Sign Up</h1>
    <form method="POST">
        <!-- Username -->    
        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            <label for="username">Username</label>    
            <div class="error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></div>               
        </div>
        
        <!-- Email --> 
        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <label for="email">Email</label>   
            <div class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>                 
        </div>
        
        <!-- Password --> 
        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password">
            <label for="password">Password</label>
            <div class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div> 
        </div>
        
        <!-- Sign up button --> 
        <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>

    <div class="link">
        <p class="account-text">Already have an account?</p>
        <a href="login.php" class="btn custom-button">Login</a>
    </div>
</div>


      <!--JS-->
      <script src="include/js/script.js"></script>
</body>
</html>
