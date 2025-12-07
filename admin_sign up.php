<!DOCTYPE html>
<html>
     <head>
        <?php
        include("admin_navbar.php");
        include("headers.php");
        ?>
        <link rel="stylesheet" type="text/css" href="sign up.css"> 
        
    </head>

    <title>Admin Signup</title>
</head>
<body>
    <?php
        
        ?>
        <div class="login-box">
    <h2>Admin Signup</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="succes"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <form method="post" action="">
    <div class="input-field">
        <input type="text" name="username" onkeypress="return /[a-zA-Z\s]/.test(event.key)" placeholder="Admin Username" required>
        </div>
    <div class="input-field">
        <input type="password" name="password" placeholder="Admin Password" required>
        </div>
    <div class="input-field">
        <input type="email" name="email" placeholder="email...">
        </div>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <button class="btn" type="submit">Register Admin</button><br>
              OR <a href="login.php" style=color:blue;>Login</a>
    </form>
   
</div>
<?php
                  include("footer.php")
           ?>
</body>
</html>

<?php
// admin_signup.php - only accessible to admins
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role = 'admin';  // Always set as admin

    $sql = "INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $role, $email);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Registration successful. Please login';
        header("Location: admin_sign up.php");
        exit();
    } else {
        $_SESSION['message'] = 'Registration failed!';
    }
}

?>

