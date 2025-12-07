<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'menubar.php';
include 'dbcon.php';

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prevent SQL injection with prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user found
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // If you're using roles
            $_SESSION['success'] = "Login successful! Welcome, " . $_SESSION['username'];
            header("Location: index.php");
            exit();
        }
    }
else{
    // Login failed
    $_SESSION['login_error'] = "Invalid username or password.";
    header("Location: login.php");
    exit();
}
    
}
?>

<!-- Login Form HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
 <title>Symptom-checker| login</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'headers.php'; ?>
  <link rel="stylesheet" type="text/css" href="sign up.css">
   <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>

<!-- Login Form -->
<div class="login-container">
    <h3 class="text-center mb-4">User Login 🩺</h3>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="succes"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['login_error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <input type="text" name="username" class="form-control" onkeypress="return /[a-zA-Z\s]/.test(event.key)"  placeholder="Username" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="text-center mt-3">OR <a href="sign up.php">Signup</a></p>
    </form>
</div>

<!-- Footer -->
<footer>
    University of Gondar © 2025 | Department of Health Informatics
</footer>

    <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="ZrmrjYknPxrPCU_lxhCBz";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</div>

</body>
</html>
