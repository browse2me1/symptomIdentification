<?php

 include 'menubar.php';
include("dbcon.php");
// Redirect if already logged in
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);  // Hash the password
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null; // optional
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password','$email')";
    //success msg.
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'Registration successful. Please login';
header("Location: login.php");
exit();

    } else {
        $_SESSION['message'] = 'Registration faild. Please try again';
        header("Location: sign up.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Symptom-checker| sign up</title>
        <?php include 'headers.php'; ?>
        <link rel="stylesheet" type="text/css" href="sign up.css"> 
        <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">   
    </head>
<body>
   
      <div class="login-container">
            <h2>Create an Account 😷</h2>
            <?php if (isset($_SESSION['message'])): ?>
        <div class="succes"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

            <form method="post" action="">
              <div class="input-field">
              <input type="text" name="username" class="form-control" onkeypress="return /[a-zA-Z\s]/.test(event.key)" placeholder="Username..." required>
           </div>

           <div class="input-field">
              <input type="password"  class="form-control" name="pass" placeholder="Password..." required>
           </div>
            <div class="input-field">
              <input type="email" name="email" class="form-control" placeholder="Email (optional)">
            </div>
              <button class="btn btn-primary w-100" type="submit" name="login">Sign up</button>
               <p style="font-weight:bold; text-align:center;" class="text-center mt-3">OR <a href="login.php">Login</a></p>
            </form>
          </div>
          
       <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="ZrmrjYknPxrPCU_lxhCBz";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
    <?php
                  include("footer.php")
           ?>
</body>
    
</html>