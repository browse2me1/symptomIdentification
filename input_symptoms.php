<?php
 include("menubar.php");
 
  ?>

<!DOCTYPE html>
<html lang="en">
         <?php
                
                  include("headers.php");

                  ?>
                  
                  <?php

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("location:welcome.php");
    exit();
}
?>
<body style="background-image: url('imge.jpg'); background-size: cover;">
    <div class="container">
          
           
        <main>
            <form id="symptomForm" action="results.php" method="POST">
                <div class="form-group">
                    <input type="text" id="symptomInput" name="symptoms" placeholder="click to select" readonly required>
               </div>
           
                <button type="submit" class="btn">Check for Diseases</button>
             <?php
                  include("symptoms.php")
           ?>
           <p id="errorMsg" style="color: red; display: none; text-align: center;"></p>
            </form>
            
            <div id="symptomSuggestions" class="suggestions">
                <!-- Suggestions will appear here -->
            </div>
        </main>
       
       
    </div>
<?php
                  include("footer.php")
           ?>
    
    <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="ZrmrjYknPxrPCU_lxhCBz";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
<script src="script.js"></script>
</body>
</html>