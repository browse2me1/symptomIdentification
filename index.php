<?php
 include 'menubar.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>


<?php include 'headers.php'; ?>

<div class="container">
  <?php if (isset($_SESSION['success'])): // success msg.?>
  <div class="flash-message success">
    <?php
      echo $_SESSION['success'];
      unset($_SESSION['success']); // Clear message after displaying
    ?>
  </div>
<?php endif; ?>
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p>This system helps you identify potential diseases based on symptoms you select.</p>

  <a href="disclaimer.php" class="btn">🩺 Check Symptoms</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="manage.php" class="btn">🛠️ Manage Data</a>
  <?php endif; ?>
  <a href="about.php" class="btn">ℹ️ About the System</a>
  <a href="contact.php" class="btn">📞 Contact Us</a>
</div>

<style>
  .container {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    text-align: center;
  }

  .btn {
    display: inline-block;
    margin: 10px;
    padding: 12px 20px;
    background-color: #007bff;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 1rem;
  }

  .btn:hover {
    background-color: #0056b3;
  }
</style>

