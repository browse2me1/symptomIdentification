<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Symptom-Based Disease ID</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/style.css"> <!-- if you have one -->

  <style>
     body {
            background-color: #007bff;;
        }

        .navbar-brand img {
            height: 40px;
        }

        .login-container {
            max-width: 400px;
            margin: 5% auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        footer {
            background-color: #2c3e50;
            color: #ccc;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            border-radius: 5px;
        }

        .logo-img {
            height: 60px;
            display: block;
            margin: 10px auto;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .nav-item a {
            color: white !important;
            float: left;
        }

        @media screen and (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
        }
        h1{
            color: white !important;
        }
  </style>
  <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button><h1>Symptom Checker</h1>
        <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
    <li class="nav-item"> <a class="nav-link" href="index.php">Home</a></li>
    <li class="nav-item"> <a class="nav-link" href="input_symptoms.php">Check Symptoms</a></li>
    <li class="nav-item"> <a class="nav-link"class href="about.php">About</a></li>
    <li class="nav-item"> <a class="nav-link" href="contact.php">Contact</a></li>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <li class="nav-item"> <a class="nav-link" href="manage.php">Manage</a></li>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
      <li class="nav-item"> <a class="nav-link" href="logout.php">Logout</a></li>
    <?php else: ?>
      <li class="nav-item"> <a class="nav-link" href="login.php">Login</a></li>
    <?php endif; ?>
    </ul>
  </div>
  </div>

  
</nav>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

