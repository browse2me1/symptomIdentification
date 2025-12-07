<div class="menu"><h3>
             <ul>
               
            <li><a href="index.php">Home</a></li>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><a href="manage.php">manage</a></li>
             <?php endif; ?>

            <?php
            if(!isset($_SESSION['username'])){
                ?>
            
            <li><a href="sign%20up.php">Sign up</a></li>
            <li><a href="login.php">login</a></li>
             <?php
            }
            ?>
            <li><a href="about.php">about</a></li>
            <li><a href="contact.php">contact</a></li>
           
            <?php
            if(isset($_SESSION['username'])){
                ?>
                 <li><a href="logout.php" style="color:red;">Logout</a></li>
                 <li><h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2></li>
          <?php  
           }
          
          ?>
            
            
            </h3></ul>
</div>
