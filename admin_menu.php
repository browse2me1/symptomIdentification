<div class="menu"><h3>
             <ul>
               
            <li><a href="index.php">Home</a></li>
            <li><a href="manage_diseases.php">disease</a></li>
            <li><a href="manage_symptoms.php">symptom</a></li>
            <li><a href="manage_mapping.php">mapping</a></li>

            
            <?php
            if(!isset($_SESSION['username'])){
                ?>
            
            <li><a href="sign%20up.php">Sign up</a></li>
            <li><a href="login.php">login</a></li>
             <?php
            }
            ?>
           
            <li><a href="about.php">about</a></li>
            <li><a href="admin_sign up.php">admin Signup</a></li>
           
            </h3></ul>
</div>