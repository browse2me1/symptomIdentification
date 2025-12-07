<?php
session_start();
session_unset();
session_destroy();


?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome | Symptom-Based Disease Identifier</title>
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
   <div class="logo">
    <img src="logo.png" alt="Logo" style="height: 150px;">
</div>

    <h1>Welcome to the Symptom-Based Disease Identification System</h1>
    <em>This system helps users identify possible diseases based on the symptoms they experience, promoting early detection and public health awareness.</em>
    <p>Promoting Our Health Digitally.</p>

    <div class="buttons">
        <a href="login.php">Login</a>
        <a href="sign up.php">Sign Up</a>
    </div>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="ZrmrjYknPxrPCU_lxhCBz";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>
<?php 
  exit();
?>
